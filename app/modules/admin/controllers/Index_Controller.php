<?php

require_once 'modules/admin/controllers/BaseAdmin_Controller.php';

Class Index_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
		}

        function indexAction() {
				$db=db::init();
				$row=$db->queryFetchRow('SELECT * FROM z_site WHERE  z_site.id='.intval($this->registry->siteid).'');
				$this->title=$row['name'];
				$this->content ='';
				$this->view->renderLayout('admin', $this);
				
        }
		function loginAction() {
				if($this->Session->User['id']>0 && $this->Session->User['usertypeid']==1)
					$this->registry->get->redirect('/admin/');
				
				if ($_SERVER["REQUEST_METHOD"]=="POST") {
					if ($this->registry->token->checkToken()) {
						
						$userData=$this->registry->user->loginAdmin($this->Post->email, $this->Post->password);
						if($userData){
							$_SESSION['User']=$userData;
							$this->registry->get->redirect('/admin/');
							die();
						}
						else
						$this->error['email']="Не корректный email/пароль";
					}
					else{
					$this->error['email']="Не корректный email/пароль";
					}
				}
				
				$this->token=$this->registry->token->writeToken();
				$this->content =$this->view->AddView('loginform', $this);
				$this->view->renderLayout('login', $this);
				
        }
		
		function logoutAction() {
				$this->Session->User=null;
				$this->registry->get->redirect('/admin/login/');	
        }
		function listAction() {
				
				$this->content =$this->view->AddView('list', $this);
				$this->view->renderLayout('admin', $this);
				
        }
	

}


?>