<?php

class m130710_091726_add_role_to_project_user_assignment extends CDbMigration
{
	public function up()
	{
            $this->addColumn('tbl_project_user_assignment','role','varchar(64)');
            
            $this->addForeignKey('fk_project_user_role','tbl_project_user_assignment','role','tbl_auth_item','name','CASCADE','CASCADE');
	}

	public function down()
	{
            $this->dropForeignKey('fk_project_user_role','tbl_project_user_assignment');
            
            $this->dropColumn('tbl_project_user_role','role');
//		echo "m130710_091726_add_role_to_project_user_assignment does not support migration down.\n";
//		return false;
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