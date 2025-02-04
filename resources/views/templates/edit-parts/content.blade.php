<div class="panel panel-bordered">
    <div class="panel-body">

        <div class="d-md-flex align-top w-full">

            <div class="pr-md-20" style="flex-grow: 1">
                @switch($template->builder)
                    @case(\App\Models\Template\Template::BUILDER_HTML)
                        @include('templates.edit-parts.content-parts.html')
                        @break
                @endswitch
            </div>

            <div class="variables-container pl-md-20 mt-20 mt-md-0">
                @include('templates.edit-parts.content-parts.variables')
            </div>

        </div>

    </div>
</div>
