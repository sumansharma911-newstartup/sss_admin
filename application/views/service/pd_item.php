<tr id="pd_row_{{pd_cnt}}" class="pd_row">
    <td style="width: 30px;" class="text-center pd-cnt v-a-m f-w-b"></td>
    <td style="vertical-align: top !important;">
        <input type="hidden" class="og_pd_cnt" value="{{pd_cnt}}" />
        <input type="text" class="form-control" id="desc_for_pd_{{pd_cnt}}"
               onblur="checkValidation('pd','desc_for_pd_{{pd_cnt}}', descriptionValidationMessage)"
               placeholder="Description !" maxlength="50" value="{{payment_description}}">
        <span class="error-message error-message-pd-desc_for_pd_{{pd_cnt}}"></span>
    </td>
    <td style="vertical-align: top !important;">
        <input type="text" class="form-control text-right payment_for_pd" id="payment_for_pd_{{pd_cnt}}"
               onblur="checkValidation('pd','payment_for_pd_{{pd_cnt}}', paymentValidationMessage);"
               onkeyup="Service.listview.pdPaymentCalculation();" placeholder="Payment !" maxlength="6" value="{{payment}}">
        <span class="error-message error-message-pd-payment_for_pd_{{pd_cnt}}"></span>
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-sm btn-danger"
                onclick="Service.listview.askForRemovePDRow({{pd_cnt}})" style="cursor: pointer;">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>