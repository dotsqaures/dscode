<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
<!--        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo e(asset('dist/img/user2-160x160.jpg')); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo e($adminUser->name); ?></p>
            </div>
        </div>-->

        <?php
        $currentUrl = \Illuminate\Support\Facades\Request::segment(2);
        ?>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?php if($currentUrl == 'dashboard'): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('admin/dashboard')); ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <!--<li class="<?php if($currentUrl == 'users'): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('admin/users')); ?>">
                    <i class="fa fa-user"></i> <span>Users</span>
                </a>
            </li>-->


            <li class="treeview <?php echo e(in_array(\Request::route()->getName(), ["admin.users.index"]) ? "active" : ""); ?>">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>User Manager</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo e(in_array(\Request::route()->getName(), ["admin.users.index"]) ? "active" : ""); ?>">
                        <a href="<?php echo e(route('admin.users.index')); ?>"><i class="fa fa-circle-o"></i>  App User</a>
                    </li>
                    
                </ul>
            </li>




        <li class="treeview <?php echo e(in_array(\Request::route()->getName(), ["admin.categories.index"]) ? "active" : ""); ?>">
            <a href="#">
                <i class="fa fa-list"></i>
                <span>Category Manager</span>
                <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
            </a>
            <ul class="treeview-menu">
                <li class="<?php echo e(in_array(\Request::route()->getName(), ["admin.categories.index"]) ? "active" : ""); ?>">
                    <a href="<?php echo e(route('admin.categories.index')); ?>"><i class="fa fa-circle-o"></i> Category List</a>
                </li>

            </ul>
        </li>

            <li class="treeview <?php echo e(in_array(\Request::route()->getName(), ["admin.product.index"]) ? "active" : ""); ?>">
                <a href="#">
                    <i class="fa fa-list"></i>
                    <span>Product Manager</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo e(in_array(\Request::route()->getName(), ["admin.product.index"]) ? "active" : ""); ?>">
                        <a href="<?php echo e(route('admin.product.index')); ?>"><i class="fa fa-circle-o"></i> Product List</a>
                    </li>

                </ul>
            </li>


             <li class="treeview <?php echo e(in_array(\Request::route()->getName(), ["admin.Orders.index"]) ? "active" : ""); ?>">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Invoice Manager</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo e(in_array(\Request::route()->getName(), ["admin.Orders.index"]) ? "active" : ""); ?>">
                        <a href="<?php echo e(route('admin.Orders.index')); ?>"><i class="fa fa-circle-o"></i> Invoice List</a>
                    </li>

                </ul>
            </li>







            <!--
                    <li class="treeview <?php echo e(in_array(\Request::route()->getName(), ["admin.Orders.index"]) ? "active" : ""); ?>">
                            <a href="#">
                                <i class="fa fa-list"></i>
                                <span>Order Manager</span>
                                <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo e(in_array(\Request::route()->getName(), ["admin.Orders.index"]) ? "active" : ""); ?>">
                                    <a href="<?php echo e(route('admin.Orders.index')); ?>"><i class="fa fa-circle-o"></i> Order List</a>
                                </li>

                            </ul>
                        </li>


                        <li class="treeview <?php echo e(in_array(\Request::route()->getName(), ["admin.Payments.index"]) ? "active" : ""); ?>">
                                <a href="#">
                                    <i class="fa fa-money"></i>
                                    <span>Payment Manager</span>
                                    <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="<?php echo e(in_array(\Request::route()->getName(), ["admin.Payments.index"]) ? "active" : ""); ?>">
                                        <a href="<?php echo e(route('admin.Payments.index')); ?>"><i class="fa fa-circle-o"></i> Payment List</a>
                                    </li>

                                </ul>
                            </li>











           <li class="treeview <?php echo e(in_array(\Request::route()->getName(), ["admin.hooks","admin.add-hooks","admin.edit-hooks","admin.view-hooks","admin.email-preferences.index","admin.email-preferences.create","admin.email-preferences.edit","admin.email-preferences.show", "admin.email-templates.index","admin.email-templates.create","admin.email-templates.edit","admin.email-templates.show"]) ? "active" : ""); ?>">
                <a href="#">
                    <i class="fa fa-fw fa-envelope-o"></i>
                    <span>Email Templates</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo e(in_array(\Request::route()->getName(), ["admin.hooks","admin.add-hooks","admin.edit-hooks","admin.view-hooks"]) ? "active" : ""); ?>"><a href="<?php echo e(route('admin.hooks')); ?>"><i class="fa fa-circle-o"></i> Hooks (slugs)</a></li>
                    <li class="<?php echo e(in_array(\Request::route()->getName(), ["admin.email-preferences.index","admin.email-preferences.create","admin.email-preferences.edit","admin.email-preferences.show"]) ? "active" : ""); ?>">
                            <a href="<?php echo e(route('admin.email-preferences.index')); ?>">
                                <i class="fa fa-circle-o"></i> Email Preferences (layouts)
                            </a>
                        </li>
                    <li  class="<?php echo e(in_array(\Request::route()->getName(), ["admin.email-templates.index","admin.email-templates.create","admin.email-templates.edit","admin.email-templates.show"]) ? "active" : ""); ?>">
                            <a href="<?php echo e(route('admin.email-templates.index')); ?>">
                                <i class="fa fa-circle-o"></i> Email Templates</a>
                            </li>
                </ul>
            </li>-->

            <li class="treeview <?php echo e(in_array(\Request::route()->getName(), ["settingtheme","setting.smtp","setting.general","setting.general.add","setting.general.view","setting.general.edit"]) ? "active" : ""); ?>">
                <a href="#">
                    <i class="fa fa-gear"></i>
                    <span>Settings</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo e(\Request::route()->getName() == "settingtheme" ? "active" : ""); ?>"><a href="<?php echo e(url('admin/settings/logos')); ?>">
                            <i class="fa fa-circle-o"></i> Logo/Favicon Icon</a>
                    </li>
                    <li class="<?php echo e(in_array(\Request::route()->getName(), ["setting.general","setting.general.add","setting.general.edit","setting.general.view"]) ? "active" : ""); ?>">
                        <a href="<?php echo e(url('admin/settings/logos')); ?>"><a href="<?php echo e(url('admin/settings/general')); ?>"><i class="fa fa-circle-o"></i> General Settings</a>
                    </li>

                    <li class="<?php echo e(\Request::route()->getName() == "setting.smtp" ? "active" : ""); ?>"><a href="<?php echo e(url('admin/settings/smtp')); ?>"><i class="fa fa-circle-o"></i> SMTP Details</a></li>
                    
                </ul>
            </li>

            <li class="<?php echo e(in_array(\Request::route()->getName(), ["admin.changepassword"]) ? "active" : ""); ?>">
                <a href="<?php echo e(route("admin.changepassword")); ?>">
                    <i class="fa fa-unlock"></i> <span>Change Password</span>
                </a>
            </li>
            <li class="<?php echo e(in_array(\Request::route()->getName(), ["admin.changepassword"]) ? "active" : ""); ?>">
                    <a href="<?php echo e(route('admin.logout')); ?>"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-sidebarform').submit();">
                    <i class="fa fa-power-off"></i> <span><?php echo e(__('Logout')); ?></span>
                </a>
                </li>

        </ul>
        <form id="logout-sidebarform" action="<?php echo e(route('admin.logout')); ?>" method="POST" style="display: none;">
                <?php echo csrf_field(); ?>
            </form>
    </section>
    <!-- /.sidebar -->
</aside>
