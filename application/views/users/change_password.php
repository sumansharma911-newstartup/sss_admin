<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="nav-icon fa fa-key"></i> Change Password</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="main#dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Change Password</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="float: none; text-align: center;">Change Password Form</h3>
                    </div>
                    <form role="form" id="change_password_form" name="change_password_form" onsubmit="return false;">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Current Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="current_password_for_change_password" name="current_password_for_change_password" placeholder="Enter Current Password !"
                                           onblur="checkValidation('change-password', 'current_password_for_change_password', passwordValidationMessage);"
                                           maxlength="20">
                                    <div class="input-group-prepend eye-class" onclick="Users.listview.hideShowPassword($(this), 'current_password_for_change_password');">
                                        <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                                <span class="error-message error-message-change-password-current_password_for_change_password"></span>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="new_password_for_change_password" name="new_password_for_change_password" placeholder="Enter New Password !"
                                           onblur="checkPasswordValidation('change-password', 'new_password_for_change_password');"
                                           maxlength="20">
                                    <div class="input-group-prepend eye-class" onclick="Users.listview.hideShowPassword($(this), 'new_password_for_change_password');">
                                        <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                                <span class="error-message error-message-change-password-new_password_for_change_password"></span>
                            </div>
                            <div class="form-group">
                                <label>Retype Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="retype_password_for_change_password" name="retype_password_for_change_password" placeholder="Enter Retypes Password !"
                                           onblur="checkPasswordValidationForRetypePassword('change-password', 'retype_password_for_change_password', 'new_password_for_change_password');"
                                           maxlength="20">
                                    <div class="input-group-prepend eye-class" onclick="Users.listview.hideShowPassword($(this), 'retype_password_for_change_password');">
                                        <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                                <span class="error-message error-message-change-password-retype_password_for_change_password"></span>
                            </div>

                            <div class="form-group">
                                <button type="button" id="submit_btn_for_change_password" class="btn btn-sm btn-success" onclick="Users.listview.changePassword($(this));" style="margin-right: 5px;">Submit</button>
                                <button type="button" class="btn btn-sm btn-default" onclick="Users.listview.resetChangePasswordForm();">Clear</button>
                            </div>
                            <div class="form-group m-b-0" style="color: red;">
                                <h5 class="f-w-b m-b-0" style="font-size: 16px;">Password Policy</h5>
                                <?php echo PASSWORD_VALIDATION_MESSAGE; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>