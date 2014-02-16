<?php
require_once 'modules/base/controllers/BaseArtist_Controller.php';
require_once 'modules/artist/models/Tracklist.php';

Class Facebook_Controller Extends BaseArtist_Controller {
		
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->registry->token=new token;
			$this->view = new View($this->registry);
		}

        function indexAction() {
        		$this->Tracklist = new Tracklist;
				$this->playertracks=$this->Tracklist->getTracklist($this->registry->siteid);
        		$this->pagetitle=$this->Menu->getPageTitle();
        		$this->pagebg=$this->Design->getPagebg($this->registry->controller);
				$this->logo=$this->Design->getSiteLogo($this->registry->siteid);
				$this->color=$this->Design->getSitecolor();
        		$this->content=$this->view->AddView('facebook', $this);
				$this->view->renderLayout('facebook', $this);
		}
}


?>