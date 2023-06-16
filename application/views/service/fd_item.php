<tr id="fd_row_{{fd_cnt}}" class="fd_row">
    <td style="width: 30px;" class="text-center fd-cnt v-a-m f-w-b"></td>
    <td style="vertical-align: top !important;">
        <input type="hidden" class="og_fd_cnt" value="{{fd_cnt}}" />
        <input type="text" class="form-control" id="desc_for_fd_{{fd_cnt}}"
               onblur="checkValidation('fd','desc_for_fd_{{fd_cnt}}', descriptionValidationMessage)"
               placeholder="Description !" maxlength="50" value="{{fee_description}}">
        <span class="error-message error-message-fd-desc_for_fd_{{fd_cnt}}"></span>
    </td>
    <td style="vertical-align: top !important;">
        <input type="text" class="form-control text-right fee_for_fd" id="fee_for_fd_{{fd_cnt}}"
               onblur="checkValidation('fd','fee_for_fd_{{fd_cnt}}', feesValidationMessage);"
               onkeyup="Service.listview.fdFeeCalculation();" placeholder="Fee !" maxlength="6" value="{{fee}}">
        <span class="error-message error-message-fd-fee_for_fd_{{fd_cnt}}"></span>
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-sm btn-danger"
                onclick="Service.listview.askForRemoveFDRow({{fd_cnt}})" style="cursor: pointer;">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>