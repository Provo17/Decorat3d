<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Edit Content</h4>
</div>
<div class="modal-body">
    <div class="alert" id='show_message' style="display: none">
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => $this->adminUrl('language/default/updateTranslation'),
        'id' => 'language-translation-form',
        'htmlOptions' => ['class' => 'form-horizontal', 'role' >= 'form'],
        'enableAjaxValidation' => false,
    ));
    ?>
    <?php echo $form->hiddenField($model, 'id'); ?>                    
    <?php echo $form->hiddenField($model, 'language'); ?>                    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-3 control-label">English  <?= CHtml::image(Yii::app()->baseUrl . "/images/en_GB.png", "flag_en_GB") ?></label>
                <div class="col-md-9">
                    <p class="form-control-static"><?= $original_message ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">                
                <label class="col-md-3 control-label"><?= $model->lang_name ?> <?= $model->country_flag ?></label>
                <div class="col-md-9">
                    <?php echo $form->textArea($model, 'translation', array('rows' => 5, 'class' => 'form-control', 'id' => '{translation}', 'placeholder' => '')); ?>                    
                    <?php echo $form->error($model, 'translation'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal">Close</button>
    <button type="button" id="submit_translation" class="btn blue">Save changes</button>
</div>
<script>
    $(document).ready(function() {
        $("#submit_translation").click(function() {            
            var $form = $form = $("#language-translation-form");
            var data = $form.serialize(),
                    url = $form.attr("action");
            $("#show_message").hide();
            $("#show_message").removeClass('alert-danger')
                    .removeClass('alert-success');

            var request = $.ajax({
                url: url,
                type: "POST",
                data: data,
                dataType: "json"
            });
            request.done(function(resp) {
                $("#show_message").html(resp.message);
                if (resp.type == 'success') {
                    $("#show_message").addClass('alert-success');
                    click_row.closest('tr').children().eq(2).html(resp.translation);
                } else {
                    $("#show_message").addClass('alert-danger');
                }
                $("#show_message").slideDown('slow');
                setTimeout(function(){$("#show_message").slideUp();},5000);
            }); //done
            
            request.always(function() {
            });
        });
    });
</script>