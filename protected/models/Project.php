<?php

/**
 * This is the model class for table "tbl_project".
 *
 * The followings are the available columns in table 'tbl_project':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 */
class Project extends TrackStarActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Project the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_project';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
// ลบ Rule create_time,update_time,create_user,update_user,last_logine เพราะอัพเดตให้อัตโนมัติไม่ต้อง Validate
        return array(
            array('name, description', 'required'),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description, create_time, create_user_id, update_time, update_user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'issues' => array(self::HAS_MANY, 'Issue', 'project_id'),
            'users' => array(self::MANY_MANY, 'User', 'tbl_project_user_assignment(project_id, user_id)'),
        );
        //สัมพันธ์กับ Issue โดยแบบ 1 project ต่อหลาย Issue
        //สัมพันธ์กับ User โดย 1 Project สามารถมีหลาย User โดยตารางที่เชื่อความสัมพันธ์คือ tbl_project_user_assignment
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'create_time' => 'Create Time',
            'create_user_id' => 'Create User',
            'update_time' => 'Update Time',
            'update_user_id' => 'Update User',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('create_user_id', $this->create_user_id);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('update_user_id', $this->update_user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getUsersOptions() {
        // งงแทบตายที่แท้ก็ลืม Generate Class User ทำให้ดึงข้อมูลไม่ได้
        $usersArray = CHtml::listData($this->users, 'id', 'username');
        return $usersArray;
    }

    public function assignUser($userId, $role) {
        $command = Yii::app()->db->createCommand();
        $command->insert('tbl_project_user_assignment', array(
            'role' => $role,
            'user_id' => $userId,
            'project_id' => $this->id,
        ));
    }

    public function removeUser($userId) {
        $command = Yii::app()->db->createCommand();
        $command->delete('tbl_project_user_assignment', array(
            'user_id=:userId AND project_id=:projectId',
            array(':userId' => $userId, ':projectId' => $this->id),
        ));
    }

    public function allowCurrentUser($role) {
        $sql = "SELECT * FROM tbl_project_user_assignment WHERE project_id =:projectId AND user_id=:userId AND role=:role";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':projectId', $this->id, PDO::PARAM_INT);
        $command->bindValue(':userId', Yii::app()->user->getId(), PDO::PARAM_INT);
        $command->bindValue(':role', $role, PDO::PARAM_STR);
        return $command->execute() == 1 ? true : false; // สะกด execute ผิด
    }

    public static function getUserRoleOptions() {
        return CHtml::listData(Yii::app()->authManager->getRoles(), 'name', 'name');
    }

    public function isUserInProject($user) {
        $sql = 'SELECT user_id FROM tbl_project_user_assignment WHERE project_id=:projectId AND user_id=:userId';
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":projectId", $this->id, PDO::PARAM_INT); // $command เมื่อจะใส่ค่า Properties ต้องใส่ '->' แต่เราไปใส่ '='
        $command->bindValue(":userId", $user->id, PDO::PARAM_INT); // ต้องส่ง $user->id ไม่ใช่ $user อย่างเดียว
        return $command->execute() == 1; // สะกด execute ผิด
    }

}
