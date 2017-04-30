<div class="conversationPartP" style="background: #fff;">
    <div class="desProjects">
        <div class="description">
            <h2 class="how-it-head headingText">Detailed Description of Project</h2>
            <p><?php echo $disputeThread->jobBid->job->description; ?></p>
        </div>
    </div>
    <div class="desProjects">
        <div class="description desCriptionPlus">
            <h2 class="how-it-head headingText">Dispute Reason</h2>
            <p><?php echo $disputeThread->reason; ?></p>
        </div>
    </div>

    <div class="desProjects projectPlus">
        <div class="reviews reviewPart">
            <div class="row">
                <div class="col-md-12 col-sm-12 colx-s-12">
                    <h3>Recent reviews</h3>
                </div>
            </div>
            <?php if(count($disputeThread->messages)==0): ?>
            <div class="reviewText" id='noReview'>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div style="color:red;"><center>There is no review</center></div>
                        </div>                        
                    </div>
                </div>
            <?php else: ?>

            <?php foreach ($disputeThread->messages(['order' => 'created_at']) as $message): ?>
                <div class="reviewText">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div><img src="<?php echo Yii::app()->request->baseUrl . ($message->user->profile_image != "" ? '/upload/usersImage/thumb/' . $message->user->profile_image : '/themes/frontend/assets/images/img1.png'); ?>"></div>
                        </div>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <!--<h2><a href="#">Project for Florida Attorneys</a></h2>-->
                            <p>"<?php echo $message->message; ?>"</p>
                            <p class="name1">-<span class="uName"><?php echo $message->user->username; ?></span><span class="date"><?php echo date("j.n.Y", strtotime($message->created_at)); ?></span></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
</div>
<div class="convertForm">
        <div class="col-md-12 col-sm-12 colxs-12">
            <?php
            //
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'conversation-form',
                'action' => Yii::app()->createAbsoluteUrl('dispute/Comment', ['disputeThreadId' => $disputeThread->id]),
                'htmlOptions' => ['class' => 'form-horizontal', 'role' => 'form'],
                'enableClientValidation' => true,
            ));
            ?>
            <div class="form-group formPart1213">
                <label for="comment">Comment:</label>
                <textarea class="form-control textControl" rows="3" placeholder="Enter Your Message" id="comment" name="DisputeConversation['reason']"></textarea>
                <div class='errorMessage' style='display: none;margin-top: 10px;'></div>
            </div>
            <div class="submitButtonPlus1"><button type="submit" class="btn btn-info submitButt" id="submitButton">Send Message</button></div>
                    <img style="display:none;height: 35px;width: 35px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
            <?php $this->endWidget(); ?>
        </div>
    </div>
<script>
$(document).ready(function () {
    $('form#conversation-form').submit(function (e) {        
        e.preventDefault();
        if ($(this).find("#comment").val() == "") {
            $(this).find(".errorMessage").text('Review must not be blank').show('fast');
        } else {
            $(this).find(".errorMessage").text('Review must not be blank').hide('fast');
            $(this).find("#submitButton").hide('fast');
            $(this).find(".loader").show('fast');
            
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createAbsoluteUrl('dispute/Comment', ['disputeThreadId' => $disputeThread->id]); ?>",
                data: {conversation: $(this).find("#comment").val()},
                dataType: 'json',
                success: function (result) {
                    $('form#conversation-form').find("#submitButton").show('slow');
                    $('form#conversation-form').find(".loader").hide('slow');
                    if (result.status == 'success') {
                        var html = '<div class="reviewText">'
                            + '<div class = "row">'
                            + '<div class = "col-md-1 col-sm-2 col-xs-12">'
                            + '<div> <img src = "' + result.image + '"> </div>' + ' </div>'
                            + '<div class = "col-md-11 col-sm-10 col-xs-12" ><!--<h2><a href="#">Project for Florida Attorneys</a></h2>-->'
                            + '<p> "' + result.review + '" </p>'
                            + '<p class = "name"> - <span>' + result.username + '</span><span>' + result.created_at + '</span > </p>'
                            + '</div>'
                            + '</div>'
                            + '</div>';

                        $('#noReview').hide('fast');
                        $('.reviewPart').append(html);
                        $('form#conversation-form').find("#comment").val('');
                    } else if (result.status == 'error') {
                        var html = '<ul>';
                        if ($.isArray(result.msg)) {
                            $.each(result.msg, function () {
                                html += '<li>' + this + '</li>';
                            });
                        } else {
                            html += '<li>' + result.msg + '</li>';
                        }
                        html += '</ul>';
                        $("#reportDisputeModal").find(".modal-body .errorMessage").html(html).show('slow');
                    }
                }
            });
        }
    });
});
</script>