<?php

require_once 'modules/base/controllers/BaseClub_Controller.php';
require_once 'modules/club/widgets/Widget.php';
require_once 'modules/club/models/Reccount.php';
require_once 'modules/club/models/Design.php';
require_once 'modules/club/models/Social.php';
require_once 'modules/club/models/Track.php';
require_once 'modules/club/models/Users.php';

Class User_Controller Extends BaseClub_Controller {
		private $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Reccount=new Reccount($this->registry);
			$this->Design=new Design();
			$this->Social=new Social();
			$this->Track=new Track();
			$this->sitedata=$this->Reccount->getSiteData();
			$this->socialblock=$this->Social->getSiteSocial();
			$this->banner=$this->Design->getBanner();
        	$this->mainmenudata=$this->Menu->getMenuItems();
			$this->pagename=$this->Menu->pagetitle;
        	$this->mainmenu=$this->mainmenudata['html'];
		}
		
		function indexAction(){
			
		}
		function userprofileAction() {
			$this->Users = new Users;
			$this->profile=$this->Users->getUserProfile($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('userprofile', $this);
			$this->view->renderLayout('layout', $this);
		}
		
		function profileAction() {
			if(!$this->Session->User['id'])
			$this->registry->get->redirect('/');
			/*$this->News=new News;
			$this->newsline=$this->News->getNewsLine();
			$this->newslineblock=$this->view->AddView('blocks/newslineblock', $this);
			$this->token=$this->registry->token->getToken();*/
			$this->Users = new Users;
			$this->profile=tools::toJSON(array('token'=>$this->registry->token->getToken(9),'user'=>$this->Users->getUserFullProfile($this->Session->User['id'])));
			$this->content =$this->view->AddView('editprofile', $this);
			$this->view->renderLayout('layout', $this);
		}
		function cardAction() {
			if(!$this->Session->User['id'])
			$this->registry->get->redirect('/');
			$this->Users = new Users;
			$this->card=tools::toJSON(array('card'=>$this->Users->getUserCard($this->Session->User['id'])));
			//tools::print_r($this->card);
			$this->content =$this->view->AddView('card', $this);
			$this->view->renderLayout('layout', $this);
		}
		function applycardAction(){
			if(!$this->Session->User['id'])
			$this->registry->get->redirect('/');
			$data = json_decode(stripcslashes($_POST['data']),true);
			$this->Users = new Users;
			$this->Users->applyCard($data['card']);
			echo tools::toJSON(array('card'=>$this->Users->getUserCard($this->Session->User['id'])));
		}
		
		public function registerinfoAction(){
			if(!$_SESSION['User']['id'])
			$this->registry->get->redirect('/');
			//$this->Geo=new Geo;
			$this->Users = new Users;
			$this->profile=$this->Users->getUserMinInfo($this->Session->User['id']);
			//$this->countries=$this->Geo->getCounties();
			$this->socialaccounts=$this->Users->getUserSocialAccounts();
			$this->token=$this->registry->token->getToken();
			
			$this->content=$this->view->AddView('/admin/registerinfo', $this);
			$this->view->renderLayout('layout', $this);
		}
		function updateregisterinfoAction() {
			//if ($this->registry->token->checkToken($_POST['token'])){
				$this->Users = new Users;
				if($this->Users->updateRegisterInfo($_POST)){
				if($this->registry->langid==1){
				$status='Изменения сохранены.';
				}elseif($this->registry->langid==2){
				$status='Changes saved.';	
				}
				
				echo json_encode(array(
						'error'=>false, 
						'status'=>$status,
						'token'=>$this->registry->token->getToken()
						));
				}
				else
				$this->registry->get->redirect('/user/registerinfo/');
			/*}
			else
			$this->registry->get->redirect('/user/registerinfo/');*/
		}
		
		function updateprofileAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			$this->Users = new Users;
			$this->Users->updateUserProfile($data['user']);
			echo json_encode(array('token'=>$this->registry->token->getToken(9),'user'=>$this->Users->getUserFullProfile($this->Session->User['id'])));
		}
        function loginAction() {
				/*if($this->Session->User['id'])
				$this->registry->get->redirect('/');*/
				//echo tools::getDirectorySize($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$SESSION['Site']['id'].'/');	
				if (tools::IsAjaxRequest()) {
				$logindata=$_POST;
					/*$this->registry->token->checkToken($logindata['token'],5) && */
						$userData=$this->registry->user->loginClubUser($logindata['email'], $logindata['password'], $logindata['stay']);
						if($userData){
							$this->Session->User=$userData;
							$data=array(
								'error'=>false,
								'status'=>''
							);
							echo json_encode($data);
						}
						else{
							if($this->registry->langid==1){
							$status='Комбинация email-пароль не верна.';
							}elseif($this->registry->langid==2){
							$status='Email or password is incorrect.';	
							}
							$data=array(
								'error'=>true,
								'status'=>$status,
								'token'=>$this->registry->token->getToken(5)
							);
							echo json_encode($data);
						}
					
				}
				else {
					if($_POST['url'])
					$this->registry->get->redirect($_POST['url']);
				}	
        }
		function retrieveAction(){
			if($this->registry->langid==1){
			$status='Инструкция для восстановления пароля отправлена.';
			}elseif($this->registry->langid==2){
			$status='Password retrieve instruction is sent.';
			}
			$out=array(
			'error'=>false,
			'status'=>$status
			);
			$this->user=new user;
			$this->user->passwordretrieve($_POST['retrieve-email']);
			echo json_encode($out);
		}
		function getnewpasswordAction(){
			$this->user=new user;
			
			if($this->registry->langid==1){
			$status='Инструкция для восстановления пароля отправлена.';
			}elseif($this->registry->langid==2){
			$status='Password retrieve instruction is sent.';	
			}
			
			if($this->registry->langid==1){
				if($this->user->setnewpassword($_GET['key']))
					$this->text='Новый пароль выслан на Ваш email';
					else
					$this->text='Ссылка для восстановления пароля устарела';
			}
			elseif($this->registry->langid==2){
				if($this->user->setnewpassword($_GET['key']))
					$this->text='New password is sent to your email';
					else
					$this->text='Password retrieve link is out of date';
			}
			$this->content =$this->view->AddView('blank', $this);
			$this->view->renderLayout('layout', $this);	
		}
		
		function logoutAction() {
				$this->user=new user;
				$this->user->loginOut();
				$this->registry->get->redirect('/');	
        }
		function readmessageAction() {
			header('Content-Type: application/json; charset=utf-8');
			
			$db=db::init();
			$db->query('UPDATE z_messages SET z_messages.new='.intval($_GET['new']).' WHERE z_messages.id='.intval($_GET['id']).' AND z_messages.userid='.$this->Session->User['id'].'');
			$data = array(
			    'counter' => intval($this->registry->user->getMessages($this->Session->User['id'])),
			    'success' => true
			);
			
			echo json_encode($data);
			die();
        }
}
?>