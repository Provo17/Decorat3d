<?php
$this->breadcrumbs = array(
    'CMS' => array('index'),
    'Details',
);
?>

<!--<h1>View User #<?php // echo $model->id;            ?></h1>-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet box <?php echo $this->portlet_color; ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-eye"></i>
                    <?php echo Yii::t('string', "View"); ?> <!-Details User #<?php //echo $model->id;            ?>-->
                </div>                
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal">
                    <div class="form-body">
                        <?php //echo $form->errorSummary($model);   ?>
                        <h3 class="form-section"><?php echo Yii::t('string', "CMS Info"); ?></h3>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="tabbable tabbable-custom boxless tabbable-reversed">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_0" data-toggle="tab">
                                                <?php echo Yii::t('string', "Content"); ?> </a>
                                        </li>
<!--                                        <li>
                                            <a href="#tab_1" data-toggle="tab">
                                                Content in Greek </a>
                                        </li>-->

                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_0">
                                            <div class="col-md-9">
                                                <p class="form-control-static"><?php echo $model->content_en; ?> </p>                   

                                            </div>
                                        </div>
                                        <div class="tab-pane " id="tab_1">
                                            <div class="col-md-9">
                                                <p class="form-control-static"><?php echo $model->content_gr; ?> </p>                   

                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions right">
                        <a href="<?php echo $this->createUrl('Cms/index') ?>" class="btn <?php echo $this->back_button; ?>"><?php echo Yii::t('string', "Back"); ?></a>
                        <a href="<?php echo $this->createUrl('Cms/update/id/' . $model->id) ?>" class="btn <?php echo $this->update_button; ?>"><?php echo Yii::t('string', "Update"); ?></a>                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>