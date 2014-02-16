<?php

require_once 'modules/admin/controllers/BaseAdmin_Controller.php';

Class Edit_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
		}

        function indexAction() {
				$this->content ='edit';
				$this->view->renderLayout('admin', $this);
				
        }
		 function testAction() {
				$this->content ='test';
				$this->view->renderLayout('admin', $this);
				
        }
	

}


?>