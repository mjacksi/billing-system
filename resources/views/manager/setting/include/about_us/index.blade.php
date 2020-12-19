<div class="tab-pane " id="about_us_us">
    <div class="m-portlet__body">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__body">

                                <div class="row"    >
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="about_us_image">{{ t('about_us_image') }}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="upload-btn-wrapper">
                                                    <button class="btn btn-brand">{{ t('upload file') }}</button>
                                                    <input name="about_us_image" class="imgInp" id="imgInp" type="file"/>
                                                </div>
                                                <img  style="display:{{!isset($about_us_image)? 'none' :'block'}}"
                                                     src="{{ isset($about_us_image)  ? url($about_us_image):'' }}" width="150"
                                                     alt="No file chosen"/>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="col-12">

                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Footer Long Description') }} </label>
                                            <div class="col-lg-9 col-xl-6">
                                        <textarea class="form-control summernote" name="footer_long_description">{{ isset($footer_long_description) ? $footer_long_description : old("footer_long_description") }}</textarea>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                    </div>
                </div>

                <!--end::Portlet-->


            </div>
        </div>
    </div>
</div>
