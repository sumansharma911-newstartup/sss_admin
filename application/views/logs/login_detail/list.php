<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="nav-icon fa fa-user-lock"></i> Login Details</h1>
            </div>     
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="main#dashboard">Home</a></li>
                    <li class="breadcrumb-item">Logs</li>
                    <li class="breadcrumb-item active">Login Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline card-outline-tabs" style="border: none; ">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-admin-login-logs" data-toggle="pill" href="#custom-tabs-three-admin-login-logs" role="tab" aria-controls="custom-tabs-three-admin-login-logs" aria-selected="true">Admin Cpanel</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-three-admin-login-logs" role="tabpanel" aria-labelledby="custom-tabs-admin-login-logs">
                                <div class="table-responsive">
                                    <table id="admin_login_detail_datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="bg-light-gray">
                                                <th class="text-center" style="width: 20px;">No.</th>
                                                <th class="text-center" style="min-width: 200px;">Name - Email</th>
                                                <th class="text-center" style="width: 100px;">IP Address</th>
                                                <th class="text-center" style="width: 100px;">Login At</th>
                                                <th class="text-center" style="width: 100px;">Logout At</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</section>