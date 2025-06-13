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
                                            <th>Type</th>
                                            <th>Code</th>
                                            <th>Product Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> @if($allproducts->count() > 0)
                                        @foreach ($allproducts as $key => $product)
                                        <tr>
                                            <td class="serial">{{ ($allproducts->currentPage() - 1) * $allproducts->perPage() + $key + 1 }}.</td>
                                            <td>{{ $product->name }}</td>
                                            <td><span class="">{{ $product->price }}</span></td>
                                            <td><span class="">{{ $product->product_id ?? '-' }}</span></td>
                                            <td><span class="">{{ $product->variant_id ?? '-' }}</span></td>
                                            <td>{{ $product->is_voucher ? 'Voucher' : 'Product' }}</td>
                                            <td><span class="">{{ $product->code ?? '-' }}</span></td>
                                            <td><span class="">@if($product->image)<img src="{{asset('admin_product_images')}}/{{ $product->image }}" alt="{{ $product->name }}">@else - @endif</span></td>
                                            <td> <span class="mr-2" style="cursor: pointer" onclick="viewProduct('{{ $product->id }}')">
                                                    <i class="fa fa-eye"></i> View
                                                </span>
                                                <span style="cursor: pointer; color: #dc3545;" onclick="deleteProduct('{{ $product->id }}')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </span>
                                                <form id="delete-form-{{ $product->id }}" action="{{ url('admin/products/delete/' . $product->id) }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div> <!-- /.table-stats --> @if($allproducts->hasPages())
                            <div class="next_prev">
                                <div class="col-md-12">
                                    @if($allproducts->previousPageUrl())
                                    <a class="btn prev" href="{{ $allproducts->previousPageUrl() }}">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                                    @endif

                                    @if($allproducts->hasMorePages())
                                    <a class="btn next" href="{{ $allproducts->nextPageUrl() }}">
                                        <i class="fa fa-arrow-right"></i> Next
                                    </a>
                                    @endif
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