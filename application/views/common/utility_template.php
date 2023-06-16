<!--------------------------- Template definitions start ------------------------------------------------>
<script id="option_template" type="text/x-handlebars-template">
    <option value="{{value_field}}">{{text_field}}</option>
</script>
<script id="tag_spinner_template" type="text/x-handlebars-template">
    <div id="tag_spinner" class="overlay dark" style="margin-top: -38px;height: 38px;">
    <div class="spinner-border text-primary" role="status">
    <span class="sr-only">Loading...</span>
    </div>
    </div>
</script>
<script id="no_record_found_template" type="text/x-handlebars-template">
    <tr style="background-color: #{{back-color}};">
    <td class='text-center' colspan='{{colspan}}'>{{{message}}}</td>
    </tr>
</script>
<script id="spinner_template" type="text/x-handlebars-template">
    <div class="spinner-border text-{{type}} {{extra_class}}" role="status">
    <span class="sr-only">Loading...</span>
    </div>
</script>
<script id="page_spinner_template" type="text/x-handlebars-template">
    <div class="card">
    <div class="card-header p-b-0px">
    <div class="row">
    <div class="form-group col-sm-12 text-center">
    <span class="color-nic-blue"><i class="fas fa-spinner fa-spin fa-4x"></i></span>
    </div>
    </div>
    </div>
    </div>
</script>
<!--------------------------------  Template definitions end -------------------------------------------->