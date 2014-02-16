<?
require_once 'modules/base/controllers/BaseReport_Controller.php';
require_once 'modules/report/models/Group.php';
require_once 'modules/report/models/System.php';
require_once 'modules/report/models/Request.php';
require_once 'modules/report/models/Support.php';
require_once 'modules/report/models/Brand.php';
require_once 'modules/main/models/Geo.php';

Class Index_Controller Extends BaseReport_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
            $this->Group=new Group;
		}

        function indexAction() {
        	if($_SESSION['User']['id']>0)
			$this->registry->get->redirect('/groups/');
			else {
                $memcache_obj = new Memcache;

                //Соединяемся с нашим сервером
                $memcache_obj->connect('127.0.0.1', 11211) or die("Could not connect");
                //Попытаемся получить объект с ключом our_var
                //$return = @$memcache_obj->get('Report_about');
                $return=null;
                //$memcache_obj->delete('site_twit_'.$_SESSION['Site']['id']);
                $this->logocolor='-white';
                if(empty($return))
                {

                    $this->visitorsnum=$this->Group->getVistors();
                    $this->followersnum=$this->Group->getFollowers();
                    $this->clubsnum=$this->Group->getGroupscount();
                    $this->clubsfav=$this->Group->getGroupsfav();
                    $this->clubs=$this->Group->getGroups();

                    $memcache_obj->set('Report_about', $this, false, 60*60*24);
                    $return=$memcache_obj->get('Report_about');
                }

                if($this->registry->langid==1)
                    $return->content=$this->view->AddView('index', $return);
                elseif($this->registry->langid==2)
                    $return->content=$this->view->AddView('indexen', $return);
                $this->view->renderLayout('layout', $return);

                $memcache_obj->close();
			}
		}
		function loginAction() {
			$this->Brand=new Brand;
			$this->branddata=$this->Brand->getBrandByCode($this->registry->brandcode);
			$this->view->renderLayout('login', $this);
		}
		function aboutAction() {
            $this->content=$this->view->AddView('about', $this);
            $this->view->renderLayout('layout', $this);
		}
		function contactsAction() {
			$this->System=new System;
        	$this->supporttypes=$this->System->getSupporttypes();
			
			$this->clubsnum=$this->Group->getGroupscount();
			$this->clubsfav=$this->Group->getGroupsfav();
			$this->content=$this->view->AddView('contacts', $this);
			$this->view->renderLayout('layout', $this);
		}
		function notfoundAction(){
			
			$this->clubsnum=$this->Group->getGroupscount();
			$this->clubsfav=$this->Group->getGroupsfav();
			$this->content=$this->view->AddView('404', $this);
			$this->view->renderLayout('layout', $this);
		}
		function activateAction(){
			
			$this->user=new user;
			if($_GET['act'])
			$this->activationcode=$_GET['act'];
			$this->userdata=$this->user->activateUser($this->activationcode);
			$this->clubsnum=$this->Group->getGroupscount();
			$this->clubsfav=$this->Group->getGroupsfav();
			$this->content=$this->view->AddView('activate', $this);
			$this->view->renderLayout('layout', $this);
		}
		function makeactiveAction(){
			$this->user=new user;
			$res=$this->user->activatebrandUser($_POST);
			if($res)
			$status='?status=1';
			else
			$status='?status=2';
			$this->registry->get->redirect('/finishactive/'.$status.'');
		}
		function finishactiveAction(){
			if($_GET['status']==1){
				$this->text="Вы успешно создали ваш пароль. Теперь вы можете войти в систему Clubsreport.";
				$this->texttitle="Активация пользователя";
			}elseif($_GET['status']==2){
				$this->text="Произошла ошибка! Повторно перейдите по ссылке для создания пароля.";
				$this->texttitle="Активация пользователя";	
			}
			$this->content=$this->view->AddView('text', $this);
			$this->view->renderLayout('layout', $this);
		}
		function helpAction(){
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
			$this->Support = new Support;
			$this->helpdata=$this->Support->getHelp($_GET['id']);
			if(!$this->helpdata || $_GET['id']<1)
			$this->helpdata=array('name'=>'Помощь', 'text'=>'В стадии наполнения.');
			$this->content=$this->view->AddView('/popups/help', $this);
			$this->view->renderLayout('blank', $this);
		}
		function consolidatedAction(){
			$this->content=$this->view->AddView('/consolidated', $this);
			$this->view->renderLayout('layout', $this);
		}
		function joinAction(){
		$subject = "Подана заявка на регистрацию бренда";
		$message = "Название бренда: ".$_POST['title']."\n\nСсылка на сайт: ".$_POST['site']."\n\nE-mail: ".$_POST['email']."\n\nНомер телефона: ".$_POST['phone']."\n\n";
		$smtp=new smtp;
		$smtp->Connect(SMTP_HOST);
		$smtp->Hello(SMTP_HOST);
		$smtp->Authenticate('support@clubsreport.com', 'Z1IRldqU');
		$smtp->Mail('support@clubsreport.com');
		$smtp->Recipient('selina@reactor.ua');
		$smtp->Recipient('inna.merk@reactor.ua');
		$smtp->Data($message, $subject);
		
		$subject2 = "Заявка на регистрацию в системе Clubsreport";
		$message2 = "Здравствуйте, ".$_POST['title']."!\n\nВы подали заявку на регистрацию в системе Clubsreport.\n\nВ течение одного рабочего дня, с Вами свяжется представитель Clubsreport для подтверждения регистрационных данных.\n\nС уважением, команда Clubsreport.\n\n";
		$smtp2=new smtp;
		$smtp2->Connect(SMTP_HOST);
		$smtp2->Hello(SMTP_HOST);
		$smtp2->Authenticate('support@clubsreport.com', 'Z1IRldqU');
		$smtp2->Mail('support@clubsreport.com');
		$smtp2->Recipient($_POST['email']);
		$smtp2->Data($message2, $subject2);
		
		$subject3 = "Заявка на регистрацию в системе Clubsreport";
		$message3 = "Здравствуйте, ".$_POST['title']."!\n\nВы подали заявку на регистрацию в системе Clubsreport.\n\nВ течение одного рабочего дня, с Вами свяжется представитель Clubsreport для подтверждения регистрационных данных.\n\nС уважением, команда Clubsreport.\n\n";
		$smtp3=new smtp;
		$smtp3->Connect(SMTP_HOST);
		$smtp3->Hello(SMTP_HOST);
		$smtp3->Authenticate('support@clubsreport.com', 'Z1IRldqU');
		$smtp3->Mail('support@clubsreport.com');
		$smtp3->Recipient('selina@reactor.ua');
		$smtp3->Recipient('inna.merk@reactor.ua');
		$smtp3->Data($message3, $subject3);
		}
		function sendfeedbackAction(){
			$subject = "Обратная связь брендов";
			$message = "E-mail: ".$_POST['email']."\n\nСообщение: ".$_POST['message']."\n\n";
			$smtp=new smtp;
			$smtp->Connect(SMTP_HOST);
			$smtp->Hello(SMTP_HOST);
			$smtp->Authenticate('reactor@reactor-pro.ru', '123qwe123');
			$smtp->Mail('reactor@reactor-pro.ru');
			if($_POST['subject']==1){
				$smtp->Recipient('selina@reactor.ua');
				$smtp->Recipient('inna.merk@reactor.ua');
			}
			elseif($_POST['subject']==4)
				$smtp->Recipient('dmitriy.bozhok@gmail.com');
			elseif($_POST['subject']==5){
				$smtp->Recipient('selina@reactor.ua');
				$smtp->Recipient('inna.merk@reactor.ua');
			}
			$smtp->Data($message, $subject);
		}
        function useragreementAction() {
            $this->clubsnum=$this->Group->getGroupscount();
            $this->clubsfav=$this->Group->getGroupsfav();
            $this->content=$this->view->AddView('/user/agreement', $this);
            $this->view->renderLayout('layout', $this);
        }
        function registerAction() {
                if($this->Session->User['id'])
                $this->registry->get->redirect('/');
                $this->Geo=new Geo;
                
                $this->countries=$this->Geo->getCounties();
                $this->clubsnum=$this->Group->getGroupscount();
                $this->token=$this->registry->token->getToken();
                if($this->Post->check || $this->Post->makeregister){
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
                        //tools::print_r($this->error);
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
    public function indicatorsAction(){
        $this->Request=new Request;
        echo json_encode(array(
            'favourites'=>intval($this->Group->getGroupsfav()),
            'requests'=>intval($this->Request->getRequestcnt()),
            'groups'=>intval($this->Group->getGroupscount())
        ));
        die();
    }
}
?>