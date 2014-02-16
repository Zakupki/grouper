<?php
require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/reparty/models/Event.php';

Class Events_Controller Extends Base_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Event=new Event;
		}

        function indexAction() {
        	$this->token=$this->registry->token->getToken();
        	$this->events=$this->Event->getEvents();
			$this->content=$this->view->AddView('events', $this);
			$this->view->renderLayout('layout', $this);
        }
		function eventinnerAction(){
			$this->eventinner=$this->Event->getEventInner($this->registry->rewrites[1]);
			$this->content=$this->view->AddView('eventinner', $this);
			$this->view->renderLayout('layout', $this);
		}
		
}
?>