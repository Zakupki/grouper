<?php

require_once 'modules/base/controllers/BaseClub_Controller.php';
require_once 'modules/club/models/Gallery.php';
require_once 'modules/club/models/Social.php';
require_once 'modules/club/models/Reccount.php';
require_once 'modules/club/widgets/Widget.php';

Class Gallery_Controller Extends BaseClub_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Gallery=new Gallery;
			$this->Social = new Social;
			$this->Reccount=new Reccount($this->registry);
			$this->sitedata=$this->Reccount->getSiteData();
			$this->socialblock=$this->Social->getSiteSocial();
			$this->banner=$this->Design->getBanner();
			$this->mainmenudata=$this->Menu->getMenuItems();
			$this->pagename=$this->Menu->pagetitle;
        	$this->mainmenu=$this->mainmenudata['html'];
			}

        function indexAction() {
				$this->cache=cache::init();
				
				$this->gallerydata=$this->cache->get($_SESSION['Site']['id'].'club/gallary/index');
				if(!$this->gallerydata){
					$this->gallerydata=$this->Gallery->getGalleryType(0,100);
					$this->cache->set($_SESSION['Site']['id'].'club/gallary/index', $this->gallerydata,false,60*20);
				}
				
				
				$this->gallery=$this->gallerydata['gallery'];
				$this->comments=$this->gallerydata['comments'];
				$this->rate=$this->gallerydata['rate'];
				$this->Widget=new Widget($this->registry,$this->mainmenu,0);
				$this->teaser=$this->Widget->teaser(true);
				foreach($this->mainmenudata['data'] as $key=>$widget){
					if($widget['allwidget'] && $widget['active'] && $widget['code']!='gallery'){
						$method=$widget['code'];
						$this->widgets.=$this->Widget->$method($widget['name'],$key);
					}
				}
				$this->sitetitle=$this->pagename.'. '.$this->sitetitle;
				$this->sitedescription=$this->pagename.'. '.$this->sitedescription;
				$this->content =$this->view->AddView('gallery', $this);
				$this->view->renderLayout('layout', $this);
	    }
		function galleryinnerAction() {
				$this->galleryinner=$this->Gallery->getGalleryInner($this->registry->rewrites[1]);
				$this->Widget=new Widget($this->registry,$this->mainmenu,0);
				$this->teaser=$this->Widget->teaser(true);
				foreach($this->mainmenudata['data'] as $key=>$widget){
					if($widget['allwidget'] && $widget['active'] && $widget['code']!='gallery'){
						$method=$widget['code'];
						$this->widgets.=$this->Widget->$method($widget['name'],$key);
					}
				}
				$this->sitetitle='Фото '.$this->galleryinner[0]['name'].'. '.$this->sitetitle;
				$this->sitedescription='Фото с вечеринки '.$this->galleryinner[0]['name'].'. '.$this->sitedescription;
				
				$this->content =$this->view->AddView('galleryinner', $this);
				$this->view->renderLayout('layout', $this);
	    }


}


?>