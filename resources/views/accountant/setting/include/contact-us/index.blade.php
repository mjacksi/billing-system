<div class="tab-pane " id="contact_us">
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
                                                for="email">{{t('email')}}</label>
                                            <input class="form-control" type="email" name="email" id="email"  name="email" value="{{isset($email) ? $email : old('email')}}">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label
                                                for="phone">{{t('phone')}}</label>
                                            <input class="form-control" type="text" name="phone" id="phone" value="{{isset($phone) ? $phone : old('phone')}}">
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
