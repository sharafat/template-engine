@extends('layouts.app')

@php
    use App\Models\Template\Template;

    $title = $template->name;
@endphp

@section('title', $title)

@section('css')
    <style>
        .form-group {
            margin-bottom: 10px !important;
        }
    </style>
@endsection

@section('content')
    <div>

        <div class="page-header">
            <div class="page-title">{{ $title }}</div>
            <div class="page-header-actions d-flex">
                @if (in_array($template->type, [Template::TYPE_VIEW, Template::TYPE_PRINT, null]))
                    <a class="btn btn-success"
                       style="padding-top: 9px"
                       target="_blank"
                       href="{{ route('templates.preview', ['template' => $template->id]) }}">
                        <i class="fa fa-{{ match ($template->type) {
                            Template::TYPE_PRINT => 'print',
                            default => 'eye'
                        } }}"></i>
                        <span class="text hidden-sm-down ml-5">Preview</span>
                    </a>
                @endif
                @if (in_array($template->type, [Template::TYPE_PDF, null]))
                    <form action="{{ route('templates.preview', ['template' => $template->id]) }}">
                        <input type="hidden" name="pdf" value="true"/>

                        <button type="submit" class="btn btn-success btn-outline ladda-button ml-10"
                                style="height: 42px"
                                data-app-plugin="ladda" data-style="expand-left"
                                onclick="setTimeout(() => window.Ladda.stopAll(), 5000)">
                            <i class="fa fa-file-pdf"></i>
                            <span class="text hidden-sm-down ml-5">Preview (PDF)</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @php
            $tabs = [
                'template_settings' => 'Template Settings',
                'content_setup' => 'Content Setup',
                'page_layout' => 'Page Layout',
                'custom_fields' => 'Custom Fields',
                'content' => 'Content',
            ];
        @endphp

        <ul class="nav nav-tabs nav-tabs-line font-size-16" role="tablist">
            @foreach ($tabs as $key => $label)
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $tab === $key ? 'active' : '' }}"
                       href="{{ route('templates.edit', ['template' => $template->id, 'tab' => $key]) }}"
                       aria-controls="profile" role="tab">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content pt-20">
            @foreach ($tabs as $key => $label)
                <div class="tab-pane {{ $tab === $key ? 'active' : '' }}" id="{{ $key }}" role="tabpanel">
                    @if ($tab === $key)
                        @include("templates.edit-parts.$key")
                    @endif
                </div>
            @endforeach
        </div>

    </div>
@endsection

@section('js')
    <script>
        window.htmlEditor = null;
        window.cssEditor = null;

        $(function () {
            highlightMenuItem('#menu-templates');

            if ($('#html-editor').length) {
                window.htmlEditor = ace.edit('html-editor', {
                    mode: 'ace/mode/html',
                    theme: 'ace/theme/github_light_default',
                    fontSize: '12pt',
                    tabSize: 4,
                    useSoftTabs: true,
                    showLineNumbers: true,
                    showPrintMargin: false,
                });
                window.cssEditor = ace.edit('css-editor', {
                    mode: 'ace/mode/css',
                    theme: 'ace/theme/github_light_default',
                    fontSize: '12pt',
                    tabSize: 4,
                    useSoftTabs: true,
                    showLineNumbers: true,
                    showPrintMargin: false,
                });
            }
        });
    </script>
@endsection
