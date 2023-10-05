<?php $base_url = base_url(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Ticket_Raise</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->load->view('common/css_links', array('base_url' => $base_url, 'is_login' => true)); ?>
        <link rel="stylesheet" href="<?php echo $base_url; ?>plugins/datetimepicker/bootstrap-datetimepicker.css">
        <?php
        $this->load->view('common/utility_template');
        $this->load->view('common/js_links', array('base_url' => $base_url, 'is_login' => true));
        ?>
        <script src="<?php echo $base_url; ?>js/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo $base_url; ?>adminLTE/js/demo.js" type="text/javascript"></script>
        <script src="<?php echo $base_url; ?>plugins/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo $base_url; ?>plugins/select2/select2.full.min.js" type="text/javascript"></script>
        <script src="<?php echo $base_url; ?>js/mordanizr.js" type="text/javascript"></script>
        <script src="<?php echo $base_url; ?>js/underscore.js" type="text/javascript"></script>
        <script src="<?php echo $base_url; ?>js/backbone.js" type="text/javascript"></script>
        <script src="<?php echo $base_url; ?>js/handlebars.js" type="text/javascript"></script>
        <?php $this->load->view('common/validation_message'); ?>
        <script type = "text/javascript">
            var tempIdInSession = '<?php echo get_from_session('temp_id_for_sss_admin'); ?>';
            var tempTypeInSession = '<?php echo get_from_session('temp_type_for_sss_admin'); ?>';
            var tempDistrictInSession = '<?php echo get_from_session('temp_district_for_sss_admin'); ?>';
            var tempGPInSession = '<?php echo get_from_session('temp_gp_for_sss_admin'); ?>';
            var tempNameInSession = '<?php echo get_from_session('name'); ?>';
            var optionTemplate = Handlebars.compile($('#option_template').html());
            var tagSpinnerTemplate = Handlebars.compile($('#tag_spinner_template').html());
            var spinnerTemplate = Handlebars.compile($('#spinner_template').html());
            var noRecordFoundTemplate = Handlebars.compile($('#no_record_found_template').html());
            var pageSpinnerTemplate = Handlebars.compile($('#page_spinner_template').html());
            var iconSpinnerTemplate = spinnerTemplate({'type': 'light', 'extra_class': 'spinner-border-small'});
            var IS_DEACTIVE = <?php echo IS_DEACTIVE ?>;
            var defaultPassword = '<?php echo DEFAULT_PASSWORD ?>';
            var TICKETRAISE_DOC_PATH = '<?php echo TICKETRAISE_DOC_PATH; ?>';


            var talukaArray = <?php echo json_encode($this->config->item('taluka_array')); ?>;
            var TEMP_TYPE_A = <?php echo TEMP_TYPE_A; ?>;
            var TEMP_TYPE_DEPT_USER = <?php echo TEMP_TYPE_DEPT_USER; ?>;

            var TALUKA_DAMAN = <?php echo TALUKA_DAMAN; ?>;
            var TALUKA_DIU = <?php echo TALUKA_DIU; ?>;
            var TALUKA_DNH = <?php echo TALUKA_DNH; ?>;

            var VALUE_ZERO = <?php echo VALUE_ZERO; ?>;
            var VALUE_ONE = <?php echo VALUE_ONE; ?>;
            var VALUE_TWO = <?php echo VALUE_TWO; ?>;
            var VALUE_THREE = <?php echo VALUE_THREE; ?>;
            var VALUE_FOUR = <?php echo VALUE_FOUR; ?>;
            var VALUE_FIVE = <?php echo VALUE_FIVE; ?>;
            var VALUE_SIX = <?php echo VALUE_SIX; ?>;
            var VALUE_SEVEN = <?php echo VALUE_SEVEN; ?>;
            var VALUE_EIGHT = <?php echo VALUE_EIGHT; ?>;
            var VALUE_NINE = <?php echo VALUE_NINE; ?>;
            var VALUE_TEN = <?php echo VALUE_TEN; ?>;

            var VIEW_UPLODED_DOCUMENT = '<?php echo VIEW_UPLODED_DOCUMENT; ?>';

            var serStatusArray = <?php echo json_encode($this->config->item('ser_status_array')); ?>;
            var serStatusTextArray = <?php echo json_encode($this->config->item('ser_status_text_array')); ?>;
            var serviceDeclaredArray = <?php echo json_encode($this->config->item('service_declared_array')); ?>;
            var sdTypeArray = <?php echo json_encode($this->config->item('sd_type_array')); ?>;
            var dsCategoryArray = <?php echo json_encode($this->config->item('ds_category_array')); ?>;
            var drTypeArray = <?php echo json_encode($this->config->item('dr_type_array')); ?>;
            var paymentTypeArray = <?php echo json_encode($this->config->item('payment_type_array')); ?>;
            var appNappArray = <?php echo json_encode($this->config->item('app_napp_array')); ?>;
            var appStatusArray = <?php echo json_encode($this->config->item('app_status_array')); ?>;
           // var replyemployeeuserArray = <?php echo json_encode($this->config->item('reply_employee_user_array')); ?>;



//            $(document).ready(function () {
//                getCommonData();
//            });
        </script>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div id="full_page_overlay_div" class="overlay-full-page text-center">
            <div style="margin-top: 20%;">
                <i class="fa fa-spinner fa-5x fa-spin text-white"></i>
            </div>
            <div>
                <h2 class="text-white mt-5">Please Wait . . .</h2>
            </div>
        </div>
        <?php $this->load->view('security'); ?>
        <div class="wrapper">
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" id="sidebar_button" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto" style="padding-right: 10px;">
                    <li class="nav-item dropdown f-w-b color-black">
                        Logged User: <?php echo get_from_session('name'); ?>
                    </li>
                </ul>
            </nav>
            <button type="button" style="display: none;" id="temp_btn"></button>
            <?php $this->load->view('common/sidebar'); ?>
            <div class="modal fade" id="popup_modal" style="padding-right: 0px !important;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="model_title" class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    onclick="resetModel();">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="model_body" class="modal-body">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="popup_modal_full_screen" style="padding-right: 0px !important;">
                <div class="modal-dialog modal-new-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="model_title_full_screen" class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    onclick="resetModel();">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="model_body_full_screen" class="modal-body">
                        </div>
                    </div>
                </div>
            </div>