<?php

class DefaultController extends AdminController {

    public function actionIndex() {
       $this->layout = '//layouts/default';
        if (isset($_POST['settings']) && is_array($_POST['settings'])) {
            foreach ($_POST['settings'] as $slug => $sett) {
                
                $row = Settings::model()->findByAttributes(['slug' => $slug]);
                if ($row) {
                    $row->value = $sett;
                    $row->save(FALSE);
                }
            }
            Yii::app()->user->setFlash('success_msg', "Settings updated successfully");
            Yii::app()->user->setFlash('selected_tab', isset($_POST['tab']) ? $_POST['tab'] : 1);
            $this->refresh();
        }
        $data = array();
        $data['tab'] = 1; //Yii::app()->user->getFlash('selected_tab') == '' ? 1 : Yii::app()->user->getFlash('selected_tab');
        $modules = [];
        $system_tab = array();

        $systems[] = array('title' => 'PHP Version', 'value' => phpversion() . '&nbsp&nbsp<a href="' . Yii::app()->createAbsoluteUrl("") . '" target="_blank">Complete PHP Info</a>');
        $systems[] = array('title' => 'MySQL Version', 'value' => Settings::mysql_version());
        //$systems[] = array('title' => 'Backup Your Database', 'value' => '<a href="' . base_url('settings/db/backup') . '">Click</a>');
        foreach (Settings::model()->findAll() as $mod) {
            $modules[$mod->module][] = (object) array(
                        'slug' => $mod->slug,
                        'title' => $mod->title,
                        'description' => $mod->description,
                        'type' => $mod->type,
                        'default' => $mod->default,
                        'value' => $mod->value,
                        'options' => $mod->options,
                        'is_required' => $mod->is_required,
                        'is_gui' => $mod->is_gui,
                        'module' => $mod->module,
                        'order' => $mod->row_order,
            );
        }
    
        foreach ($systems as $system) {
            $system_tab[] = (object) array(
                        'slug' => isset($system['slug']) ? $system['slug'] : '',
                        'title' => isset($system['title']) ? $system['title'] : '',
                        'description' => isset($system['description']) ? $system['description'] : '',
                        'type' => isset($system['type']) ? $system['type'] : '',
                        'default' => isset($system['default']) ? $system['default'] : '',
                        'value' => isset($system['value']) ? $system['value'] : '',
                        'options' => isset($system['options']) ? $system['options'] : '',
                        'is_required' => isset($system['is_required']) ? $system['is_required'] : '',
                        'is_gui' => isset($system['is_gui']) ? $system['is_gui'] : '',
                        'module' => 'System',
                        'order' => isset($system['order']) ? $system['order'] : '',
            );
        }
        $modules['System'] = $system_tab;
        $data['modules'] = $modules;
        $this->render('index', $data);
    }

}