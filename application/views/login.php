<?php $base_url = base_url(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Ticket Raised System - DNHDD | Log in</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->load->view('common/css_links', array('base_url' => $base_url)); ?>
        <?php $this->load->view('common/js_links', array('base_url' => $base_url)); ?>
        <?php $this->load->view('common/validation_message'); ?>
    </head>
    <body class="hold-transition layout-top-nav">
        <?php $this->load->view('security'); ?>
        <div class="wrapper">
            <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
                <div class="container text-center" style="display: inline;">
                    <span class="brand-text font-weight-light fs-login-title" style="font-weight: bold !important;">
                    Ticket Raised System Admin - DNHDD
                    </span>
                </div>
            </nav>
            <div class="content-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3 col-lg-4"></div>
                        <div class="col-sm-6 col-lg-4" style="margin-top: 12%;">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title f-w-b" style="float: none; text-align: center;">
                                        Login
                                    </h3>
                                </div>
                                <div class="card-body login-card-body">
                                    <div class="text-center mb-2">
                                        <span class="error-message error-message-login f-w-b" style="border-bottom: 2px solid red;"></span>
                                    </div>
                                    <form id="login_form" method="post" onsubmit="return false;">
                                        <div class="form-group mb-3">
                                            <input type="text" id="temp_name" name="temp_name" class="form-control" placeholder="Username" maxlength="50" onblur="checkValidation('login', 'temp_name', usernameValidationMessage);">
                                            <span class="error-message error-message-login-temp_name"></span>
                                        </div>
                                        <div class="iform-group mb-3">
                                            <input type="password" id="temp_password" name="temp_password" class="form-control" placeholder="Password" onblur="checkValidation('login', 'temp_password', passwordValidationMessage);">
                                            <span class="error-message error-message-login-temp_password"></span>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <button type="button" id="submit_btn_for_login" class="btn btn-nic-blue btn-block" onclick="checkLogin($(this));">Login</button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="btn btn-nic-blue btn-block" onclick="resetForm('login_form');">Clear</button>
                                            </div>
                                        </div>
                                        <!--                                        <div class="row" style="margin-top: 10px;">
                                                                                    <div class="col-12">
                                                                                        <a href="tel:09824567222"><img src="images/TECHNICAL-SUPPORT-AND-FEEDBACK.png" class="img-responsive" style="width: 100%;"></a>
                                                                                    </div>
                                                                                </div>-->
                                    </form>
                                    <!-- <div class="mt-2">
                                        <a href="<?php echo base_url() ?>registration" class="text-center">Not Registered ? Click here to Register</a>
                                    </div> -->
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
        $('#login_form').find('input').keypress(function (e) {
            if (e.which == 13) {
                checkLogin($('#submit_btn_for_login'));

            }
        });
        function checkValidationForLogin(loginFormData) {
            if (!loginFormData.temp_name) {
                return getBasicMessageAndFieldJSONArray('temp_name', usernameValidationMessage);
            }
            if (!loginFormData.temp_password) {
                return getBasicMessageAndFieldJSONArray('temp_password', passwordValidationMessage);
            }
            return '';
        }

        function checkLogin(btnObj) {
            validationMessageHide();
            var loginFormData = $('#login_form').serializeFormJSON();
            var validationData = checkValidationForLogin(loginFormData);
            if (validationData != '') {
                $('#' + validationData.field).focus();
                validationMessageShow('login-' + validationData.field, validationData.message);
                return false;
            }
            btnObj.html('Processing..');
            btnObj.attr('onclick', '');
            $.ajax({
                type: 'POST',
                url: 'login/check_login',
                data: $.extend({}, loginFormData, getTokenData()),
                error: function (textStatus, errorThrown) {
                    generateNewCSRFToken();
                    btnObj.html('Login');
                    btnObj.attr('onclick', 'checkLogin($(this))');
                    validationMessageShow('login', textStatus.statusText);
                },
                success: function (data) {
                    var parseData = JSON.parse(data);
                    setNewToken(parseData.temp_token);
                    if (parseData.success == false) {
                        btnObj.html('Login');
                        btnObj.attr('onclick', 'checkLogin($(this))');
                        validationMessageShow('login', parseData.message);
                        return false;
                    }
                    window.location = baseUrl + 'main#ticket_raise';
                }
            });
        }
    </script>
</html>
