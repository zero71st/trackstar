<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<?php if(!Yii::app()->user->isGuest):?>
<!-- ลืม echo ที่ Last Login Time-->
<p> คุณเข้าระบบครั้งที่แล้ว: <?php echo Yii::app()->user->lastLogin; ?> </p>
<?php endif; ?>