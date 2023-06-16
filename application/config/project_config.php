<?php

define('IS_CHECKED_NO', 0);
define('IS_CHECKED_YES', 1);
define('IS_DELETE', 1);
define('IS_ACTIVE', 0);
define('IS_DEACTIVE', 1);
define('IS_VERIFY', 1);

define('LOGIN', 1);
define('LOGOUT', 2);

define('OTHER_DEPT_DAMAN', 45);
define('OTHER_DEPT_DIU', 46);
define('OTHER_DEPT_DNH', 47);

define('FROM_NAME', 'S.S.S.(Samaya Sudhini Seva)');
define('FROM_EMAIL', 'noreply@nicdemo.in');

$config['log_type'] = array(
    LOGIN => 'Login',
    LOGOUT => 'Logout'
);

define("ENCRYPTION_KEY", "!@#$%^&*");

define('USERNAME_REGEX', '/^[a-z0-9-.]+$/');
define('PASSWORD_REGEX', '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!#$@%_+\-=<>]).{8,16}$/');


define('API_ENCRYPTION_KEY', 'sgAD#@$@^^&fAB%^*(*&&^%$');
define('API_ACCESS_KEY', '%#d@AE$#Idgqw$$^jhhh');


// Logs Table
define('TBL_LOGS_LOGIN_LOGOUT', 'sa_logs_login_details');
define('TBL_LOGS_LOGIN_LOGOUT_PRIMARY_KEY', 'sa_logs_login_details_id');
define('TBL_LOGS_CHANGE_PASSWORD', 'sa_logs_change_password');

define('DEFAULT_PASSWORD', 'Admin@1819');

define('TALUKA_DAMAN', 1);
define('TALUKA_DIU', 2);
define('TALUKA_DNH', 3);
$config['taluka_array'] = array(
    TALUKA_DAMAN => 'Daman',
    TALUKA_DIU => 'Diu',
    TALUKA_DNH => 'DNH'
);

define('TEMP_TYPE_A', 1);
define('TEMP_TYPE_DEPT_USER', 2);

define('VERSION', 'v=1.1.2');

define('VALUE_ZERO', 0);
define('VALUE_ONE', 1);
define('VALUE_TWO', 2);
define('VALUE_THREE', 3);
define('VALUE_FOUR', 4);
define('VALUE_FIVE', 5);
define('VALUE_SIX', 6);
define('VALUE_SEVEN', 7);
define('VALUE_EIGHT', 8);
define('VALUE_NINE', 9);
define('VALUE_TEN', 10);

define('VIEW_UPLODED_DOCUMENT', 'View Uploaded Document');

$config['ser_status_array'] = array(
    VALUE_ZERO => '<span class="badge bg-nic-blue app-status">Draft</span>',
    VALUE_ONE => '<span class="badge bg-warning app-status">Submitted</span>',
);

$config['ser_status_text_array'] = array(
    VALUE_ZERO => 'Draft',
    VALUE_ONE => 'Submitted',
);

$config['service_declared_array'] = array(
    VALUE_ONE => 'S.S.S.',
    VALUE_TWO => 'Citizen Charter',
    VALUE_THREE => 'SSDG(eDistrict)',
    VALUE_FOUR => 'New Service',
    VALUE_FIVE => 'Other'
);

$config['sd_type_array'] = array(
    VALUE_ONE => 'Offline',
    VALUE_TWO => 'Partial Online',
    VALUE_THREE => 'Online',
    VALUE_FOUR => 'Both(Online & Offline)'
);

$config['ds_category_array'] = array(
    VALUE_ONE => 'Dcoument',
    VALUE_TWO => 'Monetary',
    VALUE_THREE => 'Other'
);

$config['payment_type_array'] = array(
    VALUE_ONE => 'Offline',
    VALUE_TWO => 'Online'
);

$config['dr_type_array'] = array(
    VALUE_ONE => 'Optional',
    VALUE_TWO => 'Compulsory'
);

$config['app_napp_array'] = array(
    VALUE_ONE => 'Applicable',
    VALUE_TWO => 'Not Applicable'
);
