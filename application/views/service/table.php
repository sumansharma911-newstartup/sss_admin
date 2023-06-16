<div class="card">
    <div class="card-header">
        <h3 class="card-title float-right">
            <?php if (is_admin() || is_dept_user()) { ?>
                <button type="button" class="btn btn-sm btn-primary" onclick="Service.listview.askForNewServiceForm($(this));">
                    New Service
                </button>
            <?php } ?>
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="service_datatable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="bg-light-gray">
                        <th class="text-center v-a-m" style="width: 30px;">No.</th>
                        <th class="text-center v-a-m" style="min-width: 100px;">District<hr>Department Name</th>
                        <th class="text-center v-a-m" style="min-width: 160px;">Service Name</th>
                        <th class="text-center v-a-m" style="min-width: 120px;">Service Delivery Type</th>
                        <th class="text-center v-a-m" style="min-width: 120px;">Service Delivery Days</th>
                        <th class="text-center v-a-m" style="min-width: 120px;">Citizen Charter</th>
                        <th class="text-center v-a-m" style="min-width: 120px;">Process Flow</th>
                        <th class="text-center v-a-m" style="width: 60px;">Status</th>
                        <th class="text-center v-a-m" style="min-width: 100px;">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>