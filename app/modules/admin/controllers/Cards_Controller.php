<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Cards.php';

Class Cards_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Cards=new Cards;
		}

        function indexAction() {
        	$this->cardlist=$this->Cards->getCardList();
        	$this->content =$this->view->AddView('cards', $this);
			$this->view->renderLayout('admin', $this);
		}
		
		function cardinnerAction() {
			$this->cardinner=$this->Cards->getCardInner($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('cardinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatecardinnerAction(){
			$this->Cards->updateCardInner($_POST);
			$this->registry->get->redirect('/admin/cards/');
		}
}


?>