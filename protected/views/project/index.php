<?php
/* @var $this ProjectController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Projects',
);

$this->menu = array(
    array('label' => 'Create Project', 'url' => array('create')),
    array('label' => 'Manage Project', 'url' => array('admin')),
);
?>

<!--Alter admin message alert-->
<?php if ($sysMessage !== null) : ?>
    <div class="sys-message">
        <?php echo $sysMessage; ?>
    </div>
    <?php
    Yii::app()->clientScript->registerScript(
            'fadeAndHideEffect', '$(".sys-message").animate({opacity: 1.0}, 5000).fadeOut("slow");');
endif;
?>

<h1>Projects</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>

<!--Display Comment widget-->
<?php $this->beginWidget('zii.widgets.CPortlet', array('title' => "Recent Comment")); ?>
    <?php $this->widget('RecentCommentsWidget'); ?>
<?php $this->endWidget(); ?>
