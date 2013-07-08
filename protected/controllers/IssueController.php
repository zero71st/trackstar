<?php

class IssueController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    // ใช้กับงาน Filter
    public $_project = null;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            // projectContext คือ filter method ใน class นี้
            // + คืออนุญาตให้ใช้ได้กับ Action Create ส่วน - คือไม่อนุญาตให้ใชักับ Action ใด ๆ
            // create คือ Action method ใน Class นี้
            'projectContext + create index admin', //check to ensure valid context
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
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
        $model = new Issue;
        // กำหนดค่าใช้ Issue.project_id จาก IssueController
        $model->project_id = $this->_project->id;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Issue'])) {
            $model->attributes = $_POST['Issue'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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

        if (isset($_POST['Issue'])) {
            $model->attributes = $_POST['Issue'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Issue', array(
        'criteria' => array(
            'condition' => 'project_id=:protectId',
            'params' => array(':projectId' => $this->_project->id),
        ),
        ));
        
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Issue('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Issue']))
            $model->attributes = $_GET['Issue'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Issue the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Issue::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Issue $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'issue-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    // Custom Method
    public function filterProjectContext($filterChain) {

        if (isset($_GET['pid'])) {
            $this->loadProject($_GET['pid']);
        } else {
            throw new CHttpException(404, 'กรุณาระบุโครงการที่ต้องการก่อน!');
        }

        $filterChain->run();
    }

    protected function loadProject($projectId) {
        if ($this->_project === null) {
            $this->_project = Project::model()->findByPk($projectId);
        }
        // เช็คว่าเป็น Null อีกหรือไม่
        if ($this->_project === null) {
            throw new CHttpException(403, 'ไม่พบโครงการที่คุณเลือก');
        }
        return $this->_project;
    }

}
