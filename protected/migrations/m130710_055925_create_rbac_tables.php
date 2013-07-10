<?php

class m130710_055925_create_rbac_tables extends CDbMigration
{
	public function up()
	{
            //Create the auth item table
            $this->createTable('tbl_auth_item',array(
                'name' => 'varchar(64) NOT NULL',
                'type' => 'Integer NOT NULL',
                'description'=>'Text',
                'bizrule'=>'Text',
                'data'=>'Text',
                'PRIMARY KEY(name)',
            ),'ENGINE=InnoDB');
            
            //Create the auth child item table
            $this->createTable('tbl_auth_item_child',array(
                'parent'=>'varchar(64) NOT NULL',
                'child'=>'varchar(64) NOT NULL',
                'PRIMARY KEY(parent,child)',
            ),'ENGINE=InnoDB');
            
            // tbl_auth_item_child.parent is a referrence to tbl_auth_item.name
            $this->addForeignkey('fk_auth_item_child_parent','tbl_auth_item_child','parent','tbl_auth_item','name','CASCADE','CASCADE');
            
            // tbl_auth_item_child.child is a referrence to tbl_auth_item.name
            $this->addForeignkey('fk_auth_item_child_child','tbl_auth_item_child','child','tbl_auth_item','name','CASCADE','CASCADE');
            
            //Create the auth assignment table
            $this->createTable('tbl_auth_assignment',array(
                'itemname'=>'varchar(64) NOT NULL',
                'user_id'=>'int(11) NOT NULL',
                'bizrule'=>'Text',
                'data'=>'Text',
                'PRIMARY KEY(itemname,user_id)',
            ),'ENGINE=InnoDB');
            
            // the tbl_auth_assignment.itemname is a referrence to tbl_auth_item.name
            $this->addForeignkey('fk_auth_assignment_itemname','tbl_auth_assignment','itemname','tbl_auth_item','name','CASCADE','CASCADE');
            
            // the tbl_auth_assignment.userid is a referrence to tbl_user.id
            $this->addForeignkey('fk_auth_assignment_userid','tbl_auth_assignment','user_id','tbl_user','id','CASCADE','RESTRICT'); // ต้องใส่ RESTRICT ในตำราใส่เป็น CASCADE ซึ่ง RUN ไม่ผ่าน
	}
        
	public function down()
	{
//		echo "m130710_055925_create_rbac_tables does not support migration down.\n";
//		return false;
            $this->truncateTable('tbl_auth_assignment');
            $this->truncateTable('tbl_auth_item_child');
            $this->truncateTable('tbl_auth_item');
            $this->dropTable('tbl_auth_assignment');
            $this->dropTable('tbl_auth_item_child');
            $this->dropTable('tbl_auth_item');
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