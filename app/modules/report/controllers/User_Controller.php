<?php

require_once 'modules/base/controllers/BaseReport_Controller.php';

require_once 'modules/main/models/Geo.php';
require_once 'modules/main/models/Support.php';


require_once 'modules/report/models/Users.php';
require_once 'modules/report/models/Operation.php';
require_once 'modules/report/models/Group.php';
require_once 'modules/report/models/Brand.php';
require_once 'modules/report/models/Request.php';



Class User_Controller Extends BaseReport_Controller {
		private $registry;
		public $error;
        public $take=20;
        public $takeevents=10;
        public $takeposters=12;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
            $this->Group=new Group;
            $this->Request= new Request;
            $this->newrequests=$this->Request->getRequestcnt();
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
		
		function profileAction() {
			if(!$_SESSION['User']['id'])
			$this->registry->get->redirect('/');
			
			//$this->Brand=new Brand;
			$this->clubsnum=$this->Group->getGroupscount();
			$this->clubsfav=$this->Group->getGroupsfav();
			$this->profile=$_SESSION['User'];
			$this->content =$this->view->AddView('user/profile', $this);
			$this->view->renderLayout('layout', $this);
		}
        function withdrawAction() {
            $this->Operation= new Operation;
            $this->paytype=$this->Operation->getPaytype();
            $this->total=$this->Operation->getBalanceTotal();
            $this->reserved=$this->Operation->getBalanceReserved();
            $this->content =$this->view->AddView('user/withdraw', $this);
            $this->view->renderLayout('layout', $this);
        }
        public function updatewithdrawAction(){
            $this->Operation=new Operation;
            if($this->Operation->addWithdraw($_POST))
            echo json_encode(array(
                'error'=>false,
                'status'=>'Запрос успешно отправлен'
            ));
            else
                echo json_encode(array(
                    'error'=>true,
                    'status'=>'Произошла ошибка'
                ));
            die();
        }

		function updateprofileAction() {
			if(!$_SESSION['User']['id'])
			$this->registry->get->redirect('/');
			$this->Users=new Users;
			echo $this->Users->updateProfile($_POST);
			//$this->registry->get->redirect('/user/profile/');
		}
		function changepassAction() {
			if(!$_SESSION['User']['id'])
			$this->registry->get->redirect('/');
			$this->user=new user;
			$return=$this->user->changePassword($_POST['password'],$_POST['passwordrepeat'],$_POST['oldpassword']);
			if($return)
			$this->registry->get->redirect('/user/profile/?change=1');
			else
			$this->registry->get->redirect('/user/profile/?change=2');
		}
		function loginAction() {
				header('Content-Type: application/json; charset=utf-8');
				/*if($this->Session->User['id'])
				return;*/
				
				if (tools::IsAjaxRequest()) {
						$userData=$this->registry->user->loginUser($this->Post->email, trim($this->Post->password), $this->Post->remember);
						
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
								$data['error'] = true;
							    $data['status'] = 'Вы неверно указали email пользователя или пароль.';
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
		
		function brandsAction() {
			
			$this->clubsnum=$this->Group->getGroupscount();
			$this->clubsfav=$this->Group->getGroupsfav();
			$this->Brand=new Brand;
			$this->brandlist=$this->Brand->getUserBrands();
			$this->content=$this->view->AddView('brands', $this);
			$this->view->renderLayout('layout', $this);
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
    function groupsAction(){
            $this->listtype=2;
            $_GET['userid']=$_SESSION['User']['id'];
            $this->Users=new Users;
            $this->clubs=$this->Group->getGroups(array('take'=>$this->take,'listtype'=>$this->listtype));
            $this->socialgroups=$this->Users->getUserSocialGroups();
            foreach($this->clubs['sites'] as $k=>$gr){
               if(array_key_exists($gr['gid'], $this->socialgroups[$gr['socialid']]))
                unset($this->socialgroups[$gr['socialid']][$gr['gid']]);
               else
                   $this->clubs['sites'][$k]['notconnected']=1;
            }
            //tools::print_r($this->clubs);
            $this->clubsnum=$this->Group->getGroupscount(1,1);
            $this->clubsfav=$this->Group->getGroupsfav();
            $this->grouptypes=$this->Group->getGroupTypes(array('listtype'=>$this->listtype));
            $this->clublist=$this->view->AddView('moregroups', $this);
            $this->content=$this->view->AddView('groups', $this);
            $this->view->renderLayout('layout', $this);
    }
    function requestsAction(){
            
            $this->clubsnum=$this->Group->getGroupscount();
            $this->clubsfav=$this->Group->getGroupsfav();
            $this->requests=$this->Request->getRequests();
            $this->content=$this->view->AddView('/user/requests', $this);
            $this->view->renderLayout('layout', $this);
       }
    function getrequestinfoAction(){
            if(!tools::IsAjaxRequest())
            $this->registry->get->redirect('/');
            $requesttype=array(1=>'banner',2=>'event',3=>'public',4=>'recard');
            
            //if($_REQUEST['status']==2)
            $this->Request->markRead($_REQUEST['requesttype'],$_REQUEST['requestid']);
            switch ($_REQUEST['requesttype']) {
                case 1:
                    $this->requestdata=$this->Request->getBannerRequest($_REQUEST['requestid']);
                    break;
                case 2:
                    $this->requestdata=$this->Request->getEventRequest($_REQUEST['requestid']);
                    break;
                case 3:
                    $this->requestdata=$this->Request->getPublicRequest($_REQUEST['requestid']);
                    break;
                case 4:
                    $this->requestdata=$this->Request->getRecardRequest($_REQUEST['requestid']);
                    break;
            }
            
            $this->content=$this->view->AddView('requests/'.$requesttype[$_REQUEST['requesttype']].'request', $this);
            $this->view->renderLayout('blank', $this);
        }
    function makereportAction(){
            if(!tools::IsAjaxRequest())
            $this->registry->get->redirect('/');
            $requesttype=array(1=>'banner',2=>'event',3=>'public',4=>'recard');
            
            switch ($_REQUEST['requesttype']) {
                case 1:

                    break;
                case 2:
                    $this->requestdata=$this->Request->getEventSiteRequest($_REQUEST['requestid']);
                    break;
                case 3:
                    $this->requestdata=$this->Request->getReportSiteRequest($_REQUEST['requestid']);
                    break;
                case 4:

                    break;
            }

            $this->content=$this->view->AddView('requests/'.$requesttype[$_REQUEST['requesttype']].'report', $this);
            $this->view->renderLayout('blank', $this);
        }
    function updaterequestAction(){
            if(!tools::IsAjaxRequest())
            $this->registry->get->redirect('/');
            
            $this->Request->acceptRequest($_REQUEST['requestid'], $_REQUEST['requesttype'], $_REQUEST['action']);
        }
    function sendpublicreportAction(){
            if(!tools::IsAjaxRequest())
                $this->registry->get->redirect('/');
            
            $this->Request->sendPublicReport($_REQUEST);
        }

    function depositAction() {
            $this->token=$this->registry->token->getToken();
            $this->content =$this->view->AddView('user/deposit', $this);
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
            $oper_id=$this->Operation->popUp($_POST['sum']);
            $merchant_id='i8584647759';
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
                ";
            
            $this->xml_encoded = base64_encode($xml); 
            $this->lqsignature = base64_encode(sha1($signature.$xml.$signature,1));
            
            $this->content =$this->view->AddView('user/clicknbuy', $this);
            $this->view->renderLayout('layout', $this);
            
        }
    function balanceAction(){
            $this->Operation= new Operation;
            $this->token=$this->registry->token->getToken();
            $db=db::init();
           
            $this->total=$this->Operation->getBalanceTotal();
            $this->reserved=$this->Operation->getBalanceReserved();

            if(!$this->total)
            $this->total=0;
            $this->User['money']=$this->total;
            $this->Session->User=$this->User;
            $this->operationtypes=$this->Operation->getOperationTypes();
            
            $this->operations=$this->Operation->getOperaytions();
            $this->operationlist=$this->view->AddView('user/moreoperations', $this);
            $this->content =$this->view->AddView('user/balance', $this);
            $this->view->renderLayout('layout', $this);
        }
    function morebalanceAction(){
            $this->Operation= new Operation;
            $this->operations=$this->Operation->getOperaytions($_GET);
            $this->content=$this->view->AddView('user/moreoperations', $this);
            $this->view->renderLayout('blank', $this);
        }
    public function actionSuccess(){
        print_r($_POST);
       echo 'Оплата. Вы успешно прощли процедуру оплаты. Менеджер свяжется с вами после получения оплаты.';
    }
    public function actionFail(){
        print_r($_POST);
        echo('Оплата. Произошла ошибка при оплате');
    }

    public function payforpostAction(){
        $this->Operation= new Operation;
        $this->Operation->payForPost($_POST['id']);
        $data = array(
            'error' => false,
            'status' => 'Оплата успешно прошла'
        );
        echo json_encode($data);
    }
    public function actionInterstatus(){
        $data=$_POST;
        //$data = json_encode($_POST);
        $this->Operation=new Operation;
        $this->Operation->updateOperation(trim($data['ik_payment_id']), trim($data['ik_payment_state']), trim($data['ik_trans_id']), serialize($_POST));

        return;
        $data=json_encode($_POST);
        $test=new Test();
        $test->text=$data;
        $test->save();
        $new=false;
        $test2=Interkassa::model()->findByPk($_POST['ik_payment_id']);
        if($test2->id>0)
            $new=true;
        $test2->attributes=$_POST;
        $test2->save();

        if($new){
            $order=Order::model()->with('user')->findByPk($test2->ik_payment_id);
            $order->orderstate_id=3;
            $order->save();
            if($order->id>0){
                $message = new YiiMailMessage;
                $message_body='
					Здравствуйте!<br><br>
					Ваш заказ №'.$order->id.' успешно оплачен через систему интеркасса<br><br>
					В течение 10 минут наш менеджер вам перезвонит.<br><br>
					Наш телефон: '.Option::getOpt('mainphone').'<br><br>
					С уважением,<br>
					Личный Повар';
                $message->setBody($message_body, 'text/html');
                $message->subject = 'Заказ оплачен';
                $message->addTo($order->user->email);
                $message->from = Yii::app()->params['adminEmail'];
                Yii::app()->mail->send($message);

                $message = new YiiMailMessage;
                $message_body='
					Заказ №'.$order->id.' от пользователя '.$order->user->email.' на сумму '.$order->ik_payment_amount.' успешно оплачен через систему интеркасса.';
                $message->setBody($message_body, 'text/html');
                $message->subject = 'Новая оплата заказа';
                $orderuserarr=explode(',',Option::getOpt('order_emails'));
                foreach($orderuserarr as $order_u)
                    $message->addTo(trim($order_u));
                $message->from = array(Yii::app()->params['adminEmail']=>'Личный Повар');
                Yii::app()->mail->send($message);
            }
        }
    }
    public function accountsAction(){
        $this->Users=new Users;
        $this->accounts=$this->Users->getUserSocialAccounts();
        $this->content =$this->view->AddView('user/accounts', $this);
        $this->view->renderLayout('layout', $this);
    }
}


?>