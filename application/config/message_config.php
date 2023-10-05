<?php

define('INVALID_ACCESS', 1);
define('INVALID_ACCESS_MESSAGE', 'Invalid Access !');

$config['invalid_access_array'] = array(
    INVALID_ACCESS => INVALID_ACCESS_MESSAGE
);

define('USERNAME_VALIDATION_MESSAGE', '1. Username must be between 8 to 20 characters long.<br>'
        . '2. Allow alphabet + numbers + ( . ) dot and ( - ) dash');
define('PASSWORD_VALIDATION_MESSAGE', '1. Password must be between 8 to 16 characters long.<br>'
        . '2. Contain at least one digit and two alphabetic character.<br>'
        . '3. At least one upper case and one lower case character.<br>'
        . '4. Contain at least one special character of (!#$@%-_+<>=).');

define('DATABASE_ERROR_MESSAGE', 'Some unexpected database error encountered due to which your transaction could not be complete');
define('INVALID_USER_MESSAGE', 'Invalid User !');
define('INVALID_PASSWORD_MESSAGE', 'Invalid Password !');
define('RETYPE_PASSWORD_MESSAGE', 'Retype your Password !');
define('NEW_PASSWORD_MESSAGE', 'Enter New Password !');
define('PASSWORD_AND_RETYPE_PASSWORD_NOT_MATCH_MESSAGE', 'Password and Retype password do not match !');
define('USERNAME_MESSAGE', 'Enter Username !');
define('PASSWORD_MESSAGE', 'Enter Password !');
define('USER_EXISTS_MESSAGE', 'Username Already Exists !');
define('USERNAME_POLICY_MESSAGE', 'Username is not as per username policy !');
define('PASSWORD_POLICY_MESSAGE', 'Password is not as per password policy !');
define('NO_RECORD_FOUND_MESSAGE', 'No Record Found..!');
define('CAPTCHA_VALIDATION_MESSAGE', 'Enter Answer of Above Calculation !');
define('CAPTCHA_VERIFICATION_VALIDATION_MESSAGE', 'Enter Correct Calculation !');
define('SELECT_Employee_TYPE_MESSAGE', 'Select Employee Name !');
define('ASSIGNEDUSER_SUBMITTED_MESSAGE', 'Task Assign Successfully !');
define('REMARK_SUBMITTED_MESSAGE', 'Enter Remark !');
define('QUERYDONE_SUBMITTED_MESSAGE', 'Employee Query Solve !');
define('QUERYREJECT_SUBMITTED_MESSAGE', 'Query Rejected !');
define('EMPLOYEE_REMOVE', 'Employee Remove successfully !');



//Login
define('INVALID_USERNAME_OR_PASSWORD_MESSAGE', 'Username or Password is Invalid !');
define('EMAIL_NOT_VERIFY_MESSAGE', 'Your email is not verified. Please verify your email !');
define('MOBILE_NUMBER_NOT_VERIFY_MESSAGE', 'Your mobile number is not verified. Please verify your mobile number !');
define('ACCOUNT_NOT_ACTIVE_MESSAGE', 'Permission Denied !');
define('ACCOUNT_DELETE_MESSAGE', 'Your Account is Disabled. Please contect to System Administration !');
define('MOBILE_NUMBER_MESSAGE', 'Enter Mobile Number !');
define('INVALID_MOBILE_NUMBER_MESSAGE', 'Invalid Mobile Number !');

//User Type
define('INVALID_USER_TYPE_MESSAGE', 'Invalid User Type !');
define('USER_TYPE_MESSAGE', 'Enter User Type !');
define('USER_TYPE_EXISTS_MESSAGE', 'User Type Already Exists !');
define('USER_TYPE_SAVED_MESSAGE', 'User Type Saved Successfully !');
define('USER_TYPE_UPDATED_MESSAGE', 'User Type Updated Successfully !');

//User Module
define('NAME_MESSAGE', 'Enter Name !');
define('SELECT_USER_TYPE_MESSAGE', 'Select User Type !');
define('SELECT_USER_MESSAGE', 'Select User !');
define('USER_SAVED_MESSSAGE', 'User Saved Successfully !');
define('USER_UPDATED_MESSSAGE', 'User Updated Successfully !');

//Change Password Module
define('PASSWORD_CHANGED_MESSAGE', 'Password Changed Successfully !');
define('CURRENT_NEW_PASSWORD_SAME_MESSAGE', 'Your Current Password and New Password are Same. Please Enter Another Password !');
define('INCORRECT_CURRENT_PASSWORD', 'Incorrect Current Password !');

define('DATE_MESSAGE', 'Select Date !');
define('ONE_OPTION_MESSAGE', 'Select One Option !');
define('AADHAR_MESSAGE', 'Enter Aadhar Number !');
define('DOCUMENT_NAME_MESSAGE', 'Enter Document Name !');
define('INVALID_AADHAR_MESSAGE', 'Invalid Aadhar Number !');
define('UPLOAD_DOC_MESSAGE', 'Upload any Document !');
define('DOC_INVALID_SIZE_MESSAGE', 'Upload at least 1kb Size Document !');
define('UPLOAD_MAX_TEN_MB_MESSAGE', 'Upload Max 10MB of Document !');
define('DOCUMENT_NOT_UPLOAD_MESSAGE', 'Document Not Uploaded !');
define('DOCUMENT_REMOVED_MESSAGE', 'Document Removed Successfully !');
define('DOCUMENT_ITEM_REMOVED_MESSAGE', 'Document Item Removed Successfully !');
define('ADDRESS_MESSAGE', 'Enter Address !');
define('REMARKS_MESSAGE', 'Enter Remarks !');

//Department Messages
define('DEPARTMENT_MESSAGE', 'Enter Department Name !');
define('SELECT_DEPARTMENT_MESSAGE', 'Select Department !');
define('INVALID_DEPARTMENT_MESSAGE', 'Invalid Department !');
define('DEPARTMENT_EXISTS_MESSAGE', 'Department Name Already Exists !');
define('DEPARTMENT_SAVED_MESSAGE', 'Department Saved Successfully !');
define('DEPARTMENT_UPDATED_MESSAGE', 'Department Updated Successfully !');
define('DISTRICT_MESSAGE', 'Select District !');
define('PINCODE_MESSAGE', 'Enter Pincode !');
define('VALID_PINCODE_MESSAGE', 'Enter Valid Pincode !');
define('EMAIL_MESSAGE', 'Enter Email Address !');
define('INVALID_EMAIL_MESSAGE', 'Invalid Email Address !');

//Services Message
define('SERVICE_NAME_MESSAGE', 'Enter Service Name !');
define('DESIGNATION_MESSAGE', 'Enter Designation !');
define('SERVICE_DELIVERY_URL_MESSAGE', 'Enter Service Delivery URL !');
define('OTHER_DS_CATEGORY_MESSAGE', 'Enter Other Category of Delivered Service !');
define('DESCRIPTION_MESSAGE', 'Enter Description !');
define('FEES_MESSAGE', 'Enter Fees !');
define('ONE_FEES_MESSAGE', 'Enter Atleast One Fees Details !');
define('PAYMENT_MESSAGE', 'Enter Payment !');
define('ONE_PAYMENT_MESSAGE', 'Enter Atleast One Payment Details !');
define('NO_DAYS_MESSAGE', 'Enter No. of Days !');
define('ONE_DOC_REQ_MESSAGE', 'Upload Atleast One Document Required for Service !');
define('SERVICE_DRAFT_MESSAGE', 'Service Details Draft Successfully !');
define('SERVICE_SUBMITTED_MESSAGE', 'Service Details Submitted Successfully !');
