<div  id="service_req_document_row_{{cnt}}" class="service_req_document_row card mt-1">
    <div class="card-header">
        <h3 class="card-title f-w-b f-s-14px">Serial No. : <span class="service-req-document-cnt">{{cnt}}</span></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool"
                    onclick="Service.listview.askForRemoveDocItemForREQ({{cnt}})">
                <i class="fas fa-trash text-danger"></i>
            </button>
        </div>
        <input type="hidden" class="og_service_req_document_cnt" value="{{cnt}}" />
        <input type="hidden" id="service_req_doc_id_for_service_req_{{cnt}}" value="{{service_req_doc_id}}" />
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-6">
                <label>Document Name <span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="doc_name_for_service_req_{{cnt}}"
                       onblur="checkValidation('service-req','doc_name_for_service_req_{{cnt}}', documentNameValidationMessage)"
                       placeholder="Document Name !" value="{{doc_name}}">
                <span class="error-message error-message-service-req-doc_name_for_service_req_{{cnt}}"></span>
            </div>
            <div class="form-group col-sm-6">
                <label>Document Requirement Type <span style="color: red;">*</span></label><br>
                <div id="requirement_type_container_for_service_req_{{cnt}}"></div>
                <span class="error-message error-message-service-req-requirement_type_for_service_req_{{cnt}}"></span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <div id="document_container_for_service_req_{{cnt}}">
                    <label>Upload Sample Document</label><br>
                    <input type="file" id="document_for_service_req_{{cnt}}"
                           onchange="Service.listview.uploadDocForREQ('{{cnt}}');"
                           accept="image/jpg,image/png,image/jpeg,image/jfif,application/pdf" style="width: 200px; display: none;">
                    <button type="button" class="btn btn-sm btn-nic-blue" 
                            onclick="$('#document_for_service_req_{{cnt}}').click();"
                            style="cursor: pointer;">
                        Select File
                    </button>
                </div>
                <div class="text-center color-nic-blue" id="spinner_template_for_service_req_{{cnt}}" style="display: none;"><i class="fas fa-sync-alt fa-spin fa-2x"></i></div>
                <div id="document_name_container_for_service_req_{{cnt}}" style="display: none;">
                    <label>Sample Document</label><br>
                    <a id="document_name_href_for_service_req_{{cnt}}" target="_blank" class="cursor-pointer">
                        <label id="document_name_for_service_req_{{cnt}}" class="btn btn-sm btn-nic-blue f-w-n cursor-pointer"></label>
                    </a>
                    <button type="button" id="document_remove_btn_for_service_req_{{cnt}}" class="btn btn-sm btn-danger" style="vertical-align: top;">
                        <i class="fas fa-trash" style="padding-right: 4px;"></i> Remove</button>
                </div>
                <span class="error-message error-message-service-req-document_for_service_req_{{cnt}}"></span>
            </div>
            <div class="form-group col-sm-6">
                <label>Remarks Related to Document</label>
                <textarea id="remarks_for_service_req_{{cnt}}" name="remarks_for_service_req_{{cnt}}" class="form-control"
                          placeholder="Enter Service Delivery Type !" maxlength="200">{{remarks}}</textarea>
            </div>
        </div>
    </div>
</div>