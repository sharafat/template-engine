<div class="panel panel-bordered">
    <div class="panel-body">

        <form method="post" action="{{ route('templates.update_template_settings', ['template' => $template->id]) }}">

            @method('PUT')
            @csrf

            <div class="form-field-container col-lg-6 col-xxl-4">
                <x-form_element label="Template Name" elementId="name" cssClass="required">
                    <x-input-field id="name" required="required" :default-value="$template->name"/>
                </x-form_element>
            </div>

            <div class="d-flex w-300 mt-50">
                <input type="submit" class="form-control btn btn-primary mr-10" name="save_and_next" value="Save & Go Next">
                <input type="submit" class="form-control btn btn-primary btn-outline ml-10" name="save" value="Save & Stay Here">
            </div>

        </form>

    </div>
</div>
