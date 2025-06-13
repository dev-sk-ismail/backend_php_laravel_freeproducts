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
                                <strong class="card-title">Leads Management</strong>
                            </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Leads</h3>
                        </div>
                        <div class="card-body">
                            @if(Session::has('successMessage'))
                            <div class="alert alert-success">
                                {{ Session::get('successMessage') }}
                            </div>
                            @endif
                            @if(Session::has('errorMessage'))
                            <div class="alert alert-danger">
                                {{ Session::get('errorMessage') }}
                            </div>
                            @endif

                            <table class="table table-striped table-bordered">
                                <thead>                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Product</th>
                                        <th>Order Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leads as $lead)
                                    <tr>
                                        <td>{{ $lead->id }}</td>
                                        <td>{{ $lead->name }}</td>
                                        <td>{{ $lead->email }}</td>
                                        <td>{{ $lead->phone }}</td>
                                        <td>{{ $lead->product_name }}</td>
                                                                               <td>
                                            <span class="badge badge-{{ $lead->order_status == 'fulfilled' ? 'success' : ($lead->order_status == 'voucher' ? 'info' : 'warning') }}">
                                                {{ ucfirst($lead->order_status) }}
                                                @if($lead->is_voucher)
                                                    <i class="fa fa-ticket"></i>
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $lead->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this lead?')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $leads->links() }}
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
