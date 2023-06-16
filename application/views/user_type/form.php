<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12 text-center">
                <span class="error-message error-message-user-type f-w-b" style="border-bottom: 2px solid red;"></span>
            </div>
        </div>
        <form role="form" method="post" name="user_type_form" id="user_type_form" autocomplete="off" onsubmit="return false;">
            <div class="row">
                <div class="form-group col-sm-3"></div>
                <div class="form-group col-sm-6">
                    <input type="hidden" id="user_type_id_for_user_type" name="user_type_id_for_user_type" value="{{sa_user_type_id}}">
                    <label>User Type</label>
                    <input type="text" id="type_for_user_type" name="type_for_user_type"
                           onblur="checkValidation('user-type', 'type_for_user_type', userTypeValidationMessage);"
                           class="form-control" placeholder="Enter User Type." value="{{type}}" maxlength="50">
                    <span class="error-message error-message-user-type-type_for_user_type"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <button type="button" id="submit_btn_for_user_type" class="btn btn-sm btn-success" onclick="Users.listview.submitUserType($(this));" style="margin-right: 5px;">Submit</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close" onclick="resetModel();">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>