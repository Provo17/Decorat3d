<?php if (Yii::app()->user->hasFlash('success_msg')): ?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success_msg'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error_msg')): ?>
    <div class="alert alert-error">
        <?php echo Yii::app()->user->getFlash('error_msg'); ?>
    </div>
<?php endif; ?>