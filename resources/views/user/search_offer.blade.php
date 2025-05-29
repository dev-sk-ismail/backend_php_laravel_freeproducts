@include('user.common.header')
<div class="container fullContainer noTopMargin padding40-top padding40-bottom padding40H noBorder borderSolid border3px cornersAll radius0 shadow0 bgNoRepeat emptySection" id="section--78652" data-title="Section" data-block-color="0074C7" style="padding-top: 40px; padding-bottom: 0px; outline: none;" data-trigger="none" data-animate="fade" data-delay="500">

    <div class="containerInner ui-sortable">

        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row--87502" data-trigger="none" data-animate="fade" data-delay="500" data-title="1 column row" style="padding-top: 40px; margin: 0px; outline: none;">

            <div id="col-full-170" class="col-md-12 innerContent col_left" data-col="full" data-trigger="none" data-animate="fade" data-delay="500" data-title="1st column" style="outline: none;">

                <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">

                    <div class="de elSurvey elMargin0 elAlign_s_center elAlign_st_center sfprogress_s_round sf_answer_hs_growshadow sf_answer_h_blue surveyHideNextButton cfs_26 cfs_s_18 sfprogress_taller sfprogress_c_blue sf_btn_c_blue cfs_a_20 ui-droppable de-editable" id="tmp_survey-86889" data-complete="submit" data-page-action="submit" data-de-type="survey" data-de-editing="false" data-title="survey" data-ce="false" data-trigger="none" data-animate="fade" data-delay="500" data-survey-new="true" style="margin-top: 0px; outline: none; cursor: pointer;" data-page-redirect-url="https://get.freeboldify.com/thankyou?webinar_ext=zPFaAMUx" data-outcome="{&quot;cf_outcome_bOduIv5a32o8xPR&quot;:{&quot;xhsj3&quot;:&quot;QGWXMR7rx38s&quot;},&quot;cf_outcome_kE41iaJSbpoufRC&quot;:{&quot;hRwJcZexVK&quot;:&quot;UjkyLerigjpKp0c&quot;},&quot;cf_outcome_aKPfpQrZGOF49R5&quot;:{&quot;hRwJcZexVK&quot;:&quot;7N7dD0qcfV8u9Re&quot;},&quot;cf_outcome_srqc26oVwh6JBlK&quot;:{&quot;hRwJcZexVK&quot;:&quot;OxPTSmPiJLvHibv&quot;},&quot;cf_outcome_nEypZi8wKSGE34c&quot;:{&quot;hRwJcZexVK&quot;:&quot;AyBiVoJwr8Gu3Mh&quot;},&quot;cf_outcome_Yl5kdQm8SLGR3ts&quot;:{&quot;hRwJcZexVK&quot;:&quot;GQskUmgnVoWKhQb&quot;}}" aria-disabled="false">

                        <div class="surveyStep" data-survey-step="xhsj3" data-survey-type="multi-choice" style="display: block;" data-has-subtitle="true">

                            <div class="surveyStepProgressBar" style="height: 20px;">

                                <div class="surveyStepProgressCounter" style="width: 20%; height: 20px;" data-progress-width="NaN">

                                    <span style="color:#fff;">20%</span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_headline1-89721" data-de-type="headline" data-de-editing="false" data-title="headline" data-ce="true" data-trigger="none" data-animate="fade" data-delay="500" style="margin-top: 15px; outline: none; cursor: pointer; display: block;" aria-disabled="false" data-timed-style="no-action">

    <div class="ne elHeadline hsSize3 lh4 elMargin0 elBGStyle0 hsTextShadow0" style="text-align: center; font-size: 18px !important; color: #000; text-transform: uppercase; font-size: 25px;" data-bold="inherit" contenteditable="false">

        <b>Please click on the product below you would like to claim</b>

    </div>

</div>

<div class="container" id="section-4387310000" data-title="Section" data-block-color="0074C7" style="padding-top: 40px; padding-bottom: 40px; outline: none;" data-trigger="none" data-animate="fade" data-delay="500">

    <div class="" style="padding-left:15px;">

        <div class="products-id">

            <h4 style="border-bottom: 1px solid #c5c5c5; padding-bottom: 10px; margin: 0 30%;" class="text-center"><b># {{ Session::get('amazonOderId') }}</b></h4>

        </div>

        <div class="row single-product-container">
            @if(!empty($allproducts))
            @foreach ($allproducts['data'] as $productKey => $products) <div class="col-sm-4 single-product">
                <div class="image-container">
                    <a href="javascript:void(0)" data-product-id="{{ $products->product_id }}"
                        data-variant-id="{{ $products->variant_id }}"
                        data-price="{{ $products->price }}"
                        onclick="nextPage(this, '{{ $products->name }}|{{ $products->image }}');">
                        <img src="{{asset('admin_product_images')}}/{{ $products->image }}" class="image-responsive" width="150px" height="150px">
                    </a>
                </div>
                <div class="product-details text-center">
                    <h6><b>{{ $products->name }}</b></h6>
                </div>
            </div>
            @endforeach
            @endif
        </div>

    </div>
    <form action="{{ action([App\Http\Controllers\UserController::class, 'usingDay']) }}" method="post" id="product" style="display: none">
        <input type="hidden" name="_token" value="{{ csrf_token()}}">
        <input type="hidden" name="productName" value="" id="productName">
        <input type="hidden" name="product_id" value="" id="product_id">
        <input type="hidden" name="variant_id" value="" id="variant_id">
        <input type="hidden" name="price" value="" id="price">
    </form>
</div>

</div>

@include('user.common.footer')


<script type="text/javascript">
    function nextPage(element, product_name) {
        $("#productName").val(product_name);
        $("#product_id").val($(element).data('product-id'));
        $("#variant_id").val($(element).data('variant-id'));
        $("#price").val($(element).data('price'));
        $('form').submit();
    }
</script>

</body>



</html>