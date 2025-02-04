@extends('layouts.app')

@set('title', ___('Templates'))
@php
    use App\Models\Template\Template;
@endphp

@section('title', $title)

@section('css')
    <style>
    </style>
@endsection

@section('content')
    <div>

        <div class="page-header">
            <div class="page-title">{{ $title }}</div>
            @permission('templates.add')
                <div class="page-header-actions">
                    <button type="button" class="btn btn-primary"
                            data-toggle="modal" data-target="#new-template-modal">
                        <i class="fa fa-plus"></i>
                        <span class="text hidden-sm-down ml-5">New Template</span>
                    </button>
                </div>
            @endpermission
        </div>

        <div class="panel panel-bordered form-horizontal">
            @component('components.search-header')
            @endcomponent

            <div class="panel-body pb-20">
                <form method="post" action="" onsubmit="event.preventDefault();" class="form-horizontal">

                    <div id="template-filters" class="row">

                        {{-- Category --}}
                        <div class="form-field-container col-md-4 col-lg-3 col-xxl-2">
                            @component('components.form_element', ['label' => 'Category', 'elementId' => 'category'])
                                @component('components.select-field', ['id' => 'category'])
                                    @component('components.select-options', ['selectName' => 'category',
                                    'optionMap' => \App\Models\Template\Template::CATEGORIES, 'selectOptionLabel' => 'All'])
                                    @endcomponent
                                @endcomponent
                            @endcomponent
                        </div>

                        {{-- Type --}}
                        <div class="form-field-container col-md-4 col-lg-3 col-xxl-2">
                            @component('components.form_element', ['label' => 'Type', 'elementId' => 'type'])
                                @component('components.select-field', ['id' => 'type'])
                                    @component('components.select-options', ['selectName' => 'type',
                                    'optionMap' => \App\Models\Template\Template::TYPES, 'selectOptionLabel' => 'All'])
                                    @endcomponent
                                @endcomponent
                            @endcomponent
                        </div>

                        {{-- Built With --}}
                        <div class="form-field-container col-md-4 col-lg-3 col-xxl-2">
                            @component('components.form_element', ['label' => 'Built with', 'elementId' => 'builder'])
                                @component('components.select-field', ['id' => 'builder'])
                                    @component('components.select-options', ['selectName' => 'builder',
                                    'optionMap' => \App\Models\Template\Template::BUILDERS, 'selectOptionLabel' => 'All'])
                                    @endcomponent
                                @endcomponent
                            @endcomponent
                        </div>

                        {{-- Built By --}}
                        <div class="form-field-container col-md-4 col-lg-3 col-xxl-2">
                            @component('components.form_element', ['label' => 'Built by', 'elementId' => 'school_id'])
                                @component('components.select-field', ['id' => 'school_id'])
                                    @component('components.select-options', ['selectName' => 'school_id',
                                    'optionMap' => ['-1' => 'EximusEdu', auth_user_nonnull()->school_id => auth_user_nonnull()->school->short_name],
                                     'selectOptionLabel' => 'Anyone'])
                                    @endcomponent
                                @endcomponent
                            @endcomponent
                        </div>

                        {{-- Status --}}
                        <div class="form-field-container col-md-4 col-lg-3 col-xxl-2">
                            @component('components.form_element', ['label' => 'Status', 'elementId' => 'status'])
                                @component('components.select-field', ['id' => 'status'])
                                    @component('components.select-options', ['selectName' => 'status',
                                    'optionMap' => ['active' => 'Active', 'inactive' => 'Inactive', 'deleted' => 'Deleted'],
                                    'selectedValue' => 'active'])
                                    @endcomponent
                                @endcomponent
                            @endcomponent
                        </div>

                        {{-- Submit --}}
                        <div class="form-field-container col-md-4 col-lg-3 col-xxl-2">
                            <button
                                id="list-templates-btn"
                                class="btn btn-primary ladda-button"
                                data-app-plugin="ladda"
                                data-style="expand-left"
                                onclick="listTemplates()"
                            >
                                Search
                            </button>
                        </div>

                    </div>

                </form>
            </div>
        </div>

        <div id="templates" class="row">
            {{-- To be filled up using ajax response --}}
        </div>

        <div id="new-template-modal" class="modal fade" tabindex="-1" role="dialog"
             aria-labelledby="modal-title" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Create New Template</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="m-15">

                            <div class="form-field-container mb--15">
                                <x-form_element label="Category" elementId="category" cssClass="required">
                                    <x-select-field id="category" required="required">
                                        <x-select-options selectName="category"
                                                          selectOptionLabel="Select..."
                                                          :optionMap="\App\Models\Template\Template::CATEGORIES">
                                        </x-select-options>
                                    </x-select-field>
                                </x-form_element>
                            </div>

                            <div class="form-field-container mb--15">
                                <x-form_element label="Type" elementId="type">
                                    <x-select-field id="type">
                                        <x-select-options selectName="type"
                                                          selectOptionLabel="Any"
                                                          :optionMap="\App\Models\Template\Template::TYPES">
                                        </x-select-options>
                                    </x-select-field>
                                </x-form_element>
                            </div>

                            <div class="form-field-container mb--15">
                                <x-form_element label="Builder" elementId="builder" cssClass="required">
                                    <x-select-field id="builder" required="required">
                                        <x-select-options selectName="builder"
                                                          selectOptionLabel="Select..."
                                                          :optionMap="\App\Models\Template\Template::BUILDERS">
                                        </x-select-options>
                                    </x-select-field>
                                </x-form_element>
                            </div>

                            <div class="form-field-container mb--15">
                                <x-form_element label="Template Name" elementId="name" cssClass="required">
                                    <x-input-field id="name" required="required"/>
                                </x-form_element>
                            </div>

                            @superadmin
                                <div class="form-field-container mb--15">
                                    <x-form_element label="Master Template" elementId="is_master" cssClass="required">
                                        <x-checkbox-field id="is_master" :default-value="false"></x-checkbox-field>
                                    </x-form_element>
                                </div>
                            @endsuperadmin

                        </div>
                    </div>

                    <div class="modal-footer px-35">
                        <button class="ladda-button btn btn-primary"
                                data-app-plugin="ladda" data-style="expand-left"
                                onclick="createTemplate()">
                            Create Template
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        $(function () {
            highlightMenuItem('#menu-templates');

            list();
        });

        function list() {
            $('#list-templates-btn').click();
        }

        function listTemplates() {
            const category = $('#template-filters #category').val();
            const type = $('#template-filters #type').val();
            const builder = $('#template-filters #builder').val();
            const schoolId = $('#template-filters #school_id').val();
            const status = $('#template-filters #status').val();

            fetch(route('templates.list_data', { category, type, builder, school_id: schoolId, status }),
                {
                    method: 'get',
                    headers: new Headers({
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }),
                    credentials: 'include'  // adds cookie header
                }
            ).then(async response => {
                if (response.status === 422) {  // Validation error
                    const responseJson = await response.json();
                    throw new Error(responseJson.message);
                }

                if (!response.ok) {
                    throw new Error(response.statusText);
                }

                renderTemplates(await response.json());

                window.Ladda.stopAll();
            }).catch(error => {
                toastr.error(`Failed to fetch templates. ${error}`);
                window.Ladda.stopAll();
            });
        }

        function renderTemplates(data) {
            let html = '';

            for (let i = 0; i < data.length; i++) {
                const template = data[i];

                html += `
                    <div class="col-md-6 col-xl-4 col-xxl-3">
                        <div class="card card-shadow">
                            <div class="card-footer card-footer-transparent" style="border-bottom: 1px solid #e4eaec">
                                <h4 class="card-title mb-0">
                                    ${template.category}
                                    <div class="card-header-actions">
                                        ${template.type === '{{ Template::TYPE_VIEW }}' ? '<i class="fas fa-eye pl-10" title="{{ Template::TYPES[Template::TYPE_VIEW] }}"></i>' : ''}
                                        ${template.type === '{{ Template::TYPE_PRINT }}' ? '<i class="fas fa-print pl-10" title="{{ Template::TYPES[Template::TYPE_PRINT] }}"></i>' : ''}
                                        ${template.type === '{{ Template::TYPE_PDF }}' ? '<i class="fas fa-file-pdf pl-10" title="{{ Template::TYPES[Template::TYPE_PDF] }}"></i>' : ''}
                                        ${!template.type
                                            ? '<i class="fas fa-eye pl-10" title="{{ Template::TYPES[Template::TYPE_VIEW] }}"></i>'
                                              + '<i class="fas fa-print pl-10" title="{{ Template::TYPES[Template::TYPE_PRINT] }}"></i>'
                                              + '<i class="fas fa-file-pdf pl-10" title="{{ Template::TYPES[Template::TYPE_PDF] }}"></i>' : ''}
                                        ${template.builder === '{{ Template::BUILDER_DRAG_N_DROP }}' ? '<i class="fa-regular fa-window pl-10" title="{{ Template::BUILDERS[Template::BUILDER_DRAG_N_DROP] }}"></i>' : ''}
                                        ${template.builder === '{{ Template::BUILDER_RTE }}' ? '<i class="fas fa-input-text pl-10" title="{{ Template::BUILDERS[Template::BUILDER_RTE] }}"></i>' : ''}
                                        ${template.builder === '{{ Template::BUILDER_HTML }}' ? '<i class="fa fa-code pl-10" title="{{ Template::BUILDERS[Template::BUILDER_HTML] }}"></i>' : ''}
                                        ${template.school_id === null ? '<img src="{{ asset(mix('images/logo-100.png')) }}" class="pl-10" height="25" title="Built by EximusEdu"/>' : ''}
                                        ${template.school_id !== null ? '<img src="{{ logo_url(auth_user_nonnull()->school) }}" class="pl-10" height="25" title="Built By {{ auth_user_nonnull()->school->short_name }}"/>' : ''}
                                    </div>
                                </h4>
                            </div>
                            <div class="card-footer card-footer-transparent text-center">
                                ${template.name}
                            </div>
                            <div class="card-block">
                                <div class="card-text">
                                    <div class="d-flex align-items-center justify-content-center w-full" style="height: 200px">
                                        ${template.screenshot ? `<img src="${template.screenshot}"/>` : ''}
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer card-footer-transparent card-footer-bordered d-flex justify-content-between">
                                <a href="${route('templates.preview', {template: template.id})}" target="_blank" class="btn btn-icon btn-pure btn-success" title="Preview">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                @permission('templates.add')
                                    <a href="${route('templates.duplicate', {template: template.id})}" target="_blank" class="btn btn-icon btn-pure btn-primary" title="Duplicate">
                                        <i class="fa-solid fa-copy"></i>
                                    </a>
                                @endpermission
                                @permission('templates.edit')
                                    <a href="${route('templates.edit', {template: template.id})}" target="_blank"
                                       class="btn btn-icon btn-pure btn-default ${template.deleted_at ? 'd-none' : ''}" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endpermission
                                @permission('templates.delete')
                                    <a href="javascript:void(0)"
                                       onclick="${template.active ? `deactivateTemplate(${template.id})` : `activateTemplate(${template.id})`}"
                                       class="btn btn-icon btn-pure btn-${template.active ? 'warning' : 'success'} ${template.deleted_at ? 'd-none' : ''}" title="${template.active ? 'Deactivate' : 'Activate'}">
                                        <i class="fa-solid fa-circle-${template.active ? 'xmark' : 'check'}"></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                       onclick="confirmTemplateDeletion(${template.id}, '${template.name}')"
                                       class="btn btn-icon btn-pure btn-danger ${template.deleted_at ? 'd-none' : ''}" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                @endpermission
                            </div>
                        </div>
                    </div>
                `;
            }

            $('#templates').html(html);
        }

        function createTemplate() {
            const category = $('#new-template-modal #category').val().trim();
            const type = $('#new-template-modal #type').val().trim();
            const builder = $('#new-template-modal #builder').val().trim();
            const name = $('#new-template-modal #name').val().trim();
            const is_master = $('#new-template-modal #is_master').is(':checked') ?? false;

            if (!category.length) {
                return __showValidationError('Please select a Category.');
            }

            if (!builder.length) {
                return __showValidationError('Please select a Builder.');
            }

            if (!name.length) {
                return __showValidationError('Please enter a Template Name.');
            }

            fetch('{{ route('templates.store') }}',
                {
                    method: 'post',
                    redirect: 'follow',
                    body: JSON.stringify({category, type, builder, name, is_master}),
                    headers: new Headers({
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                    }),
                    credentials: 'include'  // adds cookie header
                }
            ).then(async response => {
                if (response.status === 422) {  // Validation error
                    const responseJson = await response.json();
                    throw new Error(responseJson.message);
                }

                if (!response.ok) {
                    throw new Error(response.statusText);
                }

                if (response.redirected && response.url !== '') {
                    window.location = response.url;
                }
            }).catch(error => {
                toastr.error(`Failed to create template. ${error}`);
                window.Ladda.stopAll();
            });
        }

        function __showValidationError(msg) {
            toastr.error(msg);
            setTimeout(() => window.Ladda.stopAll(), 100);

            return false;
        }

        function activateTemplate(id) {
            fetch(route('templates.activate', {template: id}),
                {
                    method: 'put',
                    headers: new Headers({
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                    }),
                    credentials: 'include'  // adds cookie header
                }
            ).then(async response => {
                if (response.status === 422) {  // Validation error
                    const responseJson = await response.json();
                    throw new Error(responseJson.message);
                }

                if (!response.ok) {
                    throw new Error(response.statusText);
                }

                list();
            }).catch(error => {
                toastr.error(`Failed activating template. ${error}`);
            });
        }

        function deactivateTemplate(id) {
            fetch(route('templates.deactivate', {template: id}),
                {
                    method: 'put',
                    headers: new Headers({
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                    }),
                    credentials: 'include'  // adds cookie header
                }
            ).then(async response => {
                if (response.status === 422) {  // Validation error
                    const responseJson = await response.json();
                    throw new Error(responseJson.message);
                }

                if (!response.ok) {
                    throw new Error(response.statusText);
                }

                list();
            }).catch(error => {
                toastr.error(`Failed deactivating template. ${error}`);
            });
        }

        function confirmTemplateDeletion(id, name) {
            confirmDeletion(route('templates.delete', {template: id}), `Delete template "${name}"?`, () => list());
        }
    </script>
@endsection
