<?php

require_once 'modules/base/controllers/BaseArtist_Controller.php';
require_once 'modules/artist/models/Design.php';
require_once 'modules/artist/models/Release.php';
require_once 'modules/artist/models/Tracklist.php';

Class Release_Controller Extends BaseArtist_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Release = new Release;
			$this->Social = new Social;
			$this->Tracklist = new Tracklist;
			
		}
		
		private function init(){
			$this->color=$this->Design->getSitecolor();
			$this->token=$this->registry->token->writeToken(5);
			$this->favicon=$this->Design->getFavicon();
			$this->twitter=$this->Social->getTwitter();
			$this->mainmenu=$this->Menu->getMenuItems();
			$this->socialblock= $this->Social->getSiteSocial();
			$this->playertracks=$this->Tracklist->getTracklist($this->registry->siteid);
			$this->pagebg=$this->Design->getPagebg($this->registry->controller);
			$this->logo=$this->Design->getSiteLogo($this->registry->siteid);
		}

        function indexAction() {
				$db=db::init();
				$this->releasetype=$this->Release->getReleaseType();
				$this->pagetitle=$this->Menu->getPageTitle();
				$this->content =$this->view->AddView('release', $this);
				
				if(tools::IsAjaxRequest())
					$this->view->renderLayout('blank', $this);
				else{
					self::init();
					$this->view->renderLayout('layout', $this);
				}
				
        }
		function releaseinnerAction() {
			    $db=db::init();
				$this->pagetitle=$this->Menu->getPageTitle();
				$this->cnt=$db->queryFetchRow("
				SELECT COUNT(DISTINCT z_releasetype.id) AS cnt 
				FROM
				  z_releasetype 
				  INNER JOIN
				  z_release 
				  ON z_release.releasetypeid = z_releasetype.id AND z_release.active=1
				WHERE z_releasetype.siteid = ".$this->registry->siteid." AND z_releasetype.active=1
				");
				$this->shops=$this->Release->getReleaseShops($this->registry->rewrites[1]);
				$releaseresult=$this->Release->getReleaseTypeInner($this->registry->rewrites[1], $this->registry->siteid);
				$this->releasetitle=$releaseresult[0]['title'];
				foreach($releaseresult as $data){
					$this->release[$data['id']]=$data;
					if($data['musictypename'])
					$this->releasemusic[$data['id']][]=$data['musictypename'];
				}
				usort($this->release, 'tools::sortDesc');
				
			$this->content =$this->view->AddView('releaseinner', $this);
			if(tools::IsAjaxRequest())
				$this->view->renderLayout('blank', $this);
			else{
				self::init();
				$this->view->renderLayout('layout', $this);
			}
		}


}


?>