<?php if (is_admin()) { ?>
<div class="text-center">
    {{#if enable_button}}
    <button type="button" class="btn btn-sm btn-primary" onclick="Ticketraise.listview.ViewTicketraise($(this),'{{ticketraise_id}}');"
            style="padding: 2px 7px;">Action</button>
    {{/if}}
    

    {{#if disable_button}}
    <button type="button" class="btn btn-sm btn-primary" onclick="Ticketraise.listview.ViewTicketraise($(this),'{{ticketraise_id}}');"
            style="padding: 2px 7px;">View</button>
    {{/if}}
</div>
<?php } ?>
<?php if (is_dept_user()) { ?>
<div class="text-center">
    {{#if enable_button}}
    <button type="button" class="btn btn-sm btn-primary" onclick="Ticketraise.listview.ViewTicketraise($(this),'{{ticketraise_id}}');"
            style="padding: 2px 7px;">Action</button>
    {{/if}}
    {{#if disable_button}}
    <button type="button" class="btn btn-sm btn-primary" onclick="Ticketraise.listview.ViewTicketraise($(this),'{{ticketraise_id}}');"
            style="padding: 2px 7px;">View</button>
    {{/if}}
</div>
<?php } ?>