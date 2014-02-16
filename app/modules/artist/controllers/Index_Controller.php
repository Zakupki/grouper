<?php

require_once 'modules/base/controllers/BaseArtist_Controller.php';
require_once 'modules/artist/models/Design.php';
require_once 'modules/artist/models/Social.php';
require_once 'modules/artist/models/Tracklist.php';

Class Index_Controller Extends BaseArtist_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Social = new Social;
			$this->Tracklist = new Tracklist;
		}

        function indexAction() {
        	    $db=db::init();
				$this->token=$this->registry->token->writeToken(5);
				$row=$db->queryFetchRow('SELECT * FROM z_site WHERE  z_site.id='.intval($this->registry->siteid).'');
				$this->title=$row['name'];
				$this->pagetitle='Главная';
				$this->content =$this->view->AddView('index', $this);
				if(tools::IsAjaxRequest())
					
					$this->view->renderLayout('blank', $this);
				else{
					$this->favicon=$this->Design->getFavicon();
					$this->color=$this->Design->getSitecolor();
					$this->twitter=$this->Social->getTwitter();
					$this->socialblock=$this->Social->getSiteSocial();
					$this->playertracks=$this->Tracklist->getTracklist($this->registry->siteid);
					$this->pagebg=$this->Design->getPagebg($this->registry->controller);
					$this->logo=$this->Design->getSiteLogo($this->registry->siteid);
					$this->mainmenu=$this->Menu->getMenuItems();
					$this->view->renderLayout('layout', $this);
				}
				
        }
		function testAction(){
			require_once 'modules/artist/models/File.php';
			$this->File=new File;
			$youtubedata=$this->File->getYoutubechanel('http://www.youtube.com/user/tishukraine');
			tools::print_r($youtubedata);
		}
		function unactiveAction() {
			$this->content =$this->view->AddView('unactive', $this);
			$this->view->renderLayout('unactive', $this);			
		}


}


?>