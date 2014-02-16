<?php

require_once 'modules/admin/controllers/BaseAdmin_Controller.php';

Class Reccounts_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
		}

        function indexAction() {
				$this->content =$this->view->AddView('list', $this);
				$this->view->renderLayout('admin', $this);
		}
}


?>