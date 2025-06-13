@include('user.common.header')
<div class="containerInner ui-sortable">
    <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row--63347" data-trigger="none" data-animate="fade" data-delay="500" data-title="3 column row" style="padding-top: 10px; padding-bottom: 10px; margin: 0px; outline: none;">
        <div id="col-left-148" class="col-md-4 innerContent col_left ui-resizable" data-col="left" data-trigger="none" data-animate="fade" data-delay="500" data-title="1st column" style="outline: none;">
            <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
                <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_subheadline-49617" data-de-type="headline" data-de-editing="false" data-title="sub-headline" data-ce="true" data-trigger="none" data-animate="fade" data-delay="500" style="margin-top: 25px; outline: none; cursor: pointer;" aria-disabled="false">
                    <div class="ne elHeadline hsSize2 lh3 elMargin0 elBGStyle0 hsTextShadow0" style="text-align: center; font-size: 23px; color: rgb(71, 71, 71);" data-bold="inherit" contenteditable="false">
                    </div>
                </div>
            </div>
        </div>

        <div id="col-right-138" class="col-md-4 innerContent col_right ui-resizable" data-col="right" data-trigger="none" data-animate="fade" data-delay="500" data-title="3rd column" style="outline: none;">
            <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">

            </div>
        </div>
    </div>
</div>
</div>





<div class="container noTopMargin padding40-top padding40-bottom padding40H noBorder borderSolid border3px cornersAll radius0 shadow0 emptySection fullContainer bgCover" id="section--91140" data-title="Section" data-block-color="0074C7" style="padding-top: 15px; padding-bottom: 20px; outline: none; margin-top: 0px; background-color: rgb(255, 255, 255);" data-trigger="none" data-animate="fade" data-delay="500" data-hide-on="">
    <div class="containerInner ui-sortable" style="padding-left: 0px; padding-right: 0px;">
        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row--35301" data-trigger="none" data-animate="fade" data-delay="500" data-title="1 column row" style="padding-top: 20px; padding-bottom: 20px; margin: 0px; outline: none;" data-hide-on="">
            <div id="col-full-144" class="col-md-12 innerContent col_left" data-col="full" data-trigger="none" data-animate="fade" data-delay="500" data-title="1st column" style="outline: none;">
                <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">


                    <div class="de elHeadlineWrapper ui-droppable de-editable" id="headline-20525" data-de-type="headline" data-de-editing="false" data-title="sub-headline" data-ce="true" data-trigger="none" data-animate="fade" data-delay="500" style="margin-top: 15px; outline: none; cursor: pointer; background-color: rgba(255, 255, 255, 0.36);" aria-disabled="false">
                        <div class="ne elHeadline hsSize2 lh3 elMargin0 elBGStyle0 hsTextShadow0 de1pxLetterSpacing" style="text-align: left; color: rgb(71, 71, 71); font-size: 18px; background-color: rgba(255, 255, 255, 0.36);" data-bold="inherit" contenteditable="false" data-gramm="false" spellcheck="false"><br><br>
                            <div>
                                <h3><strong>Thank you for submitting your review and confirming your information.</strong></h3>
                            </div><br><br>

                            @if(Session::has('voucher_code'))
                            <div class="voucher-section" style="background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
                                <h4><strong>Your Gift Voucher Code:</strong></h4>
                                <div class="code-display" style="display: flex; align-items: center; gap: 10px; margin-top: 10px;">
                                    <input type="text" id="voucherCode" value="{{ Session::get('voucher_code') }}"
                                        style="padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; width: 200px;"
                                        readonly>
                                    <button onclick="copyVoucherCode()"
                                        style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                        Copy Code
                                    </button>
                                </div>
                                <p style="margin-top: 10px; color: #666;">Click the button to copy the code to your clipboard.</p>
                            </div>

                            <script>
                                function copyVoucherCode() {
                                    var codeInput = document.getElementById('voucherCode');
                                    codeInput.select();
                                    document.execCommand('copy');
                                    alert('Voucher code copied to clipboard!');
                                }
                            </script>
                            @else
                            <div><strong>Once your request has been approved (within 2 business days), you will receive
                                    an e-mail confirming your free product shipment.</strong> </div><br><br>
                            @endif

                            <div><strong>This e-mail will come from <a href="mailto:contact@thelastcoat.com" target="_top">contact@thelastcoat.com</a>.</strong> </div><br><br>

                            <div><strong>Thanks!</strong></div><br><br>

                            <div><strong>Nick & Chad - Team TLC</strong></div>
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