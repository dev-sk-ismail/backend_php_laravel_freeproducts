@include('user.common.header')

<div id="col-right-125" class="innerContent col_right ui-resizable col-md-5" data-col="right" data-trigger="none" data-animate="fade" data-delay="500" data-title="2nd column" style="outline: none; float: none; margin: auto;">

    <div class="col-inner bgCover order-sec noBorder borderSolid border3px cornersAll shadow0 P0-top P0-bottom P0H noTopMargin radius5" style="padding: 68px 30px;">

        <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_headline1-89721" data-de-type="headline" data-de-editing="false" data-title="headline" data-ce="true" data-trigger="none" data-animate="fade" data-delay="500" style="margin-top: 15px; outline: none; cursor: pointer; display: block;" aria-disabled="false" data-timed-style="no-action">

            <div class="ne elHeadline hsSize3 lh4 elMargin0 elBGStyle0 hsTextShadow0" style="text-align: center; font-size: 18px !important; color: #000; text-transform: uppercase; font-size: 25px;" data-bold="inherit" contenteditable="false">

                <b>Please enter your Amazon Order ID below</b>

            </div>

        </div>

        <form class="_check_order_id_form" method="POST" action="{{ action([App\Http\Controllers\UserController::class, 'search_offer']) }}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="de elInputWrapper de-input-block elAlign_center elMargin0 ui-droppable de-editable" id="tmp_input-61613" data-de-type="input" data-de-editing="false" data-title="input" data-ce="false" data-trigger="none" data-animate="fade" data-delay="500" type="name" style="margin-top: 30px; outline: none; cursor: pointer;" aria-disabled="false">

                <select style="display: none;" type="" placeholder="Amazon" name="amazon" class="elInput elInput100 elAlign_left elInputMid elInputStyl0 elInputBG1 elInputBR5 elInputI0 elInputIBlack elInputIRight ceoinput required1 garlic-auto-save" data-type="extra">

                    <option value="amazon" selected="selected">Amazon</option>

                </select>

            </div>

            <div class="de elInputWrapper de-editable de-input-block elAlign_center elMargin0" id="tmp_input-85151" data-de-type="input" data-de-editing="false" data-title="input" data-ce="false" data-trigger="none" data-animate="fade" data-delay="500" type="custom_type" style="margin-top: 10px; outline: none; cursor: pointer;">

                

                <input type="custom_type" placeholder="Enter Amazon Order ID (Example: 112-1454151-2515)" name="order_id" value="" class="elInput elInput100 elAlign_left elInputMid elInputStyl0 elInputBG1 elInputBR5 elInputI0 elInputIBlack elInputIRight ceoinput required1 garlic-auto-save">

                @if ($errors->has('order_id'))

                    @foreach($errors->get('order_id') as $error)

                        <div class="alert alert-danger">{{ $error }}</div>

                    @endforeach

                @endif

            </div>

            <div class="de elBTN elAlign_center elMargin0 ui-droppable de-editable" id="tmp_button-33331" data-de-type="button" data-de-editing="false" data-title="button" data-ce="false" data-trigger="none" data-animate="fade" data-delay="500" style="margin-top: 10px; outline: none; cursor: pointer;" data-element-theme="customized" aria-disabled="false" data-elbuttontype="1" data-hide-on="">

                <button class="cst_btn elButton elButtonSize1 elButtonColor1 elButtonRounded elButtonPadding2 elBtnVP_10 elButtonCorner3 elBtnHP_25 elBTN_b_1_3 elButtonShadowN1 elButtonTxtColor2 elBTNone elButtonBlock elButtonFull" style="background: rgb(255, 95, 162); font-size: 20px;">

                    <span class="elButtonMain"><i class="fa fa_prepended"></i> Search for my order<i class="fa fa_appended"></i></span>

                    <span class="elButtonSub"></span>

                </button>

            </div>

        </form>

        <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_paragraph-50372" data-de-type="headline" data-de-editing="false" data-title="Paragraph" data-ce="true" data-trigger="none" data-animate="fade" data-delay="500" style="margin-top: 15px; outline: none; cursor: pointer; display: block;" aria-disabled="false">

            <div class="ne elHeadline hsSize1 lh5 elMargin0 elBGStyle0 hsTextShadow0" data-bold="inherit" style="text-align: left; color: #000; font-size: 14px;" contenteditable="false">

                <p>* We don't share your personal info with anyone. Check out our Privacy Policy for more information.</p>

                <div class="alert alert-info">

                    <h4>Where can I find my Amazon Order ID?</h4>

                    <p>- In your order confirmation email.</p>

                    <!-- <p>- In the receipt that came in the box with your The Last Coat product.</p> -->

                    <p>- In your Amazon account order history.</p>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

@include('user.common.footer') 


</body>



</html>