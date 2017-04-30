<?php

class DefaultController extends AdminController {

    protected function columns() {
        return array(
            'language:text',
            array(
                'name' => 'country_flag',
                'type' => 'html',
                'value' => '$data->country_flag'
            ),
            'translation:text',
            /* array(
              'name' => 'Join Date',
              'type' => 'date',
              'value' => 'Assets::themeUrl("images/da_DK.png")',
              ), */
            /*  'currency.name:text', */
            array(// display a column with "update" and "delete" buttons
                'class' => 'EButtonColumn',
                'template' => '{update}',
                'viewButtonIcon' => 'glyphicon glyphicon-eye-open',
                'deleteButtonIcon' => 'glyphicon glyphicon-trash',
                'updateButtonIcon' => 'glyphicon glyphicon-pencil',
                'buttons' => [
                    'update' => [
                        //'url' => 'CHtml::normalizeUrl(array("view")."/f_id/".$data->id))'
                        'url' => 'Yii::app()->createUrl("admin/language/edit/$data->id/$data->language")',
                        'options' => ['class' => 'ajax-demo'],
                    ]
                ],
            ),
        );
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEdit($id, $lang) {

        //check original content
        $original_model_in_en = Message::model()->findByAttributes(['id' => $id, 'language' => 'en']);
        if ($original_model_in_en != NULL) {
            $original_message = $original_model_in_en->translation;
        } else if ($original_model_in_en != NULL) {
            $original_model_in_en = SourceMessage::model()->findByAttributes(['id' => $id]);
            $original_message = $original_model_in_en->message;
        } else {
            $original_message = $original_model_in_en->message;
        }
        //END
        $model = $this->loadModel($id, $lang);
        $this->renderPartial('edit', array(
            'model' => $model,
            'original_message' => $original_message,
            'all_lang' => ['en' => 'English', 'de' => 'German', 'da' => 'Danish'],
        ));
    }

    public function actionUpdateTranslation() {
        $id = isset($_POST['Message']['id']) ? $_POST['Message']['id'] : '';
        $language = isset($_POST['Message']['language']) ? $_POST['Message']['language'] : '';
        $message = Message::model()->findByAttributes(['id' => $id, 'language' => $language]);
        if ($message != NULL) {
            $message->attributes = $_POST['Message'];
            $message->scenario = 'update';
            if ($message->save()) {
                $this->ajax_resp['message'] = 'Updated successfully'; //Yii::t('message', 'signup_success');
            } else {
                $errors = '';
                foreach ($message->getErrors() as $field => $error) {
                    $errors .= $error[0];
                }
                $this->ajax_resp['message'] = $errors;
                $this->ajax_resp['type'] = 'warning';
            }
            $this->ajax_resp['translation'] = $message->translation;
        }
        $this->renderAjax();
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $model = new Message('search');
        $model->unsetAttributes();
        $columns = $this->columns();
        /**
         * @var $widget EDataTables
         */
        $widget = $this->createWidget('ext.EDataTables.EDataTables', array(
            'id' => 'goldFixing',
            'dataProvider' => $model->search($columns),
            'ajaxUrl' => $this->createUrl($this->getAction()->getId()),
            'columns' => $columns,
            'htmlOptions' => array('class' => ''),
            'itemsCssClass' => 'table table-striped table-bordered table-hover dataTable no-footer',
            'pagerCssClass' => 'dataTables_paginate paging_bootstrap_full_number',
            //<'dataTables_toolbar'>
            'datatableTemplate' => "<r> <'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'<'pull-right'f>r>> t <'row'<'col-md-4 col-sm-12'i><'col-md-8 col-sm-12'p>>",
            'bootstrap' => true,
        ));
        $sEcho = isset($_GET['sEcho']) ? $_GET['sEcho'] : '';
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            echo json_encode($widget->getFormattedData(intval($sEcho)));
            Yii::app()->end();
            return;
        }
        $this->render('index', array('widget' => $widget,));
    }

    public function loadModel($id, $lang = NULL) {
        if ($lang != NULL) {
            $model = Message::model()->findByAttributes(['id' => $id, 'language' => $lang]); //findAllByAttributes
        } else {
            $model = Message::model()->findByAttributes(['id' => $id]); //findAllByAttributes
        }

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionSyncLang() {
        $original = SourceMessage::model()->findAll();
        $lang = ['en', 'de', 'da'];
        foreach ($original as $msg) {
            foreach ($lang as $l) {
                $eng_msg = Message::model()->findByAttributes(['language' => $l, 'id' => $msg->id]);
                if ($eng_msg == NULL) {
                    $new_msg = new Message();
                    $new_msg->id = $msg->id;
                    $new_msg->language = $l;
                    $new_msg->translation = $msg->message;
                    $new_msg->save(false);
                }
            }
        }
    }

}