<?php

class AdminModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'admin.models.*',
            'admin.components.*',
        ));

        $this->layout = '/admin/layouts/main';
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
//            if (!Yii::app()->user->checkAccess('admin')) {
//                throw new CHttpException(403, Yii::t('Application', 'คุณไม่ได้รับอนุญาตให้ใช้งานส่วนนี้'));
//            }
            return true;
        }
        else
            return false;
    }

}
