<?php
/* @var $this IssueController */
/* @var $model Issue */

$this->breadcrumbs = array(
    'Issues' => array('index'),
    $model->name,
);

// Menu แต่ละเมนูถูกปรับแต่งให้เรียกได้จะต้องมี Project เสมอ
$this->menu = array(
    array('label' => 'List Issue', 'url' => array('index', 'pid' => $model->project->id)), // รายการ Issue จะต้องแสดงภายใจ Project
    array('label' => 'Create Issue', 'url' => array('create', 'pid' => $model->project->id)), // Issue ที่สร้างให้จะต้องส่ง Project เข้าไป
    array('label' => 'Update Issue', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Issue', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Issue', 'url' => array('admin', 'pid' => $model->project->id)), // Issue ถูกจัดการภายใต้ Project
);
?>

<h1>View Issue #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'description',
        array(
            'name' => 'type_id',
            'value' => CHtml::encode($model->getTypeText())
        ),
        array(
            'name' => 'status_id',
            'value' => CHtml::encode($model->getStatusText())
        ),
        array(
            'name' => 'owner_id',
            'value' => isset($model->owner) ? cHtml::encode($model->owner->username) : "ไม่รู้จัก",
        ),
        array(
            'name' => 'requester_id',
            'value' => isset($model->requester) ? CHtml::encode($model->requester->username) : "ไม่รู้จัก",
        ),
    ),
));
?>

<div id="comments">
    <?php if ($model->commentCount >= 1): ?>
        <br>
        <hr>
        <h3>
            <?php echo $model->commentCount > 1 ? $model->commentCount . ' comments' : 'One comment'; ?> <!--แสดงจำนวน Comments-->
        </h3>
        <?php $this->renderPartial('_comments', array('comments' => $model->comments,)); ?> <!--Render หน้า Comment-->
    <?php endif; ?>
    <br>
    <h3> Leave Comment</h3>
    <?php if (Yii::app()->user->hasFlash('commentSubmitted')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('commentSubmitted'); // ลืม Echo อีกแล้วไง่อีกแล้ว ?>  
        </div>
    <?php else: ?>
        <?php $this->renderPartial('/comment/_form', array('model' => $comment,)); ?>
    <?php endif; ?>
</div>