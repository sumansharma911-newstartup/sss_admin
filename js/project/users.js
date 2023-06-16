var usersListTemplate = Handlebars.compile($('#users_list_template').html());
var usersTableTemplate = Handlebars.compile($('#users_table_template').html());
var usersActionTemplate = Handlebars.compile($('#users_action_template').html());
var usersFormTemplate = Handlebars.compile($('#users_form_template').html());

var userTypeListTemplate = Handlebars.compile($('#user_type_list_template').html());
var userTypeTableTemplate = Handlebars.compile($('#user_type_table_template').html());
var userTypeActionTemplate = Handlebars.compile($('#user_type_action_template').html());
var userTypeFormTemplate = Handlebars.compile($('#user_type_form_template').html());

var changePasswordFormTemplate = Handlebars.compile($('#change_password_form_template').html());
var tempUserTypeData = [];
var tempDeptData = [];
var Users = {
    run: function () {
        this.router = new this.Router();
        this.listview = new this.listView();
    }
};
Users.Router = Backbone.Router.extend({
    routes: {
        'users': 'renderList',
        'user_type': 'renderListForUserType',
        'change_password': 'renderListForChangePassword'
    },
    renderList: function () {
        Users.listview.listPage();
    },
    renderListForUserType: function () {
        Users.listview.listPageForUserType();
    },
    renderListForChangePassword: function () {
        Users.listview.listPageForChangePassword();
    }
});
Users.listView = Backbone.View.extend({
    el: 'div#main_container',
    listPage: function () {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        activeLink('menu_users');
        addClass('menu_users_user', 'active');
        Users.router.navigate('users');
        var templateData = {};
        this.$el.html(usersListTemplate(templateData));
        this.loadUsersData();

    },
    loadUsersData: function () {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        Users.router.navigate('users');
        var usersActionRenderer = function (data, type, full, meta) {
            return usersActionTemplate({'sa_user_id': data});
        };
        var userStatusRenderer = function (data, type, full, meta) {
            if (data == IS_DEACTIVE) {
                return '<span class="badge bg-danger" id="active_deactive_container_' + full.sa_user_id + '">Deactive</span>';
            }
            return '<span class="badge bg-success" id="active_deactive_container_' + full.sa_user_id + '">Active</span>';
        };
        $('#users_form_and_datatable_container').html(usersTableTemplate);
        $('#users_datatable').DataTable({
            ajax: {url: 'users/get_users_data', dataSrc: "users_data", type: "post", data: getTokenData()},
            bAutoWidth: false,
            pageLength: 25,
            ordering: false,
            language: dataTableProcessingAndNoDataMsg,
            columns: [
                {data: '', 'render': serialNumberRenderer, 'class': 'text-center'},
                {data: 'district', 'class': 'text-center', 'render': districtRenderer, 'orderable': false},
                {data: 'department_name'},
                {data: 'mobile_number', 'class': 'text-center'},
                {data: 'email', 'class': 'text-center'},
                {data: 'name'},
                {data: 'username'},
                {data: 'type', 'class': 'text-center', 'orderable': false},
                {data: 'status', 'class': 'text-center', 'render': userStatusRenderer, 'orderable': false},
                {
                    "orderable": false,
                    "data": 'sa_user_id',
                    "render": usersActionRenderer,
                    'class': 'text-center'
                }
            ],
            "initComplete": function (settings, json) {
                setNewToken(json.temp_token);
            }
        });
    },
    askForNewUsersForm: function (btnObj) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        var ogBtnHTML = btnObj.html();
        var ogBtnOnClick = btnObj.attr("onclick");
        btnObj.html(iconSpinnerTemplate);
        btnObj.attr('onclick', 'Users.listview.askForNewUsersForm($(this));');
        var that = this;
        tempUserTypeData = [];
        $.ajax({
            type: 'POST',
            url: 'users/get_common_data_for_user',
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
                tempUserTypeData = parseData.user_type_data;
                tempDeptData = parseData.department_data;
                that.newUsersForm(false, {});
            }
        });
    },
    newUsersForm: function (isEdit, usersData) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        var that = this;
        if (!isEdit) {
            usersData.password = defaultPassword;
        }
        $('#users_form_and_datatable_container').html(usersFormTemplate(usersData));
        renderOptionsForTwoDimensionalArrayWithKeyValueWithCombination(tempUserTypeData, 'user_type_for_users', 'sa_user_type_id', 'type');
        renderOptionsForTwoDimensionalArray(talukaArray, 'district_for_users');
        var deptData = [];
        if (isEdit) {
            deptData = tempDeptData[usersData.district] ? tempDeptData[usersData.district] : [];
        }
        renderOptionsForTwoDimensionalArrayWithKeyValueWithCombination(deptData, 'department_id_for_users', 'department_id', 'department_name');
        if (isEdit) {
            $('#user_type_for_users').val(usersData.user_type).trigger('change');
            $('#status_type_for_users').val(usersData.status);
            $('#district_for_users').val(usersData.district);
            $('#department_id_for_users').val(usersData.department_id);
        }
        generateSelect2();
        $('#users_form').find('input').keypress(function (e) {
            if (e.which == 13) {
                that.submitUsers($('#submit_btn_for_users'));
            }
        });
    },
    editUser: function (btnObj, userId) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        if (!userId) {
            showError(invalidUserValidationMessage);
            return;
        }
        var that = this;
        var ogBtnHTML = btnObj.html();
        var ogBtnOnClick = btnObj.attr("onclick");
        btnObj.html(iconSpinnerTemplate);
        btnObj.attr('onclick', '');
        $.ajax({
            url: 'users/get_user_data_by_id',
            type: 'post',
            data: $.extend({}, {'user_id': userId}, getTokenData()),
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
                tempDeptData = parseData.department_data;
                tempUserTypeData = parseData.user_type_data;
                that.newUsersForm(true, parseData.user_data);
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
        if (!usersData.name_for_users) {
            return getBasicMessageAndFieldJSONArray('name_for_users', nameValidationMessage);
        }
        if (!usersData.username_for_users) {
            return getBasicMessageAndFieldJSONArray('username_for_users', usernameValidationMessage);
        }
        if (!usersData.password_for_users) {
            return getBasicMessageAndFieldJSONArray('password_for_users', passwordValidationMessage);
        }
        var passwordMessage = passwordValidation(usersData.password_for_users);
        if (passwordMessage != '') {
            return getBasicMessageAndFieldJSONArray('password_for_users', passwordMessage);
        }
        if (!usersData.user_type_for_users) {
            return getBasicMessageAndFieldJSONArray('user_type_for_users', selectUserTypeValidationMessage);
        }
        return '';
    },
    submitUsers: function (btnObj) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        var that = this;
        validationMessageHide();
        var usersData = $('#users_form').serializeFormJSON();
        var validationData = that.checkValidationForUsers(usersData);
        if (validationData != '') {
            $('#' + validationData.field).focus();
            validationMessageShow('users-' + validationData.field, validationData.message);
            return false;
        }
        var ogBtnHTML = btnObj.html();
        var ogBtnOnClick = btnObj.attr("onclick");
        btnObj.html(iconSpinnerTemplate);
        btnObj.attr('onclick', '');
        var url = usersData.sa_user_id_for_users ? 'update' : 'save';
        $.ajax({
            type: 'POST',
            url: 'users/' + url + '_user',
            data: $.extend({}, usersData, getTokenData()),
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
                that.loadUsersData();
                showSuccess(parseData.message);
            }
        });
    },
    listPageForUserType: function () {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        Users.router.navigate('user_type');
        activeLink('menu_users');
        addClass('menu_users_user_type', 'active');
        var templateData = {};
        this.$el.html(userTypeListTemplate(templateData));
        this.loadUsersTypesData();
    },
    loadUsersTypesData: function () {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        var userTypeActionRenderer = function (data, type, full, meta) {
            return userTypeActionTemplate({'sa_user_type_id': data});
        };
        Users.router.navigate('user_type');
        $('#user_type_datatable_container').html(userTypeTableTemplate);
        $('#user_type_datatable').DataTable({
            ajax: {url: 'users/get_user_type_data', dataSrc: "user_type_data", type: "post", data: getTokenData()},
            bAutoWidth: false,
            pageLength: 10,
            language: dataTableProcessingAndNoDataMsg,
            columns: [
                {data: '', 'render': serialNumberRenderer, 'class': 'text-center'},
                {data: 'type'},
                {
                    "orderable": false,
                    "data": 'sa_user_type_id',
                    "render": userTypeActionRenderer,
                    'class': 'text-center'
                }
            ],
            "initComplete": function (settings, json) {
                setNewToken(json.temp_token);
            }
        });
    },
    newUserType: function (isEdit, userTypeData) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        var that = this;
        $('#model_title').html(isEdit ? 'Update' : 'Add' + ' User Type');
        $('#model_body').html(userTypeFormTemplate(userTypeData));
        $('#popup_modal').modal('show');
        $('#user_type_form').find('input').keypress(function (e) {
            if (e.which == 13) {
                that.submitUserType($('#submit_btn_for_user_type'));
            }
        });
    },
    submitUserType: function (btnObj) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        var that = this;
        validationMessageHide();
        var userTypeId = $('#user_type_id_for_user_type').val();
        var userType = $('#type_for_user_type').val();
        if (!userType) {
            $('#type_for_user_type').focus();
            validationMessageShow('user-type-type_for_user_type', userTypeValidationMessage);
            return false;
        }
        var formData = {};
        formData.user_type_for_user_type = userType;
        if (userTypeId) {
            formData.user_type_id_for_user_type = userTypeId;
        }
        var ogBtnHTML = btnObj.html();
        var ogBtnOnClick = btnObj.attr("onclick");
        btnObj.html(iconSpinnerTemplate);
        btnObj.attr('onclick', '');
        var url = userTypeId != '' ? 'update' : 'save';
        $.ajax({
            type: 'POST',
            url: 'users/' + url + '_user_type',
            data: $.extend({}, formData, getTokenData()),
            error: function (textStatus, errorThrown) {
                generateNewCSRFToken();
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnClick);
                validationMessageShow('user-type', textStatus.statusText);
                $('html, body').animate({scrollTop: '0px'}, 0);
            },
            success: function (data) {
                btnObj.html(ogBtnHTML);
                btnObj.attr('onclick', ogBtnOnClick);
                var parseData = JSON.parse(data);
                setNewToken(parseData.temp_token);
                if (parseData.success == false) {
                    validationMessageShow('user-type', parseData.message);
                    $('html, body').animate({scrollTop: '0px'}, 0);
                    return false;
                }
                that.loadUsersTypesData();
                resetModel();
                showSuccess(parseData.message);
            }
        });
    },
    editUserType: function (btnObj, userTypeId) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (tempTypeInSession != TEMP_TYPE_A) {
            Dashboard.router.navigate('dashboard', {trigger: true});
            return false;
        }
        if (!userTypeId) {
            showError(invalidUserTypeValidationMessage);
            return;
        }
        var that = this;
        var ogBtnHTML = btnObj.html();
        var ogBtnOnClick = btnObj.attr("onclick");
        btnObj.html(iconSpinnerTemplate);
        btnObj.attr('onclick', '');
        $.ajax({
            url: 'users/get_user_type_data_by_id',
            type: 'post',
            data: $.extend({}, {'user_type_id': userTypeId}, getTokenData()),
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
                that.newUserType(true, parseData.user_type_data);
            }
        });
    },
    hideShowPassword: function (obj, id) {
        var InputType = document.getElementById(id);
        if (InputType.type === "password") {
            InputType.type = "text";
            obj.html('<span class="input-group-text"><i class="fa fa-eye-slash"></i></span>');
        } else {
            InputType.type = "password";
            obj.html('<span class="input-group-text"><i class="fa fa-eye"></i></span>');
        }
    },
    listPageForChangePassword: function () {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        activeLink('menu_change_password');
        Users.router.navigate('change_password');
        var that = this;
        that.$el.html(changePasswordFormTemplate);
        $('#change_password_form').find('input').keypress(function (e) {
            if (e.which == 13) {
                that.changePassword($('#submit_btn_for_change_password'));
            }
        });
    },
    checkValidationForChangePassword: function (changePasswordFormData) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        if (!changePasswordFormData.current_password_for_change_password) {
            return getBasicMessageAndFieldJSONArray('current_password_for_change_password', passwordValidationMessage);
        }
        if (!changePasswordFormData.new_password_for_change_password) {
            return getBasicMessageAndFieldJSONArray('new_password_for_change_password', passwordValidationMessage);
        }
        var passwordVMessage = passwordValidation(changePasswordFormData.new_password_for_change_password);
        if (passwordVMessage != '') {
            return getBasicMessageAndFieldJSONArray('new_password_for_change_password', passwordVMessage);
        }
        if (!changePasswordFormData.retype_password_for_change_password) {
            return getBasicMessageAndFieldJSONArray('retype_password_for_change_password', retypePasswordValidationMessage);
        }
        if (changePasswordFormData.new_password_for_change_password != changePasswordFormData.retype_password_for_change_password) {
            return getBasicMessageAndFieldJSONArray('retype_password_for_change_password', passwordAndRetypePasswordValidationMessage);
        }
        return '';
    },
    changePassword: function (btnObj) {
        if (!tempIdInSession || tempIdInSession == null) {
            loginPage();
            return false;
        }
        var that = this;
        validationMessageHide();
        var changePasswordFormData = $('#change_password_form').serializeFormJSON();
        var validationData = that.checkValidationForChangePassword(changePasswordFormData);
        if (validationData != '') {
            $('#' + validationData.field).focus();
            validationMessageShow('change-password-' + validationData.field, validationData.message);
            return false;
        }
        var ogBtnHTML = btnObj.html();
        var ogBtnOnClick = btnObj.attr("onclick");
        btnObj.html(iconSpinnerTemplate);
        btnObj.attr('onclick', '');
        $.ajax({
            type: 'POST',
            url: 'users/change_password',
            data: $.extend({}, changePasswordFormData, getTokenData()),
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
                that.resetChangePasswordForm();
                showSuccess(parseData.message);
            }
        });
    },
    resetChangePasswordForm: function () {
        validationMessageHide();
        resetForm('change_password_form');
        document.getElementById('current_password_for_change_password').type = 'password';
        document.getElementById('new_password_for_change_password').type = 'password';
        document.getElementById('retype_password_for_change_password').type = 'password';
        $('.eye-class').html('<span class="input-group-text"><i class="fa fa-eye"></i></span>');
    },
});
