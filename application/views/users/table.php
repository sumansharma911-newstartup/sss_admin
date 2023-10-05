<div class="card">
    <div class="card-header">
        <h3 class="card-title float-right">
            <button type="button" class="btn btn-sm btn-primary" onclick="Users.listview.askForNewUsersForm($(this));">Add New User</button>
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="users_datatable" class="table table-bordered table-hover">
                <thead>
                    <tr class="bg-light-gray">
                        <th class="text-center" style="width: 20px;">No.</th>
                        <!-- <th class="text-center" style="width: 70px;">District</th>
                        <th class="text-center" style="min-width: 160px;">Department Name</th> -->
                        <th class="text-center" style="min-width: 125px;">Mobile Number</th>
                        <th class="text-center" style="min-width: 125px;">Email</th>
                        <th class="text-center" style="min-width: 200px;">Name</th>
                        <th class="text-center" style="min-width: 110px;">Username</th>
                        <th class="text-center" style="min-width: 120px;">Type</th>
                        <th class="text-center" style="width: 80px;">Status</th>
                        <th class="text-center" style="width: 80px;">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>