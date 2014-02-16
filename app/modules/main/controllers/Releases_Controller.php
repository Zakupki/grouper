<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/Release.php';
require_once 'modules/main/models/Users.php';
require_once 'modules/main/models/Comments.php';
require_once 'modules/main/models/News.php';

Class Releases_Controller Extends Base_Controller {
		public $registry;
		public $error;
		public $language=2;
		private $take=16;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->registry->token=new token;
			$this->view = new View($this->registry);
			$this->Release = new Release;
			$this->News = new News;
			$this->newsline=$this->News->getNewsLine();
			$this->newslineblock=$this->view->AddView('blocks/newslineblock', $this);
			$this->messageum=$this->registry->user->getMessages($this->Session->User['id']);
			
		}

        function indexAction() {
        		$this->Users=new Users;
				if(!$this->Session->User['id'])
        		$this->token=$this->registry->token->getToken();
				if(!$this->registry->routername || $this->registry->routername=='index' || $this->registry->routername=='releasetype2'){
				$reltype=1;
				$this->newitemnum=$this->Users->getUnseen(6);
				}else{
					$latesturl='/latest';
					$this->Users->pageVisit(6);
				}
				
				
				$this->userid=$this->Session->User['id'];
				$this->releasecount=$this->Release->getReleaseCount($reltype);
				
				$this->Pageing = new Pageing('releases'.$latesturl, $this->take, $this->releasecount, $this->registry->rewrites[1]);
				$this->pager=$this->Pageing->GetHTML();
				$this->releasetype=$this->Release->getLatestRelease($this->Pageing->getStart(), $this->take, $reltype);
				$this->submenu=$this->view->AddView('blocks/releasesubm', $this);
				$this->content=$this->view->AddView('releases', $this);
				$this->view->renderLayout('layout', $this);
				
				
        }
		function releaseinnerAction() {
				$this->Comments=new Comments;
				$this->userid=$this->Session->User['id'];
				$this->token=$this->registry->token->getToken();
				$this->releasetype=$this->Release->getSingleRelease($this->registry->rewrites[1]);
				$this->releaselinks=$this->Release->getReleaseLinks($this->registry->rewrites[1]);
				$this->releasetracks=$this->Release->getReleaseTracks($this->registry->rewrites[1]);
				$this->incuts=$this->Comments->getIncuts($this->releasetype['itemid']);
				$this->newslist=$this->News->getLatestNews(0, 3, 1);
				$this->popularnews=$this->view->AddView('popularnewsblock', $this);
				$this->submenu=$this->view->AddView('blocks/releasesubm', $this);
				$this->sharehost='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				if(strlen(trim($this->releasetype['pressrelease']))>0)
				$this->sharetitle=$this->releasetype['pressrelease'];
				else
				$this->sharetitle=$this->releasetype['author'].' - '.$this->releasetype['name'];
				if(strlen($this->releasetype['preview_text'])>0)
				$this->sharedesc=strip_tags(str_replace('"','',$this->releasetype['preview_text']));
				$this->shareimage2='http://'.$_SERVER['HTTP_HOST'].$this->releasetype['url'];
				$this->content=$this->view->AddView('releasesinner', $this);
				$this->view->renderLayout('layout', $this);
		}
}


?>