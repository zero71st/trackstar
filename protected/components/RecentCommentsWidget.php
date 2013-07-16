<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecentCommentsWidget
 *
 * @author Mis02
 */
class RecentCommentsWidget extends CWidget {

    //put your code here
    private $_comments;
    public $displayLimit = 5;
    public $projectId = null;

    // overide mothod
    public function init() {
        if (null !== $this->projectId)
        // eager loading
            $this->_comments = Comment::model()->with(array('issue' => array('condition' => 'project_id=' . $this->projectId)))->recent()->$this->displayLimit->findAll();
        else
        // lazy loading
            $this->_comments = Comment::model()->recent($this->displayLimit)->findAll();
    }

    public function getData() {
        return $this->_comments;
    }

    //overide method
    public function run() {
        // this method is called by CController::EndWidget()
        $this->render('recentCommentsWidget');
    }

}

?>
