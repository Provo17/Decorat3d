<?php /* @var $this Controller */ ?>
<?php
$this->bodyClass = 'page-header-fixed page-quick-sidebar-over-content';
?>
<?php $this->beginContent('//layouts/main'); ?>

<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <?php
    if (Yii::app()->controller->module->id == 'admin' || Yii::app()->controller->module->id == 'admin/settings')
    {
        $this->renderPartial('//menu/top');
    }
    ?>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix"></div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php
    if (Yii::app()->controller->module->id == 'admin' || Yii::app()->controller->module->id == 'admin/settings')
    {
        $this->renderPartial('//menu/left');
    }
    ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            Widget settings form goes here
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn blue">Save changes</button>
                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN STYLE CUSTOMIZER -->

            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <?php
                if (isset($this->breadcrumbs))
                {
                    if (Yii::app()->controller->route !== 'admin/dashboard/index')
                        $this->breadcrumbs = array_merge(array("Home" => $this->createUrl('dashboard/')), $this->breadcrumbs);
                    $this->widget('zii.widgets.CBreadcrumbs', array(
                        'homeLink' => '<i class="fa fa-home"></i>&nbsp;',
                        'links' => $this->breadcrumbs,
                        //'homeLink' => false,
                        'tagName' => 'ul',
                        'separator' => '',
                        'activeLinkTemplate' => '<li><a href="{url}">{label}</a><i class="fa fa-angle-right"></i></li>',
                        'inactiveLinkTemplate' => '<li><span>{label}</span></li>',
                        'htmlOptions' => array('class' => 'page-breadcrumb')
                    ));
                    ?><!-- breadcrumbs -->
                <?php } ?>
            </div>
            <?php $this->renderPartial('//message/index') ?>
            <!-- END PAGE HEADER-->
            <?php echo $content; ?>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner">
        Decorat3d Admin Dashboard.
    </div>
    <div class="page-footer-tools">
        <span class="go-top">
            <i class="fa fa-angle-up"></i>
        </span>
    </div>
</div>
<?php $this->endContent(); ?>