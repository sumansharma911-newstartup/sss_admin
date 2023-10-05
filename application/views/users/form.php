<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="float: none; text-align: center;">Add User Form</h3>
            </div>
            <form role="form" id="users_form" name="users_form" onsubmit="return false;">
                <input type="hidden" id="sa_user_id_for_users" name="sa_user_id_for_users" value="{{sa_user_id}}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <span class="error-message error-message-users f-w-b" style="border-bottom: 2px solid red;"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Name <span class="color-nic-red">*</span></label>
                            <input type="text" class="form-control" id="name_for_users" name="name_for_users"
                                   onblur="checkValidation('users', 'name_for_users', nameValidationMessage);"
                                   placeholder="Enter Name !" maxlength="100" value="{{name}}">
                            <span class="error-message error-message-users-name_for_users"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Mobile Number</label>
                            <input type="text" id="mobile_number_for_users" name="mobile_number_for_users"
                                   class="form-control" placeholder="Enter Mobile Number !"
                                   maxlength="10" onkeyup="checkNumeric($(this));" onblur="checkNumeric($(this));" value="{{mobile_number}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Email Address</label>
                            <input type="text" id="email_for_users" name="email_for_users"
                                   class="form-control" placeholder="Enter Email !"  maxlength="100"
                                   onblur="checkValidationForEmail('users', 'email_for_users', false);" value="{{email}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Username <span class="color-nic-red">*</span></label>
                            <input type="text" class="form-control" id="username_for_users" name="username_for_users" placeholder="Enter Username !"
                                   onblur="checkValidation('users', 'username_for_users', usernameValidationMessage);"
                                   maxlength="50" value="{{username}}" style="text-transform: lowercase;">
                            <span class="error-message error-message-users-username_for_users"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Password <span class="color-nic-red">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="password_for_users" name="password_for_users" placeholder="Enter Password !"
                                       onblur="checkPasswordValidation('users', 'password_for_users');"
                                       maxlength="20" value="{{password}}">
                                <div class="input-group-prepend" onclick="Users.listview.hideShowPassword($(this), 'password_for_users');">
                                    <span class="input-group-text"><i class="fa fa-eye-slash"></i></span>
                                </div>
                            </div>
                            <span class="error-message error-message-users-password_for_users"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>User Type <span class="color-nic-red">*</span></label>
                            <select id="user_type_for_users" name="user_type_for_users" class="form-control select2"
                                    data-placeholder="Select User Type"
                                    onchange="checkValidation('users', 'user_type_for_users', selectUserTypeValidationMessage);"
                                    style="width: 100%;">
                            </select>
                            <span class="error-message error-message-users-user_type_for_users"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Status <span class="color-nic-red">*</span></label>
                            <select id="status_type_for_users" name="status_type_for_users" class="form-control select2"
                                    data-placeholder="Select Status" style="width: 100%;">
                                <option value="0" selected>Active</option>
                                <option value="1">Deactive</option>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="form-group col-sm-6">
                            <label>District</label>
                            <select id="district_for_users" name="district_for_users" class="form-control select2"
                                    onchange="districtChangeEvent($(this), 'users');"
                                    data-placeholder="Select District" style="width: 100%;">
                            </select>
                            <span class="error-message error-message-users-district_for_users"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Department Name</label>
                            <select id="department_id_for_users" name="department_id_for_users" class="form-control select2"
                                    data-placeholder="Select Department" style="width: 100%;">
                            </select>
                            <span class="error-message error-message-users-department_id_for_users"></span>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <button type="button" id="submit_btn_for_users" class="btn btn-sm btn-success" onclick="Users.listview.submitUsers($(this));" style="margin-right: 5px;">Submit</button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="Users.listview.loadUsersData();">Close</button>
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