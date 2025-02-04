<style>
    #html-editor, #css-editor {
        position: relative;
        width: 100%;
        height: 50vh;
    }
</style>

<div>

    <ul class="nav nav-tabs nav-tabs-line font-size-16" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active"
               data-toggle="tab"
               href="#html"
               aria-controls="html" role="tab">
                HTML
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link"
               data-toggle="tab"
               href="#css"
               aria-controls="css" role="tab">
                CSS
            </a>
        </li>
    </ul>

    <div class="tab-content pt-20">
        @php($content = json_decode($template->content ?? '[]'))

        <div class="tab-pane active" id="html" role="tabpanel">
            <div id="html-editor">{{ $content->html ?? '' }}</div>
        </div>
        <div class="tab-pane" id="css" role="tabpanel">
            <div id="css-editor">{{ $content->css ?? '' }}</div>
        </div>
    </div>

    <div class="w-150 mt-50">
        <button
                type="button"
                onclick="saveContent()"
                class="form-control btn btn-primary ladda-button"
                data-app-plugin="ladda"
                data-style="expand-left"
        >
            Save
        </button>
    </div>

</div>

<script>
    function saveContent() {
        const html = window.htmlEditor.getValue();
        const css = window.cssEditor.getValue();

        fetch('{{ route('templates.update_content', ['template' => $template->id]) }}',
            {
                method: 'put',
                body: JSON.stringify({html, css}),
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

            toastr.success('Content saved.');

            window.Ladda.stopAll();
        }).catch(error => {
            toastr.error(`Failed to update template. ${error}`);
            window.Ladda.stopAll();
        });
    }
</script>
