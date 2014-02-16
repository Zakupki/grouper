<?php

require_once 'modules/base/controllers/Base_Controller.php';

Class Orange_Controller Extends Base_Controller {
		private $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
		}

        function indexAction() {
				$this->content ='orange';
				$this->view->renderLayout('layout', $this);
				
        }
		
		function tvAction() {
				$this->content='tv';
				$this->view->renderLayout('layout', $this);
		}
		


}


?>