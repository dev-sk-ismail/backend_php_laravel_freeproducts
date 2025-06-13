<!doctype html>
<html class="no-js" lang="">

<head>
    @include('common/base')
</head>

<body>
    <!-- Left Panel -->
    @include('common/left-sidebar')
    <!-- /#left-panel -->

    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        @include('common/header')
        <!-- /#header -->

        <!-- Content -->
        <div class="content">
            @include('common/message-show')
            
            <!-- Animated -->
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Lead Details</strong>
                                <a href="{{ route('leads.index') }}" class="btn btn-secondary float-right">Back to List</a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('leads.update', $lead->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <label><strong>Name:</strong></label>
                                            <p>{{ $lead->name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Email:</strong></label>
                                            <p>{{ $lead->email }}</p>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <label><strong>Phone:</strong></label>
                                            <p>{{ $lead->phone }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Created At:</strong></label>
                                            <p>{{ $lead->created_at->format('Y-m-d H:i') }}</p>
                                        </div>
                                    </div>                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <label><strong>Product:</strong></label>
                                            <p>{{ $lead->product_name }}</p>
                                            @if($lead->is_voucher)
                                                <div class="mt-2">
                                                    <label><strong>Voucher Code:</strong></label>
                                                    <p class="text-success">{{ $lead->voucher_code }}</p>
                                                </div>
                                            @endif
                                        </div>                                        <div class="col-md-6">
                                            <label><strong>Order Status:</strong></label>
                                            <p>
                                                <span class="badge badge-{{ $lead->order_status == 'fulfilled' ? 'success' : ($lead->order_status == 'voucher' ? 'info' : 'warning') }}">
                                                    {{ ucfirst($lead->order_status) }}
                                                </span>
                                            </p>
                                            @if($lead->order_status == 'draft')
                                                <form action="{{ route('leads.fulfill', $lead->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm mt-2" onclick="return confirm('Are you sure you want to fulfill this order?')">
                                                        <i class="fa fa-check"></i> Fulfill Order
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($lead->shopify_response)
                                                <div class="mt-3">
                                                    <label><strong>Shopify Order Details:</strong></label>
                                                    <pre class="bg-light p-2 mt-2" style="font-size: 12px;">{{ json_encode(json_decode($lead->shopify_response), JSON_PRETTY_PRINT) }}</pre>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <label><strong>Amazon Order ID:</strong></label>
                                            <p>{{ $lead->amazon_order_id }}</p>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <label><strong>Address:</strong></label>
                                            <p>
                                                {{ $lead->address }}<br>
                                                {{ $lead->city }}, {{ $lead->state }} {{ $lead->zip_code }}<br>
                                                {{ $lead->country }}
                                            </p>
                                        </div>
                                    </div>                                    @if($lead->product_rating || $lead->product_review || $lead->product_feedback)
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <label><strong>Product Feedback:</strong></label>
                                            <div class="mt-2">
                                                @if($lead->product_rating)
                                                    <p><strong>Rating:</strong> {{ $lead->product_rating }}/5</p>
                                                @endif
                                                @if($lead->product_review)
                                                    <p><strong>Review:</strong> {{ $lead->product_review }}</p>
                                                @endif
                                                @if($lead->product_feedback)
                                                    <p><strong>Feedback:</strong> {{ $lead->product_feedback }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .animated -->
        </div>
        <!-- /.content -->

        <div class="clearfix"></div>

        <!-- Footer -->
        @include('common/footer')
        <!-- /.site-footer -->
    </div>
    <!-- /#right-panel -->

    @include('common/scripts')
</body>
</html>
