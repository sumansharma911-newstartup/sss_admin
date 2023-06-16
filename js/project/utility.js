(function ($) {
    $.fn.serializeFormJSON = function () {

        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push($.trim(this.value) || '');
            } else {
                o[this.name] = $.trim(this.value) || '';
            }
        });
        return o;
    };

})(jQuery);

function loginPage() {
    window.location = baseUrl + 'login';
}

function checkValidation(moduleName, fieldName, messageName) {
    var val = $('#' + fieldName).val();
    var newFieldName = moduleName + '-' + fieldName;
    validationMessageHide(newFieldName);
    if (!val || !val.trim()) {
        validationMessageShow(newFieldName, messageName);
    }
}

function validationMessageHide(moduleName) {
    if (typeof moduleName === "undefined") {
        $('.error-message').hide();
        $('.error-message').html('');
    } else {
        $('.error-message-' + moduleName).hide();
        $('.error-message-' + moduleName).html('');
    }
}

function validationMessageShow(moduleName, messageName) {
    $('.error-message-' + moduleName).html(messageName);
    $('.error-message-' + moduleName).show();
}

function getBasicMessageAndFieldJSONArray(field, message) {
    var returnData = {};
    returnData['message'] = message;
    returnData['field'] = field;
    return returnData;
}

function resetForm(formId) {
    validationMessageHide();
    $('#' + formId).trigger("reset");
}

function usernameValidation(username) {
    if ((username.length < 8 || username.length > 20) || !usernameRegex.test(username)) {
        return usernamePolicyValidationMessage;
    }
    return '';
}

function checkPasswordValidation(moduleName, id) {
    validationMessageHide(moduleName + '-' + id);
    var password = $('#' + id).val();
    if (!password) {
        validationMessageShow(moduleName + '-' + id, passwordValidationMessage);
        return;
    }
    var msg = passwordValidation(password);
    if (msg != '') {
        validationMessageShow(moduleName + '-' + id, msg);
        return;
    }
}

function passwordValidation(password) {
    if ((password.length < 8 || password.length > 16) || !passwordRegex.test(password)) {
        return passwordPolicyValidationMessage;
    }
    return '';
}

function checkPasswordValidationForRetypePassword(moduleName, compareId, id) {
    validationMessageHide(moduleName + '-' + compareId);
    var retypePassword = $('#' + compareId).val();
    if (!retypePassword) {
        validationMessageShow(moduleName + '-' + compareId, retypePasswordValidationMessage);
        return;
    }
    var password = $('#' + id).val();
    if (password != retypePassword) {
        validationMessageShow(moduleName + '-' + compareId, passwordAndRetypePasswordValidationMessage);
        return;
    }
}

function generateSelect2() {
    $('.select2').select2({"allowClear": true});
}

function generateSelect2WithId(id) {
    $('#' + id).select2({"allowClear": true});
}

function renderOptionsForTwoDimensionalArray(dataArray, comboId, addBlankOption) {
    if (!dataArray) {
        return false;
    }
    if (typeof addBlankOption === "undefined") {
        addBlankOption = true;
    }
    if (addBlankOption) {
        $('#' + comboId).html('<option value="">&nbsp;</option>');
    }
    var data = {};
    var optionResult = "";
    $.each(dataArray, function (index, dataObject) {
        data = {"value_field": index, 'text_field': dataObject};
        optionResult = optionTemplate(data);
        $("#" + comboId).append(optionResult);
    });
}

function renderOptionsForTwoDimensionalArrayWithKeyValueWithCombination(dataArray, comboId, keyId, valueId, valueId2, addBlankOption) {
    if (!dataArray) {
        return false;
    }
    if (typeof addBlankOption === "undefined") {
        addBlankOption = true;
    }
    if (addBlankOption) {
        $('#' + comboId).html('<option value="">&nbsp;</option>');
    }
    var data = {};
    var optionResult = "";
    var textField = "";
    $.each(dataArray, function (index, dataObject) {
        if (dataObject != undefined && dataObject[keyId] != 0) {
            if (dataObject[valueId2]) {
                textField = dataObject[valueId] + (dataObject[valueId2] != null ? ' (' + dataObject[valueId2] + ')' : '');
            } else {
                textField = dataObject[valueId];
            }
            data = {"value_field": dataObject[keyId], 'text_field': textField};
            optionResult = optionTemplate(data);
            $("#" + comboId).append(optionResult);
        }
    });
}

function renderOptionsForFrtVillages(dataArray, allDataArray, comboId, addBlankOption) {
    if (!dataArray) {
        return false;
    }
    if (typeof addBlankOption === "undefined") {
        addBlankOption = true;
    }
    if (addBlankOption) {
        $('#' + comboId).html('<option value="">&nbsp;</option>');
    }
    var data = {};
    var optionResult = "";
    var textField = "";
    $.each(dataArray, function (index, dataObject) {
        if (dataObject != undefined) {
            textField = allDataArray[dataObject] ? allDataArray[dataObject] : '';
            data = {"value_field": dataObject, 'text_field': textField};
            optionResult = optionTemplate(data);
            $("#" + comboId).append(optionResult);
        }
    });
}

function dateTo_DD_MM_YYYY(date, delimeter) {
    var delim = delimeter ? delimeter : '-';
    var d = new Date(date || Date.now()),
            month = d.getMonth() + 1,
            day = '' + d.getDate(),
            year = d.getFullYear();
    if (month < 10)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [day, month, year].join(delim);
}

function dateTo_DD_MM_YYYY_TIME(date, delimeter) {
    var delim = delimeter ? delimeter : '-';
    var d = new Date(date || Date.now()),
            month = d.getMonth() + 1,
            day = '' + d.getDate(),
            year = d.getFullYear();
    if (month < 10)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    var time = "";
    var h = d.getHours();
    var m = d.getMinutes();
    var s = d.getSeconds();
    if (s <= 9)
        s = "0" + s;
    if (m <= 9)
        m = "0" + m;
    if (h <= 9)
        h = "0" + h;
    time += h + ":" + m + ":" + s;
    return [day, month, year].join(delim) + ' ' + h + ":" + m + ":" + s;
}

function getPerviousDateTo_DD_MM_YYYY(days, date) {
    var d = new Date(date || Date.now());
    d.setDate(d.getDate() - days);
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var year = d.getFullYear();
    if (month < 10)
        month = '0' + month;
    if (day < 10)
        day = '0' + day;
    return [day, month, year].join('-');
}

function getNextDateTo_DD_MM_YYYY(days, date) {
    var ndate = date.split("-").reverse().join("-");
    var d = new Date(ndate || Date.now());
    d.setDate(d.getDate() + days);
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var year = d.getFullYear();
    if (month < 10)
        month = '0' + month;
    if (day < 10)
        day = '0' + day;
    return [day, month, year].join('-');
}

function dateTo_YYYY_MM_DD(date, delimeter) {
    date = new Date(date || Date.now());
    var delim = delimeter ? delimeter : '-';
    var month = date.getMonth() + 1;
    var day = date.getDate();
    return date.getFullYear() + delim + (month < 10 ? '0' : '') + month + delim + (day < 10 ? '0' : '') + day;
}

function getCurrentTime() {
    var date = new Date();
    var hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
    var am_pm = date.getHours() >= 12 ? "PM" : "AM";
    hours = hours < 10 ? "0" + hours : hours;
    var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
    return hours + ":" + minutes + ":" + " " + am_pm;
}

function checkPincode(obj) {
    var pincode = obj.val();
    var pincodeValidationMessage = pincodeValidation(pincode);
    if (pincodeValidationMessage != '') {
        showError(pincodeValidationMessage);
        return false;
    }
}


function pincodeValidation(pincode) {
    if (!pincode) {
        return '';
    }
    var regex = /^[1-9][0-9]{5}$/;
    if (!regex.test(pincode)) {
        return 'Invalid Pincode';
    }
    return '';
}

function checkNumeric(obj) {
    if (!$.isNumeric(obj.val())) {
        obj.val("");
    }
}

function allowOnlyIntegerValue(id) {
    $('#' + id).keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
}

function allowOnlyUsernamePolicyValue(id) {
    $('#' + id).keypress(function (e) {
        if (e.which != 45 && e.which != 46 && (e.which < 97 || e.which > 122) && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
}

function roundOff(obj) {
    var amount = obj.val();
    if ($.isNumeric(amount)) {
        obj.val(parseFloat(Math.abs(amount)).toFixed(2));
    }
}

var serialNumberRenderer = function (data, type, full, meta) {
    return meta.row + meta.settings._iDisplayStart + 1;
};

var districtRenderer = function (data, type, full, meta) {
    return talukaArray[data] ? talukaArray[data] : '';
};

var dateRenderer = function (data, type, full, meta) {
    return dateTo_DD_MM_YYYY(data);
};

function datePicker() {
    $('.date_picker').datetimepicker({
        icons:
                {
                    up: 'fa fa-angle-up',
                    down: 'fa fa-angle-down',
                    next: 'fa fa-angle-right',
                    previous: 'fa fa-angle-left'
                }
    });
    dateChangeEvent();
}

function dateChangeEvent() {
    $('.date_picker').keyup(function (e) {
        e = e || window.event; //for pre-IE9 browsers, where the event isn't passed to the handler function
        if (e.keyCode == '37' || e.which == '37' || e.keyCode == '39' || e.which == '39') {
            var message = ' ' + $('.ui-state-hover').html() + ' ' + $('.ui-datepicker-month').html() + ' ' + $('.ui-datepicker-year').html();
            if ($(this).attr('id') == 'startDate') {
                $(".date_picker").val(message);
            }
        }
    });
}

function checkValidationForMobileNumber(moduleName, id) {
    validationMessageHide(moduleName + '-' + id);
    var mobileNumber = $('#' + id).val();
    if (!mobileNumber) {
        validationMessageShow(moduleName + '-' + id, mobileValidationMessage);
        return;
    }
    var validate = mobileNumberValidation(mobileNumber);
    if (validate != '') {
        validationMessageShow(moduleName + '-' + id, validate);
        return false;
    }
}

function mobileNumberValidation(mobileNumber) {
    var filter = /^[0-9-+]+$/;
    if (mobileNumber.length != 10 || !filter.test(mobileNumber)) {
        return invalidMobileValidationMessage;
    }
    return '';
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 10000
});

function toastFire(type, message) {
    Toast.fire({
        type: type,
        title: '<span style="padding-left: 10px; padding-right: 10px;">' + message + '</span>',
        showCloseButton: true,
    });
}

function showConfirmation(yesEvent, message) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'Are you sure You want to ' + message + ' ?',
        type: 'warning',
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Yes, ' + message + ' it !',
        cancelButtonText: 'No, Cancel !',
    }).then((result) => {
        if (result.value) {
            $('#temp_btn').attr('onclick', yesEvent);
            $('#temp_btn').click();
            $('#temp_btn').attr('onclick', '');
        }
    });
}

function showSuccess(message) {
    toastFire('success', message);
}

function showError(message) {
    toastFire('error', message);
}

function activeLink(id) {
    $('.nav-link').removeClass('active');
    addClass(id, 'active');
}

function addClass(id, className) {
    $('#' + id).addClass(className);
}

function addTagSpinner(id) {
    $('#' + id).parent().find('.error-message').before(tagSpinnerTemplate);
}

function removeTagSpinner() {
    $('#tag_spinner').remove();
}

function resetModel() {
    $('#popup_modal').modal('hide');
    $('#model_title').html('');
    $('#model_body').html('');
}

function activeSelectedBtn(obj) {
    $('.small-btn').removeClass('btn-success');
    $('.small-btn').addClass('btn-primary');
    if (obj) {
        obj.removeClass('btn-primary');
        obj.addClass('btn-success');
    }
}

function getCommonData() {
    $.ajax({
        url: 'utility/get_common_data',
        type: 'post',
        async: false,
        error: function (textStatus, errorThrown) {
            showError(textStatus.statusText);
        },
        success: function (response) {
            var parseData = JSON.parse(response);
            if (parseData.success === false) {
                showError(parseData.message);
                return false;
            }
        }
    });
}

function fileUploadValidation(imageUploadAttrId, size = 1024) {
    var allowedFiles = ['jpg', 'png', 'jpeg', 'pdf'];
    var fileName = $('#' + imageUploadAttrId).val();
    var ext = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();
    if ($.inArray(ext, allowedFiles) == -1) {
        $('#' + imageUploadAttrId).val('');
        $('#' + imageUploadAttrId).focus();
        return 'Please upload File having extensions: <b>' + allowedFiles.join(', ') + '</b> only.';
    }
    if (($('#' + imageUploadAttrId)[0].files[0].size / 1024) > size) {
        return 'Maximum upload size ' + (size / 1024) + ' MB only.';
    }
    return '';
}

var dataTableProcessingAndNoDataMsg = {
    'loadingRecords': '<span class="color-nic-blue"><i class="fas fa-spinner fa-spin fa-2x"></i></span>',
    'processing': '<span class="color-nic-blue"><i class="fas fa-spinner fa-spin fa-3x"></i></span>',
    'emptyTable': 'No Data Available !'
};

var searchableDatatable = function (settings, json) {
    this.api().columns().every(function () {
        var that = this;
        $('input', this.header()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
        $('select', this.header()).on('change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });
}

var fontRenderer = function (data, type, full, meta) {
    return '<span class="table-bold-data">' + data + '</span>';
};

function generateBoxes(type, data, id, moduleName, existingArray, isBr, isDiv = false) {
    $.each(data, function (index, value) {
        var template = (isDiv ? '<div class="col-sm-6">' : '') + '<label class="' + type +
                '-inline form-title f-w-n m-b-0px ' + (isDiv ? '' : 'm-r-10px') + ' cursor-pointer"><input type="' + type + '" class="mb-0" id="' + id +
                '_for_' + moduleName + '_' + index + '" name="' + id + '_for_' + moduleName + '" value="' +
                index + '">&nbsp;&nbsp;' + value + '</label>' + (isDiv ? '</div>' : '');
        if (isBr) {
            template += '<br>';
        }
        $('#' + id + '_container_for_' + moduleName).append(template);
    });
    if (existingArray) {
        if (type == 'checkbox') {
            var existingData = (existingArray).split(',');
            $.each(existingData, function (index, value) {
                $('input[name=' + id + '_for_' + moduleName + '][value="' + value + '"]').click();
            });
        } else {
            $('input[name=' + id + '_for_' + moduleName + '][value="' + existingArray + '"]').click();
        }
    } else {
        $('input[name=' + id + '_for_' + moduleName + '][value="' + existingArray + '"]').click();
}
}

function showSubContainer(id, moduleName, showId, showValue, type, showId2, showValue2, showId3, showValue3) {
    var otherId = '';
    if (type == 'radio') {
        otherId = $('input[name=' + id + '_for_' + moduleName + ']:checked').val();
    }
    if (type == 'checkbox') {
        if ($('input[name=' + id + '_for_' + moduleName + '][value="' + showValue + '"]').is(':checked')) {
            otherId = showValue;
        }
    }
    if (otherId == showValue) {
        $(showId + '_container_for_' + moduleName).show();
    }
    if (type == 'radio') {
        if (typeof showId2 != "undefined" && typeof showValue2 != "undefined") {
            if (otherId == showValue2) {
                $(showId2 + '_container_for_' + moduleName).show();
            }
        }
        if (typeof showId3 != "undefined" && typeof showValue3 != "undefined") {
            if (otherId == showValue3) {
                $(showId3 + '_container_for_' + moduleName).show();
            }
        }
    }
    if (type == 'checkbox') {
        if (typeof showId2 != "undefined" && typeof showValue2 != "undefined") {
            if ($('input[name=' + id + '_for_' + moduleName + '][value="' + showValue2 + '"]').is(':checked')) {
                $(showId2 + '_container_for_' + moduleName).show();
            }
        }
        if (typeof showId3 != "undefined" && typeof showValue3 != "undefined") {
            if ($('input[name=' + id + '_for_' + moduleName + '][value="' + showValue3 + '"]').is(':checked')) {
                $(showId3 + '_container_for_' + moduleName).show();
            }
        }
    }

    $('input[name=' + id + '_for_' + moduleName + ']').change(function () {
        var other = $(this).val();
        $(showId + '_container_for_' + moduleName).hide();
        if (typeof showId2 != "undefined" && typeof showValue2 != "undefined") {
            $(showId2 + '_container_for_' + moduleName).hide();
        }
        if (typeof showId3 != "undefined" && typeof showValue3 != "undefined") {
            $(showId3 + '_container_for_' + moduleName).hide();
        }
        if (type == 'radio') {
            if (other == showValue) {
                $(showId + '_container_for_' + moduleName).show();
                return false;
            }
            if (typeof showId2 != "undefined" && typeof showValue2 != "undefined") {
                if (other == showValue2) {
                    $(showId2 + '_container_for_' + moduleName).show();
                }
            }
            if (typeof showId3 != "undefined" && typeof showValue3 != "undefined") {
                if (other == showValue3) {
                    $(showId3 + '_container_for_' + moduleName).show();
                }
            }
        }
        if (type == 'checkbox') {
            if ($('input[name=' + id + '_for_' + moduleName + '][value="' + showValue + '"]').is(':checked')) {
                $(showId + '_container_for_' + moduleName).show();
            }
            if (typeof showId2 != "undefined" && typeof showValue2 != "undefined") {
                if ($('input[name=' + id + '_for_' + moduleName + '][value="' + showValue2 + '"]').is(':checked')) {
                    $(showId2 + '_container_for_' + moduleName).show();
                    return false;
                }
            }
            if (typeof showId3 != "undefined" && typeof showValue3 != "undefined") {
                if ($('input[name=' + id + '_for_' + moduleName + '][value="' + showValue3 + '"]').is(':checked')) {
                    $(showId3 + '_container_for_' + moduleName).show();
                    return false;
                }
            }
        }
    });
}

function showPopup() {
    const swalWithBootstrapButtons = Swal.mixin({});
    swalWithBootstrapButtons.fire({
        showCancelButton: false,
        showConfirmButton: false,
        html: '<div id="popup_container"></div>',
    });
    $('.swal2-popup').addClass('p-5px');
}

function epochToDateTime(epoch) {
    if (epoch < 10000000000)
        epoch *= 1000; // convert to milliseconds (Epoch is usually expressed in seconds, but Javascript uses Milliseconds)
    var epoch = epoch + (new Date().getTimezoneOffset() * -1); //for timeZone        
    return dateTo_DD_MM_YYYY_TIME(new Date(epoch));
}

function aadharNumberValidation(moduleName, id) {
    validationMessageHide(moduleName + '-' + id);
    var aadharNumber = $('#' + id).val();
    if (!aadharNumber) {
        validationMessageShow(moduleName + '-' + id, aadharNumberValidationMessage);
        return;
    }
    var validate = checkUID(aadharNumber);
    if (validate != '') {
        validationMessageShow(moduleName + '-' + id, validate);
        return false;
    }
}


function checkUID(uid) {
    if (uid.length != 12) {
        return invalidAadharNumberValidationMessage;
    }
    var Verhoeff = {
        "d": [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
            [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
            [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
            [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
            [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
            [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
            [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
            [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
            [9, 8, 7, 6, 5, 4, 3, 2, 1, 0]],
        "p": [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
            [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
            [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
            [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
            [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
            [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
            [7, 0, 4, 6, 9, 1, 3, 2, 5, 8]],
        "j": [0, 4, 3, 2, 1, 5, 6, 7, 8, 9],
        "check": function (str) {
            var c = 0;
            str.replace(/\D+/g, "").split("").reverse().join("").replace(/[\d]/g, function (u, i) {
                c = Verhoeff.d[c][Verhoeff.p[i % 8][parseInt(u, 10)]];
            });
            return c;

        },
        "get": function (str) {

            var c = 0;
            str.replace(/\D+/g, "").split("").reverse().join("").replace(/[\d]/g, function (u, i) {
                c = Verhoeff.d[c][Verhoeff.p[(i + 1) % 8][parseInt(u, 10)]];
            });
            return Verhoeff.j[c];
        }
    };

    String.prototype.verhoeffCheck = (function () {
        var d = [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
            [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
            [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
            [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
            [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
            [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
            [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
            [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
            [9, 8, 7, 6, 5, 4, 3, 2, 1, 0]];
        var p = [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
            [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
            [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
            [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
            [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
            [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
            [7, 0, 4, 6, 9, 1, 3, 2, 5, 8]];

        return function () {
            var c = 0;
            this.replace(/\D+/g, "").split("").reverse().join("").replace(/[\d]/g, function (u, i) {
                c = d[c][p[i % 8][parseInt(u, 10)]];
            });
            return (c === 0);
        };
    })();

    if (Verhoeff['check'](uid) === 0) {
        return '';
    } else {
        return invalidAadharNumberValidationMessage;
    }
}

function removeDocument(id, moduleName) {
    $('#' + id + '_name_container_for_' + moduleName).hide();
    $('#' + id + '_container_for_' + moduleName).show();
    $('#' + id + '_name_href_for_' + moduleName).attr('href', '');
    $('#' + id + '_name_for_' + moduleName).html('');
    $('#' + id + '_remove_btn_for_' + moduleName).attr('onclick', '');
}

function openFullPageOverlay() {
    document.getElementById("full_page_overlay_div").style.width = "100%";
}

function closeFullPageOverlay() {
    document.getElementById("full_page_overlay_div").style.width = "0%";
}

function resetCounter(className) {
    var cnt = 1;
    $('.' + className).each(function () {
        $(this).html(cnt);
        cnt++;
    });
}

function checkValidationForPincode(moduleName, id) {
    var val = $('#' + id).val();
    validationMessageHide(moduleName + '-' + id);
    if (!val || !val.trim()) {
        validationMessageShow(moduleName + '-' + id, pincodeValidationMessage);
        return false;
    }
    if (val.length != 6) {
        validationMessageShow(moduleName + '-' + id, validPincodeValidationMessage);
        return false;
    }
}

function pincodeValidation(pincode) {
    if (pincode.length != 6) {
        return validPincodeValidationMessage;
    }
    return '';
}

function checkValidationForEmail(moduleName, id, isBasicValidate) {
    if (typeof isBasicValidate === "undefined") {
        isBasicValidate = true;
    }
    validationMessageHide(moduleName + '-' + id);
    var emailId = $('#' + id).val();
    if (!emailId) {
        if (isBasicValidate) {
            validationMessageShow(moduleName + '-' + id, emailValidationMessage);
        }
        return false;
    }
    var validate = emailIdValidation(emailId);
    if (validate != '') {
        validationMessageShow(moduleName + '-' + id, validate);
        return false;
    }
}

function emailIdValidation(emailId) {
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(emailId)) {
        return invalidEmailValidationMessage;
    }
    return '';
}

function districtChangeEvent(obj, moduleName) {
    var district = obj.val();
    var deptData = tempDeptData[district] ? tempDeptData[district] : [];
    renderOptionsForTwoDimensionalArrayWithKeyValueWithCombination(deptData, 'department_id_for_' + moduleName, 'department_id', 'department_name');
    $('#department_id_for_' + moduleName).val('');
}

function getCommaStringToValue(columValue, arrayValue) {
    var tempString = '';
    var str = columValue;
    if (columValue) {
        var splitComma = str.split(',');
        $.each(splitComma, function (index, value) {
            if (index != VALUE_ZERO) {
                tempString += ', ';
            }
            tempString += arrayValue[value] ? arrayValue[value] : '';
        });
    }
    return tempString;
}

function setCaptchaCode(moduleName) {
    var randomNum1 = getRandom(),
            randomNum2 = getRandom();
    var total = randomNum1 + randomNum2;
    $("#captcha_container_for_" + moduleName).html(randomNum1 + " + " + randomNum2 + " = ?");
    $('#captcha_code_for_' + moduleName).val(total);
    $('#captcha_code_verification_for_' + moduleName).val('');
}

function getRandom() {
    return Math.ceil(Math.random() * 10);
}

function getEncryptedString(tempString) {
    return window.btoa(window.btoa(window.btoa(window.btoa(tempString))));
}