<div class="row">
    <div class="col-sm-12 text-center">
        <span class="error-message error-message-department f-w-b" style="border-bottom: 2px solid red;"></span>
    </div>
</div>
<form role="form" method="post" name="department_form" id="department_form" autocomplete="off" onsubmit="return false;">
    <div class="row">
        <div class="form-group col-sm-6">
            <input type="hidden" id="department_id_for_department" name="department_id_for_department" value="{{department_id}}">
            <label>District <span class="color-nic-red">*</span></label>
            <select id="district_for_department" name="district_for_department" class="form-control select2"
                    onchange="checkValidation('department', 'district_for_department', districtValidationMessage);"
                    data-placeholder="Select District" style="width: 100%;">
            </select>
            <span class="error-message error-message-department-district_for_department"></span>
        </div>
        <div class="form-group col-sm-6">
            <label>Department Name <span class="color-nic-red">*</span></label>
            <input type="text" id="department_name_for_department" name="department_name_for_department"
                   onblur="checkValidation('department', 'department_name_for_department', departmentValidationMessage);"
                   class="form-control" placeholder="Enter Department Name." value="{{department_name}}" maxlength="100">
            <span class="error-message error-message-department-department_name_for_department"></span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-6">
            <label>Department Address</label>
            <textarea id="department_address_for_department" name="department_address_for_department" class="form-control"
                      placeholder="Enter Department Address !"
                      maxlength="200">{{department_address}}</textarea>
            <span class="error-message error-message-department-department_address_for_department"></span>
        </div>
        <div class="form-group col-sm-6">
            <label>Pincode</label>
            <input type="text" id="pincode_for_department" name="pincode_for_department"
                   class="form-control" placeholder="Enter Pincode !" maxlength="6" onkeyup="checkNumeric($(this));" 
                   onblur="checkNumeric($(this));"
                   value="{{pincode}}">
            <span class="error-message error-message-department-pincode_for_department"></span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-6">
            <label>Department Mobile Number</label>
            <input type="text" id="mobile_number_for_department" name="mobile_number_for_department"
                   class="form-control" placeholder="Enter Department Mobile Number !"
                   maxlength="10" onkeyup="checkNumeric($(this));" onblur="checkNumeric($(this));" value="{{mobile_number}}">
        </div>
        <div class="form-group col-sm-6">
            <label>Department Landline Number</label>
            <input type="text" id="landline_number_for_department" name="landline_number_for_department"
                   class="form-control" placeholder="Enter Department Landline Number !"
                   maxlength="25" value="{{landline_number}}">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-6">
            <label>Email Address</label>
            <input type="text" id="email_for_department" name="email_for_department"
                   class="form-control" placeholder="Enter Email !"  maxlength="100"
                   value="{{email}}">
            <span class="error-message error-message-department-email_for_department"></span>
        </div>
    </div>
    <div class="row">
        <div class=" mt-1 col-12">
            <button type="button" id="submit_btn_for_department" class="btn btn-sm btn-success" onclick="Department.listview.submitDepartment($(this));" style="margin-right: 5px;">Submit</button>
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close" onclick="resetModel();">Close</button>
        </div>
    </div>
</form>