<!doctype html>
<html class="no-js" lang="">
<head>
    @include('common/base')
</head>
<body>
    <!-- Left Panel -->
    @include('common/left-sidebar')
    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        @include('common/header')
        <!-- Header-->

        <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h3 class="text-center">View Lead Details</h3>
                                        </div>
                                        <hr>
                                        
                                            <div class="form-group">
                                                <label for="name" class="control-label mb-1">Name</label>
                                                <input id="name" name="name" type="text" class="form-control" value="{{ $userDetails->name}}" readonly="readonly">
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="mobile" class="control-label mb-1">Addres</label>
                                                        <input id="mobile" name="address" type="tel" class="form-control" value="{{ $userDetails->address }}" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="mobile" class="control-label mb-1">City</label>
                                                        <input id="mobile" name="city" type="tel" class="form-control" value="{{ $userDetails->city }}" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="mobile" class="control-label mb-1">State</label>
                                                        <input id="mobile" name="state" type="tel" class="form-control" value="{{ $userDetails->state }}" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="mobile" class="control-label mb-1">Zip Code</label>
                                                        <input id="mobile" name="state" type="tel" class="form-control" value="{{ $userDetails->zip_code }}" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="mobile" class="control-label mb-1">Country</label>
                                                        <input id="mobile" name="state" type="tel" class="form-control" value="{{ $userDetails->country }}" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email" class="control-label mb-1">Email</label>
                                                        <input id="email" name="email" type="text" class="form-control" value="{{ $userDetails->email }}" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email" class="control-label mb-1">phone</label>
                                                        <input id="email" name="phone" type="text" class="form-control" value="{{ $userDetails->phone }}" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email" class="control-label mb-1">Amazon Order Id</label>
                                                        <input id="email" name="amazonOderId" type="text" class="form-control" value="{{ $userDetails->amazonOderId }}" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email" class="control-label mb-1">Product Name</label>
                                                        <input id="email" name="product_name" type="text" class="form-control" value="{{ $userDetails->product_name }}" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email" class="control-label mb-1">Product Review</label>
                                                        <input id="email" name="product_review" type="text" class="form-control" value="{{ $userDetails->product_review }}" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email" class="control-label mb-1">Product Feedback</label>
                                                        <input id="email" name="product_feedback" type="text" class="form-control" value="{{ $userDetails->product_feedback }}" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email" class="control-label mb-1">Product Rating</label>
                                                        <input id="email" name="product_rating" type="text" class="form-control" value="{{ $userDetails->product_rating }}" readonly="readonly">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                           
                                            
                                    </div>
                                </div>

                            </div>
                        </div> <!-- .card -->

                    </div>
                </div>

            </div>


        </div>

        <div class="clearfix"></div>

        @include('common/footer')

    </div><!-- /#right-panel -->

@include('common/scripts')

</body>
</html>