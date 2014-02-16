<?php

require_once 'modules/base/controllers/Base_Controller.php';

Class Account_Controller Extends Base_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->token=$this->registry->token->writeToken(5);
		}

        function indexAction() {
				
				$db=db::init();
				$row=$db->queryFetchRow('SELECT * FROM z_site WHERE  z_site.id='.intval($this->registry->siteid).'');
				
				if($_SESSION['USER']['id'])
				echo 123;
				
				$this->title=$row['name'];
				$this->content =$this->view->AddView('index', $this);
				$this->view->renderLayout('layout', $this);
				
				
        }
		function test() {
			echo 'testAction';
		}


}


?>