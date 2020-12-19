<div class="tab-pane active " id="m_general-settings">
    <div class="m-portlet__body">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__body">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="site_name">{{t('site_name')}}</label>
                                        <input class="form-control" type="text" id="site_name" name="site_name" value="{{isset($site_name) ? $site_name : old('site_name')}}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="address">{{t('address')}}</label>
                                        <input class="form-control" type="text" id="address" name="address" value="{{isset($address) ? $address : old('address')}}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group m-form__group">
                                        <label  for="about_us_footer">{{t('about_us_footer')}}</label>
                                        <textarea name="about_us_footer" id="about_us_footer" name="about_us_footer" cols="30" rows="10"
                                                  class="form-control">{{isset($about_us_footer) ? $about_us_footer : old('about_us_footer')}}</textarea>
                                    </div>
                                </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="Logo">{{ t('Logo') }}</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="upload-btn-wrapper">
                                                        <button class="btn btn-brand">{{ t('upload file') }}</button>
                                                        <input name="logo" class="imgInp" id="imgInp" type="file"/>
                                                    </div>
                                                    <img id="blah" style="display:{{!isset($logo)? 'none' :'block'}}"
                                                         src="{{ isset($logo)  ? url($logo):'' }}" width="150"
                                                         alt="No file chosen"/>
                                                </div>
                                            </div>
                                        </div>


                                <div class="col-6">
                                    <div class="form-group">

                                        <label for="bannerFile">{{ t('bannerFile') }}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="upload-btn-wrapper">
                                                <button class="btn btn-brand">{{ t('upload file') }}</button>
                                                <input name="bannerFile" class="imgInp" id="imgInp" type="file"/>
                                            </div>
                                            <img id="" style="display:{{!isset($bannerFile)? 'none' :'block'}}"
                                                 src="{{ isset($bannerFile)  ? url($bannerFile):'' }}" width="150"
                                                 alt="No file chosen"/>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="form-group">

                                        <label for="adFile">{{ t('adFile') }}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="upload-btn-wrapper">
                                                <button class="btn btn-brand">{{ t('upload file') }}</button>
                                                <input name="adFile" class="imgInp" id="imgInp" type="file"/>
                                            </div>
                                            <img id="" style="display:{{!isset($adFile)? 'none' :'block'}}"
                                                 src="{{ isset($adFile)  ? url($adFile):'' }}" width="150"
                                                 alt="No file chosen"/>
                                        </div>

                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="form-group">
                                        <label  for="occasions">{{t('occasions')}}</label>
{{--                                        <label class="col-xl-3 col-lg-3 col-form-label">{{ t('occasions') }}</label>--}}
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="upload-btn-wrapper">
                                                <button class="btn btn-brand">{{ t('upload file') }}</button>
                                                <input name="occasions" class="imgInp" id="imgInp" type="file"/>
                                            </div>
                                            <img id="" style="display:{{!isset($occasions)? 'none' :'block'}}"
                                                 src="{{ isset($occasions)  ? url($occasions):'' }}" width="150"
                                                 alt="No file chosen"/>
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
