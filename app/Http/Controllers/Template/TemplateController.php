<?php

namespace App\Http\Controllers\Template;

use App\Http\Controllers\Controller;
use App\Models\Template\Template;
use App\Services\PdfService;
use App\Services\Template\TemplateService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TemplateController extends Controller
{
    private const LOG_CONTEXT = ['class' => __CLASS__];

    public function __construct(private readonly TemplateService $templateService)
    {
    }

    public function index(): View
    {
        return view('templates.index');
    }

    public function listData(Request $request): JsonResponse
    {
        try {
            $templates = $this->templateService
                ->listQuery($request->all())
                ->get()
                ->map(function ($template) {
                    $template->category = Template::CATEGORIES[$template->category];
                    $template->active = (bool) $template->active;

                    return $template;
                });

            return response()->json($templates);
        } catch (Exception $e) {
            Log::error("Failed listing templates: {$e->getMessage()}\n{$e->getTraceAsString()}", self::LOG_CONTEXT);

            return response()->json(['error' => "Failed listing templates. Details: {$e->getMessage()}"], 500);
        }
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate(
            [
                'category'  => 'required|in:' . implode(',', array_keys(Template::CATEGORIES)),
                'type'      => 'nullable|in:' . implode(',', array_keys(Template::TYPES)),
                'builder'   => 'required|in:' . implode(',', array_keys(Template::BUILDERS)),
                'name'      => 'required|string|max:180',
                'is_master' => 'nullable|boolean',
            ]
        );

        try {
            $template = $this->templateService->store(
                $request->all(),
                auth_user_nonnull()->school_id,
                auth_user_nonnull()->id,
            );

            return redirect()->route('templates.edit', ['template' => $template->id]);
        } catch (Exception $e) {
            Log::error("Failed creating template: {$e->getMessage()}\n{$e->getTraceAsString()}", self::LOG_CONTEXT);

            return response()->json(['error' => "Failed creating template. Details: {$e->getMessage()}"], 500);
        }
    }

    public function duplicate(Template $template): RedirectResponse
    {
        $duplicatedTemplate = $this->templateService->duplicate($template);

        return redirect()->route('templates.edit', ['template' => $duplicatedTemplate->id]);
    }

    public function edit(Template $template, Request $request): View
    {
        $tab = $request->get('tab', 'content_setup');

        return view('templates.edit', ['template' => $template, 'tab' => $tab]);
    }

    public function updateTemplateSettings(Template $template, Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name'          => 'required|string|max:180',
                'save_and_next' => 'nullable|string',
                'save'          => 'nullable|string',
            ]
        );

        try {
            $template->update(
                [
                    'name' => $request->get('name'),
                ]
            );

            $request->session()->flash('message', 'Template updated successfully.');

            return redirect()->route(
                'templates.edit',
                [
                    'template' => $template->id,
                    'tab'      => $request->get('save') ? 'template_settings' : 'content_setup',
                ]
            );
        } catch (Exception $e) {
            Log::error("Failed updating template: {$e->getMessage()}\n{$e->getTraceAsString()}", self::LOG_CONTEXT);

            $request->session()->flash('message', "Failed updating template. Details: {$e->getMessage()}");
            $request->session()->flash('type', 'error');

            return back()->withInput();
        }
    }

    public function updateContentSettings(Template $template, Request $request): RedirectResponse
    {
        $request->validate(
            array_merge(
                Template::CONTENT_SETTINGS_VALIDATION_RULES,
                [
                    'save_and_next' => 'nullable|string',
                    'save'          => 'nullable|string',
                ]
            )
        );

        try {
            foreach (Template::CONTENT_SETTINGS as $setting) {
                $template->setSetting($setting, $request->get($setting));
            }
            $template->update();

            $request->session()->flash('message', 'Template updated successfully.');

            return redirect()->route(
                'templates.edit',
                [
                    'template' => $template->id,
                    'tab'      => $request->get('save') ? 'content_setup' : 'page_layout',
                ]
            );
        } catch (Exception $e) {
            Log::error("Failed updating template: {$e->getMessage()}\n{$e->getTraceAsString()}", self::LOG_CONTEXT);

            $request->session()->flash('message', "Failed updating template. Details: {$e->getMessage()}");
            $request->session()->flash('type', 'error');

            return back()->withInput();
        }
    }

    public function updateContent(Template $template, Request $request): JsonResponse
    {
        $request->validate(
            match ($template->builder) {
                Template::BUILDER_HTML => [
                    'html' => 'nullable|string|max:4194304',    // 4MB
                    'css'  => 'nullable|string|max:4194304',    // 4MB
                ],
                default => [],
            }
        );

        try {
            switch ($template->builder) {
                case Template::BUILDER_HTML:
                    $template->content = json_encode(
                        [
                            'html' => $request->get('html', ''),
                            'css'  => $request->get('css', ''),
                        ],
                        JSON_THROW_ON_ERROR|JSON_PRETTY_PRINT
                    );
                    break;
            }
            $template->update();

            return response()->json();
        } catch (Exception $e) {
            Log::error("Failed updating template: {$e->getMessage()}\n{$e->getTraceAsString()}", self::LOG_CONTEXT);

            return response()->json(['error' => "Failed updating template. Details: {$e->getMessage()}"], 500);
        }
    }

    public function preview(Template $template, Request $request, PdfService $pdfService): mixed
    {
        $view = $template->templatable()->render(true);

        if ($request->get('pdf') === 'true') {
            return $pdfService->pdf(
                $view->render(),
                'Template Preview',
                'Template_Preview'
            );
        }

        return $view;
    }

    public function deactivate(Template $template): JsonResponse
    {
        $template->update(['active' => false]);

        return response()->json();
    }

    public function activate(Template $template): JsonResponse
    {
        $template->update(['active' => true]);

        return response()->json();
    }

    public function delete(Template $template): JsonResponse
    {
        $template->delete();

        return response()->json();
    }
}
