<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Cards.php';

Class Recards_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Cards=new Cards;
		}

        function indexAction() {
        	$this->cardlist=$this->Cards->getRecardList();
        	$this->content =$this->view->AddView('recards', $this);
			$this->view->renderLayout('admin', $this);
		}
		
		function recardinnerAction() {
			$this->cardinner=$this->Cards->getRecardInner($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('recardinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updaterecardinnerAction(){
			$this->Cards->updateRecardInner($_POST,$_FILES);
			$this->registry->get->redirect('/admin/recards/');
		}
		function clubscardsAction(){
			$this->cardlist=$this->Cards->getCardList($this->registry->rewrites[1]);
        	$this->content =$this->view->AddView('cards', $this);
			$this->view->renderLayout('admin', $this);
		}
		function clubscardinnerAction() {
			$this->cardinner=$this->Cards->getCardInner($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('cardinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateclubscardinnerAction(){
			$this->Cards->updateCardInner($_POST,$_FILES);
			$this->registry->get->redirect('/admin/recards/'.tools::int($_POST['recardid']).'/');
		}
		function updatecardlistAction(){
			$this->Cards->updateCardList($_POST);
			$this->registry->get->redirect('/admin/recards/'.tools::int($_POST['pageid']).'/');
		}
}


?>