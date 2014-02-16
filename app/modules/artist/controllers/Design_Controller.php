<?php
require_once 'modules/base/controllers/BaseArtistAdmin_Controller.php';
require_once 'modules/artist/models/Design.php';

Class Design_Controller Extends BaseArtistAdmin_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			if(!$this->Session->User['id'])
			$this->registry->get->redirect('/');
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->mainmenu=$this->Menu->getAdminMenuItems();
			$this->Design=new Design;
			$this->favicon=$this->Design->getFavicon();
			if(!tools::IsAjaxRequest())
			$this->color=$this->Design->getSitecolor();
			}

        function indexAction() {
				$this->registry->get->redirect('/design/background/');
				$this->content =$this->view->AddView('index', $this);
				$this->view->renderLayout('layout', $this);
				
				
        }
		function logoAction() {
			$this->logo=stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'logo'=>$this->Design->getLogo())));
			$this->pagebg=$this->Design->getPagebg();
			$this->reccountmenu =$this->view->AddView('admindesignmenu', $this);
			$this->content =$this->view->AddView('adminlogo', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatelogoAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
			$this->Design->updateLogo($data['logo'],$data['deleted']);
			echo stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'logo'=>$this->Design->getLogo())));
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'errorid'=>1, 'errormessage'=>'Токен устарел'));	
			}
		}
		function backgroundAction() {
			$this->menu=$this->Menu->getAdminMenuItems();
			$this->background=stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(1), 'action'=>1, 'background'=>$this->Design->getBackground())));
			$this->reccountmenu =$this->view->AddView('admindesignmenu', $this);
			$this->content =$this->view->AddView('adminbackground', $this);
			$this->view->renderLayout('admin', $this);
		}
		function menubgAction(){
			if($_POST['id']>0){
			echo json_encode(array('token'=>$this->registry->token->getToken(2), 'action'=>2, 'menubg'=>$this->Design->getMenuIds($_POST['id'])));
			}
		}
		function updatebackgroundAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'], 1)){
				$this->Design->updateBackground($data['background'], $data['deleted'], $data['menuid']);
			echo stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(1), 'action'=>1, 'background'=>$this->Design->getBackground())));
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(1), 'errorid'=>1, 'errormessage'=>'Сессия устарела. Повторите действие.'));	
			}
		}
		function updatebackgroundinnerAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'], 2)){
				$this->Design->updateBackgroundinner($data['menubg'], $data['deleted']);
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(2), 'errorid'=>2, 'errormessage'=>'Сессия устарела. Повторите действие.'));	
			}
		}
		function colorAction() {
			$this->colorcode=stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'color'=>$this->Design->getSitecolor())));
			$this->reccountmenu =$this->view->AddView('admindesignmenu', $this);
			$this->content =$this->view->AddView('admincolor', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatecolorAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
			$this->Design->updateSitecolor($data['color']);
			echo stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'color'=>$this->Design->getSitecolor())));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'errorid'=>1, 'errormessage'=>'Токен устарел'));
		}
		function previewAction() {
			$this->preview=stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'preview'=>$this->Design->getVideopreview())));
			$this->reccountmenu =$this->view->AddView('admindesignmenu', $this);
			$this->content =$this->view->AddView('adminpreview', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatepreviewAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
			$this->Design->updateVideopreview($data['preview'], $data['deleted']);
			echo stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'preview'=>$this->Design->getVideopreview())));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'errorid'=>1, 'errormessage'=>'Токен устарел'));
		}
		function coverAction() {
			$this->cover=stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'cover'=>$this->Design->getCover())));
			$this->reccountmenu =$this->view->AddView('admindesignmenu', $this);
			$this->content =$this->view->AddView('admincover', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatecoverAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
			$this->Design->updateCover($data['cover'], $data['deleted']);
			echo stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'cover'=>$this->Design->getCover())));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'errorid'=>1, 'errormessage'=>'Токен устарел'));
		}
		
		function faviconAction() {
			$this->fav=stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'favicon'=>$this->Design->getFavicon())));
			$this->reccountmenu =$this->view->AddView('admindesignmenu', $this);
			$this->content =$this->view->AddView('adminfavicon', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatefaviconAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
			$this->Design->updateFavicon($data['favicon'], $data['deleted']);
			echo stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'favicon'=>$this->Design->getFavicon())));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'errorid'=>1, 'errormessage'=>'Токен устарел'));
		}		
}


?>