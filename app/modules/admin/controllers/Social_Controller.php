<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Social.php';

Class Social_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Social=new Social;
		}

        function indexAction() {
        	$this->sociallist=$this->Social->getSocialList();
        	$this->content =$this->view->AddView('social', $this);
			$this->view->renderLayout('admin', $this);
		}
		function socialinnerAction() {
        	$this->social=$this->Social->getSocialInner($this->registry->rewrites[1]);
        	$this->content =$this->view->AddView('socialinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatesocialinnerAction(){
			$this->Social->updateSocialInner($_POST,$_FILES);
			$this->registry->get->redirect('/admin/social/');
		}
}


?>