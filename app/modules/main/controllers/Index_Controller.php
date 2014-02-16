<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/Release.php';
require_once 'modules/main/models/News.php';
require_once 'modules/main/models/Support.php';
require_once 'modules/main/models/Geo.php';
require_once 'modules/main/models/Reccount.php';

Class Index_Controller Extends Base_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->News=new News;
			$this->newsline=$this->News->getNewsLine();
			$this->newslineblock=$this->view->AddView('blocks/newslineblock', $this);
			$this->messageum=$this->registry->user->getMessages($this->Session->User['id']);
		}

        function indexAction() {
        		/*if(!$this->Session->User->id)
        		$this->token=$this->registry->token->getToken();
				$this->Release=new Release;
				$this->News=new News;
				$this->releasetype=$this->Release->getLatestRelease(0,20,1);
				$this->newslist=$this->News->getLatestNews();
				$this->newsline=$this->News->getNewsLine();
				$this->newslineblock=$this->view->AddView('blocks/newslineblock', $this);
				$this->content=$this->view->AddView('index', $this);
				$this->view->renderLayout('layout', $this);*/
				
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
		        $str=uniqid();
		        $_SESSION['ADR_CAPTCHA']=substr($str, strlen($str)-4, strlen($str));
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
		function testAction(){
			tools::print_r($_SERVER);
			/*$db=db::init();
			$sth=$db->prepare('SELECT 
					*
					FROM
					  z_user
					WHERE z_user.login=:login
					LIMIT 0,1');
			//$sth->bindParam(':calories', $calories, PDO::PARAM_INT);
			$login='orange';
			$sth->bindParam(':login', $login, PDO::PARAM_STR);
			$sth->execute();
			
			$result=$sth->fetchAll();
			
			tools::var_dump($sth);*/
			
			//$exobj=$pObj->execute(array("orange"));
			
			/*$row=$db->queryFetchRow('SELECT 
					*
					FROM
					  z_user
					WHERE z_user.login="orange"
					LIMIT 0,1');*/
			
			//echo $pObj->queryString;
			
			/*$data = file_get_contents($_SERVER['DOCUMENT_ROOT']."/111.txt"); //read the file
			$convert = explode("\n", $data); //create array separate by new line
			$db=db::init();
			$cnt=0;
			for ($i=0;$i<count($convert);$i++) 
			{
			    $data=null;
				$fileid=null;
			    $data=explode(';',trim($convert[$i]));
				echo $data[0].' - '.$data[1].'<br/>';
				$row1=$db->exec('insert into z_file (subdir,file_name) values ("social","'.$data[1].'")');
				
				$fileid=$db->lastInsertId();
				
				$row=$db->exec('insert into z_social (name,url,preview_image,active) values ("'.$data[0].'","'.$data[0].'",'.$fileid.',1)');
				//echo $db->lastInsertId();
				
				//echo $convert[$i].', '; //write value by index
			$cnt++;    
			}
			echo $cnt;*/
		}
		function test2Action(){
			echo $_COOKIE['Test'];
		}
		function popupendAction(){
			$this->content =$this->view->AddView('popupend', $this);
			$this->view->renderLayout('layout', $this);
			
		}	
		function soonAction(){
			$data = array(
			    'error' => false,
			    'status' => 'Форма отправлена',
			    'token' => md5(rand())
			);
			
			echo json_encode($data);
		}
		function fillpartyAction(){
			die();
			$siteidfrom=151;
			$siteidto=163;
			$useridto=40;
			
			$db=db::init();
			$result=$db->queryFetchAllAssoc('SELECT 
				z_event.name,
				z_event.date_start,
				z_event.detail_text,
				z_event.itemid,
				z_event.coverid,
				z_event.posterid,
				CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/",
				    z_cover.url
				  ) AS cover,
				CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/",
				    z_poster.url
				  ) AS poster
			FROM z_event
			LEFT JOIN z_cover
			ON z_cover.id=z_event.coverid
			LEFT JOIN z_poster
			ON z_poster.id=z_event.posterid
			WHERE z_event.siteid='.$siteidfrom.'');
			
			foreach($result as $event){
				$newcoverid='NULL';
				$newposterid='NULL';
				$path_parts=null;
				$path_parts2=null;
				if($event['coverid']>0){
					$path_parts=pathinfo($event['cover']);
					$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
					copy($_SERVER['DOCUMENT_ROOT'].$event['cover'], $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteidto.'/img/'.$newfilename);
					$db->exec('INSERT INTO z_cover (url, siteid, userid, active) VALUES ("'.$newfilename.'", '.$siteidto.', '.$useridto.',1)');
					$newcoverid=$db->lastInsertId();
				}
				if($event['posterid']>0){
					$path_parts2=pathinfo($event['poster']);
					$newfilename=md5(uniqid().microtime()).".".$path_parts2['extension'];
					copy($_SERVER['DOCUMENT_ROOT'].$event['poster'], $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteidto.'/img/'.$newfilename);
					$db->exec('INSERT INTO z_poster (url, siteid, userid, active) VALUES ("'.$newfilename.'", '.$siteidto.', '.$useridto.',1)');
					$newposterid=$db->lastInsertId();
				}
						
				
				$artistresult=$db->queryFetchAllAssoc('SELECT * from z_artist WHERE itemid='.$event['itemid'].'');
				$itemid=null;
				$db->exec('INSERT INTO _items (datatypeid, siteid, userid) VALUES (9, '.$siteidto.', '.$useridto.')');
				$itemid=$db->lastInsertId();
				$db->exec('INSERT INTO z_event (name, date_start, detail_text, active, userid, siteid, itemid, coverid, posterid) 
				VALUES 
				("'.$event['name'].'", "'.$event['date_start'].'", "'.$event['detail_text'].'", 1, '.$useridto.', '.$siteidto.', '.$itemid.', '.$newcoverid.', '.$newposterid.')');
				if(is_array($artistresult))
				foreach($artistresult as $artist){
					$db->exec('INSERT INTO z_artist(name,comment,itemid,siteid,userid,support,sort) VALUES 
					("'.$artist['name'].'", "'.$artist['comment'].'", '.$itemid.', '.$siteidto.', 
					'.$useridto.', '.$artist['support'].', '.$artist['sort'].')
					'); 
				}
			}
			#Баннера
			$teaserresult=$db->queryFetchAllAssoc(
			'SELECT
			z_teaser.link,
			CONCAT(
			 "/uploads/sites/",
			 z_teaser.siteid,
			 "/img/",
			 z_teaser.file_name
			) AS url,
			z_teaser.sort
			FROM z_teaser WHERE z_teaser.siteid='.$siteidfrom.'');
			if(is_array($teaserresult))
			foreach($teaserresult as $teaser){
				$path_parts3=null;
				$newfilename=null;
				$path_parts3=pathinfo($teaser['url']);
				$newfilename=md5(uniqid().microtime()).".".$path_parts3['extension'];
				copy($_SERVER['DOCUMENT_ROOT'].$teaser['url'], $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteidto.'/img/'.$newfilename);
					
				$db->exec('INSERT INTO z_teaser (link, active, file_name, siteid, userid, sort) VALUES
				("'.$teaser['link'].'", 1, "'.$newfilename.'", '.$siteidto.', '.$useridto.', '.$teaser['sort'].')
				');
			}
		}
}


?>