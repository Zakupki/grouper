<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/Geo.php';
require_once 'modules/reparty/models/Support.php';


Class Index_Controller Extends Base_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
		}

        function indexAction() {
        	$this->token=$this->registry->token->getToken();
        }
		function searchAction() {
			$this->view->renderLayout('layout', $this);
        }
		function registerAction() {
				if($this->Session->User['id'])
				$this->registry->get->redirect('/');
				$this->Geo=new Geo;
				$this->countries=$this->Geo->getCounties();
				$this->token=$this->registry->token->getToken();
				if($this->Post->check || $this->Post->makeregister){
						
						#Проверка Логина
						if(strlen($this->Post->login)>0){
							if(!$this->Valid->isLogin($this->Post->login))
							$this->error['login']='Введите правильный логин.';
							else{
								if($this->Valid->loginExists($this->Post->login)==false)
								$this->error['login']='Такой логин уже зарегистрирован.';
							}
						}
						elseif(strlen($this->Post->login)<1 && !$this->Post->check) 
						$this->error['login']='Введите логин.';
						
						#Проверка Email
						if(strlen($this->Post->email)>0){
							if(!$this->Valid->isEmail($this->Post->email))
							$this->error['email']='Введите правильный email.';
							else{
								if($this->Valid->emailExists($this->Post->email)==false)
								$this->error['email']='Такой email уже зарегистрирован.';
							}
						}
						elseif(strlen($this->Post->email)<1 && !$this->Post->check) 
						$this->error['email']='Введите email.';
						
						if(strlen($this->Post->password)>0){
							if(strlen($this->Post->passwordcheck)>0){
								if($this->Post->password!=$this->Post->passwordcheck){
								$this->error['password']='&nbsp;';
								$this->error['password_check']='Пароли не совпадают.';
								}
								
							}
							elseif(strlen($this->Post->password_check)<1 && !$this->Post->check) 
							$this->error['password_check']='Введите подтверждение пароля.';
							
						}
						elseif(strlen($this->Post->password)<1 && !$this->Post->check) 
						$this->error['password']='Введите пароль.';
						
						
					
					if(!is_array($this->error) && !$this->Post->check)
					{
						$User=new user();
						$User->addUser($this->Post->asIterator());
						//$this->registry->get->redirect('/');
						echo json_encode(array(
						'error'=>false, 
						'status'=>'Вы успешно зарегистрированы! На ваш email отправлено письмо с активацией вашего аккаунта.',
						'redirect'=>'/'
						));
						die();
					}
					if(!$this->Post->check){
						tools::print_r($this->error);
					}
					if(is_array($this->error) || $this->Post->check) {
						foreach($this->Post->asIterator() as $k=>$v){
							if(!$this->error[$k] && $k!='check'){
							echo json_encode(true);
							die();
							}
						}
						echo json_encode(implode(',',$this->error));
						die();
					}
					
				}
				
				
				
				$this->content=$this->view->AddView('register_form', $this);
				$this->view->renderLayout('layout', $this);
		}
		function aboutAction() {
			    $this->token=$this->registry->token->getToken();
				$this->content=$this->view->AddView('about', $this);
				$this->view->renderLayout('layout', $this);
		}
		function supportAction() {
				if($_SESSION['User']['id']<1)
				$this->registry->get->redirect('/');
				$this->Support = new Support;
				$this->token=$this->registry->token->getToken();
				$this->supporttype= $this->Support->getSupporttype(1);
				$this->questions=$this->Support->getQuestions();
				$this->Support->readNew();
				$this->content=$this->view->AddView('support', $this);
				$this->view->renderLayout('layout', $this);
		}
		function faqAction() {
				$this->token=$this->registry->token->getToken();
				$this->content=$this->view->AddView('faq', $this);
				$this->view->renderLayout('layout', $this);
		}
		function feedbackAction(){
				$this->token=$this->registry->token->getToken();
				$this->Support = new Support;
				$this->supporttype= $this->Support->getSupporttype(0);
				$this->content=$this->view->AddView('feedback', $this);
				$this->view->renderLayout('layout', $this);
		}
		function agreementAction(){
				$this->News = new News;
				$this->newsline=$this->News->getNewsLine();
				$this->newslineblock=$this->view->AddView('blocks/newslineblock', $this);
				$this->token=$this->registry->token->getToken();
				$this->content=$this->view->AddView('agreement', $this);
				$this->view->renderLayout('layout', $this);
		}
		function activateAction(){
			$User=new user;
			if($User->activateUser($_GET['act']))
			$this->registry->get->redirect('/cabinet/editprofile/');
			else
			$this->registry->get->redirect('/error/?error=1');
			
		}
		function transferAction(){
			$this->Reccount=new Reccount;
			$siteid=$this->Reccount->activateTransfer($_GET['act']);
			if($siteid>0)
			$this->registry->get->redirect('/cabinet/myreccounts/#content'.$siteid.'');
			else
			$this->registry->get->redirect('/error/?error=1');
			
		}
		function errorAction(){
			$statusArr[1]='Код активации устарел или вы перешли по ложной ссылке.';
			$this->status=$statusArr[$_GET['error']];
			$this->content=$this->view->AddView('error', $this);
			$this->view->renderLayout('layout', $this);
		}
		function notfoundAction(){
			$this->content=$this->view->AddView('404', $this);
			$this->view->renderLayout('layout', $this);
		}
		function helpAction(){
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
			$this->Support = new Support;
			$this->helpdata=$this->Support->getHelp($_GET['id']);
			if(!$this->helpdata)
			$this->helpdata=array('name'=>'Помощь', 'text'=>'В стадии наполнения.');
			$this->content=$this->view->AddView('help', $this);
			$this->view->renderLayout('blank', $this);
		}
		
}


?>