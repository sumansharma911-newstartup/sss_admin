var ticketRaiseListTemplate = Handlebars.compile($('#ticket_raise_list_template').html());
var ticketRaiseTableTemplate = Handlebars.compile($('#ticket_raise_table_template').html());
var ticketRaiseActionTemplate = Handlebars.compile($('#ticket_raise_action_template').html());
var ticketRaiseViewTemplate = Handlebars.compile($('#ticket_raise_view_template').html());
var ticketRaiseDocItemViewTemplate = Handlebars.compile($('#ticket_raise_doc_item_view_template').html());

var Ticketraise = {
    run: function () {
        this.router = new this.Router();
        this.listview = new this.listView();
    }
};

Ticketraise.Router = Backbone.Router.extend({
    routes: {
        'ticket_raise': 'renderList',

              
    },
    renderList: function () {
        Ticketraise.listview.listPage();
    },
    renderListForForm: function () {
        Ticketraise.listview.listPage();
    },
});

Ticketraise.listView = Backbone.View.extend({
    el: 'div#main_container',
    listPage: function () {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        activeLink('menu_ticket_raise');
        addClass('menu_ticket_raise', 'active');
        Ticketraise.router.navigate('ticket_raise');
        var templateData = {};
        this.$el.html(ticketRaiseListTemplate(templateData));
        this.loadticketRaiseData();
    },

    loadticketRaiseData: function () {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }

        var deptDetailsRenderer = function (data, type, full, meta) {
            return (talukaArray[data] ? talukaArray[data] : '')
        };
        
        var actionRenderer = function (data, type, full, meta) {
            var templateData = {};
            templateData.ticketraise_id = data;
            if (full.status == VALUE_ONE) {
                full.enable_button = true;  
                 full.disable_button = false;
            }
            if (full.status == VALUE_TWO) {
                full.enable_button = true;
                full.disable_button = false;
            }
            if (full.status == VALUE_THREE) {
                full.enable_button = false;
                full.disable_button = true;
            }
            if (full.status == VALUE_FOUR) {
                full.enable_button = false;
                full.disable_button = true;
            }
            return ticketRaiseActionTemplate(full);
        };


        var statusRenderer = function (data, type, full, meta) {
            return appStatusArray[data] ? appStatusArray[data] : '';
        };


        renderOptionsForTwoDimensionalArray(talukaArray, 'district_for_ticketraise');

        Ticketraise.router.navigate('ticket_raise');       
        $('#ticket_raise_form_and_datatable_container').html(ticketRaiseTableTemplate);

        ticketraiseDataTable = $('#ticket_raise_datatable').DataTable({             
            ajax: {url: 'ticket_raise/get_ticketraise_data', dataSrc: "ticketraise_data", type: "post", data: getTokenData()},
            bAutoWidth: false,
            pageLength: 10,
            ordering: false,
            language: dataTableProcessingAndNoDataMsg,
            columns: [
                {data: '', 'render': serialNumberRenderer, 'class': 'text-center'},
                {data: 'district', 'class': 'text-center', 'render': deptDetailsRenderer},
                {data: 'username', 'class': 'text-center'}, 
                {data: 'designation', 'class': 'text-center'}, 
                // {data: 'supportrequired', 'class': 'text-center'},  
                 {data: 'name', 'class': 'text-center'},
                {data: 'status', 'class': 'text-center','render' : statusRenderer},              
                {data: 'ticketraise_id', 'class': 'text-center', 'render': actionRenderer},
            ],
            "initComplete": function (settings, json) {
                setNewToken(json.temp_token);
               
                    this.api().columns().every(function () {
                        var that = this;
                        $('input', this.header()).on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        });
                        $('select', this.header()).on('change', function () {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        });        
                    });
                
            }
        });             
    },

    ViewTicketraise: function (btnObj,ticketraiseId,isEdit,ticketraiseData) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }

        if (!ticketraiseId) {
            showError(invalidAccessValidationMessage);
            return;
        }
        
        var that = this;
        tempUserTypeData = [];
        var ogBtnHTML = btnObj.html();
        var ogBtnOnClick = btnObj.attr("onclick");
        btnObj.html(iconSpinnerTemplate);
        btnObj.attr('onclick', '');
        $.ajax({
            url: 'ticket_raise/get_ticketraise_data_by_id',
            type: 'post',
            data: $.extend({}, {'ticketraise_id': ticketraiseId}, getTokenData()),
            error: function (textStatus, errorThrown) {
                generateNewCSRFToken();
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnClick);
                showError(textStatus.statusText);
                $('html, body').animate({scrollTop: '0px'}, 0);
            },
            success: function (response) {
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnClick);
                var parseData = JSON.parse(response);
                setNewToken(parseData.temp_token);
                if (parseData.success === false) {
                    showError(parseData.message);
                    $('html, body').animate({scrollTop: '0px'}, 0);
                    return false;
                }
                var ticketraiseData = parseData.ticketraise_data;
                ticketraiseData.TICKETRAISE_DOC_PATH = TICKETRAISE_DOC_PATH;

                ticketraiseData.district_text = talukaArray[ticketraiseData.district] ? talukaArray[ticketraiseData.district] : '';  

                ticketraiseData.remark_assign = ticketraiseData.status == VALUE_ONE ? true : false;  
                if (ticketraiseData.status == VALUE_THREE || ticketraiseData.status == VALUE_FOUR){
                    ticketraiseData.hide_assign = true;
                }
                if (ticketraiseData.status == VALUE_ONE || ticketraiseData.status == VALUE_TWO){
                    ticketraiseData.employee_assign = true;
                }
                // if (ticketraiseData.status == VALUE_THREE || ticketraiseData.status == VALUE_ONE || ticketraiseData.status == VALUE_TWO){
                //     ticketraiseData.show_assign = true;
                // }
                if (ticketraiseData.status == VALUE_TWO || ticketraiseData.status == VALUE_THREE){
                    ticketraiseData.already_assign = true;
                }
                ticketraiseData.completedata_assign = ticketraiseData.status == VALUE_TWO ? true : false;               


                //Employee name display                
                ticketraiseData.name = parseData.assignedusername;                 
                ticketraiseData.button_status = ticketraiseData.status == VALUE_THREE ? false : true;
                
    
                
                //Enable and disable drop down in employee name
                
                $('#model_title').html('Ticketing System ');
                $('#model_body').html(ticketRaiseViewTemplate(ticketraiseData));
                $('#popup_modal').modal('show');

                // workstatus = parseData.assigned_users;              
                // if (workstatus[0].work_status == 0) {
                //    $('#username_for_ticketraise').prop('disabled', false);
                // }
                // else if (workstatus[0].work_status == 1){
                //     $('#username_for_ticketraise').prop('disabled', true);
                // }
                // else {
                //     return false;
                // }
                   
                if (parseData.assigned_users != '') {
                    var assignedUserData = parseData.assigned_users;
                    var detailCnt = 1;
                    $.each(assignedUserData, function (index, aud) {                        
                       
                        var buttonRow = aud.work_status == 0 || aud.status == 3 ?
                        '<td><button type="button" class="btn" disabled> Cancel</button></td>' :                              
                      '<td><button type="button" id="workstatus_' + aud.assignedemployee_id +'" name="workstatus" class="btn" onclick="Ticketraise.listview.askForRemoveuser(\''+ aud.emp_user_id + "','" + aud.ticketraise_id + '\');" style="color:blue;text-decoration: underline;">Cancel</button></td></tr>';
                        
                        var audRow = '<tr><td class="text-center" style="width:20px;">' + detailCnt + '</td><td class="text-center">' + aud.sa_user_name + '</td>' +
                                '<td class="text-center">' + (aud.date != '0000-00-00' ? dateTo_DD_MM_YYYY(aud.date) : '') + '</td>' +
                                buttonRow
                               
                        $('#assignuser_item_container_for_fr_view').append(audRow);
                        
                        detailCnt++;
                    });                    
                    
                }            
                

                if (ticketraiseData.process_flow_doc != '') {
                    that.loadDocForticketRaiseView('process_flow_doc', ticketraiseData.process_flow_doc);
                }
                if (ticketraiseData.tr_doc_data) {
                    var tdwdCnt = VALUE_ONE;
                    $.each(ticketraiseData.tr_doc_data, function (index, trDoc) {
                        trDoc.cnt = (index + 1);
                        $('#doc_item_container_for_ticketraise_view').append(ticketRaiseDocItemViewTemplate(trDoc));
                        if (trDoc.document != '') {
                            that.loadDocForticketRaiseView('document', 'tr_doc/' + trDoc.document, '_' + trDoc.cnt + '_tr');
                        }
                        tdwdCnt++;
                    });
                    if (tdwdCnt == VALUE_ONE) {
                        $('#doc_item_container_for_ticketraise_view').html(noRecordFoundTemplate({'colspan': 3, 'message': 'Document Not Available !'}));
                    }
                    if (tdwdCnt != VALUE_ONE) {
                        $('#req_doc_container_for_ticketraise_view').show();
                    }
                }                      
                tempUserTypeData = parseData.name;               
                renderOptionsForTwoDimensionalArrayWithKeyValueWithCombination(tempUserTypeData, 'username_for_ticketraise','sa_user_id','name');   
                generateSelect2(); 
                workstatus = parseData.assigned_users;              
                if (workstatus[0].work_status == 0) {
                   $('#username_for_ticketraise').prop('disabled', false);
                }
                else {
                    $('#username_for_ticketraise').prop('disabled', true);
                }
                
                          
                
            }
            
        });       

    },
    checkValidationForUsers: function (usersData) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        
        if (!usersData.username_for_ticketraise) {
            return getBasicMessageAndFieldJSONArray('username_for_ticketraise', selectEmployeeTypeValidationMessage);
        }
        return '';
    },
    loadDocForticketRaiseView: function (id, docField, tCnt) {
        if (typeof tCnt === "undefined") {
            tCnt = '';
        }
        $('#' + id + '_name_container_for_ticketraise_view' + tCnt).show();
        $('#' + id + '_name_href_for_ticketraise_view' + tCnt).attr('href', TICKETRAISE_DOC_PATH  + docField);
        $('#' + id + '_name_for_ticketraise_view' + tCnt).html(VIEW_UPLODED_DOCUMENT);
    },

    submitticketRaiseassign: function (btnObj) {      
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        var that = this;
        validationMessageHide();
        var ticketraiseData = $('#ticketraise_assign_remark_user').serializeFormJSON();
       
        var validationData = that.checkValidationForUsers(ticketraiseData);
            if (validationData != '') {
                $('#' + validationData.field).focus();
                validationMessageShow('users-' + validationData.field, validationData.message);
                return false;
            }             
            var ogBtnHTML = btnObj.html();
            var ogBtnOnclick = btnObj.attr('onclick');
            btnObj.html(iconSpinnerTemplate);
            btnObj.attr('onclick', '');
            $.ajax({
                type: 'POST',
                url: 'ticket_raise/submit_assignuser_details',
                data: $.extend({}, ticketraiseData, getTokenData()),
                error: function (textStatus, errorThrown) {
                    generateNewCSRFToken();
                    if (!textStatus.statusText) {
                        loginPage();
                        return false;
                    }
                    btnObj.html(ogBtnHTML);
                    btnObj.attr('onclick', ogBtnOnclick);
                    validationMessageShow('users', textStatus.statusText);
                    $('html, body').animate({ scrollTop: '0px' }, 0);
                },
                success: function (data) {
                    btnObj.html(ogBtnHTML);
                    btnObj.attr('onclick', ogBtnOnclick);
                    var parseData = JSON.parse(data);
                    setNewToken(parseData.temp_token);
                    if (parseData.success == false) {
                        validationMessageShow('users', parseData.message);
                        $('html, body').animate({ scrollTop: '0px' }, 0);
                        return false;
                    }
                    showSuccess(parseData.message);
                    resetModel();
                    Ticketraise.listview.loadticketRaiseData();
                }
            });        
    },
    checkValidationForticketraise: function (ticketraiseData) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }        

        if (!ticketraiseData.remark_for_ticketraise) {
            return getBasicMessageAndFieldJSONArray('remark_for_ticketraise', remarkValidationMessage);
        }

        return '';
    },    
    submitticketRaiseremark: function (btnObj) {      
        
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        var that = this;
        validationMessageHide();
        var ticketraiseData = $('#ticketraise_assign_remark_user').serializeFormJSON();
        var validationData = that.checkValidationForticketraise(ticketraiseData);
            if (validationData != '') {
                $('#' + validationData.field).focus();
                validationMessageShow('ticketraise-' + validationData.field, validationData.message);
                return false;
            }             

            var ogBtnHTML = btnObj.html();
            var ogBtnOnclick = btnObj.attr('onclick');
            btnObj.html(iconSpinnerTemplate);
            btnObj.attr('onclick', '');
            $.ajax({
                type: 'POST',
                url: 'ticket_raise/submit_ticketraiseremark_details',
                data: $.extend({}, ticketraiseData, getTokenData()),
                error: function (textStatus, errorThrown) {
                    generateNewCSRFToken();
                    if (!textStatus.statusText) {
                        loginPage();
                        return false;
                    }
                    btnObj.html(ogBtnHTML);
                    btnObj.attr('onclick', ogBtnOnclick);
                    validationMessageShow('ticketraise', textStatus.statusText);
                    $('html, body').animate({ scrollTop: '0px' }, 0);
                },
                success: function (data) {
                    btnObj.html(ogBtnHTML);
                    btnObj.attr('onclick', ogBtnOnclick);
                    var parseData = JSON.parse(data);
                    setNewToken(parseData.temp_token);
                    if (parseData.success == false) {
                        validationMessageShow('ticketraise', parseData.message);
                        $('html, body').animate({ scrollTop: '0px' }, 0);
                        return false;
                    }
                    showSuccess(parseData.message);
                    resetModel();
                   Ticketraise.listview.loadticketRaiseData();
                }
            });
        
    },   
    rejectTicketRaiseremark: function (btnObj,ticketraise_id) {      
        
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        var that = this;
        validationMessageHide();
        var ticketraiseData = $('#ticketraise_assign_remark_user').serializeFormJSON();
        var validationData = that.checkValidationForticketraise(ticketraiseData);
        if (validationData != '') {
            $('#' + validationData.field).focus();
            validationMessageShow('ticketraise-' + validationData.field, validationData.message);
            return false;
        }             

        var ogBtnHTML = btnObj.html();
        var ogBtnOnclick = btnObj.attr('onclick');
        btnObj.html(iconSpinnerTemplate);
        btnObj.attr('onclick', '');
        $.ajax({
            type: 'POST',
            url: 'ticket_raise/submit_ticketraisereject_details',
            data: $.extend({}, ticketraiseData, getTokenData()),
            error: function (textStatus, errorThrown) {
                generateNewCSRFToken();
                if (!textStatus.statusText) {
                    loginPage();
                    return false;
                }
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnclick);
                validationMessageShow('ticketraise', textStatus.statusText);
                $('html, body').animate({ scrollTop: '0px' }, 0);
            },
            success: function (data) {
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnclick);
                var parseData = JSON.parse(data);
                setNewToken(parseData.temp_token);
                if (parseData.success == false) {
                    validationMessageShow('ticketraise', parseData.message);
                    $('html, body').animate({ scrollTop: '0px' }, 0);
                    return false;
                }
                showSuccess(parseData.message);
                resetModel();
                Ticketraise.listview.loadticketRaiseData();
            }
        });        
    },
    askForRemoveuser: function (sauserid,ticketraise_id) {
        // alert(trDocId);
         if (!sauserid || !ticketraise_id) {
             showError(invalidAccessValidationMessage);
             return false;
         }
        var yesEvent = 'Ticketraise.listview.cancelassign($(this),'+ sauserid +',' + ticketraise_id + ')';
        showConfirmation(yesEvent, 'Remove');
     },
    cancelassign: function (btnObj,sauserid,ticketraise_id) {    
         if (!tempIdInSession || tempIdInSession == null) {
             loginPage();
             return false;
         }              
                   
        var ogBtnHTML = btnObj.html();
        var ogBtnOnclick = btnObj.attr('onclick');
        btnObj.html(iconSpinnerTemplate);
        btnObj.attr('onclick', '');
        $.ajax({
            type: 'POST',
            url: 'ticket_raise/assignuserstatus',
            data: $.extend({}, {'sa_user_id':sauserid,'ticketraise_id':ticketraise_id}, getTokenData()),
            error: function (textStatus, errorThrown) {
                generateNewCSRFToken();
                if (!textStatus.statusText) {
                    loginPage();
                    return false;
                }
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnclick);
                validationMessageShow('users', textStatus.statusText);
                $('html, body').animate({ scrollTop: '0px' }, 0);
            },
            success: function (data) {
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnclick);
                var parseData = JSON.parse(data);
                setNewToken(parseData.temp_token);
                if (parseData.success == false) {
                    validationMessageShow('users', parseData.message);
                    $('html, body').animate({ scrollTop: '0px' }, 0);
                    return false;
                }
                showSuccess(parseData.message);
                resetModel();
                Ticketraise.listview.loadticketRaiseData();
            }
        });        
     },
});

// 'http://localhost:90/ticketsystem/documents/ticketraise/'