

<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * */
abstract class TrackStarActiveRecord extends CActiveRecord {

    protected function beforeSave() {
        //เขียนแบบนี้อ่านยากน่าจะมี {} หลัง if
        if (null !== Yii::app()->User)
            $id = Yii::app()->user->id;
        else
            $id = 1;

        // เขียนแบบนี้อ่านยาก เพราะไม่มี {}
        if ($this->isNewRecord)
            $this->create_user_id = $id;
            $this->update_user_id = $id;
            return parent::beforeSave();
    }

    /** สร้าง Behavior ให้ Update Date time อัตโนมัติ* */
    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
                'setUpdateOnCreate' => true,
            ),
        );
    }

}
?>
