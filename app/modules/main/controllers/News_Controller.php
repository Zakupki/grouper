<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/News.php';
require_once 'modules/main/models/Users.php';
require_once 'modules/main/models/Comments.php';

Class News_Controller Extends Base_Controller {
		public $registry;
		public $error;
		public $language=2;
		private $take=10;
		private $page=1;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->registry->token=new token;
			$this->News=new News;
			$this->view = new View($this->registry);
			$this->newsline=$this->News->getNewsLine();
			$this->newslineblock=$this->view->AddView('blocks/newslineblock', $this);
			$this->messageum=$this->registry->user->getMessages($this->Session->User['id']);
			
		}

        function indexAction() {
				$this->userid=$this->Session->User['id'];
				$this->token=$this->registry->token->getToken();
				$this->Users=new Users;
				if(tools::int($this->registry->rewrites[1])>0)
				$this->page=tools::int($this->registry->rewrites[1]);
				if(!$this->registry->routername || $this->registry->routername=='index' || $this->registry->routername=='news2'){
					$newstype=1;
					$this->newitemnum=$this->Users->getUnseen(5);
				}
				else{
					$this->Users->pageVisit(5);
					$newstype=0;
					$latesturl='/latest';
				}
				if($_GET['tag'])
				$newstype=0;
				$this->newscount=$this->News->getNewsCount($newstype, $_GET['tag']);
				$this->Pageing = new Pageing('news'.$latesturl, $this->take, $this->newscount, $this->page);
				$this->pager=$this->Pageing->GetHTML();
				$this->newslist=$this->News->getLatestNews($this->Pageing->getStart(), $this->take, $newstype, $_GET['tag']);
				$this->submenu=$this->view->AddView('blocks/newssubm', $this);
				$this->content=$this->view->AddView('news', $this);
				$this->view->renderLayout('layout', $this);
				
        }
		function newsinnerAction() {
				$this->userid=$this->Session->User['id'];
				$this->token=$this->registry->token->getToken();
				$this->newsdata=$this->News->getSingleNews($this->registry->rewrites[1]);
				$this->innernews=$this->newsdata['news'];
				$this->images=$this->newsdata['images'];
				$this->tags=$this->newsdata['tags'];
				$this->tracks=$this->newsdata['tracks'];
				$this->popular=$this->News->getPopularNews($this->registry->rewrites[1]);
				$this->currentitem=$this->registry->rewrites[1];
				$this->Comments=new Comments;
				$this->incuts=$this->Comments->getIncuts($this->registry->rewrites[1]);
				$this->newslist=$this->News->getLatestNews(0, 3, 1);
				$this->popularnews=$this->view->AddView('popularnewsblock', $this);
				$this->submenu=$this->view->AddView('blocks/newssubm', $this);
				
				$this->sharehost='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				$this->sharetitle=$this->innernews['name'];
				if(strlen($this->innernews['preview_text'])>0)
				$this->sharedesc=strip_tags(str_replace('"','',$this->innernews['preview_text']));
				$this->shareimage2='http://'.$_SERVER['HTTP_HOST'].$this->innernews['socurl'];
				
				$this->content=$this->view->AddView('newsinner', $this);
				$this->view->renderLayout('layout', $this);
		}
}


?>