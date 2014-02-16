<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Users.php';

Class Balance_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
		}

        function indexAction() {
        	$this->Users=new Users;
			$this->balance=$this->Users->getUsersBalance();
        	$this->content =$this->view->AddView('balance', $this);
			$this->view->renderLayout('admin', $this);
		}
}


?>