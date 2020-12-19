<div class="tab-pane " id="social_media">
    <div class="m-portlet__body">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__body">

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="facebook">{{t('facebook')}}</label>
                                            <input class="form-control" type="url"  id="facebook" name="facebook" value="{{isset($facebook) ? $facebook : old('facebook')}}">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label
                                                for="twitter">{{t('twitter')}}</label>
                                            <input class="form-control" type="url"  id="twitter"  name="twitter" value="{{isset($twitter) ? $twitter : old('twitter')}}">
                                        </div>
                                    </div>


                                    <div class="col-6">
                                        <div class="form-group">
                                            <label
                                                for="instagram">{{t('instagram')}}</label>
                                            <input class="form-control" type="url"  id="instagram"  name="instagram" value="{{isset($instagram) ? $instagram : old('instagram')}}">
                                        </div>
                                    </div>


                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="youtube">{{t('youtube')}}</label>
                                            <input class="form-control" type="url"  id="youtube"  name="youtube" value="{{isset($youtube) ? $youtube : old('youtube')}}">
                                        </div>
                                    </div>


                                    <div class="col-6">
                                        <div class="form-group">
                                            <label
                                                for="linkedin">{{t('linkedin')}}</label>
                                            <input class="form-control" type="url"  id="linkedin"  name="linkedin" value="{{isset($linkedin) ? $linkedin : old('linkedin')}}">
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
