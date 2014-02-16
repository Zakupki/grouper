<?php

require_once 'modules/base/controllers/BaseArtist_Controller.php';
require_once 'modules/artist/models/Design.php';
require_once 'modules/artist/models/Social.php';
require_once 'modules/artist/models/Tracklist.php';

Class User_Controller Extends BaseArtist_Controller {
		private $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Social = new Social;
			$this->Tracklist = new Tracklist;
		}
		
		function indexAction(){
			
		}
		
        function loginAction() {
				if($this->Session->User['id'])
				$this->registry->get->redirect('/');
				
				$logindata=json_decode(stripcslashes($_POST['data']),true);
						$userData=$this->registry->user->loginReccountUser($logindata['email'], trim($logindata['password']), $logindata['remember']);
						if($userData){
							$this->Session->User=$userData;
							$data=array(
								'error'=>false,
								'status'=>''
							);
							echo json_encode($data);
						}
						else{
							$data=array(
								'error'=>true,
								'status'=>'Комбинация email-пароль не верна.',
								'token'=>$this->registry->token->getToken(5)
							);
							echo json_encode($data);
						}
								
        }
		function retrieveAction(){
			$data=json_decode(stripcslashes($_POST['data']),true);
			$this->user=new user;
			$this->user->passwordretrieve($data['email']);
			echo 'Инструкция для восстановления пароля отправлена.';
		}
		function getnewpasswordAction(){
			$db=db::init();
			$this->user=new user;
			if($this->user->setnewpassword($_GET['key']))
			$this->text='Новый пароль выслан на Ваш email';
			else
			$this->text='Ссылка для восстановления пароля устарела';
			$this->content =$this->view->AddView('blank', $this);
			$this->view->renderLayout('clean', $this);	
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