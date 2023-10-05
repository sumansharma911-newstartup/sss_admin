<?php $base_url = base_url(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>TICKET RAISED SYSTEM - DNHDD | Registration</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
        $this->load->view('common/css_links', array('base_url' => $base_url, 'is_login' => true));
        $this->load->view('common/utility_template');
        $this->load->view('common/js_links', array('base_url' => $base_url));
        ?>
        <script src="<?php echo $base_url; ?>plugins/select2/select2.full.min.js" type="text/javascript"></script>
        <script src="<?php echo $base_url; ?>js/handlebars.js" type="text/javascript"></script>
        <?php $this->load->view('common/validation_message'); ?>
    </head>
    <body class="hold-transition layout-top-nav">
        <?php $this->load->view('security'); ?>
        <div class="wrapper">
            <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
                <div class="container text-center" style="display: inline;">
                    <span class="brand-text font-weight-light fs-login-title" style="font-weight: bold !important;">
                        TICKET RAISED SYSTEM Admin - DNHDD
                    </span>
                </div>
            </nav>
            <div class="content-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6 mt-4 mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title f-w-b" style="float: none; text-align: center;">
                                        Registration
                                    </h3>
                                </div>
                                <div class="card-body registration-card-body" id="registration_success_message_container">
                                    <div class="text-center mb-2">
                                        <span class="error-message error-message-registration f-w-b" style="border-bottom: 2px solid red;"></span>
                                    </div>
                                    <form id="registration_form" method="post" onsubmit="return false;">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>District <span style="color: red;">*</span></label>
                                                <select id="district_for_registration" name="district_for_registration" class="form-control select2"
                                                        onchange="districtChangeEvent($(this), 'registration');"
                                                        data-placeholder="Select District" style="width: 100%;">
                                                </select>
                                                <span class="error-message error-message-registration-district_for_registration"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Department Name <span style="color: red;">*</span></label>
                                                <select id="department_id_for_registration" name="department_id_for_registration" class="form-control select2"
                                                        onblur="checkValidation('registration', 'department_id_for_registration', selectDepartmentValidationMessage);"
                                                        data-placeholder="Select Department" style="width: 100%;">
                                                </select>
                                                <span class="error-message error-message-registration-department_id_for_registration"></span>
                                            </div>
                                        </div>
                                        <div class="row" id="other_department_container_for_registration" style="display: none;">
                                            <div class="form-group col-sm-12">
                                                <label>Other Department Name <span class="color-nic-red">*</span></label>
                                                <input type="text" id="other_department_name_for_registration" name="other_department_name_for_registration"
                                                       onblur="checkValidation('registration', 'other_department_name_for_registration', departmentValidationMessage);"
                                                       class="form-control" placeholder="Enter Other Department Name." maxlength="50">
                                                <span class="error-message error-message-registration-other_department_name_for_registration"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label>Contact Person Name <span class="color-nic-red">*</span></label>
                                                <input type="text" class="form-control" id="cp_name_for_registration" name="cp_name_for_registration"
                                                       onblur="checkValidation('registration', 'cp_name_for_registration', nameValidationMessage);"
                                                       placeholder="Enter Contact Person Name !" maxlength="50">
                                                <span class="error-message error-message-registration-cp_name_for_registration"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Contact Person Mobile Number <span class="color-nic-red">*</span></label>
                                                <input type="text" id="cp_mobile_number_for_registration" name="cp_mobile_number_for_registration"
                                                       class="form-control" placeholder="Enter Contact Person Mobile Number !"
                                                       maxlength="10" onkeyup="checkNumeric($(this));" onblur="checkNumeric($(this));
                                                               checkValidationForMobileNumber('registration', 'cp_mobile_number_for_registration');">
                                                <span class="error-message error-message-registration-cp_mobile_number_for_registration"></span>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Contact Person Email Address <span class="color-nic-red">*</span></label>
                                                <input type="text" id="cp_email_for_registration" name="cp_email_for_registration"
                                                       class="form-control" placeholder="Enter Contact Person Email Address !"  maxlength="100"
                                                       onblur="checkValidationForEmail('registration', 'cp_email_for_registration');">
                                                <span class="error-message error-message-registration-cp_email_for_registration"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Username <span class="color-nic-red">*</span></label>
                                                <input type="text" class="form-control" id="username_for_registration" name="username_for_registration"
                                                       placeholder="Enter Username !" onblur="checkUsername($(this));" 
                                                       maxlength="20" style="text-transform: lowercase;">
                                                <span class="error-message error-message-registration-username_for_registration"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Password <span class="color-nic-red">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="password_for_registration" name="password_for_registration" placeholder="Enter Password !"
                                                           onblur="checkPasswordValidation('registration', 'password_for_registration');"
                                                           maxlength="20">
                                                    <div class="input-group-prepend" onclick="hideShowPassword($(this), 'password_for_registration');">
                                                        <span class="input-group-text"><i class="fa fa-eye-slash"></i></span>
                                                    </div>
                                                </div>
                                                <span class="error-message error-message-registration-password_for_registration"></span>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Retype Password <span class="color-nic-red">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="retype_password_for_registration" name="retype_password_for_registration"
                                                           onblur="checkPasswordValidationForRetypePassword('registration', 'retype_password_for_registration', 'password_for_registration');"
                                                           placeholder="Enter Password !" maxlength="20">
                                                    <div class="input-group-prepend" onclick="hideShowPassword($(this), 'retype_password_for_registration');">
                                                        <span class="input-group-text"><i class="fa fa-eye-slash"></i></span>
                                                    </div>
                                                </div>
                                                <span class="error-message error-message-registration-retype_password_for_registration"></span>
                                            </div>
                                        </div>
                                        <hr class="mb-3">
                                        <div class="row">
                                            <input type="hidden" id="captcha_code_for_registration" name="captcha_code_for_registration"/>
                                            <div class="form-group col-sm-6">
                                                <div class="row">
                                                    <div class="col-9 col-sm-8 col-md-9 text-center">
                                                        <span class="btn-block btn-flat captcha-code" id="captcha_container_for_registration"></span>
                                                    </div>
                                                    <div class="col-3 col-sm-4 col-md-3">
                                                        <button type="button" class="btn btn-primary"
                                                                onclick="setCaptchaCode('registration');">
                                                            <i class="fas fa-sync"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <input type="text" id="captcha_code_verification_for_registration" name="captcha_code_verification_for_registration" 
                                                       class="form-control mb-0" placeholder="Enter Answer of Calculation !" onkeypress='checkNumeric($(this));'
                                                       maxlength="3" onblur="checkNumeric($(this));">
                                                <span class="error-message error-message-registration-captcha_code_verification_for_registration"></span>
                                            </div>
                                        </div>
                                        <hr class="mb-3">
                                        <div class="row mt-2 mb-3">
                                            <div class="col-6 col-md-3">
                                                <button type="button" id="submit_btn_for_registration" class="btn btn-nic-blue btn-block" onclick="checkRegistration($(this));">Submit</button>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <button type="button" class="btn btn-nic-blue btn-block" onclick="resetRegistrationForm();">Clear</button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="form-group m-b-0" style="color: red;">
                                        <h5 class="f-w-b m-b-0" style="font-size: 16px;">Username Policy</h5>
                                        <?php echo USERNAME_VALIDATION_MESSAGE; ?>
                                    </div>
                                    <hr>
                                    <div class="form-group m-b-0" style="color: red;">
                                        <h5 class="f-w-b m-b-0" style="font-size: 16px;">Password Policy</h5>
                                        <?php echo PASSWORD_VALIDATION_MESSAGE; ?>
                                    </div>
                                    <hr>
                                    <div class="mt-2">
                                        <a href="<?php echo base_url() ?>login" class="text-center">Already have an account ? Click here to Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('common/footer_text'); ?>
        </div>
    </body>
    <script type="text/javascript">
        var talukaArray = <?php echo json_encode($this->config->item('taluka_array')); ?>;
        var optionTemplate = Handlebars.compile($('#option_template').html());
        var tagSpinnerTemplate = Handlebars.compile($('#tag_spinner_template').html());
        var spinnerTemplate = Handlebars.compile($('#spinner_template').html());
        var iconSpinnerTemplate = spinnerTemplate({'type': 'light', 'extra_class': 'spinner-border-small'});
        var tempDeptData = <?php echo json_encode($department_data); ?>;

        var OTHER_DEPT_DAMAN = <?php echo OTHER_DEPT_DAMAN; ?>;
        var OTHER_DEPT_DIU = <?php echo OTHER_DEPT_DIU; ?>;
        var OTHER_DEPT_DNH = <?php echo OTHER_DEPT_DNH; ?>;

        renderOptionsForTwoDimensionalArray(talukaArray, 'district_for_registration');
        renderOptionsForTwoDimensionalArray([], 'department_id_for_registration');
        showSubContainer();
        generateSelect2WithId('district_for_registration');
        generateSelect2WithId('department_id_for_registration');

        allowOnlyIntegerValue('cp_mobile_number_for_registration');
        allowOnlyUsernamePolicyValue('username_for_registration');
        allowOnlyIntegerValue('captcha_code_verification_for_registration');

        setCaptchaCode('registration');

        $('#department_id_for_registration').change(function () {
            var other = $(this).val();
            $('#other_department_container_for_registration').hide();
            if (other == OTHER_DEPT_DAMAN || other == OTHER_DEPT_DIU || other == OTHER_DEPT_DNH) {
                $('#other_department_container_for_registration').show();
            }
        });

        function resetRegistrationForm() {
            $('#district_for_registration').val('').trigger('change');
            $('#registration_form').trigger("reset");
        }

        function hideShowPassword(obj, id) {
            var InputType = document.getElementById(id);
            if (InputType.type === "password") {
                InputType.type = "text";
                obj.html('<span class="input-group-text"><i class="fa fa-eye-slash"></i></span>');
            } else {
                InputType.type = "password";
                obj.html('<span class="input-group-text"><i class="fa fa-eye"></i></span>');
            }
        }

        $('#registration_form').find('input').keypress(function (e) {
            if (e.which == 13) {
                checkRegistration($('#submit_btn_for_registration'));

            }
        });

        function checkValidationForRegistration(registrationData) {
            if (!registrationData.district_for_registration) {
                return getBasicMessageAndFieldJSONArray('district_for_registration', districtValidationMessage);
            }
            if (!registrationData.department_id_for_registration) {
                return getBasicMessageAndFieldJSONArray('department_id_for_registration', selectDepartmentValidationMessage);
            }
            if (registrationData.department_id_for_registration == OTHER_DEPT_DAMAN ||
                    registrationData.department_id_for_registration == OTHER_DEPT_DIU ||
                    registrationData.department_id_for_registration == OTHER_DEPT_DNH) {
                if (!registrationData.other_department_name_for_registration) {
                    return getBasicMessageAndFieldJSONArray('other_department_name_for_registration', departmentValidationMessage);
                }
            }
            if (!registrationData.cp_name_for_registration) {
                return getBasicMessageAndFieldJSONArray('cp_name_for_registration', nameValidationMessage);
            }
            if (!registrationData.cp_mobile_number_for_registration) {
                return getBasicMessageAndFieldJSONArray('cp_mobile_number_for_registration', mobileValidationMessage);
            }
            var mobileMessage = mobileNumberValidation(registrationData.cp_mobile_number_for_registration);
            if (mobileMessage != '') {
                return getBasicMessageAndFieldJSONArray('cp_mobile_number_for_registration', mobileMessage);
            }
            if (!registrationData.cp_email_for_registration) {
                return getBasicMessageAndFieldJSONArray('cp_email_for_registration', emailValidationMessage);
            }
            var emailMessage = emailIdValidation(registrationData.cp_email_for_registration);
            if (emailMessage != '') {
                return getBasicMessageAndFieldJSONArray('cp_email_for_registration', emailMessage);
            }
            if (!registrationData.username_for_registration) {
                return getBasicMessageAndFieldJSONArray('username_for_registration', usernameValidationMessage);
            }
            var uVMessage = usernameValidation(registrationData.username_for_registration);
            if (uVMessage != '') {
                return getBasicMessageAndFieldJSONArray('username_for_registration', uVMessage);
            }
            if (!registrationData.username_for_registration) {
                return getBasicMessageAndFieldJSONArray('username_for_registration', usernameValidationMessage);
            }
            if (!registrationData.password_for_registration) {
                return getBasicMessageAndFieldJSONArray('password_for_registration', passwordValidationMessage);
            }
            var pMessage = passwordValidation(registrationData.password_for_registration);
            if (pMessage != '') {
                return getBasicMessageAndFieldJSONArray('password_for_registration', pMessage);
            }
            if (!registrationData.retype_password_for_registration) {
                return getBasicMessageAndFieldJSONArray('retype_password_for_registration', retypePasswordValidationMessage);
            }
            if (registrationData.password_for_registration != registrationData.retype_password_for_registration) {
                return getBasicMessageAndFieldJSONArray('retype_password_for_registration', passwordAndRetypePasswordValidationMessage);
            }
            if (!registrationData.captcha_code_verification_for_registration) {
                return getBasicMessageAndFieldJSONArray('captcha_code_verification_for_registration', captchaValidationMessage);
            }
            if ((registrationData.captcha_code_verification_for_registration).trim() != (registrationData.captcha_code_for_registration).trim()) {
                return getBasicMessageAndFieldJSONArray('captcha_code_verification_for_registration', captchaVerificationValidationMessage);
            }
            return '';
        }

        function checkUsername(obj) {
            validationMessageHide();
            var username = obj.val();
            var id = obj.attr('id');
            if (!username) {
                validationMessageShow('registration-' + id, usernameValidationMessage);
                return false;
            }
            var uVMessage = usernameValidation(username);
            if (uVMessage != '') {
                validationMessageShow('registration-' + id, uVMessage);
                return false;
            }
            addTagSpinner(id);
            obj.prop('readonly', true);
            $.ajax({
                type: 'POST',
                url: 'registration/check_username',
                data: {'username_for_verification': username},
                error: function (textStatus, errorThrown) {
                    $('#password_for_registration').val('');
                    $('#retype_password_for_registration').val('');
                    removeTagSpinner();
                    obj.prop('readonly', false);
                    validationMessageShow('registration-' + id, textStatus.statusText);
                },
                success: function (data) {
                    removeTagSpinner();
                    obj.prop('readonly', false);
                    var parseData = JSON.parse(data);
                    if (parseData.success == false) {
                        $('#password_for_registration').val('');
                        $('#retype_password_for_registration').val('');
                        validationMessageShow('registration-' + id, parseData.message);
                        return false;
                    }
                }
            });
        }

        function checkRegistration(btnObj) {
            validationMessageHide();
            var registrationData = $('#registration_form').serializeFormJSON();
            var validationData = checkValidationForRegistration(registrationData);
            if (validationData != '') {
                setCaptchaCode('registration');
                $('#' + validationData.field).focus();
                validationMessageShow('registration-' + validationData.field, validationData.message);
                return false;
            }
            registrationData.password_for_registration = getEncryptedString(registrationData.password_for_registration);
            $('#password_for_registration').val(registrationData.password_for_registration);
            registrationData.retype_password_for_registration = getEncryptedString(registrationData.retype_password_for_registration);
            $('#retype_password_for_registration').val(registrationData.retype_password_for_registration);
            var ogBtnHTML = btnObj.html();
            var ogBtnOnClick = btnObj.attr("onclick");
            btnObj.html(iconSpinnerTemplate);
            btnObj.attr('onclick', '');
            $.ajax({
                type: 'POST',
                url: 'registration/check_registration',
                data: $.extend({}, registrationData, getTokenData()),
                error: function (textStatus, errorThrown) {
                    generateNewCSRFToken();
                    btnObj.html(ogBtnHTML);
                    btnObj.attr('onclick', ogBtnOnClick);
                    setCaptchaCode('registration');
                    validationMessageShow('registration', textStatus.statusText);
                    $('html, body').animate({scrollTop: '0px'}, 0);
                },
                success: function (data) {
                    var parseData = JSON.parse(data);
                    setNewToken(parseData.temp_token);
                    if (parseData.success == false) {
                        btnObj.html(ogBtnHTML);
                        btnObj.attr('onclick', ogBtnOnClick);
                        setCaptchaCode('registration');
                        validationMessageShow('registration', parseData.message);
                        $('html, body').animate({scrollTop: '0px'}, 0);
                        return false;
                    }
                    var template = '<div class="text-center text-success">';
                    template += '<h6 class="h6-new f-w-b" style="line-height: 22px;">' + parseData.message + '</h6><div class="text-center"><a class="btn btn-primary" href="' + baseUrl + 'login">Back to Login</a></div></div>';
                    $('#registration_success_message_container').html(template);
                }
            });
        }
    </script>
</html>
