<?php

require_once 'modules/base/controllers/BaseReport_Controller.php';
require_once 'modules/report/models/Event.php';
require_once 'modules/report/models/Club.php';
require_once 'modules/report/models/Request.php';

Class Ajax_Controller Extends BaseReport_Controller {
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
        	$this->Banners=new Banner;
			$this->bannerlist=$this->Banners->getBanners();
       		$this->Club=new Club;
			$this->clubsnum=$this->Club->getClubscount();
			$this->clubsfav=$this->Club->getClubsfav();
			$this->content=$this->view->AddView('banners', $this);
			$this->view->renderLayout('layout', $this);
		}
		function posterreplyAction() {
			$this->Event=new Event;
			$this->Event->applyPosterChange($_POST);
		}
	    function getunreadnoticesAction() {
	        $this->Request=new Request;
            echo $this->Request->unreadRequestNum();
        }
		
}?>