<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"> Disputed Projects </h2>
    </div><!--col-md-12-->
</div><!--row-->
<div class="searchJob">
    <div class="job1">
        <?php foreach ($disputes as $dispute): ?>
            <div class="row jobPart1 jobPartPart">
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <?php echo CHtml::image(Yii::app()->baseUrl . '/upload/usersImage/thumb/' . $dispute->disputeFrom->profile_image); ?>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="contentMiddlePart">
                        <h2><a href="<?php echo Yii::app()->createAbsoluteUrl('bothDashboard/jobDetails', ['id'=>$dispute->jobBid->job->id]); ?>"><?php echo strlen($dispute->jobBid->job->description)>57?substr($dispute->jobBid->job->description, 0, 57)."...":$dispute->jobBid->job->description; ?></a></h2>
                        <p>by -<span class="usereNameP"><?php echo $dispute->disputeFrom->username!="" ? $dispute->disputeFrom->username:""; ?></span></p>
                        <span><?php echo date("M j, Y", strtotime($dispute->created_at)); ?></span>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12 ">
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('dispute/conversations', ['disputeThreadId'=>$dispute->id]); ?>" class="applyNow pull-right" style="width:150%;">See Conversations</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>