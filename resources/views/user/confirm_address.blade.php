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

                                        <form method="post" action="{{ action([App\Http\Controllers\UserController::class, 'generateLead']) }}" accept-charset="UTF-8" class="form-horizontal _address_form" name="address">



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

                                            <div class="form-group"> <label for="country_code" class="control-label col-sm-2">Country Code:</label>

                                                <div class="col-sm-10">

                                                    <select class="form-control" name="country_code">
                                                        <optgroup label="Popular Countries">
                                                            <option value="US" selected>United States</option>
                                                            <option value="MX">Mexico</option>
                                                            <option value="ES">Spain</option>
                                                            <option value="IN">India</option>
                                                        </optgroup>
                                                        <optgroup label="All Countries">
                                                            <option value="AF">Afghanistan</option>
                                                            <option value="AL">Albania</option>
                                                            <option value="DZ">Algeria</option>
                                                            <option value="AS">American Samoa</option>
                                                            <option value="AD">Andorra</option>
                                                            <option value="AO">Angola</option>
                                                            <option value="AI">Anguilla</option>
                                                            <option value="AQ">Antarctica</option>
                                                            <option value="AG">Antigua and Barbuda</option>
                                                            <option value="AR">Argentina</option>
                                                            <option value="AM">Armenia</option>
                                                            <option value="AW">Aruba</option>
                                                            <option value="AU">Australia</option>
                                                            <option value="AT">Austria</option>
                                                            <option value="AZ">Azerbaijan</option>
                                                            <option value="BS">Bahamas</option>
                                                            <option value="BH">Bahrain</option>
                                                            <option value="BD">Bangladesh</option>
                                                            <option value="BB">Barbados</option>
                                                            <option value="BY">Belarus</option>
                                                            <option value="BE">Belgium</option>
                                                            <option value="BZ">Belize</option>
                                                            <option value="BJ">Benin</option>
                                                            <option value="BM">Bermuda</option>
                                                            <option value="BT">Bhutan</option>
                                                            <option value="BO">Bolivia</option>
                                                            <option value="BA">Bosnia and Herzegovina</option>
                                                            <option value="BW">Botswana</option>
                                                            <option value="BV">Bouvet Island</option>
                                                            <option value="BR">Brazil</option>
                                                            <option value="IO">British Indian Ocean Territory</option>
                                                            <option value="BN">Brunei Darussalam</option>
                                                            <option value="BG">Bulgaria</option>
                                                            <option value="BF">Burkina Faso</option>
                                                            <option value="BI">Burundi</option>
                                                            <option value="KH">Cambodia</option>
                                                            <option value="CM">Cameroon</option>
                                                            <option value="CA">Canada</option>
                                                            <option value="CV">Cape Verde</option>
                                                            <option value="KY">Cayman Islands</option>
                                                            <option value="CF">Central African Republic</option>
                                                            <option value="TD">Chad</option>
                                                            <option value="CL">Chile</option>
                                                            <option value="CN">China</option>
                                                            <option value="CX">Christmas Island</option>
                                                            <option value="CC">Cocos (Keeling) Islands</option>
                                                            <option value="CO">Colombia</option>
                                                            <option value="KM">Comoros</option>
                                                            <option value="CG">Congo</option>
                                                            <option value="CD">Congo, Democratic Republic</option>
                                                            <option value="CK">Cook Islands</option>
                                                            <option value="CR">Costa Rica</option>
                                                            <option value="CI">Cote D'Ivoire</option>
                                                            <option value="HR">Croatia</option>
                                                            <option value="CU">Cuba</option>
                                                            <option value="CY">Cyprus</option>
                                                            <option value="CZ">Czech Republic</option>
                                                            <option value="DK">Denmark</option>
                                                            <option value="DJ">Djibouti</option>
                                                            <option value="DM">Dominica</option>
                                                            <option value="DO">Dominican Republic</option>
                                                            <option value="EC">Ecuador</option>
                                                            <option value="EG">Egypt</option>
                                                            <option value="SV">El Salvador</option>
                                                            <option value="GQ">Equatorial Guinea</option>
                                                            <option value="ER">Eritrea</option>
                                                            <option value="EE">Estonia</option>
                                                            <option value="ET">Ethiopia</option>
                                                            <option value="FK">Falkland Islands</option>
                                                            <option value="FO">Faroe Islands</option>
                                                            <option value="FJ">Fiji</option>
                                                            <option value="FI">Finland</option>
                                                            <option value="FR">France</option>
                                                            <option value="GF">French Guiana</option>
                                                            <option value="PF">French Polynesia</option>
                                                            <option value="TF">French Southern Territories</option>
                                                            <option value="GA">Gabon</option>
                                                            <option value="GM">Gambia</option>
                                                            <option value="GE">Georgia</option>
                                                            <option value="DE">Germany</option>
                                                            <option value="GH">Ghana</option>
                                                            <option value="GI">Gibraltar</option>
                                                            <option value="GR">Greece</option>
                                                            <option value="GL">Greenland</option>
                                                            <option value="GD">Grenada</option>
                                                            <option value="GP">Guadeloupe</option>
                                                            <option value="GU">Guam</option>
                                                            <option value="GT">Guatemala</option>
                                                            <option value="GN">Guinea</option>
                                                            <option value="GW">Guinea-Bissau</option>
                                                            <option value="GY">Guyana</option>
                                                            <option value="HT">Haiti</option>
                                                            <option value="HM">Heard and McDonald Islands</option>
                                                            <option value="VA">Holy See (Vatican City)</option>
                                                            <option value="HN">Honduras</option>
                                                            <option value="HK">Hong Kong</option>
                                                            <option value="HU">Hungary</option>
                                                            <option value="IS">Iceland</option>
                                                            <option value="ID">Indonesia</option>
                                                            <option value="IR">Iran</option>
                                                            <option value="IQ">Iraq</option>
                                                            <option value="IE">Ireland</option>
                                                            <option value="IL">Israel</option>
                                                            <option value="IT">Italy</option>
                                                            <option value="JM">Jamaica</option>
                                                            <option value="JP">Japan</option>
                                                            <option value="JO">Jordan</option>
                                                            <option value="KZ">Kazakhstan</option>
                                                            <option value="KE">Kenya</option>
                                                            <option value="KI">Kiribati</option>
                                                            <option value="KP">Korea, Democratic People's Republic</option>
                                                            <option value="KR">Korea, Republic of</option>
                                                            <option value="KW">Kuwait</option>
                                                            <option value="KG">Kyrgyzstan</option>
                                                            <option value="LA">Lao People's Democratic Republic</option>
                                                            <option value="LV">Latvia</option>
                                                            <option value="LB">Lebanon</option>
                                                            <option value="LS">Lesotho</option>
                                                            <option value="LR">Liberia</option>
                                                            <option value="LY">Libya</option>
                                                            <option value="LI">Liechtenstein</option>
                                                            <option value="LT">Lithuania</option>
                                                            <option value="LU">Luxembourg</option>
                                                            <option value="MO">Macao</option>
                                                            <option value="MK">Macedonia</option>
                                                            <option value="MG">Madagascar</option>
                                                            <option value="MW">Malawi</option>
                                                            <option value="MY">Malaysia</option>
                                                            <option value="MV">Maldives</option>
                                                            <option value="ML">Mali</option>
                                                            <option value="MT">Malta</option>
                                                            <option value="MH">Marshall Islands</option>
                                                            <option value="MQ">Martinique</option>
                                                            <option value="MR">Mauritania</option>
                                                            <option value="MU">Mauritius</option>
                                                            <option value="YT">Mayotte</option>
                                                            <option value="FM">Micronesia</option>
                                                            <option value="MD">Moldova</option>
                                                            <option value="MC">Monaco</option>
                                                            <option value="MN">Mongolia</option>
                                                            <option value="MS">Montserrat</option>
                                                            <option value="MA">Morocco</option>
                                                            <option value="MZ">Mozambique</option>
                                                            <option value="MM">Myanmar</option>
                                                            <option value="NA">Namibia</option>
                                                            <option value="NR">Nauru</option>
                                                            <option value="NP">Nepal</option>
                                                            <option value="NL">Netherlands</option>
                                                            <option value="AN">Netherlands Antilles</option>
                                                            <option value="NC">New Caledonia</option>
                                                            <option value="NZ">New Zealand</option>
                                                            <option value="NI">Nicaragua</option>
                                                            <option value="NE">Niger</option>
                                                            <option value="NG">Nigeria</option>
                                                            <option value="NU">Niue</option>
                                                            <option value="NF">Norfolk Island</option>
                                                            <option value="MP">Northern Mariana Islands</option>
                                                            <option value="NO">Norway</option>
                                                            <option value="OM">Oman</option>
                                                            <option value="PK">Pakistan</option>
                                                            <option value="PW">Palau</option>
                                                            <option value="PS">Palestinian Territory</option>
                                                            <option value="PA">Panama</option>
                                                            <option value="PG">Papua New Guinea</option>
                                                            <option value="PY">Paraguay</option>
                                                            <option value="PE">Peru</option>
                                                            <option value="PH">Philippines</option>
                                                            <option value="PN">Pitcairn</option>
                                                            <option value="PL">Poland</option>
                                                            <option value="PT">Portugal</option>
                                                            <option value="PR">Puerto Rico</option>
                                                            <option value="QA">Qatar</option>
                                                            <option value="RE">Reunion</option>
                                                            <option value="RO">Romania</option>
                                                            <option value="RU">Russian Federation</option>
                                                            <option value="RW">Rwanda</option>
                                                            <option value="SH">Saint Helena</option>
                                                            <option value="KN">Saint Kitts and Nevis</option>
                                                            <option value="LC">Saint Lucia</option>
                                                            <option value="PM">Saint Pierre and Miquelon</option>
                                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                                            <option value="WS">Samoa</option>
                                                            <option value="SM">San Marino</option>
                                                            <option value="ST">Sao Tome and Principe</option>
                                                            <option value="SA">Saudi Arabia</option>
                                                            <option value="SN">Senegal</option>
                                                            <option value="CS">Serbia and Montenegro</option>
                                                            <option value="SC">Seychelles</option>
                                                            <option value="SL">Sierra Leone</option>
                                                            <option value="SG">Singapore</option>
                                                            <option value="SK">Slovakia</option>
                                                            <option value="SI">Slovenia</option>
                                                            <option value="SB">Solomon Islands</option>
                                                            <option value="SO">Somalia</option>
                                                            <option value="ZA">South Africa</option>
                                                            <option value="GS">South Georgia</option>
                                                            <option value="LK">Sri Lanka</option>
                                                            <option value="SD">Sudan</option>
                                                            <option value="SR">Suriname</option>
                                                            <option value="SJ">Svalbard and Jan Mayen</option>
                                                            <option value="SZ">Swaziland</option>
                                                            <option value="SE">Sweden</option>
                                                            <option value="CH">Switzerland</option>
                                                            <option value="SY">Syrian Arab Republic</option>
                                                            <option value="TW">Taiwan</option>
                                                            <option value="TJ">Tajikistan</option>
                                                            <option value="TZ">Tanzania</option>
                                                            <option value="TH">Thailand</option>
                                                            <option value="TL">Timor-Leste</option>
                                                            <option value="TG">Togo</option>
                                                            <option value="TK">Tokelau</option>
                                                            <option value="TO">Tonga</option>
                                                            <option value="TT">Trinidad and Tobago</option>
                                                            <option value="TN">Tunisia</option>
                                                            <option value="TR">Turkey</option>
                                                            <option value="TM">Turkmenistan</option>
                                                            <option value="TC">Turks and Caicos Islands</option>
                                                            <option value="TV">Tuvalu</option>
                                                            <option value="UG">Uganda</option>
                                                            <option value="UA">Ukraine</option>
                                                            <option value="AE">United Arab Emirates</option>
                                                            <option value="GB">United Kingdom</option>
                                                            <option value="UM">United States Minor Outlying Islands</option>
                                                            <option value="UY">Uruguay</option>
                                                            <option value="UZ">Uzbekistan</option>
                                                            <option value="VU">Vanuatu</option>
                                                            <option value="VE">Venezuela</option>
                                                            <option value="VN">Vietnam</option>
                                                            <option value="VG">Virgin Islands, British</option>
                                                            <option value="VI">Virgin Islands, U.S.</option>
                                                            <option value="WF">Wallis and Futuna</option>
                                                            <option value="EH">Western Sahara</option>
                                                            <option value="YE">Yemen</option>
                                                            <option value="ZM">Zambia</option>
                                                            <option value="ZW">Zimbabwe</option>
                                                        </optgroup>
                                                    </select>

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