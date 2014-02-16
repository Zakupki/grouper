<?php

require_once 'modules/base/controllers/BaseArtist_Controller.php';
require_once 'modules/artist/models/Social.php';
require_once 'modules/artist/models/Gallery.php';
require_once 'modules/artist/models/Tracklist.php';

Class Gallery_Controller Extends BaseArtist_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->token=$this->registry->token->writeToken(5);
			$this->Social= new Social;
			$this->Gallery = new Gallery;
			$this->Tracklist = new Tracklist;
		}

        function indexAction() {
				$db=db::init();
				$this->gallerytype=$this->Gallery->getGalleryType($this->registry->siteid);
				$this->pagetitle=$this->Menu->getPageTitle();
				$this->content =$this->view->AddView('gallery', $this);
				if(tools::IsAjaxRequest())
					$this->view->renderLayout('blank', $this);
				else{
					$this->color=$this->Design->getSitecolor();
					$this->favicon=$this->Design->getFavicon();
					$this->twitter=$this->Social->getTwitter();
					$this->mainmenu=$this->Menu->getMenuItems();
					$this->socialblock= $this->Social->getSiteSocial();
					$this->playertracks=$this->Tracklist->getTracklist($this->registry->siteid);
					$this->pagebg=$this->Design->getPagebg($this->registry->controller);
					$this->logo=$this->Design->getSiteLogo($this->registry->siteid);
					$this->view->renderLayout('layout', $this);
				}
				
        }
		function galleryinnerAction() {
				$db=db::init();
				$this->gallerycnt=$this->Gallery->getGalleryTypeNum($this->registry->siteid);
				$this->gallery=$this->Gallery->getGalleryInner($this->registry->rewrites[1],$this->registry->siteid);
				$this->gallerytitle=$this->gallery[0]['name'];
				$this->pagetitle=$this->Menu->getPageTitle();				
			$this->content =$this->view->AddView('galleryinner', $this);
			if(tools::IsAjaxRequest())
				$this->view->renderLayout('blank', $this);
			else{
				$this->color=$this->Design->getSitecolor();
				$this->favicon=$this->Design->getFavicon();
				$this->twitter=$this->Social->getTwitter();
				$this->mainmenu=$this->Menu->getMenuItems();
				$this->socialblock= $this->Social->getSiteSocial();
				$this->playertracks=$this->Tracklist->getTracklist($this->registry->siteid);
				$this->pagebg=$this->Design->getPagebg($this->registry->controller);
				$this->logo=$this->Design->getSiteLogo($this->registry->siteid);
				$this->view->renderLayout('layout', $this);
			}
		}


}


?>