<?php

class ManageBannerController extends AdminController {

    protected function columns() {
        return array(
            array(
                'name' => 'image',
                'type' => 'raw',
                'value' => '"<img src=".Yii::app()->baseUrl."/upload/banner/".$data->image." width=50,height=150>"',
            ),
            'text',
           array(
                'name' => 'user_for',
                'header' => 'Added By',
                'value' => '$data->added_by',
            ),
            array(
                'name' => 'user_for',
                'header' => 'Banner For',
                'value' => '$data->user_for=="H" ? "Home"  : "Product" ',
            ),
            array(// display a column with "delete" buttons

                'class' => 'EButtonColumn',
                'template' => '{update} {delete}', //{view} 
                'buttons' => array('delete' => array('options' => array('ajax' => array('type' => 'get', 'url' => "js:$(this).attr('href')", 'dataType' => 'json', 'success' => 'js:function(data) {window.location.reload();}')))),
//'viewButtonIcon' => 'glyphicon glyphicon-eye-open',
                'deleteButtonIcon' => 'glyphicon glyphicon-trash',
                'updateButtonIcon' => 'glyphicon glyphicon-pencil',
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Banner('create');
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);        
            $user_for = 'H,P';       
        $banner = Banner::model()->findAllByAttributes(array('added_by' => Yii::app()->user->id, 'user_for' => $user_for));
        if (count($banner) < 10) {
            if (isset($_POST['Banner'])) {
                $model->text = $_POST['Banner']['text'];
                $model->user_for = $_POST['Banner']['user_for'];
                $model->added_by = Yii::app()->user->id;
                $img = CUploadedFile::getInstance($model, 'image');
                $rename = time() . '_' . $img;
                if (isset($img)) {
                    $model->image = $rename;
                    if ($img->saveAs(Yii::app()->basePath . '/../upload/banner/' . $rename)) {
                        $img = Yii::app()->image->load(Yii::app()->basePath . '/../upload/banner/' . $rename);
                        $img->resize(1140, 300, Image::NONE);
                        $img->save();
                        if ($model->save()) {
                            Yii::app()->user->setFlash('success_msg', "Banner created successfully");
                            $this->redirect(array('index'));
                        }
                    }
                }
            }
        } else {
            Yii::app()->user->setFlash('error_msg', "Maximum Ten Banner Should be added!");
            $this->redirect(array('index'));
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model); 
        $old_image = Yii::app()->basePath . '/../upload/banner/' . $model->image;
        if ($model->added_by != Yii::app()->user->id || (Yii::app()->user->type == 'admin' && ($model->user_for != 'H' && $model->user_for != 'P'))) {
            $this->redirect(array('index'));
        }
        if (isset($_POST['Banner'])) {
            $model->text = $_POST['Banner']['text'];
            $model->user_for = $_POST['Banner']['user_for'];
            $img = CUploadedFile::getInstance($model, 'image');
            $rename = time() . '_' . $img;
            if (isset($img)) {
                $model->image = $rename;
                if ($img->saveAs(Yii::app()->basePath . '/../upload/banner/' . $rename)) {
                    $img = Yii::app()->image->load(Yii::app()->basePath . '/../upload/banner/' . $rename);
                    $img->resize(1140, 300, Image::NONE);
                    $img->save();
                    if (is_file($old_image)) {
                        unlink($old_image);
                    }
                }
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success_msg', "Banner updated successfully");
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $old_image = Yii::app()->basePath . '/../upload/banner/' . $model->image;
        if (is_file($old_image)) {
            unlink($old_image);
        }
        $model->delete();
        $url = "http://www.stackoverflow.com";
        return 'window.location.href="' . $url . '";';
        //echo json_encode(array('delete'=>'1'));
        //$this->redirect(array('index'));
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//        if (!isset($_GET['ajax']))
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Banner('search');
        $model->unsetAttributes();
        $columns = $this->columns();
        $allbanner = Banner::model()->findAll();
       
//        $banner_product = Banner::model()->findAllByAttributes(array('added_by' => Yii::app()->user->id, 'user_for' => 'P'));
        $banner = count($allbanner) ;
        $widget = $this->createWidget('ext.EDataTables.EDataTables', array(
            'id' => 'goldFixing',
            'dataProvider' => $model->search($columns),
            'ajaxUrl' => $this->createUrl($this->getAction()->getId()),
            'columns' => $columns,
            'htmlOptions' => array('class' => ''),
            'itemsCssClass' => 'table table-striped table-bordered table-hover dataTable no-footer',
            'pagerCssClass' => 'dataTables_paginate paging_bootstrap_full_number',
            //<'dataTables_toolbar'>
            'datatableTemplate' => "<r> <'row'<'col-md-6 col-sm-12'><'col-md-6 col-sm-12'<'pull-right'>r>> t <'row'<'col-md-4 col-sm-12'><'col-md-8 col-sm-12'>>",
            'bootstrap' => true,
        ));
        $sEcho = isset($_GET['sEcho']) ? $_GET['sEcho'] : '';
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            echo json_encode($widget->getFormattedData(intval($sEcho)));
            Yii::app()->end();
            return;
        }
        $this->render('list', array('widget' => $widget, 'banner' => $banner));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductCategory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Banner::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProductCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'banner-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

