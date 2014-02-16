<?php

require_once 'modules/base/controllers/Base_Controller.php';

Class BaseAdmin_Controller Extends Base_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			if(!$this->Session->User['id'] && $this->Session->User['usertypeid']!=1 && trim($_SERVER['REQUEST_URI'], ' /')!='admin/login' && trim($_SERVER['REQUEST_URI'], ' /')!='admin/logout')
				$this->registry->get->redirect('/admin/login/');
			if($this->registry->action!='login' && $this->registry->action!='logout' && $this->Session->User['usertypeid']!=1)
			$this->registry->get->redirect('/admin/login/');
		}
		function indexAction(){
			
		}

}


?>