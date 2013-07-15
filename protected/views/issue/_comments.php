<?php foreach ($comments as $comment): ?>
    <div class="comment">
        <div class="author">
            <?php echo CHtml::encode($comment->author->username); ?>
        </div>
        <div class="content">
            <?php echo CHtml::encode($comment->content); ?>
        </div>
    </div>
<?php endforeach; ?>
