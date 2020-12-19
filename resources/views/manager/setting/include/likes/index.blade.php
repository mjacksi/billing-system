<div class="tab-pane " id="likes">
    <div class="m-portlet__body">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__body">

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label
                                                for="facebook">{{t('facebook')}}</label>
                                            <input class="form-control" type="number"  id="facebook" name="facebook_likes" value="{{isset($facebook_likes) ? $facebook_likes : old('facebook_likes')}}">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label
                                                for="twitter">{{t('twitter')}}</label>
                                            <input class="form-control" type="number"  id="twitter"  name="twitter_likes" value="{{isset($twitter_likes) ? $twitter_likes : old('twitter_likes')}}">
                                        </div>
                                    </div>


                                    <div class="col-6">
                                        <div class="form-group">
                                            <label
                                                for="youtube">{{t('youtube')}}</label>
                                            <input class="form-control" type="number"  id="youtube"  name="youtube_likes" value="{{isset($youtube_likes) ? $youtube_likes : old('$youtube_likes')}}">
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
