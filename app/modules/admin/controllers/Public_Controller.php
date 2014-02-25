<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Publics.php';

Class Public_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		private $take=50;
		private $page=1;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Publics = new Publics;
		}

        function indexAction() {
        	$this->publiccount=$this->Publics->getPublicCount();
			if(tools::int($this->registry->rewrites[1])>0)
			$this->page=tools::int($this->registry->rewrites[1]);
        	$this->Pageing = new Pageing('admin/public', $this->take, $this->publiccount, $this->page);
			$this->pager=$this->Pageing->GetAdminHTML();
        	$this->publiclist=$this->Publics->getPublicList($this->Pageing->getStart(), $this->take);
			$this->content =$this->view->AddView('public', $this);
			$this->view->renderLayout('admin', $this);
		}
		function publicinnerAction() {
			$this->groups=$this->Publics->getPublicInner($this->registry->rewrites[1]);
            $this->content =$this->view->AddView('publicinner', $this);
			$this->view->renderLayout('admin', $this);
		}
}


?>