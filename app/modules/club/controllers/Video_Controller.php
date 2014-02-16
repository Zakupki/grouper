<?php

require_once 'modules/base/controllers/BaseClub_Controller.php';
require_once 'modules/club/models/Video.php';
require_once 'modules/club/models/Reccount.php';
require_once 'modules/club/widgets/Widget.php';

Class Video_Controller Extends BaseClub_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Video=new Video;
			$this->Reccount=new Reccount($this->registry);
			$this->sitedata=$this->Reccount->getSiteData();
			$this->socialblock=$this->Social->getSiteSocial();
			$this->banner=$this->Design->getBanner();
			$this->mainmenudata=$this->Menu->getMenuItems();
			$this->pagename=$this->Menu->pagetitle;
        	$this->mainmenu=$this->mainmenudata['html'];
			}

        function indexAction() {
        		$this->Widget=new Widget($this->registry,$this->mainmenu,0);
				$this->teaser=$this->Widget->teaser(true);
        		$this->videodata=$this->Video->getVideoList();
				$this->video=$this->videodata['videos'];
				$this->comments=$this->videodata['comments'];
				$this->rate=$this->videodata['rate'];
				$this->sitetitle=$this->pagename.'. '.$this->sitetitle;
				$this->sitedescription=$this->pagename.'. '.$this->sitedescription;
				$this->content =$this->view->AddView('video', $this);
				$this->view->renderLayout('layout', $this);
	    }
		function videoinnerAction() {
				$this->videoinner=$this->Video->getVideoInner($this->registry->rewrites[1]);
				
				$this->sitetitle=$this->videoinner['name'].'. Видеотчеты о вечеринках - '.$this->sitetitle;
				$this->sitedescription='Вечеринка '.$this->videoinner['name'].'. '.$this->sitedescription;
				
				
				$this->content =$this->view->AddView('videoinner', $this);
				$this->view->renderLayout('layout', $this);
	    }


}


?>