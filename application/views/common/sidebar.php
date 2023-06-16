<aside class="main-sidebar sidebar-dark-primary">
    <?php $this->load->view('common/logo'); ?>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
<!--                <li class="nav-item">
                    <a id="menu_dashboard" href="Javascript:void(0);" class="nav-link menu-close-click"
                       onclick="Dashboard.listview.listPage();">
                        <i class="nav-icon fa fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>-->
                <li class="nav-item">
                    <a id="menu_service" href="Javascript:void(0);" class="nav-link menu-close-click"
                       onclick="Service.listview.listPage();">
                        <i class="nav-icon fa fa-cogs"></i>
                        <p>Services Details</p>
                    </a>
                </li>
                <?php if (is_admin()) { ?>
                    <li class="nav-item has-treeview">
                        <a id="menu_users" href="Javascript:void(0)" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Master Management <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a id="menu_users_department" href="Javascript:void(0);"
                                   onclick="Department.listview.listPage();" class="nav-link menu-close-click">
                                    <i class="fas fa-building nav-icon"></i>
                                    <p>Department(s)</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="menu_users_user" href="Javascript:void(0);"
                                   onclick="Users.listview.listPage();" class="nav-link menu-close-click">
                                    <i class="fas fa-users nav-icon"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="menu_users_user_type" href="Javascript:void(0);"
                                   onclick="Users.listview.listPageForUserType();" class="nav-link menu-close-click">
                                    <i class="fas fa-list-alt nav-icon"></i>
                                    <p>User Type</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a id="menu_logs" href="Javascript:void(0)" class="nav-link">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Logs <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a id="menu_logs_login_detail" href="main#login_detail_logs" class="nav-link menu-close-click">
                                    <i class="fas fa-user-lock nav-icon"></i>
                                    <p>Login Details</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a id="menu_change_password" href="main#change_password" class="nav-link menu-close-click">
                        <i class="nav-icon fa fa-key"></i>
                        <p>Change Password</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a id="menu_logout" href="<?php echo base_url() ?>login/logout" class="nav-link menu-close-click" onclick="activeLink('menu_logout');">
                        <i class="nav-icon fa fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>