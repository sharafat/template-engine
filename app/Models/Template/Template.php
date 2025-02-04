<?php

namespace App\Models\Template;

use App\Models\School\School;
use App\Models\Template\Templates\FeesReceiptTemplate;
use App\Models\Template\Templates\PageHeaderTemplate;
use App\Models\Template\Traits\ContentSettings;
use App\Models\Template\Traits\CustomFields;
use App\Models\Template\Traits\PageLayoutSettings;
use App\Models\Template\Variables\VariableOperations;
use App\Models\User\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Throwable;

class Template extends Model
{
    use SoftDeletes, ContentSettings, PageLayoutSettings, CustomFields;

    public const CATEGORY_PAGE_HEADER = 'page_header';
    public const CATEGORY_PAGE_FOOTER = 'page_footer';
    public const CATEGORY_FEES_RECEIPT = 'fees_receipt';
    public const CATEGORY_SEAT_PLAN = 'seat_plan';
    public const CATEGORIES = [
        self::CATEGORY_PAGE_HEADER  => 'Page Header',
        self::CATEGORY_PAGE_FOOTER  => 'Page Footer',
        self::CATEGORY_FEES_RECEIPT => 'Fees Receipt',
        self::CATEGORY_SEAT_PLAN    => 'Seat Plan',
    ];

    public const TEMPLATABLE_TYPES = [
        self::CATEGORY_PAGE_HEADER  => PageHeaderTemplate::class,
        self::CATEGORY_FEES_RECEIPT => FeesReceiptTemplate::class,
    ];

    public const TYPE_VIEW = 'view';
    public const TYPE_PRINT = 'print';
    public const TYPE_PDF = 'pdf';
    public const TYPES = [
        self::TYPE_VIEW  => 'View',
        self::TYPE_PRINT => 'Print',
        self::TYPE_PDF   => 'PDF',
    ];

    public const BUILDER_DRAG_N_DROP = 'drag_and_drop';
    public const BUILDER_RTE = 'rich_text_editor';
    public const BUILDER_HTML = 'html_editor';
    public const BUILDERS = [
        self::BUILDER_DRAG_N_DROP => 'Drag & Drop',
        self::BUILDER_RTE         => 'Rich Text',
        self::BUILDER_HTML        => 'HTML',
    ];

    protected $guarded = ['id'];

    public function casts(): array
    {
        return [
            'id'               => 'int',
            'school_id'        => 'int',
            'name'             => 'string',
            'templatable_type' => 'string',
            'category'         => 'string',
            'type'             => 'string',
            'builder'          => 'string',
            'settings'         => 'array',
            'custom_fields'    => 'array',
            'content'          => 'string',
            'screenshot'       => 'string',
            'active'           => 'bool',
            'created_by'       => 'int',
            'created_at'       => 'datetime',
            'updated_at'       => 'datetime',
            'deleted_at'       => 'datetime',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setting(string $key, mixed $defaultValue = null): mixed
    {
        return $this->settings[$key] ?? $defaultValue;
    }

    public function setSetting(string $key, mixed $value): void
    {
        $settings = $this->settings;
        $settings[$key] = $value;
        $this->settings = $settings;
    }

    public function templatable(): mixed
    {
        // Dynamically resolve the class based on the 'templatable_type' field
        $className = $this->templatable_type;

        // Ensure the class exists and is a subclass of Template
        if (class_exists($className) && is_subclass_of($className, Template::class)) {
            return new $className($this->attributes);
        }

        return $this;
    }

    /**
     * @return Collection<VariableOperations>
     */
    public function variableOperations(bool $preview = false): Collection
    {
        return collect();
    }

    /**
     * @throws Throwable
     */
    public function render(bool $preview = false): View
    {
        $css = $html = '';

        switch ($this->builder) {
            case self::BUILDER_HTML:
                $json = json_decode($this->content);
                $css = $json->css;
                $html = $json->html;
                break;
        }

        /** @var Collection<VariableOperations> $variables */
        $variables = $this->variableOperations($preview);
        foreach ($variables as /** @var VariableOperations $variable */ $variable) {
            $html = $variable->bind($html, $preview);
        }

        return view('templates.render', ['css' => $css, 'html' => $html]);
    }
}
