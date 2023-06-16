<div class="text-center">
    {{#if show_edit_btn}}
    <button type="button" class="btn btn-sm btn-nic-blue" onclick="Service.listview.editOrViewService($(this),'{{service_id}}',{{VALUE_ONE}});"
            style="padding: 2px 7px;">Edit</button>
    {{/if}}
    <button type="button" class="btn btn-sm btn-primary" onclick="Service.listview.editOrViewService($(this),'{{service_id}}',{{VALUE_TWO}});"
            style="padding: 2px 7px;">View</button>
</div>