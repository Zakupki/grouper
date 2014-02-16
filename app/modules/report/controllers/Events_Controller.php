<?
require_once 'modules/base/controllers/BaseReport_Controller.php';
require_once 'modules/report/models/Club.php';
require_once 'modules/report/models/Event.php';

Class Events_Controller Extends BaseReport_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			if(!$_SESSION['User']['id'])
			$this->registry->get->redirect('/');
			$this->view = new View($this->registry);
			$this->registry->token=new token;
		}

        function indexAction() {
        	$this->Club=new Club;
			$this->clubsnum=$this->Club->getClubscount();
			$this->clubsfav=$this->Club->getClubsfav();
			$this->Event=new Event;
			$this->events=$this->Event->getEventRequests();
			$this->content=$this->view->AddView('events', $this);
			$this->view->renderLayout('layout', $this);
		}
		function eventinnerAction() {
        	$this->Club=new Club;
			$this->clubsnum=$this->Club->getClubscount();
			$this->clubsfav=$this->Club->getClubsfav();
			$this->Event=new Event;
			$this->eventinner=$this->Event->getEventRequestInner($this->registry->rewrites[1]);
			$this->Event->visitEvent($this->registry->rewrites[1]);
			$this->content=$this->view->AddView('eventinner', $this);
			$this->view->renderLayout('layout', $this);
		}
		function geteventAction() {
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
			$this->Club=new Club;
			$this->clubsnum=$this->Club->getClubscount();
			$this->clubsfav=$this->Club->getClubsfav();
        	$this->Event=new Event;
			$this->eventinner=$this->Event->getEventRequest($_GET['id']);
			$this->content=$this->view->AddView('popups/getevent', $this);
			$this->view->renderLayout('blank', $this);
		}
		function geteventreportAction() {
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
			/*
			$this->Club=new Club;
						$this->clubsnum=$this->Club->getClubscount();
						$this->clubsfav=$this->Club->getClubsfav();
						$this->Event=new Event;
						$this->eventinner=$this->Event->getEventRequest($_GET['id']);*/
			$this->Event=new Event;
			$this->eventdata=$this->Event->getEventReport($_REQUEST['id']);
			$this->content=$this->view->AddView('popups/geteventreport', $this);
			$this->view->renderLayout('blank', $this);
		}
		function updateeventAction() {
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
			$this->Event=new Event;
        	$this->Event->updateEventRequest($_REQUEST,$_FILES);
		}
		/* function getmoreAction() {
        	$this->Club=new Club;
			$this->clubs=$this->Club->getClubs(tools::int($_GET['start']),tools::int($_GET['take']),$_GET);
			$this->content=$this->view->AddView('moreclubs', $this);
			$this->view->renderLayout('blank', $this);
		}*/
		
}
?>