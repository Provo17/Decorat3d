<?php
$this->breadcrumbs = array(
    Yii::t('string','Manufacturer')
);
?><div>
    <h1 style="display: inline"><?php echo Yii::t('string', "Manage Manufacturers"); ?></h1>
    <?php if (Yii::app()->user->hasFlash('success-msg')): ?>
        <div role="alert" class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::app()->user->getFlash('success-msg'); ?>
        </div>
    <?php endif; ?>
<!--    <div class="pull-right">
        <a href="<?php echo $this->createUrl('both/create') ?>" class="btn <?php echo $this->add_button; ?>">Add New</a>        
    </div>-->
</div>
<br/>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box <?php echo $this->portlet_color ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-users"></i> <?php echo Yii::t('string', "Manufacturer List"); ?> 
                </div>
            </div>
            <div class="portlet-body">
                <!----------->
                <div class="table-container">
                    <?php $widget->run(); ?>
                </div>
                <!----------->
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>
<script type="text/javascript">
    //    function approval(id) {
    ////        alert($('#' + id).attr('name'));
    //        $.ajax({
    //            type: 'POST',
    //            url: '<?php echo Yii::app()->createUrl('admin/manageUser/AjaxAdminApprove'); ?>/id/' + id,
    ////            data: {'id': id},
    //            dataType: 'json',
    //            success: function(res) {
    //                $('#s_' + id).html(res['res']);
    //            }
    //        });
    //    }
</script>
<script>
    $(document).ready(function() {
    $(document).on('click', '.admin_processing1', function(e) {//Pending approval portion
    var _this = $(this).bind('click', function(e) {
    e.preventDefault();
    });
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    success: function(res) {
    _this.closest('td').prev('td').find('span').html(res['res']);
    _this.replaceWith(res['status']);
    }
    });
    });

    $(document).on('click', '.admin_processing', function(e) {//Approval portion
    var _this = $(this).bind('click', function(e) {
    e.preventDefault();
    });
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    success: function(res) {
    _this.closest('td').prev('td').find('span').html(res['res']);
    _this.replaceWith(res['status']);
    }
    });
    });

//    $(".glyphicon-trash").on('click', function(e) {
//    e.preventDefault();
//    var url = $(this).attr('href');
//    $.ajax({
//    type: 'POST',
//    url: url,
//    dataType: 'json',
//    success: function(res) {
//    if (data.success === 'deleted') {
//    _this.closest('tr').remove();
//    //                    _this.replaceWith(res['status']);
//    }
//    }
//    });
//    });
    });
</script>