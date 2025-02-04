<?php

namespace App\Services\Template;

use App\Models\Template\Template;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class TemplateService
{
    public const DEFAULT_ORDER_BY_FIELDS = 'created_at DESC';

    public function listQuery(array $queryParams): Builder
    {
        $category = $queryParams['category'] ?? null;
        $type = $queryParams['type'] ?? null;
        $builder = $queryParams['builder'] ?? null;
        $schoolId = $queryParams['school_id'] ?? null;
        $status = $queryParams['status'] ?? null;

        return DB::table('templates')
                 ->whereTrue($category, 'category', $category)
                 ->whereTrue($type, 'type', $type)
                 ->whereTrue($builder, 'builder', $builder)
                 ->whereTrue($schoolId == -1, 'school_id', null)
                 ->whereTrue($schoolId > 0, 'school_id', $schoolId)
                 ->whereTrue(
                     empty($schoolId),
                     fn($query) => $query->where('school_id', $schoolId)
                                         ->orWhereNull('school_id')
                 )
                 ->when(
                     $status === 'deleted',
                     fn($q) => $q->whereNotNull('deleted_at'),
                     fn($q) => $q->whereNull('deleted_at')
                                 ->when(
                                     $status === 'inactive',
                                     fn($q) => $q->where('active', false),
                                     fn($q) => $q->where('active', true)
                                 ),
                 )
                 ->select(
                     'id',
                     'school_id',
                     'name',
                     'templatable_type',
                     'category',
                     'type',
                     'builder',
                     'screenshot',
                     'active',
                     'deleted_at',
                 )
                 ->orderByRaw(self::DEFAULT_ORDER_BY_FIELDS);
    }

    public function store(array $input, int $schoolId, int $loggedInUserId): Template
    {
        return Template::create(
            [
                'school_id'        => ($input['is_master'] ?? false) ? null : $schoolId,
                'name'             => $input['name'],
                'templatable_type' => Template::TEMPLATABLE_TYPES[$input['category']],
                'category'         => $input['category'],
                'type'             => $input['type'],
                'builder'          => $input['builder'],
                'settings'         => [],
                'custom_fields'    => [],
                'content'          => '',
                'created_by'       => $loggedInUserId,
            ]
        );
    }

    public function duplicate(Template $template): Template
    {
        $duplicatedTemplate = $template->replicate();

        $duplicatedTemplate->name = $duplicatedTemplate->name . ' (Copy)';
        if (!$duplicatedTemplate->school_id && !is_superadmin()) {
            $duplicatedTemplate->school_id = auth_user_nonnull()->school_id;
        }

        $duplicatedTemplate->save();

        return $duplicatedTemplate;
    }

    public function delete(Template $template): void
    {
        $template->delete();
    }
}
