<div class="card-header">
    <h3 class="card-title f-w-b" style="float:none; text-align:center;margin-top:-5px;">
    Ticket Raised Detail 
    </h3>
</div>

<div class="card-body p-b-0px text-left" style="font-size: 13px;">
    <div class="table-responsive">
        <table class="table table-bordered table-padding bg-beige">
            <tr>
                <td class="f-w-b" style="width: 30%;">District</td>
                <td>{{district_text}}</td>
            </tr>
            <tr>
                <td class="f-w-b">UserName</td>
                <td>{{username}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Title</td>
                <td>{{designation}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Mobile Number</td>
                <td>{{mobilenumber}}</td>
            </tr>
            <tr>
                <td class="f-w-b">Support Required</td>
                <td>{{supportrequired}}</td>
            </tr>
        </table>
    </div>
    <br>
    <div class="f-w-b" style="font-weight:bold;margin-bottom:5px;text-align:center;font-size:15px;">
       Applicant Submitted Documents
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead>
                <tr class="bg-light-gray">
                    <th class="text-center" style="width: 30px;">No.</th>
                    <th class="text-center" style="min-width: 165px;">Document Name</th>
                    <th class="text-center" style="min-width: 165px;">Sample Document</th>
                </tr>
            </thead>
            <tbody id="doc_item_container_for_ticketraise_view" class="bg-white"></tbody>
        </table>
    </div>
    <div id="req_doc_container_for_ticketraise_view" class="mt-3" style="display: none;">
        <div id="req_doc_item_container_for_ticketraise_view"></div>
    </div>
 
    <br>
    {{#if hide_assign}}
    <div class="table-responsive">
        <table class="table table-bordered table-padding bg-beige">
            <tr>
                <th style="color: red;font-size:15px;width:100px;text-align:center;">Remark&nbsp;&nbsp; :</th>
                <th>{{remark}}</th>
            </tr>                                    
        </table>
    </div>
    {{/if}}
    
    <?php if (is_admin()) { ?>    
    <form role="form" id="ticketraise_assign_remark_user" name="ticketraise_assign_remark_user" onsubmit="return false;" autocomplete="off">
    <input type="hidden" id="ticketraise_id_for_ticketraise" name="ticketraise_id_for_ticketraise" value="{{ticketraise_id}}">   
    
        {{#if employee_assign}}
        <div style="margin-left:5px;" class="f-w-b" style="margin-left:10px;">
            Assign Task To : <span class="color-nic-red">*</span>
        </div>
        <div style="margin-Top:2px;margin-left:-3px;" class="form-group col-sm-6">        
            <select id="username_for_ticketraise" name="username_for_ticketraise" class="form-control select2"
                    data-placeholder="Select Employee Name"
                    onblur="checkValidation('sa_users', 'username_for_ticketraise', selectEmployeeTypeValidationMessage);"
                    style="width: 100%;">
            </select>
            <span class="error-message error-message-users-username_for_ticketraise"></span> 
               
        </div>
        {{/if}}
        {{#if remark_assign}}
        <div class="row">
            <div class="form-group col-sm-12">
                <label style="margin-top:10px;">Remark To Applicant (If Rejected) <span style="color: red;">*</span></label>
                <textarea id="remark_for_ticketraise" name="remark_for_ticketraise" class="form-control"
                        placeholder="Enter Remark !"
                        maxlength="400"></textarea>
                <span class="error-message error-message-ticketraise-remark_for_ticketraise"></span>
            </div>
        </div><br>
        {{/if}}
        {{#if already_assign}} 
        <br>
        
        <div class="table-responsive">
                <table class="table table-bordered table-padding bg-beige" style="text-align:center;">
                    <thead>
                    <tr>
                        <th style="width:25%;">Sr. No.</th>
                        <th style="width:50%;">Task Assigned Employee Name</th>
                        <th style="width:25%;">Date</th>                      
                        <th style="width:25%;">Action</th>
                      
                    </tr>
                    </thead>
                    
                    <tbody id="assignuser_item_container_for_fr_view">
                        
                    </tbody>
                   
                </table>
        </div>
        
        {{/if}}
        <div class="card-footer pl-2 text-right">
            {{#if employee_assign}}            
            <button type="button" class="btn btn-sm btn-success" onclick="Ticketraise.listview.submitticketRaiseassign($(this));">Forward To Employee</button>
            {{/if}}
            {{#if remark_assign}}
            <button type="button" class="btn btn-sm btn-danger" onclick="Ticketraise.listview.rejectTicketRaiseremark($(this));">Reject</button>
            {{/if}} 
            <button type="button" class="btn btn-sm btn-danger" onclick="resetModel();">Close</button>
        </div>
    </form>
    <?php } ?>
            
    
    <?php if (is_dept_user()) { ?>

    <form role="form" id="ticketraise_assign_remark_user" name="ticketraise_assign_remark_user" onsubmit="return false;" autocomplete="off">
    <input type="hidden" id="ticketraise_id_for_ticketraise" name="ticketraise_id_for_ticketraise" value="{{ticketraise_id}}">
    {{#if completedata_assign}}
    <div class="row">
        <div class="form-group col-sm-12">
            <label>Remark <span style="color: red;">*</span></label>
            <textarea id="remark_for_ticketraise" name="remark_for_ticketraise" class="form-control"
                      placeholder="Enter Remark !"
                      maxlength="400"></textarea>
            <span class="error-message error-message-ticketraise-remark_for_ticketraise"></span>
        </div>
    </div>
    <div class="card-footer pl-2 text-right">
        <button type="button" class="btn btn-sm btn-success" onclick="Ticketraise.listview.submitticketRaiseremark($(this));">Submit</button>
        <button type="button" class="btn btn-sm btn-danger" onclick="Ticketraise.listview.rejectTicketRaiseremark($(this));">Reject</button>         
    {{/if}} 
        <button type="button" class="btn btn-sm btn-danger" onclick="resetModel();">Close</button>
    </div> 
    </form> 
       
    <?php } ?>
    
</div>

