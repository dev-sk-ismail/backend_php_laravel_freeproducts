@include('user.common.header')

<div class="containerWrapper" style="background: #fff;">

    <div class="container fullContainer noTopMargin padding40-top padding40-bottom padding40H noBorder borderSolid border3px cornersAll radius0 shadow0 bgNoRepeat emptySection" id="section--78652" data-title="Section" data-block-color="0074C7" style="padding-top: 40px; padding-bottom: 40px; outline: none;" data-trigger="none" data-animate="fade" data-delay="500">

        <div class="containerInner ui-sortable">

            <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row--87502" data-trigger="none" data-animate="fade" data-delay="500" data-title="1 column row" style="padding-top: 40px; padding-bottom: 40px; margin: 0px; outline: none;">

                <div id="col-full-170" class="col-md-12 innerContent col_left" data-col="full" data-trigger="none" data-animate="fade" data-delay="500" data-title="1st column" style="outline: none;">

                    <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">

                        <div class="de elSurvey elMargin0 elAlign_s_center elAlign_st_center sfprogress_s_round sf_answer_hs_growshadow sf_answer_h_blue surveyHideNextButton cfs_26 cfs_s_18 sfprogress_taller sfprogress_c_blue sf_btn_c_blue cfs_a_20 ui-droppable de-editable" id="tmp_survey-86889" data-complete="submit" data-page-action="submit" data-de-type="survey" data-de-editing="false" data-title="survey" data-ce="false" data-trigger="none" data-animate="fade" data-delay="500" data-survey-new="true" style="margin-top: 0px; outline: none; cursor: pointer;" data-page-redirect-url="https://get.freeboldify.com/thankyou?webinar_ext=zPFaAMUx" data-outcome="{&quot;cf_outcome_bOduIv5a32o8xPR&quot;:{&quot;xhsj3&quot;:&quot;QGWXMR7rx38s&quot;},&quot;cf_outcome_kE41iaJSbpoufRC&quot;:{&quot;hRwJcZexVK&quot;:&quot;UjkyLerigjpKp0c&quot;},&quot;cf_outcome_aKPfpQrZGOF49R5&quot;:{&quot;hRwJcZexVK&quot;:&quot;7N7dD0qcfV8u9Re&quot;},&quot;cf_outcome_srqc26oVwh6JBlK&quot;:{&quot;hRwJcZexVK&quot;:&quot;OxPTSmPiJLvHibv&quot;},&quot;cf_outcome_nEypZi8wKSGE34c&quot;:{&quot;hRwJcZexVK&quot;:&quot;AyBiVoJwr8Gu3Mh&quot;},&quot;cf_outcome_Yl5kdQm8SLGR3ts&quot;:{&quot;hRwJcZexVK&quot;:&quot;GQskUmgnVoWKhQb&quot;}}" aria-disabled="false">

                            <div class="surveyStep" data-survey-step="xhsj3" data-survey-type="multi-choice" style="display: block;" data-has-subtitle="true">

                                <div class="surveyStepProgressBar" style="height: 20px;">

                                    <div class="surveyStepProgressCounter" style="width: 90%; height: 20px;" data-progress-width="NaN">

                                        <span style="color:#fff;">90%</span>

                                    </div>

                                </div>

                                <div>

                                    <h1 style="margin-top:30px;"><b>Confirm your address</b></h1>

                                    <h3>Please confirm if this is the address where you like us to ship your free Product</h3>

                                </div>

                                <div class="address_text">

                                    <div class="col-md-12">

                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul style="margin-bottom: 0px;">
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                        <form method="post" action="{{ url('userdata') }}" accept-charset="UTF-8" class="form-horizontal _address_form" name="address">



                                            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

                                            <div class="form-group">

                                                <label for="name" class="control-label col-sm-2">Name:</label>

                                                <div class="col-sm-10">

                                                    <input class="form-control" name="name" type="text" value="{{ $user_cred['name'] }}">

                                                    @if ($errors->has('name'))

                                                    @foreach ($errors->get('name') as $error)

                                                    <div class="alert alert-danger">{{ $error }}</div>

                                                    @endforeach

                                                    @endif

                                                </div>



                                            </div>

                                            <div class="form-group">

                                                <label for="pwd" class="control-label col-sm-2">Address Line 1:</label>

                                                <div class="col-sm-10">

                                                    <input class="form-control" name="address_line1" type="text" value="">

                                                    @if ($errors->has('address_line1'))

                                                    @foreach ($errors->get('address_line1') as $error)

                                                    <div class="alert alert-danger">{{ $error }}</div>

                                                    @endforeach

                                                    @endif

                                                </div>



                                            </div>

                                            <div class="form-group">

                                                <label class="control-label col-sm-2" for="address_line2">Address Line 2:</label>

                                                <div class="col-sm-10">

                                                    <input class="form-control" name="address_line2" type="text" value="">

                                                    @if ($errors->has('address_line2'))

                                                    @foreach ($errors->get('address_line2') as $error)

                                                    <div class="alert alert-danger">{{ $error }}</div>

                                                    @endforeach

                                                    @endif

                                                </div>



                                            </div>

                                            <div class="form-group">

                                                <label for="address_line3" class="control-label col-sm-2">Address Line 3:</label>

                                                <div class="col-sm-10">

                                                    <input class="form-control" name="address_line3" type="text" value="">

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="email_address" class="control-label col-sm-2">Email:</label>

                                                <div class="col-sm-10">

                                                    <input class="form-control" name="email_address" type="text" value="{{ $user_cred['email'] }}">

                                                    @if ($errors->has('email_address'))

                                                    @foreach ($errors->get('email_address') as $error)

                                                    <div class="alert alert-danger">{{ $error }}</div>

                                                    @endforeach

                                                    @endif

                                                </div>



                                            </div>

                                            <div class="form-group">

                                                <label for="phone" class="control-label col-sm-2">Phone:</label>

                                                <div class="col-sm-10">

                                                    <input class="form-control" name="phone" type="text" value="{{ $user_cred['phone_number'] }}">

                                                    @if ($errors->has('phone'))

                                                    @foreach ($errors->get('phone') as $error)

                                                    <div class="alert alert-danger">{{ $error }}</div>

                                                    @endforeach

                                                    @endif

                                                </div>



                                            </div>

                                            <div class="form-group">

                                                <label for="city" class="control-label col-sm-2">City:</label>

                                                <div class="col-sm-10">

                                                    <input class="form-control" name="city" type="text" value="">

                                                    @if ($errors->has('city'))

                                                    @foreach ($errors->get('city') as $error)

                                                    <div class="alert alert-danger">{{ $error }}</div>

                                                    @endforeach

                                                    @endif

                                                </div>



                                            </div>

                                            <div class="form-group">

                                                <label for="state_or_region" class="control-label col-sm-2">State Or Region:</label>

                                                <div class="col-sm-10">

                                                    <input class="form-control" name="state_or_region" type="text" value="">

                                                    @if ($errors->has('state_or_region'))

                                                    @foreach ($errors->get('state_or_region') as $error)

                                                    <div class="alert alert-danger">{{ $error }}</div>

                                                    @endforeach

                                                    @endif

                                                </div>



                                            </div>

                                            <div class="form-group">

                                                <label for="country_code" class="control-label col-sm-2">Country Code:</label>

                                                <div class="col-sm-10">

                                                    <input class="form-control" name="country_code" type="text" value="US">

                                                    @if ($errors->has('country_code'))

                                                    @foreach ($errors->get('country_code') as $error)

                                                    <div class="alert alert-danger">{{ $error }}</div>

                                                    @endforeach

                                                    @endif

                                                </div>



                                            </div>

                                            <div class="form-group">

                                                <label for="zip_code" class="control-label col-sm-2">Zip Code:</label>

                                                <div class="col-sm-10">

                                                    <input class="form-control" name="zip_code" type="tel" maxlength="5">

                                                    @if ($errors->has('zip_code'))

                                                    @foreach ($errors->get('zip_code') as $error)

                                                    <div class="alert alert-danger">{{ $error }}</div>

                                                    @endforeach

                                                    @endif

                                                </div>



                                            </div>

                                            <button type="submit" class="btn btn-success hide _form_buttons">Save</button>

                                            <button type="cancel" id="address-cancel" class="btn btn-danger _form_buttons hide">Cancel</button>



                                    </div>

                                </div>

                                <div class="address_buttons">

                                    <!-- <button class="btn btn-danger _address_buttons" id="no-update">NO, UPDATE THIS ADDRESS</button> -->

                                    <button type="submit" class="btn button btn-success _address_buttons">Send My Product!</button>

                                </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

@include('user.common.footer')
</body>



</html>