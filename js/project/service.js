var serviceListTemplate = Handlebars.compile($('#service_list_template').html());
var serviceTableTemplate = Handlebars.compile($('#service_table_template').html());
var serviceActionTemplate = Handlebars.compile($('#service_action_template').html());
var serviceFormTemplate = Handlebars.compile($('#service_form_template').html());
var serviceViewTemplate = Handlebars.compile($('#service_view_template').html());
var serviceSASDocItemTemplate = Handlebars.compile($('#service_sas_doc_item_template').html());
var serviceREQDocItemTemplate = Handlebars.compile($('#service_req_doc_item_template').html());
var serviceFDItemTemplate = Handlebars.compile($('#service_fd_item_template').html());
var servicePDItemTemplate = Handlebars.compile($('#service_pd_item_template').html());
var serviceFPDItemViewTemplate = Handlebars.compile($('#service_fpd_item_view_template').html());
var serviceSASDocItemViewTemplate = Handlebars.compile($('#service_sas_doc_item_view_template').html());
var serviceREQDocItemViewTemplate = Handlebars.compile($('#service_req_doc_item_view_template').html());
var tempDeptData = [];
var sasDocCnt = 1;
var reqDocCnt = 1;
var fdCnt = 1;
var pdCnt = 1;
var Service = {
    run: function () {
        this.router = new this.Router();
        this.listview = new this.listView();
    }
};
Service.Router = Backbone.Router.extend({
    routes: {
        'service': 'renderList'
    },
    renderList: function () {
        Service.listview.listPage();
    },
});
Service.listView = Backbone.View.extend({
    el: 'div#main_container',
    listPage: function () {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        activeLink('menu_service');
        Service.router.navigate('service');
        var templateData = {};
        this.$el.html(serviceListTemplate(templateData));
        this.loadServiceData();

    },
    loadServiceData: function () {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        var deptDetailsRenderer = function (data, type, full, meta) {
            return (talukaArray[data] ? talukaArray[data] : '') + '<hr>' + (full.department_name ? full.department_name : '');
        };
        var dtRenderer = function (data, type, full, meta) {
            return sdTypeArray[data] ? sdTypeArray[data] : '';
        };
        var daysRenderer = function (data, type, full, meta) {
            return  (full.days_as_per_cc != '' ? ('<div><b>CC</b> &nbsp;&nbsp; :- <span class="badge bg-warning app-status">' + full.days_as_per_cc + ' Days</span></div>') : '')
                    + (full.days_as_per_sss != '' ? ('<b>SSS</b> :- <span class="badge bg-warning app-status mt-2">' + full.days_as_per_sss + ' Days</span>') : '');
        };
        var docRenderer = function (data, type, full, meta) {
            return data != '' ?
                    ('<a id="process_flow_doc_name_href_for_service" target="_blank" class="cursor-pointer" ' +
                            ' href="documents/service/' + data + '">' +
                            '<label class="btn btn-sm btn-nic-blue f-w-n cursor-pointer" style="padding: 2px 7px;">View Document</label></a>')
                    : '';
        };
        var statusRenderer = function (data, type, full, meta) {
            return serStatusArray[data] ? serStatusArray[data] : '';
        };
        var actionRenderer = function (data, type, full, meta) {
            if (tempTypeInSession == TEMP_TYPE_A || (tempTypeInSession == TEMP_TYPE_DEPT_USER && full.status == VALUE_ZERO && tempIdInSession == full.user_id)) {
                full.show_edit_btn = true;
            }
            full.VALUE_ONE = VALUE_ONE;
            full.VALUE_TWO = VALUE_TWO;
            return serviceActionTemplate(full);
        };
        Service.router.navigate('service');
        $('#service_form_and_datatable_container').html(serviceTableTemplate);
        serviceDataTable = $('#service_datatable').DataTable({
            ajax: {url: 'service/get_service_data', dataSrc: "service_data", type: "post", data: getTokenData()},
            bAutoWidth: false,
            ordering: false,
            pageLength: 25,
            language: dataTableProcessingAndNoDataMsg,
            columns: [
                {data: '', 'render': serialNumberRenderer, 'class': 'text-center'},
                {data: 'district', 'class': 'text-center', 'render': deptDetailsRenderer},
                {data: 'service_name'},
                {data: 'delivery_type', 'class': 'text-center', 'render': dtRenderer},
                {data: '', 'class': 'f-s-app-details', 'render': daysRenderer},
                {data: 'cc_doc', 'class': 'text-center', 'render': docRenderer},
                {data: 'process_flow_doc', 'class': 'text-center', 'render': docRenderer},
                {data: 'status', 'class': 'text-center', 'render': statusRenderer},
                {data: '', 'class': 'text-center', 'render': actionRenderer}
            ],
            "initComplete": function (settings, json) {
                setNewToken(json.temp_token);
            }
        });
    },
    askForNewServiceForm: function (btnObj) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        var that = this;
        if (tempTypeInSession == TEMP_TYPE_DEPT_USER) {
            that.newServiceForm(false, {});
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        var ogBtnHTML = btnObj.html();
        var ogBtnOnClick = btnObj.attr("onclick");
        btnObj.html(iconSpinnerTemplate);
        btnObj.attr('onclick', '');
        var that = this;
        tempUserTypeData = [];
        $.ajax({
            type: 'POST',
            url: 'service/get_common_data_for_service',
            data: getTokenData(),
            error: function (textStatus, errorThrown) {
                generateNewCSRFToken();
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnClick);
                showError(textStatus.statusText);
                $('html, body').animate({scrollTop: '0px'}, 0);
            },
            success: function (data) {
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnClick);
                var parseData = JSON.parse(data);
                setNewToken(parseData.temp_token);
                if (parseData.success == false) {
                    showError(parseData.message);
                    $('html, body').animate({scrollTop: '0px'}, 0);
                    return false;
                }
                tempDeptData = parseData.department_data;
                that.newServiceForm(false, {});
            }
        });
    },
    newServiceForm: function (isEdit, serviceData) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        var that = this;
        sasDocCnt = 1;
        reqDocCnt = 1;
        fdCnt = 1;
        pdCnt = 1;
        serviceData.VALUE_ONE = VALUE_ONE;
        serviceData.VALUE_TWO = VALUE_TWO;
        serviceData.VALUE_THREE = VALUE_THREE;
        $('#service_form_and_datatable_container').html(serviceFormTemplate(serviceData));
        if (tempTypeInSession == TEMP_TYPE_A) {
            renderOptionsForTwoDimensionalArray(talukaArray, 'district_for_service');
            var deptData = [];
            if (isEdit) {
                deptData = tempDeptData[serviceData.district] ? tempDeptData[serviceData.district] : [];
            }
            renderOptionsForTwoDimensionalArrayWithKeyValueWithCombination(deptData, 'department_id_for_service', 'department_id', 'department_name');
            if (isEdit) {
                $('#district_for_service').val(serviceData.district);
                $('#department_id_for_service').val(serviceData.department_id);
            }
        }
        generateBoxes('checkbox', serviceDeclaredArray, 'declared_in', 'service', serviceData.declared_in, false, true);
        showSubContainer('declared_in', 'service', '#declared_in_remarks', VALUE_FOUR, 'checkbox', '#declared_in_remarks', VALUE_FIVE);
        generateBoxes('radio', sdTypeArray, 'delivery_type', 'service', serviceData.delivery_type, false, true);
        showSubContainer('delivery_type', 'service', '#service_url', VALUE_THREE, 'radio', '#service_url', VALUE_FOUR);
        generateBoxes('checkbox', dsCategoryArray, 'ds_category', 'service', serviceData.ds_category, false, false);
        showSubContainer('ds_category', 'service', '#ds_other_category', VALUE_THREE, 'checkbox');
        generateBoxes('radio', appNappArray, 'is_delivery_fees', 'service', serviceData.is_delivery_fees, false, false);
        showSubContainer('is_delivery_fees', 'service', '#delivery_fees_details', VALUE_ONE, 'radio');
        generateBoxes('radio', appNappArray, 'is_payment_to_applicant', 'service', serviceData.is_payment_to_applicant, false, false);
        showSubContainer('is_payment_to_applicant', 'service', '.applicant_payment_details', VALUE_ONE, 'radio');
        generateBoxes('radio', paymentTypeArray, 'applicant_payment_type', 'service', serviceData.applicant_payment_type, false, false);
        if (isEdit) {
            if (serviceData.delivery_fees_details != '') {
                var dfdData = JSON.parse(serviceData.delivery_fees_details);
                $.each(dfdData, function (index, fd) {
                    that.addFDRow(fd);
                });
            }
            if (serviceData.applicant_payment_details != '') {
                var apdData = JSON.parse(serviceData.applicant_payment_details);
                $.each(apdData, function (index, pd) {
                    that.addPDRow(pd);
                });
            }
            if (serviceData.cc_doc != '') {
                serviceData.module_type = VALUE_ONE;
                that.loadServiceDocument('cc_doc', serviceData);
            }
            if (serviceData.process_flow_doc != '') {
                serviceData.module_type = VALUE_TWO;
                that.loadServiceDocument('process_flow_doc', serviceData);
            }
            if (serviceData.sas_doc_data) {
                $.each(serviceData.sas_doc_data, function (index, sasDocData) {
                    that.addMoreSASDocItem(sasDocData);
                });
            }
            if (serviceData.req_doc_data) {
                $.each(serviceData.req_doc_data, function (index, reqDocData) {
                    that.addMoreREQDocItem(reqDocData);
                });
            }
        } else {
            that.addMoreREQDocItem({});
            that.addFDRow({});
            that.addPDRow({});
        }
        resetCounter('service-cnt');
        allowOnlyIntegerValue('days_as_per_cc_for_service');
        allowOnlyIntegerValue('days_as_per_sss_for_service');
        generateSelect2();
        $('#service_form').find('input').keypress(function (e) {
            if (e.which == 13) {
                that.submitService(VALUE_THREE);
            }
        });
    },
    uploadDocForService: function (moduleType) {
        var that = this;
        if (moduleType != VALUE_ONE && moduleType != VALUE_TWO) {
            showError(invalidAccessValidationMessage);
            return false;
        }
        var fileSize = 10240;
        var id = '';
        if (moduleType == VALUE_ONE) {
            id = 'cc_doc';
        }
        if (moduleType == VALUE_TWO) {
            id = 'process_flow_doc';
        }
        var fullId = id + '_for_service';
        var doc = $('#' + fullId).val();
        if (doc == '') {
            return false;
        }
        var serviceId = $('#service_id_for_service').val();
        validationMessageHide();
        var docMessage = fileUploadValidation(fullId, fileSize);
        if (docMessage != '') {
            showError(docMessage);
            return false;
        }
        openFullPageOverlay();
        $('#' + id + '_container_for_service').hide();
        $('#' + id + '_name_container_for_service').hide();
        $('#spinner_template_for_service_' + moduleType).show();
        var formData = new FormData();
        formData.append('service_id', serviceId);
        formData.append('module_type', moduleType);
        formData.append('document_file', $('#' + fullId)[0].files[0]);
        $.ajax({
            type: 'POST',
            url: 'service/upload_service_document',
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            error: function (textStatus, errorThrown) {
                if (!textStatus.statusText) {
                    loginPage();
                    return false;
                }
                $('#' + id + '_name_container_for_service').hide();
                $('#spinner_template_for_service_' + moduleType).hide();
                $('#' + id + '_container_for_service').show();
                $('#' + fullId).val('');
                closeFullPageOverlay();
                showError(textStatus.statusText);
            },
            success: function (data) {
                var parseData = JSON.parse(data);
                if (parseData.success == false) {
                    $('#' + id + '_name_container_for_service').hide();
                    $('#spinner_template_for_service_' + moduleType).hide();
                    $('#' + id + '_container_for_service').show();
                    $('#' + fullId).val('');
                    closeFullPageOverlay();
                    showError(parseData.message);
                    return false;
                }
                $('#spinner_template_for_service_' + moduleType).hide();
                $('#' + id + '_name_container_for_service').hide();
                $('#' + fullId).val('');

                var serviceData = parseData.service_data;
                $('#service_id_for_service').val(serviceData.service_id);
                that.loadServiceDocument(id, serviceData);
                closeFullPageOverlay();
            }
        });
    },
    loadServiceDocument: function (documentFieldName, serviceData) {
        $('#' + documentFieldName + '_container_for_service').hide();
        $('#' + documentFieldName + '_name_container_for_service').show();
        $('#' + documentFieldName + '_name_href_for_service').attr('href', 'documents/service/' + serviceData[documentFieldName]);
        $('#' + documentFieldName + '_name_for_service').html(VIEW_UPLODED_DOCUMENT);
        $('#' + documentFieldName + '_remove_btn_for_service').attr('onclick', 'Service.listview.askForRemoveDocForService("' + serviceData.module_type + '")');
    },
    askForRemoveDocForService: function (moduleType) {
        if (moduleType != VALUE_ONE && moduleType != VALUE_TWO) {
            showError(invalidAccessValidationMessage);
            return false;
        }
        var yesEvent = 'Service.listview.removeServiceDoc(' + moduleType + ')';
        showConfirmation(yesEvent, 'Remove');
    },
    removeServiceDoc: function (moduleType) {
        if (moduleType != VALUE_ONE && moduleType != VALUE_TWO) {
            showError(invalidAccessValidationMessage);
            return false;
        }
        var serviceId = $('#service_id_for_service').val();
        if (!serviceId) {
            showError(invalidAccessValidationMessage);
            return false;
        }
        var id = '';
        if (moduleType == VALUE_ONE) {
            id = 'cc_doc';
        }
        if (moduleType == VALUE_TWO) {
            id = 'process_flow_doc';
        }
        openFullPageOverlay();
        $('#' + id + '_container_for_service').hide();
        $('#' + id + '_name_container_for_service').hide();
        $('#spinner_template_for_service_' + moduleType).show();
        $.ajax({
            type: 'POST',
            url: 'service/remove_service_document',
            data: $.extend({}, {'service_id': serviceId, 'module_type': moduleType}, getTokenData()),
            error: function (textStatus, errorThrown) {
                $('#spinner_template_for_service_' + moduleType).hide();
                $('#' + id + '_container_for_service').hide();
                $('#' + id + '_name_container_for_service').show();
                closeFullPageOverlay();
                generateNewCSRFToken();
                showError(textStatus.statusText);
            },
            success: function (response) {
                var parseData = JSON.parse(response);
                setNewToken(parseData.temp_token);
                if (parseData.success === false) {
                    $('#spinner_template_for_service_' + moduleType).hide();
                    $('#' + id + '_container_for_service').hide();
                    $('#' + id + '_name_container_for_service').show();
                    closeFullPageOverlay();
                    showError(parseData.message);
                    return false;
                }
                $('#spinner_template_for_service_' + moduleType).hide();
                $('.stack-bar-bottom').hide();
                showSuccess(parseData.message);
                removeDocument(parseData.doc_filename, 'service');
                closeFullPageOverlay();
            }
        });
    },
    addMoreSASDocItem: function (sasDocData) {
        var that = this;
        sasDocData.cnt = sasDocCnt;
        $('#sas_doc_item_container_for_service').append(serviceSASDocItemTemplate(sasDocData));
        if (sasDocData.document) {
            that.loadSASDocument('document', sasDocCnt, sasDocData);
        }
        resetCounter('service-sas-document-cnt');
        sasDocCnt++;
    },
    uploadDocForSAS: function (tempCnt) {
        var that = this;
        var id = 'document_for_service_sas_' + tempCnt;
        var doc = $('#' + id).val();
        if (doc == '') {
            return false;
        }
        validationMessageHide();
        var docMessage = fileUploadValidation(id, 10240);
        if (docMessage != '') {
            showError(docMessage);
            return false;
        }
        openFullPageOverlay();
        $('#document_container_for_service_sas_' + tempCnt).hide();
        $('#document_name_container_for_service_sas_' + tempCnt).hide();
        $('#spinner_template_for_service_sas_' + tempCnt).show();
        var formData = new FormData();
        formData.append('service_id_for_service', $('#service_id_for_service').val());
        formData.append('service_sas_doc_id_for_service_sas', $('#service_sas_doc_id_for_service_sas_' + tempCnt).val());
        formData.append('document_for_service_sas', $('#' + id)[0].files[0]);
        $.ajax({
            type: 'POST',
            url: 'service/upload_sas_document',
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            error: function (textStatus, errorThrown) {
                if (!textStatus.statusText) {
                    loginPage();
                    return false;
                }
                $('#spinner_template_for_service_sas_' + tempCnt).hide();
                $('#document_container_for_service_sas_' + tempCnt).show();
                $('#document_name_container_for_service_sas_' + tempCnt).hide();
                $('#' + id).val('');
                closeFullPageOverlay();
                showError(textStatus.statusText);
            },
            success: function (data) {
                var parseData = JSON.parse(data);
                if (parseData.success == false) {
                    $('#spinner_template_for_service_sas_' + tempCnt).hide();
                    $('#document_container_for_service_sas_' + tempCnt).show();
                    $('#document_name_container_for_service_sas_' + tempCnt).hide();
                    $('#' + id).val('');
                    closeFullPageOverlay();
                    showError(parseData.message);
                    return false;
                }
                $('#spinner_template_for_service_sas_' + tempCnt).hide();
                $('#document_name_container_for_service_sas_' + tempCnt).hide();
                $('#' + id).val('');
                $('#service_id_for_service').val(parseData.service_id);
                $('#service_sas_doc_id_for_service_sas_' + tempCnt).val(parseData.service_sas_doc_id);
                var docItemData = {};
                docItemData.service_id = parseData.service_id;
                docItemData.service_sas_doc_id = parseData.service_sas_doc_id;
                docItemData.document = parseData.document_name;
                that.loadSASDocument('document', tempCnt, docItemData);
                closeFullPageOverlay();
            }
        });
    },
    loadSASDocument: function (documentFieldName, cnt, sasDocItemData) {
        $('#' + documentFieldName + '_container_for_service_sas_' + cnt).hide();
        $('#' + documentFieldName + '_name_container_for_service_sas_' + cnt).show();
        $('#' + documentFieldName + '_name_href_for_service_sas_' + cnt).attr('href', 'documents/service/sas_doc/' + sasDocItemData[documentFieldName]);
        $('#' + documentFieldName + '_name_for_service_sas_' + cnt).html(VIEW_UPLODED_DOCUMENT);
        $('#' + documentFieldName + '_remove_btn_for_service_sas_' + cnt).attr('onclick', 'Service.listview.askForRemoveDocForSAS("' + sasDocItemData.service_sas_doc_id + '","' + cnt + '")');
    },
    askForRemoveDocForSAS: function (sasDocId, cnt) {
        if (!sasDocId || !cnt) {
            showError(invalidAccessValidationMessage);
            return false;
        }
        var yesEvent = 'Service.listview.removeSASDoc(' + sasDocId + ', ' + cnt + ')';
        showConfirmation(yesEvent, 'Remove');
    },
    removeSASDoc: function (sasDocId, cnt) {
        if (!sasDocId || !cnt) {
            showError(invalidAccessValidationMessage);
            return false;
        }
        openFullPageOverlay();
        $('#document_container_for_service_sas_' + cnt).hide();
        $('#document_name_container_for_service_sas_' + cnt).hide();
        $('#spinner_template_for_service_sas_' + cnt).show();
        $.ajax({
            type: 'POST',
            url: 'service/remove_sas_document',
            data: $.extend({}, {'service_sas_doc_id': sasDocId}, getTokenData()),
            error: function (textStatus, errorThrown) {
                $('#spinner_template_for_service_sas_' + cnt).hide();
                $('#document_container_for_service_sas_' + cnt).hide();
                $('#document_name_container_for_service_sas_' + cnt).show();
                generateNewCSRFToken();
                closeFullPageOverlay();
                showError(textStatus.statusText);
            },
            success: function (response) {
                var parseData = JSON.parse(response);
                setNewToken(parseData.temp_token);
                if (parseData.success === false) {
                    $('#spinner_template_for_service_sas_' + cnt).hide();
                    $('#document_container_for_service_sas_' + cnt).hide();
                    $('#document_name_container_for_service_sas_' + cnt).show();
                    closeFullPageOverlay();
                    showError(parseData.message);
                    return false;
                }
                $('#spinner_template_for_service_sas_' + cnt).hide();
                $('.stack-bar-bottom').hide();
                showSuccess(parseData.message);
                removeDocument('document', 'service_sas_' + cnt);
                closeFullPageOverlay();
            }
        });
    },
    askForRemoveDocItemForSAS: function (cnt) {
        var that = this;
        var sasDocId = $('#service_sas_doc_id_for_service_sas_' + cnt).val();
        if (!sasDocId || sasDocId == 0 || sasDocId == null) {
            that.removeSASItem(cnt);
            return false;
        }
        var yesEvent = 'Service.listview.removeSASItemRow(' + cnt + ')';
        showConfirmation(yesEvent, 'Remove');
    },
    removeSASItem: function (cnt) {
        $('#service_sas_document_row_' + cnt).remove();
        resetCounter('service-sas-document-cnt');
    },
    removeSASItemRow: function (cnt) {
        var sasDocId = $('#service_sas_doc_id_for_service_sas_' + cnt).val();
        if (!sasDocId || sasDocId == 0 || sasDocId == null) {
            showError(invalidAccessValidationMessage);
            return false;
        }
        var that = this;
        openFullPageOverlay();
        $.ajax({
            type: 'POST',
            url: 'service/remove_sas_document_item',
            data: $.extend({}, {'service_sas_doc_id': sasDocId}, getTokenData()),
            error: function (textStatus, errorThrown) {
                generateNewCSRFToken();
                closeFullPageOverlay();
                showError(textStatus.statusText);
            },
            success: function (response) {
                var parseData = JSON.parse(response);
                setNewToken(parseData.temp_token);
                if (parseData.success === false) {
                    closeFullPageOverlay();
                    showError(parseData.message);
                    return false;
                }
                that.removeSASItem(cnt);
                closeFullPageOverlay();
                showSuccess(parseData.message);
            }
        });
    },
    addMoreREQDocItem: function (reqDocData) {
        var that = this;
        reqDocData.cnt = reqDocCnt;
        $('#req_doc_item_container_for_service').append(serviceREQDocItemTemplate(reqDocData));
        generateBoxes('radio', drTypeArray, 'requirement_type', 'service_req_' + reqDocCnt, reqDocData.requirement_type, false, false);
        if (reqDocData.document) {
            that.loadREQDocument('document', reqDocCnt, reqDocData);
        }
        resetCounter('service-req-document-cnt');
        reqDocCnt++;
    },
    uploadDocForREQ: function (tempCnt) {
        var that = this;
        var id = 'document_for_service_req_' + tempCnt;
        var doc = $('#' + id).val();
        if (doc == '') {
            return false;
        }
        validationMessageHide();
        var docMessage = fileUploadValidation(id, 10240);
        if (docMessage != '') {
            showError(docMessage);
            return false;
        }
        openFullPageOverlay();
        $('#document_container_for_service_req_' + tempCnt).hide();
        $('#document_name_container_for_service_req_' + tempCnt).hide();
        $('#spinner_template_for_service_req_' + tempCnt).show();
        var formData = new FormData();
        formData.append('service_id_for_service', $('#service_id_for_service').val());
        formData.append('service_req_doc_id_for_service_req', $('#service_req_doc_id_for_service_req_' + tempCnt).val());
        formData.append('document_for_service_req', $('#' + id)[0].files[0]);
        $.ajax({
            type: 'POST',
            url: 'service/upload_req_document',
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            error: function (textStatus, errorThrown) {
                if (!textStatus.statusText) {
                    loginPage();
                    return false;
                }
                $('#spinner_template_for_service_req_' + tempCnt).hide();
                $('#document_container_for_service_req_' + tempCnt).show();
                $('#document_name_container_for_service_req_' + tempCnt).hide();
                $('#' + id).val('');
                closeFullPageOverlay();
                showError(textStatus.statusText);
            },
            success: function (data) {
                var parseData = JSON.parse(data);
                if (parseData.success == false) {
                    $('#spinner_template_for_service_req_' + tempCnt).hide();
                    $('#document_container_for_service_req_' + tempCnt).show();
                    $('#document_name_container_for_service_req_' + tempCnt).hide();
                    $('#' + id).val('');
                    closeFullPageOverlay();
                    showError(parseData.message);
                    return false;
                }
                $('#spinner_template_for_service_req_' + tempCnt).hide();
                $('#document_name_container_for_service_req_' + tempCnt).hide();
                $('#' + id).val('');
                $('#service_id_for_service').val(parseData.service_id);
                $('#service_req_doc_id_for_service_req_' + tempCnt).val(parseData.service_req_doc_id);
                var docItemData = {};
                docItemData.service_id = parseData.service_id;
                docItemData.service_req_doc_id = parseData.service_req_doc_id;
                docItemData.document = parseData.document_name;
                that.loadREQDocument('document', tempCnt, docItemData);
                closeFullPageOverlay();
            }
        });
    },
    loadREQDocument: function (documentFieldName, cnt, reqDocItemData) {
        $('#' + documentFieldName + '_container_for_service_req_' + cnt).hide();
        $('#' + documentFieldName + '_name_container_for_service_req_' + cnt).show();
        $('#' + documentFieldName + '_name_href_for_service_req_' + cnt).attr('href', 'documents/service/req_doc/' + reqDocItemData[documentFieldName]);
        $('#' + documentFieldName + '_name_for_service_req_' + cnt).html(VIEW_UPLODED_DOCUMENT);
        $('#' + documentFieldName + '_remove_btn_for_service_req_' + cnt).attr('onclick', 'Service.listview.askForRemoveDocForREQ("' + reqDocItemData.service_req_doc_id + '","' + cnt + '")');
    },
    askForRemoveDocForREQ: function (reqDocId, cnt) {
        if (!reqDocId || !cnt) {
            showError(invalidAccessValidationMessage);
            return false;
        }
        var yesEvent = 'Service.listview.removeREQDoc(' + reqDocId + ', ' + cnt + ')';
        showConfirmation(yesEvent, 'Remove');
    },
    removeREQDoc: function (reqDocId, cnt) {
        if (!reqDocId || !cnt) {
            showError(invalidAccessValidationMessage);
            return false;
        }
        openFullPageOverlay();
        $('#document_container_for_service_req_' + cnt).hide();
        $('#document_name_container_for_service_req_' + cnt).hide();
        $('#spinner_template_for_service_req_' + cnt).show();
        $.ajax({
            type: 'POST',
            url: 'service/remove_req_document',
            data: $.extend({}, {'service_req_doc_id': reqDocId}, getTokenData()),
            error: function (textStatus, errorThrown) {
                $('#spinner_template_for_service_req_' + cnt).hide();
                $('#document_container_for_service_req_' + cnt).hide();
                $('#document_name_container_for_service_req_' + cnt).show();
                generateNewCSRFToken();
                closeFullPageOverlay();
                showError(textStatus.statusText);
            },
            success: function (response) {
                var parseData = JSON.parse(response);
                setNewToken(parseData.temp_token);
                if (parseData.success === false) {
                    $('#spinner_template_for_service_req_' + cnt).hide();
                    $('#document_container_for_service_req_' + cnt).hide();
                    $('#document_name_container_for_service_req_' + cnt).show();
                    closeFullPageOverlay();
                    showError(parseData.message);
                    return false;
                }
                $('#spinner_template_for_service_req_' + cnt).hide();
                $('.stack-bar-bottom').hide();
                showSuccess(parseData.message);
                removeDocument('document', 'service_req_' + cnt);
                closeFullPageOverlay();
            }
        });
    },
    askForRemoveDocItemForREQ: function (cnt) {
        var that = this;
        var reqDocId = $('#service_req_doc_id_for_service_req_' + cnt).val();
        if (!reqDocId || reqDocId == 0 || reqDocId == null) {
            that.removeREQItem(cnt);
            return false;
        }
        var yesEvent = 'Service.listview.removeREQItemRow(' + cnt + ')';
        showConfirmation(yesEvent, 'Remove');
    },
    removeREQItem: function (cnt) {
        $('#service_req_document_row_' + cnt).remove();
        resetCounter('service-req-document-cnt');
    },
    removeREQItemRow: function (cnt) {
        var reqDocId = $('#service_req_doc_id_for_service_req_' + cnt).val();
        if (!reqDocId || reqDocId == 0 || reqDocId == null) {
            showError(invalidAccessValidationMessage);
            return false;
        }
        var that = this;
        openFullPageOverlay();
        $.ajax({
            type: 'POST',
            url: 'service/remove_req_document_item',
            data: $.extend({}, {'service_req_doc_id': reqDocId}, getTokenData()),
            error: function (textStatus, errorThrown) {
                generateNewCSRFToken();
                closeFullPageOverlay();
                showError(textStatus.statusText);
            },
            success: function (response) {
                var parseData = JSON.parse(response);
                setNewToken(parseData.temp_token);
                if (parseData.success === false) {
                    closeFullPageOverlay();
                    showError(parseData.message);
                    return false;
                }
                that.removeREQItem(cnt);
                closeFullPageOverlay();
                showSuccess(parseData.message);
            }
        });
    },
    addFDRow: function (fdd) {
        var that = this;
        fdd.fd_cnt = fdCnt;
        $('#fd_item_container_for_service').append(serviceFDItemTemplate(fdd));
        allowOnlyIntegerValue('fee_for_fd_' + fdCnt);
        resetCounter('fd-cnt');
        that.fdFeeCalculation();
        fdCnt++;
    },
    askForRemoveFDRow: function (rowCnt) {
        $('#fd_row_' + rowCnt).remove();
        this.fdFeeCalculation();
        resetCounter('fd-cnt');
    },
    fdFeeCalculation: function () {
        var totalFee = 0;
        $('.fee_for_fd').each(function () {
            var fee = parseInt($(this).val());
            totalFee += fee ? fee : 0;
        });
        $('#total_fees_for_service').html(totalFee + ' /-');
    },
    addPDRow: function (pdd) {
        var that = this;
        pdd.pd_cnt = pdCnt;
        $('#pd_item_container_for_service').append(servicePDItemTemplate(pdd));
        allowOnlyIntegerValue('payment_for_pd_' + pdCnt);
        resetCounter('pd-cnt');
        that.pdPaymentCalculation();
        pdCnt++;
    },
    askForRemovePDRow: function (rowCnt) {
        $('#pd_row_' + rowCnt).remove();
        this.pdPaymentCalculation();
        resetCounter('pd-cnt');
    },
    pdPaymentCalculation: function () {
        var totalPayment = 0;
        $('.payment_for_pd').each(function () {
            var payment = parseInt($(this).val());
            totalPayment += payment ? payment : 0;
        });
        $('#total_payment_for_service').html(totalPayment + ' /-');
    },
    editOrViewService: function (btnObj, serviceId, moduleType) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (!serviceId) {
            showError(invalidAccessValidationMessage);
            return;
        }
        var that = this;
        var ogBtnHTML = btnObj.html();
        var ogBtnOnclick = btnObj.attr('onclick');
        btnObj.html(iconSpinnerTemplate);
        btnObj.attr('onclick', '');
        $.ajax({
            url: 'service/get_service_data_by_id',
            type: 'post',
            data: $.extend({}, {'service_id': serviceId, 'module_type': moduleType}, getTokenData()),
            error: function (textStatus, errorThrown) {
                generateNewCSRFToken();
                if (!textStatus.statusText) {
                    loginPage();
                    return false;
                }
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnclick);
                showError(textStatus.statusText);
            },
            success: function (response) {
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnclick);
                var parseData = JSON.parse(response);
                setNewToken(parseData.temp_token);
                if (parseData.success === false) {
                    showError(parseData.message);
                    return false;
                }
                var serviceData = parseData.service_data;
                if (moduleType == VALUE_ONE) {
                    tempDeptData = parseData.department_data;
                    that.newServiceForm(true, serviceData);
                }
                if (moduleType == VALUE_TWO) {
                    that.viewService(serviceData);
                }
            }
        });
    },
    checkValidationForService: function (moduleType, serviceData) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession == TEMP_TYPE_A) {
            if (!serviceData.district_for_service) {
                return getBasicMessageAndFieldJSONArray('district_for_service', districtValidationMessage);
            }
            if (!serviceData.department_id_for_service) {
                return getBasicMessageAndFieldJSONArray('department_id_for_service', oneOptionValidationMessage);
            }
        }
        if (!serviceData.service_name_for_service) {
            return getBasicMessageAndFieldJSONArray('service_name_for_service', serviceNameValidationMessage);
        }
        if (moduleType == VALUE_ONE) {
            return '';
        }
        if (!serviceData.designation_for_service) {
            return getBasicMessageAndFieldJSONArray('designation_for_service', designationValidationMessage);
        }
        if (!serviceData.declared_in_for_service) {
            $('#declared_in_for_service_1').focus();
            return getBasicMessageAndFieldJSONArray('declared_in_for_service', oneOptionValidationMessage);
        }
        if ($('input[name="declared_in_for_service"][value=' + VALUE_FOUR + ']').is(':checked') ||
                $('input[name="declared_in_for_service"][value=' + VALUE_FIVE + ']').is(':checked')) {
            if (!serviceData.declared_in_remarks_for_service) {
                return getBasicMessageAndFieldJSONArray('declared_in_remarks_for_service', remarksValidationMessage);
            }
        }
        if (!serviceData.delivery_type_for_service) {
            $('#delivery_type_for_service_1').focus();
            return getBasicMessageAndFieldJSONArray('delivery_type_for_service', oneOptionValidationMessage);
        }
        if (!serviceData.delivery_remarks_for_service) {
            return getBasicMessageAndFieldJSONArray('delivery_remarks_for_service', remarksValidationMessage);
        }
        if (serviceData.delivery_type_for_service == VALUE_THREE || serviceData.delivery_type_for_service == VALUE_FOUR) {
            if (!serviceData.service_url_for_service) {
                return getBasicMessageAndFieldJSONArray('service_url_for_service', sdURLValidationMessage);
            }
        }
        if (!serviceData.ds_category_for_service) {
            $('#ds_category_for_service_1').focus();
            return getBasicMessageAndFieldJSONArray('ds_category_for_service', oneOptionValidationMessage);
        }
        if ($('input[name="ds_category_for_service"][value=' + VALUE_THREE + ']').is(':checked')) {
            if (!serviceData.ds_other_category_for_service) {
                return getBasicMessageAndFieldJSONArray('ds_other_category_for_service', otherDSCategoryValidationMessage);
            }
        }
        if (!serviceData.is_delivery_fees_for_service) {
            $('#is_delivery_fees_for_service_1').focus();
            return getBasicMessageAndFieldJSONArray('is_delivery_fees_for_service', oneOptionValidationMessage);
        }
        return '';
    },
    checkValidationForFD: function (moduleType) {
        var tempCntForFD = 0;
        var FDItems = [];
        var totalFees = 0;
        var isFDItemValidation = false;
        $('.fd_row').each(function () {
            var tfdCnt = $(this).find('.og_fd_cnt').val();
            var fdItem = {};
            var desc = $('#desc_for_fd_' + tfdCnt).val();
            if (moduleType != VALUE_ONE) {
                if (desc == '' || desc == null) {
                    $('#desc_for_fd_' + tfdCnt).focus();
                    validationMessageShow('fd-desc_for_fd_' + tfdCnt, descriptionValidationMessage);
                    isFDItemValidation = true;
                    return false;
                }
            }
            fdItem.fee_description = desc;
            var fee = parseInt($('#fee_for_fd_' + tfdCnt).val());
            fee = fee ? fee : VALUE_ZERO;
            fdItem.fee = fee;
            totalFees += fee;
            FDItems.push(fdItem);
            tempCntForFD++;
        });
        if (isFDItemValidation) {
            return false;
        }
        if (moduleType != VALUE_ONE) {
            if (tempCntForFD == 0) {
                $('#is_delivery_fees_for_service_1').focus();
                validationMessageShow('fd', oneFeeValidationMessage);
                return false;
            }
        }
        var returnData = {};
        returnData.fd_items = FDItems;
        returnData.total_fees = totalFees;
        return returnData;
    },
    checkValidationForPD: function (moduleType) {
        var tempCntForPD = 0;
        var PDItems = [];
        var totalPayment = 0;
        var isPDItemValidation = false;
        $('.pd_row').each(function () {
            var tpdCnt = $(this).find('.og_pd_cnt').val();
            var pdItem = {};
            var desc = $('#desc_for_pd_' + tpdCnt).val();
            if (moduleType != VALUE_ONE) {
                if (desc == '' || desc == null) {
                    $('#desc_for_pd_' + tpdCnt).focus();
                    validationMessageShow('pd-desc_for_pd_' + tpdCnt, descriptionValidationMessage);
                    isPDItemValidation = true;
                    return false;
                }
            }
            pdItem.payment_description = desc;
            var payment = parseInt($('#payment_for_pd_' + tpdCnt).val());
            payment = payment ? payment : VALUE_ZERO;
            pdItem.payment = payment;
            totalPayment += payment;
            PDItems.push(pdItem);
            tempCntForPD++;
        });
        if (isPDItemValidation) {
            return false;
        }
        if (moduleType != VALUE_ONE) {
            if (tempCntForPD == 0) {
                $('#is_payment_to_applicant_for_service_1').focus();
                validationMessageShow('pd', onePaymentValidationMessage);
                return false;
            }
        }
        var returnData = {};
        returnData.pd_items = PDItems;
        returnData.total_payment = totalPayment;
        return returnData;
    },
    checkValidationForSD: function (moduleType, serviceData) {
        if (moduleType == VALUE_ONE) {
            return '';
        }
        if ($('#cc_doc_container_for_service').is(':visible')) {
            if (!serviceData.cc_doc_for_service) {
                return getBasicMessageAndFieldJSONArray('cc_doc_for_service', uploadDocValidationMessage);
            }
            var ccDocMessage = fileUploadValidation('cc_doc_for_service', 10240);
            if (ccDocMessage != '') {
                return getBasicMessageAndFieldJSONArray('cc_doc_for_service', ccDocMessage);
            }
        }
        if ($('#process_flow_doc_container_for_service').is(':visible')) {
            if (!serviceData.process_flow_doc_for_service) {
                return getBasicMessageAndFieldJSONArray('process_flow_doc_for_service', uploadDocValidationMessage);
            }
            var pfDocMessage = fileUploadValidation('process_flow_doc_for_service', 10240);
            if (pfDocMessage != '') {
                return getBasicMessageAndFieldJSONArray('process_flow_doc_for_service', pfDocMessage);
            }
        }
        return '';
    },
    checkValidationForSASDocument: function (moduleType) {
        var sasCnt = 1;
        var newSASDItems = [];
        var exiSASDItems = [];
        var isSASDItemValidation;
        $('.service_sas_document_row').each(function () {
            var that = $(this);
            var tempCnt = that.find('.og_service_sas_document_cnt').val();
            if (tempCnt == '' || tempCnt == null) {
                showError(invalidAccessValidationMessage);
                isSASDItemValidation = true;
                return false;
            }
            var docName = $('#doc_name_for_service_sas_' + tempCnt).val();
            if (moduleType != VALUE_ONE) {
                if (docName == '' || docName == null) {
                    $('#doc_name_for_service_sas_' + tempCnt).focus();
                    validationMessageShow('service-sas-doc_name_for_service_sas_' + tempCnt, documentNameValidationMessage);
                    isSASDItemValidation = true;
                    return false;
                }
                if ($('#document_container_for_service_sas_' + tempCnt).is(':visible')) {
                    var uploadDoc = $('#document_for_service_sas_' + tempCnt).val();
                    if (!uploadDoc) {
                        validationMessageShow('service-sas-document_for_service_sas_' + tempCnt, uploadDocValidationMessage);
                        isSASDItemValidation = true;
                    }
                    var uploadDocMessage = fileUploadValidation('document_for_service_sas_' + tempCnt, 10240);
                    if (uploadDocMessage != '') {
                        validationMessageShow('service-sas-document_for_service_sas_' + tempCnt, uploadDocMessage);
                        isSASDItemValidation = true;
                    }
                }
            }
            var qdItem = {}
            qdItem.doc_name = docName;
            var sasDocId = $('#service_sas_doc_id_for_service_sas_' + tempCnt).val();
            if (!sasDocId || sasDocId == null) {
                newSASDItems.push(qdItem);
            } else {
                qdItem.service_sas_doc_id = sasDocId;
                exiSASDItems.push(qdItem);
            }
            sasCnt++;
        });
        if (isSASDItemValidation) {
            return false;
        }
        var returnData = {};
        returnData.new_sasd_items = newSASDItems;
        returnData.exi_sasd_items = exiSASDItems;
        return returnData;
    },
    checkValidationForREQDocument: function (moduleType) {
        var reqCnt = 1;
        var newREQDItems = [];
        var exiREQDItems = [];
        var isREQDItemValidation;
        $('.service_req_document_row').each(function () {
            var that = $(this);
            var tempCnt = that.find('.og_service_req_document_cnt').val();
            if (tempCnt == '' || tempCnt == null) {
                showError(invalidAccessValidationMessage);
                isREQDItemValidation = true;
                return false;
            }
            var docName = $('#doc_name_for_service_req_' + tempCnt).val();
            var reqType = $('input[name=requirement_type_for_service_req_' + tempCnt + ']:checked').val();
            if (moduleType != VALUE_ONE) {
                if (docName == '' || docName == null) {
                    $('#doc_name_for_service_req_' + tempCnt).focus();
                    validationMessageShow('service-req-doc_name_for_service_req_' + tempCnt, documentNameValidationMessage);
                    isREQDItemValidation = true;
                    return false;
                }
                if (reqType == '' || reqType == null) {
                    $('#requirement_type_for_service_req_' + tempCnt + '_1').focus();
                    validationMessageShow('service-req-requirement_type_for_service_req_' + tempCnt, oneOptionValidationMessage);
                    isREQDItemValidation = true;
                    return false;
                }
            }
            var qdItem = {}
            qdItem.doc_name = docName;
            qdItem.requirement_type = reqType;
            qdItem.remarks = $('#remarks_for_service_req_' + tempCnt).val();
            var reqDocId = $('#service_req_doc_id_for_service_req_' + tempCnt).val();
            if (!reqDocId || reqDocId == null) {
                newREQDItems.push(qdItem);
            } else {
                qdItem.service_req_doc_id = reqDocId;
                exiREQDItems.push(qdItem);
            }
            reqCnt++;
        });
        if (isREQDItemValidation) {
            return false;
        }
        if (moduleType != VALUE_ONE) {
            if (reqCnt == 1) {
                showError(oneDocREQValidationMessage);
                return false;
            }
        }
        var returnData = {};
        returnData.new_reqd_items = newREQDItems;
        returnData.exi_reqd_items = exiREQDItems;
        return returnData;
    },
    submitService: function (moduleType) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (moduleType != VALUE_ONE && moduleType != VALUE_TWO && moduleType != VALUE_THREE) {
            showError(invalidAccessValidationMessage);
            return false;
        }
        var that = this;
        validationMessageHide();
        var serviceData = $('#service_form').serializeFormJSON();
        var validationData = that.checkValidationForService(moduleType, serviceData);
        if (validationData != '') {
            $('#' + validationData.field).focus();
            validationMessageShow('service-' + validationData.field, validationData.message);
            return false;
        }
        if (serviceData.is_delivery_fees_for_service == VALUE_ONE) {
            var vdFD = that.checkValidationForFD(moduleType);
            if (!vdFD) {
                return false;
            }
            serviceData.delivery_fees_details = vdFD.fd_items;
            serviceData.total_delivery_fees = vdFD.total_fees;
        }
        if (moduleType != VALUE_ONE) {
            if (!serviceData.is_payment_to_applicant_for_service) {
                $('#is_payment_to_applicant_for_service_1').focus();
                validationMessageShow('service-is_payment_to_applicant_for_service', oneOptionValidationMessage);
                return false;
            }
        }
        if (serviceData.is_payment_to_applicant_for_service == VALUE_ONE) {
            if (moduleType != VALUE_ONE) {
                if (!serviceData.applicant_payment_type_for_service) {
                    $('#applicant_payment_type_for_service_1').focus();
                    validationMessageShow('service-applicant_payment_type_for_service', oneOptionValidationMessage);
                    return false;
                }
            }
            var vdPD = that.checkValidationForPD(moduleType);
            if (!vdPD) {
                return false;
            }
            serviceData.applicant_payment_details = vdPD.pd_items;
            serviceData.total_applicant_payment = vdPD.total_payment;
        }
        var validationDataSD = that.checkValidationForSD(moduleType, serviceData);
        if (validationDataSD != '') {
            $('#' + validationDataSD.field).focus();
            validationMessageShow('service-' + validationDataSD.field, validationDataSD.message);
            return false;
        }
        var vdSASD = that.checkValidationForSASDocument(moduleType);
        if (!vdSASD) {
            return false;
        }
        serviceData.new_sasd_items = vdSASD.new_sasd_items;
        serviceData.exi_sasd_items = vdSASD.exi_sasd_items;
        var vdREQD = that.checkValidationForREQDocument(moduleType);
        if (!vdREQD) {
            return false;
        }
        serviceData.new_reqd_items = vdREQD.new_reqd_items;
        serviceData.exi_reqd_items = vdREQD.exi_reqd_items;
        if (moduleType == VALUE_THREE) {
            var yesEvent = 'Service.listview.submitService(\'' + VALUE_TWO + '\')';
            showConfirmation(yesEvent, 'Submit');
            return false;
        }
        serviceData.module_type = moduleType;
        var btnObj = moduleType == VALUE_ONE ? $('#draft_btn_for_service') : $('#submit_btn_for_service');
        var ogBtnHTML = btnObj.html();
        var ogBtnOnclick = btnObj.attr('onclick');
        btnObj.html(iconSpinnerTemplate);
        btnObj.attr('onclick', '');
        $.ajax({
            type: 'POST',
            url: 'service/submit_service_details',
            data: $.extend({}, serviceData, getTokenData()),
            error: function (textStatus, errorThrown) {
                generateNewCSRFToken();
                if (!textStatus.statusText) {
                    loginPage();
                    return false;
                }
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnclick);
                validationMessageShow('service', textStatus.statusText);
                $('html, body').animate({scrollTop: '0px'}, 0);
            },
            success: function (data) {
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnclick);
                var parseData = JSON.parse(data);
                setNewToken(parseData.temp_token);
                if (parseData.success == false) {
                    validationMessageShow('service', parseData.message);
                    $('html, body').animate({scrollTop: '0px'}, 0);
                    return false;
                }
                showSuccess(parseData.message);
                Service.listview.listPage();
            }
        });
    },
    viewService: function (serviceData) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        var that = this;
        serviceData.district_text = talukaArray[serviceData.district] ? talukaArray[serviceData.district] : '';
        serviceData.declared_in_text = getCommaStringToValue(serviceData.declared_in, serviceDeclaredArray);
        serviceData.delivery_type_text = sdTypeArray[serviceData.delivery_type] ? sdTypeArray[serviceData.delivery_type] : '';
        if (serviceData.delivery_type == VALUE_THREE || serviceData.delivery_type == VALUE_FOUR) {
            serviceData.show_sd_url = true;
        }
        serviceData.ds_category_text = getCommaStringToValue(serviceData.ds_category, dsCategoryArray);
        serviceData.is_delivery_fees_text = appNappArray[serviceData.is_delivery_fees] ? appNappArray[serviceData.is_delivery_fees] : '';
        if (serviceData.is_delivery_fees == VALUE_ONE) {
            serviceData.show_delivery_fees_details = true;
        }
        serviceData.is_payment_to_applicant_text = appNappArray[serviceData.is_payment_to_applicant] ? appNappArray[serviceData.is_payment_to_applicant] : '';
        if (serviceData.is_payment_to_applicant == VALUE_ONE) {
            serviceData.show_applicant_payment_details = true;
            serviceData.applicant_payment_type_text = paymentTypeArray[serviceData.applicant_payment_type] ? paymentTypeArray[serviceData.applicant_payment_type] : '';
        }
        showPopup();
        $('.swal2-popup').css('width', '40em');
        $('#popup_container').html(serviceViewTemplate(serviceData));
        if (serviceData.show_delivery_fees_details) {
            var tdfdCnt = VALUE_ONE;
            if (serviceData.delivery_fees_details != '') {
                var dfdData = JSON.parse(serviceData.delivery_fees_details);
                $.each(dfdData, function (index, fd) {
                    fd.cnt = (index + 1);
                    fd.description = fd.fee_description;
                    fd.amount = fd.fee;
                    $('#fd_item_container_for_view_service').append(serviceFPDItemViewTemplate(fd));
                    tdfdCnt++;
                });
            }
            if (tdfdCnt == VALUE_ONE) {
                $('#fd_item_container_for_view_service').html(noRecordFoundTemplate({'colspan': 3, 'message': 'Fee Details Not Available !'}));
            }
        }
        if (serviceData.show_applicant_payment_details) {
            var tapdCnt = VALUE_ONE;
            if (serviceData.applicant_payment_details != '') {
                var apdData = JSON.parse(serviceData.applicant_payment_details);
                $.each(apdData, function (index, pd) {
                    pd.cnt = (index + 1);
                    pd.description = pd.payment_description;
                    pd.amount = pd.payment;
                    $('#pd_item_container_for_view_service').append(serviceFPDItemViewTemplate(pd));
                    tapdCnt++;
                });
            }
            if (tapdCnt == VALUE_ONE) {
                $('#pd_item_container_for_view_service').html(noRecordFoundTemplate({'colspan': 3, 'message': 'Payment Details Not Available !'}));
            }
        }
        if (serviceData.cc_doc != '') {
            that.loadDocForServiceView('cc_doc', serviceData.cc_doc);
        }
        if (serviceData.process_flow_doc != '') {
            that.loadDocForServiceView('process_flow_doc', serviceData.process_flow_doc);
        }
        if (serviceData.sas_doc_data) {
            var tsasdCnt = VALUE_ONE;
            $.each(serviceData.sas_doc_data, function (index, sasDoc) {
                sasDoc.cnt = (index + 1);
                $('#sas_doc_item_container_for_service_view').append(serviceSASDocItemViewTemplate(sasDoc));
                if (sasDoc.document != '') {
                    that.loadDocForServiceView('document', 'sas_doc/' + sasDoc.document, '_' + sasDoc.cnt + '_sas');
                }
                tsasdCnt++;
            });
            if (tsasdCnt == VALUE_ONE) {
                $('#sas_doc_item_container_for_service_view').html(noRecordFoundTemplate({'colspan': 3, 'message': 'Document Not Available !'}));
            }
        }
        if (serviceData.req_doc_data) {
            var tsasdCnt = VALUE_ONE;
            $.each(serviceData.req_doc_data, function (index, reqDoc) {
                reqDoc.cnt = (index + 1);
                reqDoc.requirement_type_text = drTypeArray[reqDoc.requirement_type] ? drTypeArray[reqDoc.requirement_type] : '';
                $('#req_doc_item_container_for_service_view').append(serviceREQDocItemViewTemplate(reqDoc));
                if (reqDoc.document != '') {
                    that.loadDocForServiceView('document', 'req_doc/' + reqDoc.document, '_' + reqDoc.cnt + '_req');
                }
                tsasdCnt++;
            });
            if (tsasdCnt != VALUE_ONE) {
                $('#req_doc_container_for_service_view').show();
            }
        }
    },
    loadDocForServiceView: function (id, docField, tCnt) {
        if (typeof tCnt === "undefined") {
            tCnt = '';
        }
        $('#' + id + '_name_container_for_service_view' + tCnt).show();
        $('#' + id + '_name_href_for_service_view' + tCnt).attr('href', 'documents/service/' + docField);
        $('#' + id + '_name_for_service_view' + tCnt).html(VIEW_UPLODED_DOCUMENT);
    },
});
