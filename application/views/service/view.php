<div class="card-header">
    <h3 class="card-title f-w-b" style="float: none; text-align: center;">
        View Service Details
    </h3>
</div>
<div class="card-body p-b-0px text-left" style="font-size: 13px;">
    <div class="table-responsive">
        <table class="table table-bordered table-padding bg-beige">
            <tr>
                <td class="f-w-b" style="width: 40%;">District / Department Name</td>
                <td>{{district_text}} / {{department_name}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Service Name</td>
                <td>{{service_name}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Designation of the Competent Authority Responsible to Deliver the Service</td>
                <td style="vertical-align: top !important;">{{designation}}</td>
            </tr>
            <tr>
                <td class="f-w-b">1st Appellate for Grievance Redressal</td>
                <td>{{first_app_for_gr}}</td>
            </tr>
            <tr>
                <td class="f-w-b">2nd Appellate for Grievance Redressal</td>
                <td>{{second_app_for_gr}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Service Declared In</td>
                <td>{{declared_in_text}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Service Declared in Remarks</td>
                <td>{{declared_in_remarks}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Service Delivery Type</td>
                <td>{{delivery_type_text}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Service Delivery Remarks</td>
                <td>{{delivery_remarks}}</td>
            </tr>
            {{#if show_sd_url}}
            <tr>
                <td class="f-w-b">Service Delivery URL</td>
                <td>{{service_url}}</td>
            </tr>
            {{/if}}
            <tr>
                <td class="f-w-b">Service Delivery Days (Citizen Charter)</td>
                <td>{{days_as_per_cc}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Service Delivery Days (S.S.S.)</td>
                <td>{{days_as_per_sss}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Delivered Service Category</td>
                <td>{{ds_category_text}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Other Category of Delivered Service</td>
                <td>{{ds_other_category}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Service Delivery Fees</td>
                <td>{{is_delivery_fees_text}}</td>
            </tr>
        </table>
    </div>
    {{#if show_delivery_fees_details}}
    <div class="f-w-b">
        Total Fees Details
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="bg-light-gray">
                    <th class="text-center" style="width: 30px;">No.</th>
                    <th class="text-center" style="min-width: 250px;">Fee Description</th>
                    <th class="text-center" style="min-width: 90px;">Fee</th>
                </tr>
            </thead>
            <tbody id="fd_item_container_for_view_service" class="bg-white"></tbody>
            <tfoot>
                <tr class="bg-light-gray">
                    <th class="text-right" colspan="2">Total Fees Payment : </th>
                    <th class="text-right">{{total_delivery_fees}} /-</th>
                </tr>
            </tfoot>
        </table>
    </div>
    {{/if}}
    <div class="table-responsive">
        <table class="table table-bordered table-padding bg-beige">
            <tr>
                <td class="f-w-b" style="width: 40%;">Payment to the Applicant</td>
                <td>{{is_payment_to_applicant_text}}</td>
            </tr>
            {{#if show_applicant_payment_details}}
            <tr>
                <td class="f-w-b">Payment Type</td>
                <td>{{applicant_payment_type_text}}</td>
            </tr>
        </table>
    </div>
    <div class="f-w-b">
        Total Payment to Applicant Details
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="bg-light-gray">
                    <th class="text-center" style="width: 30px;">No.</th>
                    <th class="text-center" style="min-width: 250px;">Payment Description</th>
                    <th class="text-center" style="min-width: 90px;">Payment</th>
                </tr>
            </thead>
            <tbody id="pd_item_container_for_view_service" class="bg-white"></tbody>
            <tfoot>
                <tr class="bg-light-gray">
                    <th class="text-right" colspan="2">Total Payment : </th>
                    <th class="text-right">{{total_applicant_payment}} /-</th>
                </tr>
            </tfoot>
        </table>
    </div>
    {{/if}}
    <div class="table-responsive">
        <table class="table table-bordered table-padding bg-beige">
            <tr>
                <td class="f-w-b" style="width: 40%;">Citizen Charter Document</td>
                <td>
                    <div id="cc_doc_name_container_for_service_view" style="display: none;">
                        <a id="cc_doc_name_href_for_service_view" target="_blank" class="cursor-pointer">
                            <label id="cc_doc_name_for_service_view" class="btn btn-sm btn-nic-blue f-w-n cursor-pointer"></label>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="f-w-b">Process Flow Document</td>
                <td>
                    <div id="process_flow_doc_name_container_for_service_view" style="display: none;">
                        <a id="process_flow_doc_name_href_for_service_view" target="_blank" class="cursor-pointer">
                            <label id="process_flow_doc_name_for_service_view" class="btn btn-sm btn-nic-blue f-w-n cursor-pointer"></label>
                        </a>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="f-w-b">
        Sample Application Submission Document (if any)
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead>
                <tr class="bg-light-gray">
                    <th class="text-center" style="width: 30px;">No.</th>
                    <th class="text-center" style="min-width: 165px;">Document Name</th>
                    <th class="text-center" style="min-width: 165px;">Sample Document</th>
                </tr>
            </thead>
            <tbody id="sas_doc_item_container_for_service_view" class="bg-white"></tbody>
        </table>
    </div>
    <div id="req_doc_container_for_service_view" class="mt-3" style="display: none;">
        <div id="req_doc_item_container_for_service_view"></div>
    </div>
</div>
<div class="card-footer pl-2 text-right">
    <button type="button" class="btn btn-sm btn-danger" onclick="Swal.close();">Close</button>
</div>