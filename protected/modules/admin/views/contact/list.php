<?php
$this->breadcrumbs = array(
    'ContactUs' => array('index'),
    'Manage',
);
?><div>
    <h1 style="display: inline">Manage Static</h1>
    
</div>
<br/>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box <?php echo $this->portlet_color ; ?>">
            <div class="portlet-title ">
                <div class="caption">
                    <i class="fa fa-comments"></i>Pages</div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <?php
                    $gridColumns = array(
                        ['name' => 'name', 'header' => 'Name', 'htmlOptions' => []],
                        ['name' => 'email', 'header' => 'Email', 'htmlOptions' => []],
                        ['name' => 'phone', 'header' => 'Contact Number', 'htmlOptions' => []],
                        ['name' => 'status','type'=>'raw','value'=>'$data->statusTag()', 'header' => 'Status','htmlOptions' => [],'sortable' => false,'filter'=>false],
                        array(
                            'htmlOptions' => array('nowrap' => 'nowrap'),
                            'class' => 'booster.widgets.TbButtonColumn',
                            'header'=>'Action',
                            'template' => '{update}' //removed {view}
                        //'viewButtonUrl' => null,//explicitly define url
                        //'updateButtonUrl' => null,
                        //'deleteButtonUrl' => null,
                        )
                    );
                    $this->widget('booster.widgets.TbGridView', array(
                        'id' => 'email-grid',
                        'dataProvider' => $model->search(),
                        'template' => "{summary}\n{pager}<br>\n{items}\n{pager}",
                        'enableSorting' => false,
                        //'filter'=>$model,
                        'columns' => $gridColumns));
                    ?>
                </div>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>