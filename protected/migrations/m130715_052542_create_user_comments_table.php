<?php

class m130715_052542_create_user_comments_table extends CDbMigration
{
	public function up()
	{
            $this->createTable('tbl_comment',array(
                'id'=>'pk',
                'content'=>'text NOT NULL',
                'issue_id'=>'int(11) NOT NULL',
                'create_time'=>'datetime DEFAULT NULL',
                'create_user_id'=>'int(11) DEFAULT NULL',
                'update_time'=>'datetime DEFAULT NULL',
                'update_user_id'=>'int(11) DEFAULT NULL',
            ),'ENGINE=InnoDB');
            
            //tbl_comment.issue_id is a referance to tbl_issue.id 
            $this->addForeignKey('fk_comment_issue','tbl_comment','issue_id','tbl_issue','id','CASCADE','RESTRICT');
            
            //tbl_comment.create_user_id is a referance to tbl_user.id
            $this->addForeignKey('fk_comment_owner','tbl_comment','create_user_id','tbl_user','id','RESTRICT','RESTRICT');
            
            //tbl_comment.update_user_id is a referance to tbl_user.id
            $this->addForeignKey('fk_comment_update_user','tbl_comment','update_user_id','tbl_user','id','RESTRICT','RESTRICT');
	}

	public function down()
	{
		$this->dropForeignKey('fk_comment_issue','tbl_comment');
                $this->dropForeignKey('fk_comment_owner','tbl_comment');
                $this->dropForeignkey('fk_comment_update_user','tbl_comment');
                $this->dropTable('tbl_comment');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}