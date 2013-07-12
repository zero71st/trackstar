<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?> // Double slash (//) ให้ค้นหาภายใต้ Folder view เท่านั้น ถ้าไม่ระบุ Yii จะหาทั้ง Module
<div id="content">
    <?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>