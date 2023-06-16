<div class="card fw-body">
    <div class="card-header pt-1 pb-1 bg-nic-blue">
        <h3 class="card-title f-w-b f-s-14px">
            Document Required for Service : Sr. No. {{cnt}}
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus text-white"></i>
            </button>
        </div>
    </div>
    <div class="card-body border-nic-blue">
        <div class="table-responsive">
            <table class="table table-bordered table-padding bg-beige mb-0">
                <tr>
                    <td class="f-w-b" style="width: 40%;">Document Name</td>
                    <td>{{doc_name}}</td>
                </tr>
                <tr>
                    <td class="f-w-b">Document Requirement Type</td>
                    <td>{{requirement_type_text}}</td>
                </tr>
                <tr>
                    <td class="f-w-b">Sample Document</td>
                    <td>
                        <div id="document_name_container_for_service_view_{{cnt}}_req" style="display: none;">
                            <a id="document_name_href_for_service_view_{{cnt}}_req" target="_blank" class="cursor-pointer">
                                <label id="document_name_for_service_view_{{cnt}}_req" class="btn btn-sm btn-nic-blue f-w-n cursor-pointer"></label>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="f-w-b">Remarks Related to Document</td>
                    <td>{{remarks}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>