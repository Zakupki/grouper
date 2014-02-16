<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/Users.php';
require_once 'modules/main/models/News.php';
require_once 'modules/main/models/Geo.php';
require_once 'modules/main/models/Support.php';

Class User_Controller Extends Base_Controller {
		private $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			//$this->messageum=$this->registry->user->getMessages($this->Session->User['id']);
		}

        function indexAction() {
         $this->token=$this->registry->token->getToken();
         echo $this->token;
		 echo '<br/>';
		 $this->registry->token->checkToken();
		 
		 $this->token=$this->registry->token->getToken();
         echo $this->token;
		}
		
		function userprofileAction() {
			$this->News=new News;
			$this->newsline=$this->News->getNewsLine();
			$this->newslineblock=$this->view->AddView('blocks/newslineblock', $this);
			$this->token=$this->registry->token->getToken();
			$this->Users = new Users;
			$this->profile=$this->Users->getUserProfile($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('userprofile', $this);
			$this->view->renderLayout('layout', $this);
		}
		function loginAction() {
				header('Content-Type: application/json; charset=utf-8');
				/*if($this->Session->User['id'])
				return;*/
				
				if (tools::IsAjaxRequest()) {
					//if ($this->Valid->isLogin($this->Post->login)) {
						$userData=$this->registry->user->loginUser($this->Post->email, trim($this->Post->password), $this->Post->remember);
						
						if($userData){
							$_SESSION['User']=$userData;
							$data['error'] = false;
							$data['token'] = $this->registry->token->getToken();
							echo json_encode($data);
							die();
						}
						else{
							$data = array(
							    'error' => true,
							    'status' => '',
								'token' => $this->registry->token->getToken()
							);
								$data['error'] = true;
							    $data['status'] = 'Вы неверно указали email пользователя или пароль.';
							echo json_encode($data);
						die();
						}
					/*}
					else{
						$data = array(
							    'error' => true,
							    'status' => 'Ваша сессия истекла! Повторите попытку',
								'token' => $this->registry->token->getToken()
						);
						echo json_encode($data);
						die();
					}*/
				}
				else {
					if($_POST['url'])
					$this->registry->get->redirect($_POST['url']);
				}				
        }
		
		function logoutAction() {
				$this->registry->user->loginOut();
				$this->registry->get->redirect('/');	
        }
		
		public function agreementAction(){
			$this->News = new News;
			$this->newsline=$this->News->getNewsLine();
			$this->newslineblock=$this->view->AddView('blocks/newslineblock', $this);
			$this->token=$this->registry->token->getToken();
			$this->content=$this->view->AddView('agreement', $this);
			$this->view->renderLayout('layout', $this);
		}
		function retrieveAction(){
			$out=array(
			'error'=>false,
			'status'=>'Инструкция для восстановления пароля отправлена.'
			);
			$this->user=new user;
			$this->user->passwordretrieve($_POST['retrieve-email']);
			echo json_encode($out);
		}
		function getnewpasswordAction(){
			$this->user=new user;
			if($this->user->setnewpassword($_GET['key']))
			$this->text='Новый пароль выслан на Ваш email';
			else
			$this->text='Ссылка для восстановления пароля устарела';
			$this->content =$this->view->AddView('blank', $this);
			$this->view->renderLayout('layout', $this);	
		}
		function sendfeedbackAction(){
				$this->Support = new Support;
				if(strlen($_POST['message'])>0)
				$message=$this->Support->sendFeedback($_POST);
				if($message){
					$data = array(
					    'error' => false,
					    'status' => 'Форма отправлена'
					);
					echo json_encode($data);
				}else{
                    $data = array(
                        'error' => true,
                        'status' => 'Заполните обязательные поля и введите код Captcha'
                    );
                    echo json_encode($data);
                }
		}
		function checkbalanceAction(){
			/* header('Content-Type: application/json; charset=utf-8'); */
			
			$data = array(
			    'error' => false,
			    'status' => ''
			);
			if($_POST['final_cost']>0){
				$this->Users = new Users;
				$data['balance'] = $this->Users->getBalance();
			}
			if ($_POST['final_cost']>$data['balance']) {
				
			    $data['status'] = 'У вас недостаточно средств на счёте.<br />Хотите перейти на страницу пополнения?';
			}
			echo json_encode($data);
		}

}


?>