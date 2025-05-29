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
        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-12">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li class="active">
                                        <a class="nav-link" href="{{url('/admin/products/add')}}"><i class="fa fa-plus"></i> Create New Product</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            @include('common/message-show')
            <div class="animated fadeIn listingCls">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">All Products</strong>
                            </div>

                            <div class="table-stats order-table ov-h userListTable">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th class="serial">#</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Product ID</th>
                                            <th>Variant ID</th>
                                            <th>Product Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($allproducts))
                                        @foreach ($allproducts['data'] as $productKey => $products)
                                        <tr>
                                            <td class="serial">{{ $productKey+1 }}.</td>
                                            <td> {{ $products->name }} </td>
                                            <td> <span class="">{{ $products->price }}</span></td>
                                            <td> <span class="">{{ $products->product_id }}</span></td>
                                            <td> <span class="">{{ $products->variant_id }}</span></td>
                                            <td> <span class=""><img src="{{asset('admin_product_images')}}/{{ $products->image }}"></span></td>
                                            <td>
                                                <span class="mr-2" style="cursor: pointer" onclick="viewProduct('{{ $products->id }}')">
                                                    <i class="fa fa-eye"></i> View
                                                </span>
                                                <span style="cursor: pointer; color: #dc3545;" onclick="deleteProduct('{{ $products->id }}')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </span>
                                                <form id="delete-form-{{ $products->id }}" action="{{ url('admin/products/delete/' . $products->id) }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div> <!-- /.table-stats -->

                            @if(!empty($allproducts))
                            <div class="next_prev">
                                <div class="col-md-12">
                                    <?php if ($allproducts['prev_page_url'] != '') { ?>
                                        <a class="btn prev" href="<?php echo $allproducts['prev_page_url'] ?>"> <i class="fa fa-arrow-left"></i> Back</a>
                                    <?php } ?>

                                    <?php if ($allproducts['next_page_url'] != '') { ?>
                                        <a class="btn next" href="<?php echo $allproducts['next_page_url'] ?>"> <i class="fa fa-arrow-right"></i> Next</a>
                                    <?php } ?>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="clearfix"></div>

        @include('common/footer')

    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    @include('common/scripts')

    <script type="text/javascript">
        function viewProduct(productId) {
            window.location.href = "{{url('admin/products/view/')}}" + '/' + productId;
        }

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>

</body>

</html>