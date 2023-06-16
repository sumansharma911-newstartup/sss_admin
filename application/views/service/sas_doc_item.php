<tr id="service_sas_document_row_{{cnt}}" class="service_sas_document_row">
    <td style="width: 30px;" class="text-center service-sas-document-cnt v-a-m f-w-b">{{cnt}}</td>
    <td>
        <input type="hidden" class="og_service_sas_document_cnt" value="{{cnt}}" />
        <input type="hidden" id="service_sas_doc_id_for_service_sas_{{cnt}}" value="{{service_sas_doc_id}}" />
        <input type="text" class="form-control" id="doc_name_for_service_sas_{{cnt}}"
               onblur="checkValidation('service-sas','doc_name_for_service_sas_{{cnt}}', documentNameValidationMessage)"
               placeholder="Document Name !" value="{{doc_name}}">
        <span class="error-message error-message-service-sas-doc_name_for_service_sas_{{cnt}}"></span>
    </td>
    <td class="text-center v-a-m">
        <div id="document_container_for_service_sas_{{cnt}}">
            <input type="file" id="document_for_service_sas_{{cnt}}"
                   onchange="Service.listview.uploadDocForSAS('{{cnt}}');"
                   accept="image/jpg,image/png,image/jpeg,image/jfif,application/pdf" style="width: 200px; display: none;">
            <button type="button" class="btn btn-sm btn-nic-blue" 
                    onclick="$('#document_for_service_sas_{{cnt}}').click();"
                    style="cursor: pointer;">
                Select File
            </button>
        </div>
        <div class="text-center color-nic-blue" id="spinner_template_for_service_sas_{{cnt}}" style="display: none;"><i class="fas fa-sync-alt fa-spin fa-2x"></i></div>
        <div id="document_name_container_for_service_sas_{{cnt}}" style="display: none;">
            <a id="document_name_href_for_service_sas_{{cnt}}" target="_blank" class="cursor-pointer">
                <label id="document_name_for_service_sas_{{cnt}}" class="btn btn-sm btn-nic-blue f-w-n cursor-pointer"></label>
            </a>
            <button type="button" id="document_remove_btn_for_service_sas_{{cnt}}" class="btn btn-sm btn-danger" style="vertical-align: top;">
                <i class="fas fa-trash" style="padding-right: 4px;"></i> Remove</button>
        </div>
        <span class="error-message error-message-service-sas-document_for_service_sas_{{cnt}}"></span>
    </td>
    <td class="text-center v-a-m">
        <button type="button" class="btn btn-sm btn-danger"
                onclick="Service.listview.askForRemoveDocItemForSAS({{cnt}})" style="cursor: pointer;">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>