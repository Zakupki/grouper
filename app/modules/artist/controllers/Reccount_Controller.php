<?php

require_once 'modules/base/controllers/BaseArtistAdmin_Controller.php';
require_once 'modules/artist/models/Social.php';
require_once 'modules/artist/models/Reccount.php';
require_once 'modules/artist/models/Design.php';
require_once 'modules/artist/models/Tracklist.php';

Class Reccount_Controller Extends BaseArtistAdmin_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			if(!$this->Session->User['id'])
			$this->registry->get->redirect('/');
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->mainmenu=$this->Menu->getAdminMenuItems();
			$this->Social=new Social();
			$this->Design=new Design();
			$this->favicon=$this->Design->getFavicon();
			if(!tools::IsAjaxRequest())
			$this->color=$this->Design->getSitecolor();
			}

        function indexAction() {
				$this->registry->get->redirect('/reccount/menu/');
				$this->content =$this->view->AddView('index', $this);
				$this->view->renderLayout('layout', $this);
				
				
        }
		/*function languagesAction() {
			//$this->print_r($this->Lang->getSiteAdminLanguages($this->Session->siteid));
			$this->token=$this->registry->token->getToken();
			$this->languages=json_encode(array('token'=>$this->token, 'langlist'=>$this->Lang->getSiteAdminLanguages($_SESSION['Site']['id'])));
			$this->reccountmenu =$this->view->AddView('adminreccountmenu', $this);
			$this->content =$this->view->AddView('adminlanguages', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatelanguageAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
			$this->Lang->updateLanguages($data['langlist']);
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'langlist'=>$this->Lang->getSiteAdminLanguages($_SESSION['Site']['id'])));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'errorid'=>1, 'errormessage'=>'Токен устарел'));
		}
		*/
		function titleAction(){
			$this->token=$this->registry->token->getToken();
			$this->Reccount= new Reccount;
			$this->title=tools::toJSON(array('token'=>$this->token, 'title'=>$this->Reccount->getTitle($_SESSION['Site']['id'])));
			$this->reccountmenu =$this->view->AddView('adminreccountmenu', $this);
			$this->content =$this->view->AddView('admintitle', $this);
			$this->view->renderLayout('admin', $this);
		} 
		function updatetitleAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			$this->Reccount= new Reccount;
			if ($this->registry->token->checkToken($data['token'])){
			$this->Reccount->updateTitle($data);
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'title'=>$this->Reccount->getTitle($_SESSION['Site']['id'])));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'title'=>$this->Reccount->getTitle($_SESSION['Site']['id'])));
		}
		
		function findsocialAction() {
			echo stripcslashes(json_encode($this->Social->findSocial($_POST['url'])));	
		}
		function updatesocialAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
			$this->Social->updateSocialList($data);
			echo stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'sociallist'=>$this->Social->getUserSocial($_SESSION['Site']['id']), 'socialmode'=>$this->Social->getSocialMode($_SESSION['Site']['id']))));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'errorid'=>1, 'errormessage'=>'Токен устарел'));
		}
		function menuAction() {
			$this->menulist=tools::toJSON(array('token'=>$this->registry->token->getToken(), 'menulist'=>$this->Menu->getAdminMenuAll()));
			$this->reccountmenu =$this->view->AddView('adminreccountmenu', $this);
			$this->content =$this->view->AddView('adminmenu', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatemenuAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->Menu->updateMenu($data['menulist']);
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'menulist'=>$this->Menu->getAdminMenuAll()));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'errorid'=>1, 'errormessage'=>'Токен устарел'));
		}
		function linksAction() {
			$this->sociallist=stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'sociallist'=>$this->Social->getUserSocial($_SESSION['Site']['id']), 'socialmode'=>$this->Social->getSocialMode($_SESSION['Site']['id']))));
			$this->reccountmenu =$this->view->AddView('adminreccountmenu', $this);
			$this->content =$this->view->AddView('adminlinks', $this);
			$this->view->renderLayout('admin', $this);
		}
		function urlAction() {
			$this->Reccount=new Reccount;
			$this->ip='89.184.69.200';
			$this->url=json_encode(array('token'=>$this->registry->token->getToken(), 'domainlist'=>$this->Reccount->getDomains()));
			$this->reccountmenu =$this->view->AddView('adminreccountmenu', $this);
			$this->content =$this->view->AddView('adminurl', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateurlAction() {
			$this->Reccount=new Reccount;
		 	$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
			$this->Reccount->updateDomain($data['domainlist']);
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'domainlist'=>$this->Reccount->getDomains()));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'errorid'=>1, 'errormessage'=>'Токен устарел'));
		}
		function tracklistAction() {
			$this->Tracklist= new Tracklist;
			$this->tracks=tools::toJSON(array('token'=>$this->registry->token->getToken(), 'autoplay'=>$this->Tracklist->getAutoplay(), 'tracks'=>$this->Tracklist->getAdminTracklist()));
			
			$this->reccountmenu =$this->view->AddView('adminreccountmenu', $this);
			$this->content =$this->view->AddView('admintracklist', $this);
			$this->view->renderLayout('admin', $this);
		}
			
		function updatetracklistAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			$this->Tracklist= new Tracklist;
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->Tracklist->updateTracklist($data['tracks'], $data['deleted'], $data['autoplay']);
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'autoplay'=>$this->Tracklist->getAutoplay(), 'tracks'=>$this->Tracklist->getAdminTracklist()));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'autoplay'=>$this->Tracklist->getAutoplay(), 'tracks'=>$this->Tracklist->getAdminTracklist()));
			}	
        }
		function sitestatusAction() {
			$this->Reccount=new Reccount;
			echo $this->Reccount->getSiteStatus($this->registry->siteid);
		}
		function setsitestatusAction() {
			$this->Reccount=new Reccount;
			$this->Reccount->setSiteStatus($this->registry->siteid, $_POST['data']);
		}
		function synchroAction(){
			$this->Tracklist = new Tracklist;
			$this->tracknum=count($this->Tracklist->getTracklist($this->registry->siteid));
			$this->content =$this->view->AddView('synchro', $this);
			$this->view->renderLayout('admin', $this);
		}


}


?>