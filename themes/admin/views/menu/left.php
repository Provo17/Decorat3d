<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <li class="divider"><br/></li>
            <li class="start open <?php
            if (Yii::app()->request->requestUri == Yii::app()->baseUrl . '/admin')
            {
                echo 'active';
            }
            ?>">
                <a href="<?php echo $this->adminUrl('Dashboard/') ?>">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>  
                    <span class="selected"></span>
                </a>
            </li>
            <li class="<?php
            if (Yii::app()->controller->id == 'contact')
            {
                echo 'active';
            }
            ?>">
                <a href="<?php echo $this->adminUrl('Contact/') ?>">
                    <i class="glyphicon glyphicon-link"></i>
                    <span class="title">Contact Us</span>  
                    <span class="selected"></span>
                </a>
            </li>
            <li class="<?php
            if (Yii::app()->controller->id == 'both')
            {
                echo 'active';
            }
            ?>">
                <a href="<?php echo $this->adminUrl('both/') ?>">
                    <i class="icon-users"></i>
                    <span class="title">Employer / Designer</span>  
                    <span class="selected"></span>
                </a>
            </li>
             <li class="<?php
            if (Yii::app()->controller->id == 'manufacturer')
            {
                echo 'active';
            }
            ?>">
                <a href="<?php echo $this->adminUrl('manufacturer/') ?>">
                    <i class="icon-users"></i>
                    <span class="title">Manufacturer</span>  
                    <span class="selected"></span>
                </a>
            </li>
            <li class="<?php
            if (Yii::app()->controller->id == 'job')
            {
                echo 'active';
            }
            ?>">
                <a href="<?php echo $this->adminUrl('job/') ?>">
                    <i class="fa fa-bars"></i>
                    <span class="title">Projects</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="<?php
            if (Yii::app()->controller->id == 'dispute')
            {
                echo 'active';
            }
            ?>">
                <a href="<?php echo $this->adminUrl('dispute/') ?>">
                    <i class="fa fa-trash-o"></i>
                    <span class="title">Disputes</span>  
                    <span class="selected"></span>
                </a>
            </li>
            <li class="<?php
            if (Yii::app()->controller->id == 'skill')
            {
                echo 'active';
            }
            ?>">
                <a href="<?php echo $this->adminUrl('skill/') ?>">
                    <i class="fa fa-bars"></i>
                    <span class="title">Skills</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="<?php
            if (Yii::app()->controller->id == 'transaction')
            {
                echo 'active';
            }
            ?>">
                <a href="<?php echo $this->adminUrl('transaction/') ?>">
                    <i class="fa fa-bars"></i>
                    <span class="title">Transactions</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="<?php
            if (Yii::app()->controller->id == 'paymentRelease')
            {
                echo 'active';
            }
            ?>">
                <a href="<?php echo $this->adminUrl('paymentRelease/') ?>">
                    <i class="fa fa-bars"></i>
                    <span class="title">Payment Release</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="<?php
            if (Yii::app()->controller->module->id == 'admin/settings' && Yii::app()->controller->id == 'default')
            {
                echo 'active';
            }
            ?>">
                <a href="<?php echo Yii::app()->baseUrl . '/admin/settings'; ?>">
                    <i class="fa fa-wrench"></i>
                    <span class="title">General Settings</span>
                    <span class="selected"></span>
                </a>
            </li> 
            <li class="<?php
            if (Yii::app()->controller->id == 'cms')
            {
                echo 'active';
            }
            ?>">
                <a href="<?php echo $this->adminUrl('cms/index') ?>">
                    <i class="fa fa-pencil"></i>
                    <span class="title">Site CMS</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="<?php
            if (Yii::app()->controller->id == 'emailNotification')
            {
                echo 'active';
            }
            ?>">
                <a href="<?php echo $this->adminUrl('emailNotification/') ?>">
                    <i class="fa fa-pencil"></i>
                    <span class="title">Email Notification</span>
                    <span class="selected"></span>
                </a>
            </li>
        </ul>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>