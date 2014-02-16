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
					if ($this->registry->token->checkToken() && $this->Valid->isLogin($this->Post->login)) {
						$userData=$this->registry->user->loginUser($this->Post->login, $this->Post->password, $this->Post->remember);
						
						if($userData){
							$_SESSION['User']=$userData;
							$data['error'] = false;
							$data['tokem'] = $this->registry->token->getToken();
							echo json_encode($data);
							die();
						}
						else{
							$data = array(
							    'error' => true,
							    'status' => '',
								'token' => $this->registry->token->getToken()
							);
							if ($_POST['login'] == 'user' && $_POST['password'] == '111') {
							    $data['error'] = false;
								$data['tokem'] = $this->registry->token->getToken();
							} else {
								$data['error'] = true;
							    $data['status'] = 'Вы неверно указали имя пользователя или пароль.';
							}
							echo json_encode($data);
						die();
						}
					}
					else{
						$data = array(
							    'error' => true,
							    'status' => 'Ваша сессия истекла! Повторите попытку',
								'token' => $this->registry->token->getToken()
						);
						echo json_encode($data);
						die();
					}
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