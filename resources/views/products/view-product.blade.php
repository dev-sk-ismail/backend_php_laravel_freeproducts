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
                                            <h3 class="text-center">View Product Details</h3>
                                        </div>
                                        <hr>
                                        <form action="{{ url('admin/products/update/' . $productDetails->id) }}" method="post" enctype="multipart/form-data">
                                            {{ csrf_field() }}

                                            <div class="form-group">
                                                <label for="name" class="control-label mb-1">Name</label>
                                                <input id="name" name="name" type="text" class="form-control @if ($errors->has('name')) is-invalid @endif" value="{{ $productDetails->name}}">
                                                @if ($errors->has('name'))
                                                @foreach ($errors->get('name') as $error)
                                                <span class="help-block formValidationError">{{ $error }}</span>
                                                @endforeach
                                                @endif
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="price" class="control-label mb-1">Price</label>
                                                        <input id="price" name="price" type="tel" class="form-control @if ($errors->has('price')) is-invalid @endif" value="{{ $productDetails->price }}">
                                                        @if ($errors->has('price'))
                                                        @foreach ($errors->get('price') as $error)
                                                        <span class="help-block formValidationError">{{ $error }}</span>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="product_id" class="control-label mb-1">Product ID</label>
                                                        <input id="product_id" name="product_id" type="text" class="form-control @if ($errors->has('product_id')) is-invalid @endif" value="{{ $productDetails->product_id }}">
                                                        @if ($errors->has('product_id'))
                                                        @foreach ($errors->get('product_id') as $error)
                                                        <span class="help-block formValidationError">{{ $error }}</span>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="variant_id" class="control-label mb-1">Variant ID</label>
                                                        <input id="variant_id" name="variant_id" type="text" class="form-control @if ($errors->has('variant_id')) is-invalid @endif" value="{{ $productDetails->variant_id }}">
                                                        @if ($errors->has('variant_id'))
                                                        @foreach ($errors->get('variant_id') as $error)
                                                        <span class="help-block formValidationError">{{ $error }}</span>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="image" class="control-label mb-1">Image</label>
                                                        <input type="file" id="image" name="image" class="form-control-file" accept="image/png, image/jpeg">
                                                        <div class="mt-2">
                                                            <label>Current Image:</label>
                                                            <img src="{{asset('admin_product_images')}}/{{$productDetails->image}}" style="max-width: 200px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <button type="submit" class="btn btn-lg btn-info btn-block">
                                                    Update Product
                                                </button>
                                            </div>
                                        </form>
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