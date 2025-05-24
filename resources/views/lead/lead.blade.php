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
            @include('common/message-show')
            <div class="animated fadeIn listingCls">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">All Leads</strong>
                            </div>

                            <div class="table-stats order-table ov-h userListTable">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th class="serial">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Amazon OderId</th>
                                            <th>Product Name</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($allUsers))
                                            @foreach ($allUsers['data'] as $userKey => $users)
                                                <tr>
                                                    <td class="serial">{{ $userKey+1 }}.</td>
                                                    <td> {{ $users->name }} </td>
                                                    <td>  <span class="">{{ $users->email }}</span></td>
                                                    <td> <span class="">{{ $users->phone }}</span></td>
                                                    <td> <span class="">{{ $users->amazonOderId }}</span></td>
                                                    <td> <span class="">{{ $users->product_name }}</span></td>
                                                    <td> <span class="" style="cursor: pointer" onclick="viewLead('{{ $users->id }}')">View Lead</span></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div> <!-- /.table-stats -->

                            @if(!empty($allUsers))
                            <div class="next_prev">
                                <div class="col-md-12">
                                    <?php if($allUsers['prev_page_url'] != '') { ?>
                                        <a class="btn prev" href="<?php echo $allUsers['prev_page_url'] ?>"> <i class="fa fa-arrow-left"></i> Back</a>
                                    <?php } ?>

                                    <?php if($allUsers['next_page_url'] != '') { ?>
                                        <a class="btn next" href="<?php echo $allUsers['next_page_url'] ?>"> <i class="fa fa-arrow-right"></i> Next</a>
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
    function viewLead(userId) {
       window.location.href = "{{url('admin/leads/view/')}}"+'/'+userId;
    }
</script>

</body>
</html>
