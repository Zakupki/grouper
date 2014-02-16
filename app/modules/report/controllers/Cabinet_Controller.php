<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/Users.php';
require_once 'modules/main/models/News.php';
require_once 'modules/main/models/Geo.php';
require_once 'modules/main/models/Support.php';
require_once 'modules/main/models/Operation.php';
require_once 'modules/main/models/Reccount.php';

Class Cabinet_Controller Extends Base_Controller {
		private $registry;
		public $error;
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			
			if($this->Session->User['id']<1)
			$this->registry->get->redirect('/');
			
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			
			//$this->messageum=$this->registry->user->getMessages($this->Session->User['id']);
		}
		
		function indexAction() {
        	$this->registry->get->redirect('/cabinet/profile/');
        	/*
			$csrf=new csrf;
			$ptoken = $csrf->csrfkey();
			echo $ptoken;
			
			if($csrf->checkcsrf($ptoken)){
				echo'yes';
			}
			else
			{
				echo 'no';
			}
			
			echo '<br/>';*/
		}
		
		public function registerinfoAction(){
			$this->Geo=new Geo;
			$this->Users = new Users;
			$this->profile=$this->Users->getUserMinInfo($this->Session->User['id']);
			$this->countries=$this->Geo->getCounties();
			$this->socialaccounts=$this->Users->getUserSocialAccounts();
			//tools::print_r($this->socialaccounts);
			$this->token=$this->registry->token->getToken();
			
			$this->submenu=$this->view->AddView('blocks/usersubm', $this);
			$this->content=$this->view->AddView('registerinfo', $this);
			$this->view->renderLayout('layout', $this);
		}
		function updateregisterinfoAction() {
			if ($this->registry->token->checkToken($_POST['token'])){
				$this->Users = new Users;
				if($this->Users->updateRegisterInfo($_POST)){
				echo json_encode(array(
						'error'=>false, 
						'status'=>'Изменения сохранены.',
						'token'=>$this->registry->token->getToken()
						));
				}
				else
				$this->registry->get->redirect('/user/registerinfo/?error1');
			}
			else
			$this->registry->get->redirect('/user/registerinfo/?error2');
		}
		
		
		
		
		function depositAction() {
			$this->token=$this->registry->token->getToken();
			$this->content =$this->view->AddView('deposit', $this);
			$this->view->renderLayout('layout', $this);
		}
		function activatediscountAction() {
			
			/*for ($i=0; $i<6; $i++) { 
			    $d=rand(1,30)%2; 
			    echo $d ? chr(rand(65,90)) : chr(rand(48,57)); 
			} */
			
			
			/* header('Content-Type: application/json; charset=utf-8'); */
			$data = array(
			    'error' => false,
			    'status' => '',
			    'token' => md5(rand())
			);
			
			$this->Reccount=new Reccount;
			
			if ($this->Reccount->activateDiscount($_POST['code'])) {
			    $data['status'] = 'Вы успешно активировали свой секретный код.';
			} else {
			    $data['error'] = true;
			    $data['status'] = 'Такого кода нет в нашей базе.<br />Проверте правильность ввода, и попробуйте ещё раз.';
			}
			
			echo json_encode($data);
		}
		
		function clicknbuyAction(){
			$this->Operation= new Operation;
			$this->oper_id=$this->Operation->popUp($_POST['sum']);

            /*$merchant_id='i8584647759';
			$signature="35cvp8zuOIGBCua4XReJYIuIPccQo1XzkkQzqcyRAOiH";
			$this->liqurl="https://www.liqpay.com/?do=clickNbuy";
			$method='card';
			$phone='+20123145121';

			$xml="<request>      
				<version>1.2</version>
				<result_url>http://".$_SERVER['HTTP_HOST']."/popupend/</result_url>
				<server_url>http://".$_SERVER['HTTP_HOST']."/operation/operationresponse/</server_url>
				<merchant_id>$merchant_id</merchant_id>
				<order_id>$oper_id</order_id>
				<amount>".$_POST['sum']."</amount>
				<currency>UAH</currency>
				<description>Пополнение счета</description>
				<pay_way>$method</pay_way> 
				</request>
				";*/
			
			//$this->xml_encoded = base64_encode($xml);
			//$this->lqsignature = base64_encode(sha1($signature.$xml.$signature,1));
			
			$this->content =$this->view->AddView('clicknbuy', $this);
			$this->view->renderLayout('layout', $this);
			
		}
		function balanceAction() {
			$this->token=$this->registry->token->getToken();
			$db=db::init();
			$result=$db->queryFetchRow('
			SELECT 
			  SUM(z_operation.VALUE) AS total
			FROM
			  z_operation 
			WHERE z_operation.userid = '.intval($this->Session->User['id']).' 
			  AND z_operation.status = 2 
			');	
			$this->total=$result['total'];
			if(!$this->total)
			$this->total=0;
			$this->User['money']=$this->total;
			$this->Session->User=$this->User;
			
			$this->operations=$db->queryFetchAllAssoc('
			SELECT 
			  z_operation.id,
			  z_operation.date_create,
			  z_operation.value,
			  z_operationtype.name,
			  if(z_operationstatustype.id, z_operationstatustype.name,z_operation.status) AS status
			FROM
			  z_operation 
			  INNER JOIN
			  z_operationtype 
			  ON z_operationtype.id = z_operation.operationtypeid
			  LEFT JOIN z_operationstatustype
			  ON z_operationstatustype.id=z_operation.status
			WHERE z_operation.userid = '.intval($this->Session->User['id']).' 
			  AND z_operation.active = "Y"
			  AND z_operation.status>0
			ORDER by date_create DESC
  			');
        	$this->content =$this->view->AddView('balance', $this);
			$this->view->renderLayout('layout', $this);
		}
		function profileAction() {
			$this->token=$this->registry->token->getToken();
			$this->Users = new Users;
			$this->profile=$this->Users->getUserProfile($this->Session->User['id']);
			$this->submenu=$this->view->AddView('blocks/usersubm', $this);
			$this->content =$this->view->AddView('profile', $this);
			$this->view->renderLayout('layout', $this);
		}
		function messagesAction() {
				$this->token=$this->registry->token->getToken();
				$db=db::init();
				$this->messages=$db->queryFetchAllAssoc('SELECT * FROM z_messages WHERE active=1 AND userid='.$this->Session->User['id'].' ORDER BY date_create DESC');
				$this->content =$this->view->AddView('messages', $this);
				$this->view->renderLayout('layout', $this);
        }
		
		
		function readmessageAction() {
			header('Content-Type: application/json; charset=utf-8');
			
			$db=db::init();
			
			
			$db->query('UPDATE z_messages SET z_messages.new='.tools::int($_GET['new']).' WHERE z_messages.id='.intval($_GET['id']).' AND z_messages.userid='.$this->Session->User['id'].'');
			
			$data = array(
			    'total' => $this->registry->user->getMessages($this->Session->User['id']),
			    'success' => true
			);
			
			echo json_encode($data);
			die();
        }
		function myreccountsAction(){
			$this->token=$this->registry->token->getToken();
			
			$db=db::init();
			$result=$db->queryFetchRow('
			SELECT 
			  SUM(z_operation.VALUE) AS total
			FROM
			  z_operation 
			WHERE z_operation.userid = '.intval($this->Session->User['id']).' 
			  AND z_operation.status = 2 
			');	
			$this->total=$result['total'];
			if(!$this->total)
			$this->total=0;
			$this->User['money']=$this->total;
			$this->Session->User=$this->User;
			
			$db=db::init();
			
			if($this->Post->isSent()){
				if($this->Post->kind>0 && $this->Post->siteid>0 && $this->Session->User['id']>0 && $this->registry->token->checkToken()){
					$db->query('UPDATE z_site SET sitetypeid='.intval($this->Post->kind).' WHERE z_site.id='.intval($this->Post->siteid).' AND z_site.userid='.$this->Session->User['id'].'');
				}	
			}
			
			$result=$db->queryFetchAllAssoc('SELECT * FROM z_sitetype WHERE onsite="Y"');
				foreach($result as $k=>$v){
					if(!$v['parentid'])
					$this->sitetypes[$v['id']]['data']=$v;
					else
					$this->sitetypes[$v['parentid']]['subcats'][$v['id']]=$v;
				}
			$this->Reccount=new Reccount;
			$this->sites=$this->Reccount->getUserSites($this->Session->User['id']);
			$this->sitedisc=$this->Reccount->siteDiscSpace($this->Session->User['id']);
			$this->discount=$this->Reccount->getUserDiscount();
			$this->content=$this->view->AddView('myreccounts', $this);
			$this->view->renderLayout('layout', $this);
			
		}
		public function setkindAction(){
			header('Content-Type: application/json; charset=utf-8');
			$db=db::init();
			if($this->Post->isSent()){
				if($this->Post->kind>0 && $this->Post->siteid>0 && $this->Session->User['id']>0 && $this->registry->token->checkToken()){
					$db->query('UPDATE z_site SET sitetypeid='.intval($this->Post->kind).' WHERE z_site.id='.intval($this->Post->siteid).' AND z_site.userid='.$this->Session->User['id'].'');
				}	
			}
			$data = array(
			    'error' => false,
			    'status' => 'Статус успешно изменен',
			    'token' => $this->registry->token->getToken()
			);
			
			echo json_encode($data);
			
		}
		public function clientloginAction(){
			echo 'client login';
		}
		public function editprofileAction(){
			$this->token=$this->registry->token->getToken();
			$this->Users = new Users;
			$this->reccounts=$this->Users->getUserReccounts();
			$this->profile=$this->Users->getUserFullProfile($this->Session->User['id']);
			$this->submenu=$this->view->AddView('blocks/usersubm', $this);
			$this->content=$this->view->AddView('editprofile', $this);
			$this->view->renderLayout('layout', $this);
		}
		function updateprofileAction() {
			$this->Users = new Users;
			$this->Users->updateUserProfile($_POST);
			$this->registry->get->redirect('/cabinet/editprofile/');
		}
		
		function sendsupportAction(){
				$this->Support = new Support;
				if(strlen($_POST['message'])>0)
				$message=$this->Support->addQuestion($_POST);
				if($message){
					$data = array(
					    'error' => false,
					    'status' => 'Форма отправлена'
					);
					echo json_encode($data);
				}
		}
		function transferAction(){
			$data = array(
			    'error' => false,
			    'status' => '',
			    'token' => md5(rand())
			);
			$this->Users=new Users;
			$userid=$this->Users->checkLoginMail($_POST['login'],$_POST['email']);
			if($userid>0){
				$this->Reccount=new Reccount;
				$this->Reccount->startTransfer($userid,$_POST['siteid'],$_POST['email']);
				
				
				
				$data['status'] = 'На ваш e-mail выслано подтверждение.';
			} else {
			    $data['error'] = true;
			    $data['status'] = 'Пользователя с таким email нет в базе.';
			}
			
			echo json_encode($data);
		}
		function canceltransferAction(){
			$this->Reccount=new Reccount;
			$siteid=$this->Reccount->cancelTransfer($_POST['transferid'],$_POST['siteid']);
			
			$data = array(
		    'post' => $_POST,
		    'error' => false,
		    'status' => '',
		    'token' => md5(rand())
			);


			if ($siteid>0) {
			   $data['status'] = 'На ваш e-mail выслано подтверждение.';
			} else {
			   
			   $data['error'] = true;
			   $data['status'] = 'Имя пользователя и e-mail не совпадают.';
			}
			if($siteid>0)
			$this->registry->get->redirect('/cabinet/myreccounts/#content'.$siteid.'');
			else
			$this->registry->get->redirect('/error/?error=1');
			echo json_encode($data);
		}
		function prolongAction(){
			//tools::print_r($_POST);
			if ($this->Post->isSent() && $this->Session->User['id']>0) {
					if ($this->Post->userid==$this->Session->User['id']) {
					$db=db::init();
					if($this->Post->free)
					$free=$this->Post->free;
					else
					$free=0;
					$db->exec("CALL prolongsite(".$this->Post->siteid.",".$this->Session->User['id'].", ".$this->Post->period.", ".$this->Post->quota.", ".$this->Post->final_cost.", ".$free.")");
					$this->registry->get->redirect('/cabinet/myreccounts/#content'.$this->Post->siteid);
					}
			}
		}

}


?>