<div class="panel panel-bordered">
    <div class="panel-body">

        <form method="post" action="{{ route('templates.update_content_settings', ['template' => $template->id]) }}">

            @method('PUT')
            @csrf

            <div class="form-field-container col-lg-6 col-xxl-4">
                <x-form_element label="Size" :element-id="Template::CONTENT_SIZE_WIDTH">
                    <div class="d-flex">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Width</span></div>
                            <x-input-field
                                    :id="Template::CONTENT_SIZE_WIDTH"
                                    :default-value="$template->setting(Template::CONTENT_SIZE_WIDTH)"
                                    placeholder="4in"
                            />
                        </div>
                        <div class="input-group ml-20">
                            <div class="input-group-prepend"><span class="input-group-text">Height</span></div>
                            <x-input-field
                                    :id="Template::CONTENT_SIZE_HEIGHT"
                                    :default-value="$template->setting(Template::CONTENT_SIZE_HEIGHT)"
                                    placeholder="2in"
                            />
                        </div>
                    </div>
                </x-form_element>
            </div>

            <div class="form-field-container col-lg-6 col-xxl-4">
                <x-form_element label="Minimum Size" :element-id="Template::CONTENT_MIN_SIZE_WIDTH">
                    <div class="d-flex">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Width</span></div>
                            <x-input-field
                                    :id="Template::CONTENT_MIN_SIZE_WIDTH"
                                    :default-value="$template->setting(Template::CONTENT_MIN_SIZE_WIDTH)"
                                    placeholder="4in"
                            />
                        </div>
                        <div class="input-group ml-20">
                            <div class="input-group-prepend"><span class="input-group-text">Height</span></div>
                            <x-input-field
                                    :id="Template::CONTENT_MIN_SIZE_HEIGHT"
                                    :default-value="$template->setting(Template::CONTENT_MIN_SIZE_HEIGHT)"
                                    placeholder="2in"
                            />
                        </div>
                    </div>
                </x-form_element>
            </div>

            <div class="form-field-container col-lg-6 col-xxl-4">
                <x-form_element label="Maximum Size" :element-id="Template::CONTENT_MAX_SIZE_WIDTH">
                    <div class="d-flex">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Width</span></div>
                            <x-input-field
                                    :id="Template::CONTENT_MAX_SIZE_WIDTH"
                                    :default-value="$template->setting(Template::CONTENT_MAX_SIZE_WIDTH)"
                                    placeholder="4in"
                            />
                        </div>
                        <div class="input-group ml-20">
                            <div class="input-group-prepend"><span class="input-group-text">Height</span></div>
                            <x-input-field
                                    :id="Template::CONTENT_MAX_SIZE_HEIGHT"
                                    :default-value="$template->setting(Template::CONTENT_MAX_SIZE_HEIGHT)"
                                    placeholder="2in"
                            />
                        </div>
                    </div>
                </x-form_element>
            </div>

            <div class="form-field-container col-lg-6 col-xxl-4">
                <x-form_element label="Margin" :element-id="Template::CONTENT_MARGIN">
                    <x-input-field
                            :id="Template::CONTENT_MARGIN"
                            :default-value="$template->setting(Template::CONTENT_MARGIN)"
                            placeholder="1in 0.5in 0.5in 1in"
                    />
                    <small>
                        <code>Top</code>
                        <code class="ml-5">Right</code>
                        <code class="ml-5">Bottom</code>
                        <code class="ml-5">Left</code>
                    </small>
                </x-form_element>
            </div>

            <div class="form-field-container col-lg-6 col-xxl-4">
                <x-form_element label="Padding" :element-id="Template::CONTENT_PADDING">
                    <x-input-field
                            :id="Template::CONTENT_PADDING"
                            :default-value="$template->setting(Template::CONTENT_PADDING)"
                            placeholder="1in 0.5in 0.5in 1in"
                    />
                    <small>
                        <code>Top</code>
                        <code class="ml-5">Right</code>
                        <code class="ml-5">Bottom</code>
                        <code class="ml-5">Left</code>
                    </small>
                </x-form_element>
            </div>

            <div class="form-field-container col-lg-6 col-xxl-4">
                <x-form_element label="Zoom" :element-id="Template::CONTENT_ZOOM">
                    <div class="input-group">
                        <x-input-field
                                :id="Template::CONTENT_ZOOM"
                                :default-value="$template->setting(Template::CONTENT_ZOOM)"
                                placeholder="1.25"
                        />
                    </div>
                </x-form_element>
            </div>

            <div class="d-flex w-300 mt-50">
                <input type="submit" class="form-control btn btn-primary mr-10" name="save_and_next" value="Save & Go Next">
                <input type="submit" class="form-control btn btn-primary btn-outline ml-10" name="save" value="Save & Stay Here">
            </div>

        </form>

    </div>
</div>
