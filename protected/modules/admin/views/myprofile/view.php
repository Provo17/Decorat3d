<?php
/* @var $this MyprofileController */
/* @var $model AdminUser */

$this->breadcrumbs = array(
    'Admin Users' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List AdminUser', 'url' => array('index')),
    array('label' => 'Create AdminUser', 'url' => array('create')),
    array('label' => 'Update AdminUser', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete AdminUser', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage AdminUser', 'url' => array('admin')),
);
?>

<h1>View AdminUser #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'email',
        'password',
        'role',
        'create_at',
        'update_at',
        'status',
    ),
));
?>
