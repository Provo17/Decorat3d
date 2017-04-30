<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"><?php echo Yii::t('string', "Submit To Catalog"); ?></h2>
    </div><!--col-md-12-->
</div><!--row-->
<?php
?>
<div class="ds-block-pro">
<!--    <h3> <span></span> Total Bid: <?php // echo isset($total_bids) ? $total_bids : '0'; ?> Bids
        <span class="posted_on">3 Days Left</span>
    </h3>-->
     <?php if (Yii::app()->user->hasFlash('success')): ?>        
        <div role="alert" class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="feture-grids">
            <div class="col-md-12">
                <div class="feture-grid">
                    <div class="pro-des" style="height:100%; overflow:hidden;">
                        <!--<h4>Description</h4>-->
                         <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'bid-form',
                            'htmlOptions' => array('enctype' => 'multipart/form-data'),
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'enableAjaxValidation' => false,
                        ));
                        ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title: </label>
                            <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'placeholder' => 'Title')); ?>
                            <?php echo $form->error($model, 'title'); ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Price: </label>
                            <?php echo $form->textField($model, 'price', array('class' => 'form-control', 'placeholder' => 'Price')); ?>
                            <?php echo $form->error($model, 'price'); ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Upload File: </label>
                            <?php echo $form->fileField($model, 'uploaded_file', array('class' => 'form-control', 'placeholder' => 'color')); ?>
                            <?php echo $form->error($model, 'uploaded_file'); ?>

                            <!--                                <ul class="img-preview">
                                                                <li><img src="images/img4.png"></li>
                                                                <li><img src="images/img5.png"></li>
                                                            </ul>-->
                        </div>
                        <button type="submit" id="sbid-form_submit_btn" class="btn btn-default buyButton">Submit</button>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>    
        </div>
    </div><!--row-->
</div>
