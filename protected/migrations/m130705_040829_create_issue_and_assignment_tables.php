<?php

class m130705_040829_create_issue_and_assignment_tables extends CDbMigration {

    public function up() {
        $this->createTable('tbl_issue', array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'description' => 'text',
            'project_id' => 'int(11) DEFAULT NULL',
            'type_id' => 'int(11) DEFAULT NULL',
            'status_id' => 'int(11) DEFAULT NULL',
            'owner_id' => 'int(11) DEFAULT NULL',
            'requester_id' => 'int(11) DEFAULT NULL',
            'create_time' => 'datetime DEFAULT NULL',
            'create_user_id' => 'int(11) DEFAULT NULL',
            'update_time' => 'datetime DEFAULT NULL',
            'update_user_id' => 'int(11) DEFAULT NULL',
                ), 'ENGINE=InnoDB');

        //Create the user table            
        $this->createTable('tbl_user', array(
            'id' => 'pk',
            'username' => 'string NOT NULL',
            'email' => 'string NOT NULL',
            'password' => 'string NOT NULL',
            'last_login_time' => 'datetime DEFAULT NULL',
            'create_time' => 'datetime DEFAULT NULL',
            'create_user_id' => 'int(11) DEFAULT NULL',
            'update_time' => 'datetime DEFAULT NULL',
            'update_user_id' => 'int(11) DEFAULT NULL',
                ), 'ENGINE=InnoDB');

        //Create the assignment table that allows many to many relationship between projects and users
        $this->createTable('tbl_project_user_assignment', array(
            'project_id' => 'int(11) NOT NULL',
            'user_id' => 'int(11) NOT NULL',
            'PRIMARY KEY(project_id,user_id)',
                ), 'ENGINE=InnoDB');
        
        //Foreign key relationships
        //the tbl_issue.project_id is a reference to tbl_project.id
        $this->addForeignKey("fk_issue_project","tbl_issue","project_id","tbl_project","id","CASCADE","RESTRICT");
        
        //the tbl_issue.owner_id is a referance to tbl_user.id
        $this->addForeignKey("fk_issue_owner","tbl_issue","owner_id","tbl_user","id","CASCADE","RESTRICT");
        
        //the tbl_issue.requester_id is a referance to tbl_user.id
        $this->addForeignKey("fk_issue_requester","tbl_issue","requester_id","tbl_user","id","CASCADE","RESTRICT");

        //the tbl_project_user_assignment.project_id is a referance to tbl_project.id
        $this->addForeignKey("fk_project_user","tbl_project_user_assignment","project_id","tbl_project","id","CASCADE","RESTRICT");
        
        //the tbl_project_user_assignment.user_id is a referance to tbl_user.id
        $this->addForeignKey("fk_user_project","tbl_project_user_assignment","user_id","tbl_user","id","CASCADE","RESTRICT");
    }

    public function down() {
//		echo "m130705_040829_create_issue_and_assignment_tables does not support migration down.\n";
//		return false;
        $this->truncateTable('tbl_project_user_assignment');
        $this->truncateTable('tbl_issue');
        $this->truncateTable('tbl_user');
        $this->dropTable('tbl_project_user_assignment');
        $this->dropTable('tbl_issue');
        $this->dropTable('tbl_user');
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