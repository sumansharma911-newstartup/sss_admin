<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<script type="text/javascript">
    function getTokenData() {
        var tokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var returnData = {};
        returnData['<?php echo $this->security->get_csrf_token_name(); ?>'] = $('#' + tokenName).val();
        return returnData;
    }

    function setNewToken(newToken) {
        var tokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        $('#' + tokenName).val(newToken);
    }
    function generateNewCSRFToken() {
        $.ajax({
            type: 'POST',
            url: 'utility/generate_new_token',
            error: function (textStatus, errorThrown) {
                showError(textStatus.statusText);
            },
            success: function (data) {
                var parseData = JSON.parse(data);
                if (parseData.success == false) {
                    showError(parseData.message);
                    return false;
                }
                setNewToken(parseData.temp_token);
            }
        });
    }

    function handleDataTableError() {
        $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
            generateNewCSRFToken();
            showError(message);
        };
    }
</script>