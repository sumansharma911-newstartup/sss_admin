<script type="text/javascript" src="<?php echo base_url() ?>js/project/dashboard.js?<?php echo VERSION; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/project/department.js?<?php echo VERSION; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/project/users.js?<?php echo VERSION; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/project/logs.js?<?php echo VERSION; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/project/service.js?<?php echo VERSION; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/project/ticket_raise.js?<?php echo VERSION; ?>"></script>
<script type="text/javascript" >
    $(function () {
        Dashboard.run();
        Department.run();
        Users.run();
        Logs.run();
        Service.run();
        Ticketraise.run();
        Backbone.history.start();
    });
    var width = parseFloat($(window).width());
    if (width < 1024) {
//        $('body').addClass('sidebar-collapse');

        // Close side bar when Display width is less then 1400.
        $('a.menu-close-click').click(function () {
            if ($('body').hasClass('sidebar-open') || !$('body').hasClass('sidebar-collapse')) {
                $('#sidebar_button').click();
            }
        });
    }
</script>