<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="float: none; text-align: center;">Service Details Form</h3>
            </div>
            <form role="form" id="service_form" name="service_form" onsubmit="return false;">
                <input type="hidden" id="service_id_for_service" name="service_id_for_service" value="{{service_id}}">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 text-center">
                            <span class="error-message error-message-service f-w-b" style="border-bottom: 2px solid red;"></span>
                        </div>
                    </div>
                    <?php if (is_admin()) { ?>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label><span class="service-cnt"></span>. District <span style="color: red;">*</span></label>
                                <select id="district_for_service" name="district_for_service" class="form-control select2"
                                        onchange="districtChangeEvent($(this), 'service');
                                                checkValidation('department', 'district_for_service', districtValidationMessage);"
                                        data-placeholder="Select District" style="width: 100%;">
                                </select>
                                <span class="error-message error-message-service-district_for_service"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label><span class="service-cnt"></span>. Department Name <span style="color: red;">*</span></label>
                                <select id="department_id_for_service" name="department_id_for_service" class="form-control select2"
                                        onchange="checkValidation('department', 'department_id_for_service', oneOptionValidationMessage);"
                                        data-placeholder="Select Department" style="width: 100%;">
                                </select>
                                <span class="error-message error-message-service-department_id_for_service"></span>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label><span class="service-cnt"></span>. Service Name <span style="color: red;">*</span></label>
                            <input type="text" id="service_name_for_service" name="service_name_for_service" 
                                   class="form-control" placeholder="Enter Service Name !"
                                   maxlength="100" onblur="checkValidation('service', 'service_name_for_service', serviceNameValidationMessage);"
                                   value="{{service_name}}">
                            <span class="error-message error-message-service-service_name_for_service"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label><span class="service-cnt"></span>. Designation of the Competent Authority Responsible to Deliver the Service <span style="color: red;">*</span></label>
                            <textarea id="designation_for_service" name="designation_for_service" 
                                      class="form-control" placeholder="Enter Designation !"
                                      onblur="checkValidation('service', 'designation_for_service', designationValidationMessage);"
                                      >{{designation}}</textarea>
                            <span class="error-message error-message-service-designation_for_service"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label><span class="service-cnt"></span>. 1st Appellate for Grievance Redressal</label>
                            <input type="text" id="first_app_for_gr_for_service" name="first_app_for_gr_for_service" 
                                   class="form-control" placeholder="Enter 1st Appellate for Grievance Redressal !"
                                   maxlength="100" value="{{first_app_for_gr}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label><span class="service-cnt"></span>. 2nd Appellate for Grievance Redressal</label>
                            <input type="text" id="second_app_for_gr_for_service" name="second_app_for_gr_for_service" 
                                   class="form-control" placeholder="Enter 2nd Appellate for Grievance Redressal !"
                                   maxlength="100" value="{{second_app_for_gr}}">
                        </div>
                    </div>
                    <div class="card bg-beige">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label><span class="service-cnt"></span>. Service Declared In <span style="color: red;">*</span></label><br>
                                    <div class="row" id="declared_in_container_for_service"></div>
                                    <span class="error-message error-message-service-declared_in_for_service"></span>
                                </div>
                                <div class="form-group col-sm-6" id="declared_in_remarks_container_for_service" style="display: none;">
                                    <label><?php echo is_admin() ? '7' : '5'; ?>.1 Service Declared in Remarks <span style="color: red;">*</span></label>
                                    <textarea id="declared_in_remarks_for_service" name="declared_in_remarks_for_service" class="form-control"
                                              placeholder="Enter Service Declared in Remarks !"
                                              onblur="checkValidation('service', 'declared_in_remarks_for_service', remarksValidationMessage);"
                                              maxlength="200">{{declared_in_remarks}}</textarea>
                                    <span class="error-message error-message-service-declared_in_remarks_for_service"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-beige">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label><span class="service-cnt"></span>. Service Delivery Type <span style="color: red;">*</span></label><br>
                                    <div class="row" id="delivery_type_container_for_service"></div>
                                    <span class="error-message error-message-service-delivery_type_for_service"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label><?php echo is_admin() ? '8' : '6'; ?>.1 Service Delivery Remarks <span style="color: red;">*</span></label>
                                    <textarea id="delivery_remarks_for_service" name="delivery_remarks_for_service" class="form-control"
                                              placeholder="Enter Service Delivery Remarks !"
                                              onblur="checkValidation('service', 'delivery_remarks_for_service', remarksValidationMessage);"
                                              maxlength="200">{{delivery_remarks}}</textarea>
                                    <span class="error-message error-message-service-delivery_remarks_for_service"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6" id="service_url_container_for_service" style="display: none;">
                                    <label><?php echo is_admin() ? '8' : '6'; ?>.2 Service Delivery URL <span style="color: red;">*</span></label>
                                    <textarea id="service_url_for_service" name="service_url_for_service" class="form-control"
                                              placeholder="Enter Service Delivery Type !"
                                              onblur="checkValidation('service', 'service_url_for_service', sdURLValidationMessage);"
                                              maxlength="200">{{service_url}}</textarea>
                                    <span class="error-message error-message-service-service_url_for_service"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-beige mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label><span class="service-cnt"></span>. Service Delivery Days (Citizen Charter)</label>
                                    <input type="text" id="days_as_per_cc_for_service" name="days_as_per_cc_for_service" 
                                           class="form-control" placeholder="Enter Service Delivery Days !"
                                           maxlength="3" onkeyup="checkNumeric($(this));" onblur="checkNumeric($(this));"
                                           value="{{days_as_per_cc}}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label><span class="service-cnt"></span>. Service Delivery Days (S.S.S.)</label>
                                    <input type="text" id="days_as_per_sss_for_service" name="days_as_per_sss_for_service" 
                                           class="form-control" placeholder="Enter Service Delivery Days !"
                                           maxlength="3" onkeyup="checkNumeric($(this));" onblur="checkNumeric($(this));"
                                           value="{{days_as_per_sss}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-beige mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label><span class="service-cnt"></span>. Delivered Service Category <span style="color: red;">*</span></label><br>
                                    <div id="ds_category_container_for_service"></div>
                                    <span class="error-message error-message-service-ds_category_for_service"></span>
                                </div>
                                <div class="form-group col-sm-6" id="ds_other_category_container_for_service" style="display: none;">
                                    <label><?php echo is_admin() ? '11' : '9'; ?>.1 Other Category of Delivered Service <span style="color: red;">*</span></label>
                                    <textarea id="ds_other_category_for_service" name="ds_other_category_for_service" class="form-control"
                                              placeholder="Enter Other Category of Delivered Service !"
                                              onblur="checkValidation('service', 'ds_other_category_for_service', otherDSCategoryValidationMessage);"
                                              maxlength="200">{{ds_other_category}}</textarea>
                                    <span class="error-message error-message-service-ds_other_category_for_service"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-beige mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label><span class="service-cnt"></span>. Service Delivery Fees <span style="color: red;">*</span></label><br>
                                    <div id="is_delivery_fees_container_for_service"></div>
                                    <span class="error-message error-message-service-is_delivery_fees_for_service"></span>
                                </div>
                            </div>
                            <div class="card mb-0" id="delivery_fees_details_container_for_service" style="display: none;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <span class="error-message error-message-fd f-w-b" style="border-bottom: 2px solid red;"></span>
                                        </div>
                                    </div>
                                    <div class="f-w-b">
                                        <?php echo is_admin() ? '12' : '10'; ?>.1 Total Fees Details <span style="color: red;">*</span>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="bg-light-gray">
                                                    <th class="text-center" style="width: 30px;">No.</th>
                                                    <th class="text-center" style="min-width: 250px;">Fee Description</th>
                                                    <th class="text-center" style="min-width: 90px;">Fee</th>
                                                    <th class="text-center" style="width: 50px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="fd_item_container_for_service" class="bg-white"></tbody>
                                            <tfoot>
                                                <tr class="bg-light-gray">
                                                    <th class="text-right" colspan="2">Total Fees Payment : </th>
                                                    <th id="total_fees_for_service" class="text-right">0 /-</th>
                                                    <th class="text-center"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-primary float-right"
                                                onclick="Service.listview.addFDRow({});">Add More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-beige mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label><span class="service-cnt"></span>. Payment to the Applicant <span style="color: red;">*</span></label><br>
                                    <div id="is_payment_to_applicant_container_for_service"></div>
                                    <span class="error-message error-message-service-is_payment_to_applicant_for_service"></span>
                                </div>
                                <div class="form-group col-sm-6 applicant_payment_details_container_for_service" style="display: none;">
                                    <label><?php echo is_admin() ? '13' : '11'; ?>.1 Payment Type <span style="color: red;">*</span></label><br>
                                    <div id="applicant_payment_type_container_for_service"></div>
                                    <span class="error-message error-message-service-applicant_payment_type_for_service"></span>
                                </div>
                            </div>
                            <div class="card mb-0 applicant_payment_details_container_for_service" style="display: none;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <span class="error-message error-message-pd f-w-b" style="border-bottom: 2px solid red;"></span>
                                        </div>
                                    </div>
                                    <div class="f-w-b">
                                        <?php echo is_admin() ? '13' : '11'; ?>.2 Total Payment to Applicant Details <span style="color: red;">*</span>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="bg-light-gray">
                                                    <th class="text-center" style="width: 30px;">No.</th>
                                                    <th class="text-center" style="min-width: 250px;">Payment Description</th>
                                                    <th class="text-center" style="min-width: 90px;">Payment</th>
                                                    <th class="text-center" style="width: 50px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="pd_item_container_for_service" class="bg-white"></tbody>
                                            <tfoot>
                                                <tr class="bg-light-gray">
                                                    <th class="text-right" colspan="2">Total Payment : </th>
                                                    <th id="total_payment_for_service" class="text-right">0 /-</th>
                                                    <th class="text-center"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <button type="button" class="btn btn-sm btn-primary float-right"
                                                onclick="Service.listview.addPDRow({});">Add More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-beige mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-danger f-w-b">
                                    Note : Maximum File Size: 10MB & Upload JPG, PNG, JPEG & PDF File Only.
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <div id="cc_doc_container_for_service">
                                        <label><span class="service-cnt"></span>. Upload Citizen Charter <span style="color: red;">*</span></label><br>
                                        <input type="file" id="cc_doc_for_service"
                                               onchange="Service.listview.uploadDocForService({{VALUE_ONE}});"
                                               accept="image/jpg,image/png,image/jpeg,application/pdf" style="width: 200px; display: none;">
                                        <button type="button" class="btn btn-sm btn-nic-blue" onclick="$('#cc_doc_for_service').click();"
                                                style="cursor: pointer;">
                                            Select File
                                        </button>
                                    </div>
                                    <div class="text-center color-nic-blue" id="spinner_template_for_service_{{VALUE_ONE}}" style="display: none;"><i class="fas fa-sync-alt fa-spin fa-2x"></i></div>
                                    <div id="cc_doc_name_container_for_service" style="display: none;">
                                        <label><?php echo is_admin() ? '14' : '12'; ?>. Citizen Charter Document <span style="color: red;">*</span></label><br>
                                        <a id="cc_doc_name_href_for_service" target="_blank" class="cursor-pointer">
                                            <label id="cc_doc_name_for_service" class="btn btn-sm btn-nic-blue f-w-n cursor-pointer"></label>
                                        </a>
                                        <button type="button" id="cc_doc_remove_btn_for_service" class="btn btn-sm btn-danger" style="vertical-align: top;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="error-message error-message-service-cc_doc_for_service"></div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div id="process_flow_doc_container_for_service">
                                        <label><span class="service-cnt"></span>. Upload Process Flow <span style="color: red;">*</span></label><br>
                                        <input type="file" id="process_flow_doc_for_service"
                                               onchange="Service.listview.uploadDocForService({{VALUE_TWO}});"
                                               accept="image/jpg,image/png,image/jpeg,application/pdf" style="width: 200px; display: none;">
                                        <button type="button" class="btn btn-sm btn-nic-blue" onclick="$('#process_flow_doc_for_service').click();"
                                                style="cursor: pointer;">
                                            Select File
                                        </button>
                                    </div>
                                    <div class="text-center color-nic-blue" id="spinner_template_for_service_{{VALUE_TWO}}" style="display: none;"><i class="fas fa-sync-alt fa-spin fa-2x"></i></div>
                                    <div id="process_flow_doc_name_container_for_service" style="display: none;">
                                        <label><?php echo is_admin() ? '15' : '13'; ?>. Process Flow Document <span style="color: red;">*</span></label><br>
                                        <a id="process_flow_doc_name_href_for_service" target="_blank" class="cursor-pointer">
                                            <label id="process_flow_doc_name_for_service" class="btn btn-sm btn-nic-blue f-w-n cursor-pointer"></label>
                                        </a>
                                        <button type="button" id="process_flow_doc_remove_btn_for_service" class="btn btn-sm btn-danger" style="vertical-align: top;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="error-message error-message-service-process_flow_doc_for_service"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-beige mt-2">
                        <div class="card-header">
                            <h3 class="card-title f-w-b f-s-14px">
                                <span class="service-cnt"></span>. Upload Sample Application Submission Document (if any)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="bg-light-gray">
                                                    <th class="text-center" style="width: 30px;">No.</th>
                                                    <th class="text-center" style="min-width: 165px;">Document Name</th>
                                                    <th class="text-center" style="min-width: 165px;">Sample Document</th>
                                                    <th class="text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="sas_doc_item_container_for_service" class="bg-white"></tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm pull-right"
                                            onclick="Service.listview.addMoreSASDocItem({});">Add More Documents</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-beige mt-2">
                        <div class="card-header">
                            <h3 class="card-title f-w-b f-s-14px">
                                <span class="service-cnt"></span>. Document Required for Service <span style="color: red;">*</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="req_doc_item_container_for_service"></div>
                            <button type="button" class="btn btn-primary btn-sm pull-right"
                                    onclick="Service.listview.addMoreREQDocItem({});">Add More Documents</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label><span class="service-cnt"></span>. Service Remarks</label>
                            <textarea id="remarks_for_service" name="remarks_for_service" class="form-control"
                                      placeholder="Enter Service Remarks !"
                                      maxlength="200">{{remarks}}</textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-footer pl-2">
                <button type="button" class="btn btn-sm btn-nic-blue" id="draft_btn_for_service"
                        onclick="Service.listview.submitService(VALUE_ONE);"
                        style="margin-right: 5px;">Save as Draft</button>
                <button type="button" class="btn btn-sm btn-success" id="submit_btn_for_service"
                        onclick="Service.listview.submitService(VALUE_THREE);"
                        style="margin-right: 5px;">Submit Service Details</button>
                <button type="button" class="btn btn-sm btn-danger"
                        onclick="Service.listview.loadServiceData();">Cancel</button>
            </div>
        </div>
    </div>
</div>