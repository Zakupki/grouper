<?
require_once 'modules/base/controllers/BaseClubAdmin_Controller.php';
require_once 'modules/club/models/Design.php';

Class Design_Controller Extends BaseClubAdmin_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->registry->token=new token;
			$this->Design=new Design;
			}

        function indexAction() {
				$this->content =$this->view->AddView('admin', $this);
				$this->view->renderLayout('admin', $this);
	    }
}


?>