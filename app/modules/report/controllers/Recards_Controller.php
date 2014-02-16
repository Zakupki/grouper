<?
require_once 'modules/base/controllers/BaseReport_Controller.php';
require_once 'modules/report/models/Club.php';
require_once 'modules/report/models/Recard.php';

Class Recards_Controller Extends BaseReport_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			if(!$_SESSION['User']['id'])
			$this->registry->get->redirect('/');
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Recard=new Recard;
		}

        function indexAction() {
        	$this->Club=new Club;
			$this->clubsnum=$this->Club->getClubscount();
			$this->clubsfav=$this->Club->getClubsfav();			
			$this->recards=$this->Recard->getRecardRequests();
			$this->content=$this->view->AddView('recards', $this);
			$this->view->renderLayout('layout', $this);
		}
		function recardinnerAction() {
			$this->Club=new Club;
			$this->clubsnum=$this->Club->getClubscount();
			$this->clubsfav=$this->Club->getClubsfav();
			$this->recardinner=$this->Recard->getRecardRequestInner($this->registry->rewrites[1]);
			$this->Recard->visitRecard($this->registry->rewrites[1]);
			$this->content=$this->view->AddView('recardinner', $this);
			$this->view->renderLayout('layout', $this);
		}
		function getrecardAction() {
			$this->Club=new Club;
			$this->clubsnum=$this->Club->getClubscount();
			$this->clubsfav=$this->Club->getClubsfav();
			$this->recardinner=$this->Recard->getRecardRequest($_GET['id']);
        	$this->content=$this->view->AddView('popups/getrecard', $this);
			$this->view->renderLayout('blank', $this);
		}
		function updaterecardAction() {
        	$this->Recard->updateRecardRequest($_REQUEST,$_FILES);
		}
		/* function getmoreAction() {
        	$this->Club=new Club;
			$this->clubs=$this->Club->getClubs(tools::int($_GET['start']),tools::int($_GET['take']),$_GET);
			$this->content=$this->view->AddView('moreclubs', $this);
			$this->view->renderLayout('blank', $this);
		}*/
		
}
?>