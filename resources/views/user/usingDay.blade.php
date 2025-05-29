@include('user.common.header')

<div class="containerWrapper">
    <div class="container fullContainer noTopMargin padding40-top padding40-bottom padding40H noBorder borderSolid border3px cornersAll radius0 shadow0 bgNoRepeat emptySection" id="section--78652" data-title="Section" data-block-color="0074C7" style="padding-top: 40px; padding-bottom: 97px; outline: none;" data-trigger="none" data-animate="fade" data-delay="500">
        
        <div class="containerInner ui-sortable">
            <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row--87502" data-trigger="none" data-animate="fade" data-delay="500" data-title="1 column row" style="padding-top: 40px; padding-bottom: 40px; margin: 0px; outline: none;">
                <div id="col-full-170" class="col-md-12 innerContent col_left" data-col="full" data-trigger="none" data-animate="fade" data-delay="500" data-title="1st column" style="outline: none;">
                    <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
                        <div class="de elSurvey elMargin0 elAlign_s_center elAlign_st_center sfprogress_s_round sf_answer_hs_growshadow sf_answer_h_blue surveyHideNextButton cfs_26 cfs_s_18 sfprogress_taller sfprogress_c_blue sf_btn_c_blue cfs_a_20 ui-droppable de-editable" id="tmp_survey-86889" data-complete="submit" data-page-action="submit" data-de-type="survey" data-de-editing="false" data-title="survey" data-ce="false" data-trigger="none" data-animate="fade" data-delay="500" data-survey-new="true" style="margin-top: 0px; outline: none; cursor: pointer;" data-page-redirect-url="https://get.freeboldify.com/thankyou?webinar_ext=zPFaAMUx" data-outcome="{&quot;cf_outcome_bOduIv5a32o8xPR&quot;:{&quot;xhsj3&quot;:&quot;QGWXMR7rx38s&quot;},&quot;cf_outcome_kE41iaJSbpoufRC&quot;:{&quot;hRwJcZexVK&quot;:&quot;UjkyLerigjpKp0c&quot;},&quot;cf_outcome_aKPfpQrZGOF49R5&quot;:{&quot;hRwJcZexVK&quot;:&quot;7N7dD0qcfV8u9Re&quot;},&quot;cf_outcome_srqc26oVwh6JBlK&quot;:{&quot;hRwJcZexVK&quot;:&quot;OxPTSmPiJLvHibv&quot;},&quot;cf_outcome_nEypZi8wKSGE34c&quot;:{&quot;hRwJcZexVK&quot;:&quot;AyBiVoJwr8Gu3Mh&quot;},&quot;cf_outcome_Yl5kdQm8SLGR3ts&quot;:{&quot;hRwJcZexVK&quot;:&quot;GQskUmgnVoWKhQb&quot;}}" aria-disabled="false">
                            <div class="surveyStep" data-survey-step="xhsj3" data-survey-type="multi-choice" style="display: block;" data-has-subtitle="true">
                                <div class="surveyStepHeadline">How Long Have You Been Using Your The Last Coat Product?</div>
                                <div class="surveyStepHeadline_subtitle">Count how many days since you first tried The Last Coat</div>
                                <div class="surveyStepProgressBar" style="height: 20px;">
                                    <div class="surveyStepProgressCounter" style="width: 40%; height: 20px;" data-progress-width="NaN">
                                        <span style="color:#fff;">40%</span>
                                    </div>
                                </div>
                                <div class="surveyStepQuestions">
                                        <input type="hidden" value="1" name="less_than_five">
                                        <div class="surveyRadioOption clearfix" data-answer-id="QGWXMR7rx38s" data-skip-q="end">
                                            <a style="color: #000; width:100%;" id="less_than_five">
                                                <input type="radio" name="survey" value="1" style="margin-top: 10px;">
                                                <span class="surveyRadioOptionText">0 - 5 days</span>
                                            </a>
                                        </div>
                                    
                                       
                                        <input type="hidden" value="2" name="five_to_thirty">
                                        <div class="surveyRadioOption clearfix" data-answer-id="QGWX73js">
                                            <a style="color: #000; width:100%;" id="five_to_thirty">
                                                <input type="radio" name="survey" value="2" style="    margin-top: 10px;">
                                                <span class="surveyRadioOptionText">5 - 30 days</span>
                                            </a>
                                        </div>
                                    
                                        <input type="hidden" value="3" name="more_than_thirty">
                                        <div class="surveyRadioOption clearfix" data-answer-id="T2Jc7aDsCHKbgde">
                                            <a style="color: #000; width:100%;" id="more_than_thirty">
                                                <input type="radio" name="survey" value="3" style="    margin-top: 10px;">
                                                <span class="surveyRadioOptionText" style="color: rgb(47, 47, 47);">Over 30 days</span>
                                            </a>
                                        </div>
                                  
                                </div>
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

<script type="text/javascript">
    $(".surveyRadioOption").click(function() {
        window.location.href = "{{url('product-survey')}}";
    });
</script>
</body>

</html>