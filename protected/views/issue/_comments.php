<!--This is Partail files-->
<?php foreach ($comments as $comment): ?>
    <div class="comment">
        <div class="author">
            <?php echo CHtml::encode($comment->author->username); ?>
        </div>
        <div class="time">
            <?php echo date('F,j Y \a\t h:i a', strtotime($comment->create_time)); ?>
        </div>
        <div class="content">
            <?php echo nl2br(CHtml::encode($comment->content)); ?>
        </div>
    </div>
    <hr>
<?php endforeach; ?>
