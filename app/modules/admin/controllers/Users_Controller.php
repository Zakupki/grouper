<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Users.php';

Class Users_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		private $take=50;
		private $page=1;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Users = new Users;
		}

        function indexAction() {
        	$this->usercount=$this->Users->getUserCount();
			if(tools::int($this->registry->rewrites[1])>0)
			$this->page=tools::int($this->registry->rewrites[1]);
        	$this->Pageing = new Pageing('admin/users', $this->take, $this->usercount, $this->page);
			$this->pager=$this->Pageing->GetAdminHTML();
        	$this->userlist=$this->Users->getUserList($this->Pageing->getStart(), $this->take);
			$this->content =$this->view->AddView('users', $this);
			$this->view->renderLayout('admin', $this);
		}
		function discountsAction() {
        	$this->userlist=$this->Users->getUserDiscounts();
			$this->content =$this->view->AddView('discounts', $this);
			$this->view->renderLayout('admin', $this);
		}
		function userinnerAction() {
			$this->userinner=$this->Users->getUserInner($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('userinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateuserinnerAction(){
			$this->Users->updateUserInner($_POST);
			$this->registry->get->redirect('/admin/users/');
		}
}


?>