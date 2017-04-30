<?php
$this->breadcrumbs = array(
    'Language' => array('language'),
    'Manage',
);
?>
<div>
    <h1 style="display: inline">Manage Language</h1>    
</div>
<br/>

<div class="row">
    <div class="col-md-12">        
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box <?php echo $this->portlet_color ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-users"></i>Users                </div>
            </div>
            <div class="portlet-body">
                <!----------->
                <div class="table-container">
                    <?php $widget->run();
                    ?>
                </div>
                <!----------->
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/apps/snapfixit/public/themes/admin/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" />
<link rel="stylesheet" type="text/css" href="/apps/snapfixit/public/themes/admin/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" />
<?php
$cs = Yii::app()->clientScript;

$cs->packages = array(
    'modal-box' => array(
        'basePath' => 'application.assets.global.plugins.bootstrap-modal',
        'baseUrl' => Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-modal/',
        'js' => array('js/bootstrap-modalmanager.js', 'js/bootstrap-modal.js'),
        //'css' => array('css/bootstrap-modal-bs3patch.css', 'css/bootstrap-modal.css'),
        'depends' => array('bootstrap')
        ));
$cs->registerPackage('modal-box');
?>
<script>
    var click_row;
</script>
<?php
$script = <<< EOD
        
// general settings
            $.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner = 
              '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
                '<div class="progress progress-striped active">' +
                  '<div class="progress-bar" style="width: 100%;"></div>' +
                '</div>' +
              '</div>';

            $.fn.modalmanager.defaults.resize = true;
//ajax demo:
var modal = $('#ajax-modal');
$(document).on('click','.ajax-demo', function(e){
        click_row = $(this);
        e.preventDefault();
url = $(this).attr('href');
// create the backdrop and wait for next modal to be triggered
$('body').modalmanager('loading');

setTimeout(function(){
modal.load(url, '', function(){
modal.modal();
});
}, 1000);
});
EOD;

Yii::app()->clientScript->registerScript('ajax-modal', $script);
?>