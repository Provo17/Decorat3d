<link href="<?php echo Assets::themeUrl("vendor/select2/select2-bootstrap.css"); ?>" rel="stylesheet">
<link href="<?php echo Assets::themeUrl("vendor/select2/select2.css"); ?>" rel="stylesheet">
<link href="<?php echo Assets::themeUrl("css/easy-responsive-tabs.css"); ?>" rel="stylesheet">
<script src="<?php echo Assets::themeUrl("js/jquery-1.9.1.min.js"); ?>"></script>
<script src="<?php echo Assets::themeUrl("js/easyResponsiveTabs.js"); ?>"></script>
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />-->
<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"> 
            <?php
            if ($model->user_type_id == 2)
                {
                echo 'Employer / Designer';
                }
            else
                {
                echo 'Manufacturer';
                }
            ?> Page Settings</h2>
    </div><!--col-md-12-->   
</div><!--row-->
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div role="alert" class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>


<div class="row">
    <div class="col-md-12">
        <div class="topr-up-box" id="parentHorizontalTab">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs tabs-part resp-tabs-list hor_1">
                <li class="active"><a href="#browse-ds" data-toggle="tab"><?php echo Yii::t('string', 'Profile Update'); ?></a></li>
                <li><a href="#submit-ds" data-toggle="tab"><?php echo Yii::t('string', 'Skill'); ?></a></li>
                <li><a href="#manufacturer" data-toggle="tab"><?php echo Yii::t('string', 'Change Password'); ?></a></li>
                <li><a href="#change-pass" data-toggle="tab"><?php echo Yii::t('string', 'Account Email'); ?></a></li>
                <li><a href="#acc_detail" data-toggle="tab"><?php echo Yii::t('string', 'Account Details'); ?></a></li>
            </ul>
            <!-- Nav tabs end -->
            <div class="tab-content resp-tabs-container hor_1">
                <div class="tab-pane active" id="browse-ds">
                    <!--/ds-block-pro-->
                    <div class="profileUpdate">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'user_profile-Form',
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                        ));
                        ?> 
                        <form>
                            <div class="form-group">
                                <label>User Name:</label>
                                <input type="hidden" name="form1"/>
                                <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'Enter Your User Name')); ?>
                                <?php echo $form->error($model, 'username'); ?>
                            </div>

                            <div class="form-group">
                                <label>Zip code:</label>
                                <?php echo $form->textField($model, 'zip', array('class' => 'form-control', 'placeholder' => 'Enter Your Zip Code')); ?>
                                <?php echo $form->error($model, 'zip'); ?>
                            </div>

                            <div class="form-group">
                                <label>Sequrity Question:</label>
                                <select name="UserMaster['security_question_id']" id="basic" class="form-control">
                                    <option value=" ">Choose Your Sequrity Question?</option>
                                    <?php
                                    if ($securityQuestions)
                                        {
                                        foreach ($securityQuestions as $index => $questions)
                                            {
                                            ?>
                                            <option class="question1" selected="<?php echo $model->security_question_id; ?>" value="<?php echo $index; ?>"><?php echo $questions; ?></option>
                                            <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <?php echo $form->error($model, 'security_question_id'); ?>
                            </div>
                            <div class="form-group">
                                <label>Answer:</label>
                                <?php echo $form->textField($model, 'security_question_ans', array('class' => 'form-control', 'placeholder' => 'Write your answer')); ?>
                                <?php echo $form->error($model, 'security_question_ans'); ?>
                            </div>
                            <div class="form-group">
                                <label>About Me:</label>
                                <?php echo $form->textArea($model, 'description', array('rows' => 8, 'class' => 'form-control', 'placeholder' => 'Write something about you.')); ?>
                                <?php echo $form->error($model, 'description'); ?>
                            </div>

                            <div class="form-group">
                                <label>Upload Image:</label>
                                <span class="btn btn-default btn-file btn-block">
                                    Upload Image
                                    <?php echo $form->fileField($model, 'profile_image', array('class' => 'form-control', 'placeholder' => 'Select an image file')); ?>
                                </span>
                                <?php echo $form->error($model, 'profile_image'); ?> 
                                <!--Note: Leave blank for no changes-->
                            </div>
                            <div class="form-group">
                                <button id="profile_submit" type="submit" class="btn btn-default buyButton">Update</button>
                                <img style="display:none;height: 50px;width: 50px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                            </div>
                            <?php $this->endWidget(); ?>
                    </div>


                </div><!--Browse designs-->


                <div role="tabpanel" class="tab-pane" id="submit-ds">

                    <!--/ds-block-pro-->

                    <div class="tagPart">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'user_skill-Form',
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                        ));
                        ?>                         
                        <ul id="readOnlyTags">
                            <?php foreach ($user_skills as $s_idx => $uskill): ?>
                                <li><?php echo $uskill->skill->name; ?><span class="cross1"><a href="#" class="skill" data-skill_id="<?php echo $uskill->id; ?>">x</a></span></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="clearfix"></div>                    
                        <?php echo $form->dropDownList($user_skill, 'skill_id', $not_included_skills, array('multiple' => true, 'class' => 'js-example-programmatic-multi  form-control', 'prompt' => '')); ?>
                        <?php echo $form->error($user_skill, 'skill_id'); ?>    
                        <!--<input class="form-control textField1" type="text" placeholder="Enter Your Skills"></form>-->

                        <div class="form-group">
                            <button id="add_skill_btn" class="btn btn-default buyButton pull-right skillPart1" type="submit">Add Skill</button>
                            <img style="display:none;height: 50px;width: 50px;" class="loader img-responsive pull-right" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                        </div>
                        <?php $this->endWidget(); ?>
                        <div class="clearfix"></div>
                    </div>
                </div> <!--Submit Design-->

                <style>                    
                    /*.errorMessage{display: none;}*/
                </style>
                <div class="tab-pane" id="manufacturer">
                    <div class="profileUpdate">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'user_change_pass-Form',
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                        ));
                        ?> 
                        <div class="form-group">
                            <label>Old Password:</label>
                            <?php echo $form->passwordField($model, 'old_password', array('class' => 'form-control', 'placeholder' => 'Enter Your Old Password')); ?>
                            <div class="errorMessage" style="display:none;" id="old_password_err"></div>
                            <!--<input class="form-control" type="text" placeholder="Enter Your Old Password">-->
                        </div>

                        <div class="form-group">
                            <label>New Password:</label>
                            <?php echo $form->passwordField($model, 'new_password', array('class' => 'form-control', 'placeholder' => 'Enter Your new Password')); ?>                            
                            <div class="errorMessage" style="display:none;" id="new_password_err"></div>
                            <!--<input class="form-control" type="text" placeholder="Enter Your new Password">-->
                        </div>

                        <div class="form-group">
                            <label>Retype New Password:</label>
                            <?php echo $form->passwordField($model, 'new_conf_password', array('class' => 'form-control', 'placeholder' => 'Retype Your new Password')); ?>
                            <div class="errorMessage" style="display:none;" id="new_conf_password_err"></div>
                            <!--<input class="form-control" type="text" placeholder="Retype Your new Password">-->
                        </div>                                
                        <div class="form-group">
                            <button id="change_pass_btn" class="btn btn-default buyButton pull-right skillPart1" type="submit">Change Password</button>
                            <img style="display:none;height: 50px;width: 50px;" class="loader img-responsive pull-right" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                        </div>
                        <?php $this->endWidget(); ?>
                        <div class="clearfix"></div>
                    </div>
                </div> <!--Design Send to Manufacturer-->

                <div class="tab-pane" id="change-pass">
                    <div class="profileUpdate">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'user_change_email-Form',
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                        ));
                        ?> 
                        <div class="form-group">
                            <label>Current Email:</label>
                            <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'Enter Your Current Email ID')); ?>
                            <div class="errorMessage" style="display:none;" id="curr_email_err"></div>
                            <div class="errorMessage" style="display:none;" id="email_err"></div>
                            <!--<input class="form-control" type="text" placeholder="Enter Your Current Email Id">-->
                        </div>

                        <div class="form-group">
                            <label>Current Password:</label>
                            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'Enter Your Current Password')); ?>
                            <div class="errorMessage" style="display:none;" id="curr_password_err"></div>
                            <div class="errorMessage" style="display:none;" id="password_err"></div>
                            <!--<input class="form-control" type="text" placeholder="Enter Your Current Password">-->
                        </div>

                        <div class="form-group">
                            <label>New Email Id:</label>
                            <?php echo $form->textField($model, 'new_email', array('class' => 'form-control', 'placeholder' => 'Enter Your new Email ID')); ?>
                            <div class="errorMessage" style="display:none;" id="new_email_err"></div>
                            <!--<input class="form-control" type="text" placeholder="Enter Your new Email ID">-->
                        </div>

                        <div class="form-group">
                            <label>Retype Email Id:</label>
                            <?php echo $form->textField($model, 'new_conf_email', array('class' => 'form-control', 'placeholder' => 'Retype Your new Email ID')); ?>
                            <div class="errorMessage"  style="display:none;" id="new_conf_email_err"></div>
                            <!--<input class="form-control" type="text" placeholder="Retype Your new Email ID">-->
                        </div>

                        <div class="form-group">
                            <button id="change_email_btn"class="btn btn-default buyButton pull-right skillPart1" type="submit">Change Account</button>
                            <img style="display:none;height: 50px;width: 50px;" class="loader img-responsive pull-right" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                        </div>
                        <?php $this->endWidget(); ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="tab-pane" id="acc_detail">
                    <div role="alert" class="alert alert-danger" id="acc_detail_gen_err" style="display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo Yii::t('string', "asdsad"); ?>
                    </div>
                    <div class="profileUpdate">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'user_acc_detail-Form',
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                        ));
                        ?> 
                        <div class="form-group">
                            <label><?php echo Yii::t('string', "Paypal Marchant Email"); ?>:</label>
                            <?php echo $form->textField($model, 'paypal_marchant_email', array('class' => 'form-control', 'placeholder' => 'Enter Your Paypal Marchant Email ID')); ?>
                            <div class="errorMessage" style="display:none;" id="paypal_marchant_email_err"></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo Yii::t('string', "Account No"); ?>:</label>
                            <?php echo $form->textField($model, 'bank_acc_no', array('class' => 'form-control', 'placeholder' => 'Enter Your Account No')); ?>
                            <div class="errorMessage" style="display:none;" id="bank_acc_no_err"></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo Yii::t('string', "Routing No"); ?>:</label>
                            <?php echo $form->textField($model, 'routing_no', array('class' => 'form-control', 'placeholder' => 'Enter Routing No')); ?>
                            <div class="errorMessage"  style="display:none;" id="routing_no_err"></div>
                        </div>                       
                        <div class="form-group">
                            <button id="acc_detail_btn"class="btn btn-default buyButton pull-right skillPart1" type="submit">Update Account Details</button>
                            <img style="display:none;height: 50px;width: 50px;" class="loader img-responsive pull-right" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                        </div>
                        <?php $this->endWidget(); ?>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div><!-- tab-content-->

        </div>  <!--topr-up-box--> 

    </div><!--col-md-12-->
</div><!--row-->

<!--row-->

<!--<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>-->
<script src="<?php echo Assets::themeUrl("vendor/select2/select2.js"); ?>"></script>
<script>
    $(document).ready(function() {
        $(".js-example-programmatic-multi ").select2({
            maximumSelectionLength: 2
        });
    });

//    jQuery(document).on('click', '#profile_submit', function() {
//        $('#profile_submit').hide();
//        $('.loader').show();
//    });
    jQuery(document).on('click', '.skill', function() {
        var _this = $(this);
        var skill = _this.closest('li').find('.skill').data("skill_id");
        jQuery.ajax({
            type: 'POST',
            cache: false,
            dataType: "json",
            url: '<?php echo Yii::app()->createUrl('bothDashboard/deleteSkill'); ?>?sid=' + skill,
            success: function(resp) {
                if (resp['type'] == 'success')
                    $('#UserSkill_skill_id').html(resp.options)
                _this.closest('li').remove();
            }
        });
        return false;
    });

    jQuery(document).on('click', '#add_skill_btn', function(e) {
        e.preventDefault();
        var _this = $(this);
        $('#UserSkill_skill_id_em_').hide();
        $('#UserSkill_skill_id_em_').html('');
        $('#add_skill_btn').hide();
        $('.loader').show();
        jQuery.ajax({
            type: 'POST',
            cache: false,
            data: $('#user_skill-Form').serialize(),
            dataType: "json",
            url: '<?php echo Yii::app()->createUrl('bothDashboard/addSkill'); ?>?uid=' + <?php echo $model->id; ?>,
            success: function(resp) {
                $('.loader').hide();
                $('#add_skill_btn').show();
                if (resp['type'] == 'success') {
                    window.location.href = '';
                } else {
                    if (typeof (resp.msg) !== 'undefined') {
                        $('#UserSkill_skill_id_em_').html(resp.msg);
                    }
//                    if(typeof(resp.msg) !== 'undefined'){
//                        $('#UserSkill_skill_id_em_').html(resp.skill.msg);
//                    }                   

                    $('#UserSkill_skill_id_em_').show();
                }
            }
        });
        return false;
    });

    jQuery(document).on('click', '#change_pass_btn', function(e) {
        e.preventDefault();
        var _this = $(this);
        $('#errorMessage').html('');
        $('#change_pass_btn').hide();
        $('.loader').show();
        jQuery.ajax({
            type: 'POST',
            cache: false,
            data: $('#user_change_pass-Form').serialize(),
            dataType: "json",
            url: '<?php echo Yii::app()->createUrl('bothDashboard/changePassword'); ?>?uid=' + <?php echo $model->id; ?>,
            success: function(resp) {
                $('.loader').hide();
                $('#change_pass_btn').show();
                if (resp['type'] == 'success') {
                    window.location.href = '';
                } else {
                    if (typeof (resp.msg.old_password) !== 'undefined') {
                        $('#old_password_err').html(resp.msg.old_password);
                        $('#old_password_err').closest('.errorMessage').show();
                    }
                    if (typeof (resp.msg) !== 'undefined') {
                        $('#new_password_err').html(resp.msg.new_password);
                        $('#new_password_err').closest('.errorMessage').show();
                    }
                    if (typeof (resp.msg) !== 'undefined') {
                        $('#new_conf_password_err').html(resp.msg.new_conf_password);
                        $('#new_conf_password_err').closest('.errorMessage').show();
                    }

                    $('#UserSkill_skill_id_em_').show();
                }
            }
        });
        return false;
    });

    jQuery(document).on('click', '#change_email_btn', function(e) {
        e.preventDefault();
        var _this = $(this);
        $('#errorMessage').html('');
        $('#change_email_btn').hide();
        $('.loader').show();
        jQuery.ajax({
            type: 'POST',
            cache: false,
            data: $('#user_change_email-Form').serialize(),
            dataType: "json",
            url: '<?php echo Yii::app()->createUrl('bothDashboard/changeEmail'); ?>?uid=' + <?php echo $model->id; ?>,
            success: function(resp) {
                $('.loader').hide();
                $('#change_email_btn').show();
                if (resp['type'] == 'success') {
                    window.location.href = '';
                } else {
                    if (typeof (resp.msg.curr_email) !== 'undefined') {
                        $('#curr_email_err').html(resp.msg.curr_email);
                        $('#curr_email_err').closest('.errorMessage').show();
                    }
                    if (typeof (resp.msg.curr_password) !== 'undefined') {
                        $('#curr_password_err').html(resp.msg.curr_password);
                        $('#curr_password_err').closest('.errorMessage').show();
                    }
                    if (typeof (resp.msg.password) !== 'undefined') {
                        $('#password_err').html(resp.msg.password);
                        $('#password_err').closest('.errorMessage').show();
                    }
                    if (typeof (resp.msg.new_email) !== 'undefined') {
                        $('#new_email_err').html(resp.msg.new_email);
                        $('#new_email_err').closest('.errorMessage').show();
                    }

                    if (typeof (resp.msg.new_conf_email) !== 'undefined') {
                        $('#new_conf_email_err').html(resp.msg.new_conf_email);
                        $('#new_conf_email_err').closest('.errorMessage').show();
                    }
                }
            }
        });
        return false;
    });

    jQuery(document).on('click', '#acc_detail_btn', function(e) {
        e.preventDefault();
        var _this = $(this);
        $('#errorMessage').html('');
        $('#acc_detail_btn').hide();
         $('#acc_detail_gen_err').hide();
        $('.loader').show();
        jQuery.ajax({
            type: 'POST',
            cache: false,
            data: $('#user_acc_detail-Form').serialize(),
            dataType: "json",
            url: '<?php echo Yii::app()->createUrl('bothDashboard/updateFinacialDetail'); ?>?uid=' + <?php echo $model->id; ?>,
            success: function(resp) {
                $('.loader').hide();
                $('#acc_detail_btn').show();
                if (resp['type'] == 'success') {
                    window.location.href = '';
                } else {
                     if (typeof (resp.gmsg) !== 'undefined') {
                        $('#acc_detail_gen_err').show();
                        $('#acc_detail_gen_err').html(resp.gmsg);
                    }
                    if (typeof (resp.msg.paypal_marchant_email) !== 'undefined') {
                        $('#paypal_marchant_email_err').html(resp.msg.paypal_marchant_email);
                        $('#paypal_marchant_email_err').closest('.errorMessage').show();
                    }
                    if (typeof (resp.msg.bank_acc_no) !== 'undefined') {
                        $('#bank_acc_no_err').html(resp.msg.bank_acc_no);
                        $('#bank_acc_no_err').closest('.errorMessage').show();
                    }
                    if (typeof (resp.msg.routing_no) !== 'undefined') {
                        $('#routing_no_err').html(resp.msg.routing_no);
                        $('#routing_no_err').closest('.errorMessage').show();
                    }
                }
            }
        });
        return false;
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        //Horizontal Tab
        $('#parentHorizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $info = $('#nested-tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
    });
</script>