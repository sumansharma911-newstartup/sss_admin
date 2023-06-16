<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="nav-icon fas fa-building"></i> List of Department(s)</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="main#dashboard">Home</a></li>
                    <li class="breadcrumb-item">Master Management</li>
                    <li class="breadcrumb-item active">Department(s)</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-right">
                    <button type="button" class="btn btn-sm btn-primary" onclick="Department.listview.newDepartment(false, {});">Add New Department</button>
                </h3>
            </div>
            <div class="card-body" id="department_datatable_container">
            </div>
        </div>
    </div>
</section>