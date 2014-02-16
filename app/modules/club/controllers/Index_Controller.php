<?php

require_once 'modules/base/controllers/BaseClub_Controller.php';
require_once 'modules/club/widgets/Widget.php';
require_once 'modules/club/models/Reccount.php';
require_once 'modules/club/models/Design.php';
require_once 'modules/club/models/Social.php';
require_once 'modules/club/models/Track.php';
require_once 'modules/club/models/Support.php';
require_once 'modules/main/models/Geo.php';


Class Index_Controller Extends BaseClub_Controller {
		private $registry;
		
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

        function indexAction() {
        		$this->tracklist=$this->Track->getTracks(0,100);
				$this->Widget=new Widget($this->registry,$this->mainmenu);
				foreach($this->mainmenudata['data'] as $key=>$widget){
					if($widget['homewidget'] && $widget['active']){
						$method=$widget['code'];
						$this->widgets.=$this->Widget->$method($widget['name'],$key);
					}
				}
				$this->content=$this->view->AddView('index', $this);
				$this->view->renderLayout('layout', $this);
	    }
		function unactiveAction() {
			$this->content =$this->view->AddView('unactive', $this);
			$this->view->renderLayout('unactive', $this);			
		}
		function placeAction() {
			$this->place=$this->Reccount->getPlace();
			$this->tracklist=$this->Track->getTracks(0,100);
			$this->Widget=new Widget($this->registry,$this->mainmenu,0);
			$this->teaser=$this->Widget->teaser(true);	
				foreach($this->mainmenudata['data'] as $key=>$widget){
					if($widget['allwidget'] && $widget['active'] && $widget['code']!='place'){
						$method=$widget['code'];
						$this->widgets.=$this->Widget->$method($widget['name'],$key);
					}
				}
			$this->sitetitle=$this->pagename.'. '.$this->sitetitle;
			$this->sitedescription=$this->pagename.'. '.$this->sitedescription;
			$this->content =$this->view->AddView('place', $this);
			$this->view->renderLayout('layout', $this);			
		}
		function musicAction() {
			$this->tracks=$this->Track->getTracks(0,100);
			$this->tracklist=$this->tracks;
			$this->Widget=new Widget($this->registry,$this->mainmenu,0);
			$this->teaser=$this->Widget->teaser(true);	
				foreach($this->mainmenudata['data'] as $key=>$widget){
					if($widget['allwidget'] && $widget['active'] && $widget['code']!='music'){
						$method=$widget['code'];
						$this->widgets.=$this->Widget->$method($widget['name'],$key);
					}
				}
			$this->sitetitle=$this->pagename.'. '.$this->sitetitle;
			$this->sitedescription=$this->pagename.'. '.$this->sitedescription;
			$this->content =$this->view->AddView('music', $this);
			$this->view->renderLayout('layout', $this);			
		}
		function contactsAction() {
			$this->contacts=$this->Reccount->getСontacts();
			$this->Widget=new Widget($this->registry,$this->mainmenu,0);
			$this->teaser=$this->Widget->teaser(true);	
				foreach($this->mainmenudata['data'] as $key=>$widget){
					if($widget['allwidget'] && $widget['active'] && $widget['code']!='contacts'){
						$method=$widget['code'];
						$this->widgets.=$this->Widget->$method($widget['name'],$key);
					}
				}
			$this->sitetitle=$this->pagename.'. '.$this->sitetitle;
			$this->sitedescription=$this->pagename.'. '.$this->sitedescription;
			$this->content =$this->view->AddView('contacts', $this);
			$this->view->renderLayout('layout', $this);			
		}
		/*
		function testAction(){
					$db=db::init();
					$row=$db->queryFetchAllFirst('SELECT distinct(z_site.id) FROM 
					z_site 
					INNER JOIN
					  z_timeorder 
					  ON z_timeorder.siteid = z_site.id 
					  AND z_timeorder.date_end > NOW()
					WHERE z_site.userid=30');
					tools::print_r($row);
					
					$row=$db->queryFetchAllAssoc('SELECT distinct(z_site.id) FROM 
					z_site 
					INNER JOIN
					  z_timeorder 
					  ON z_timeorder.siteid = z_site.id 
					  AND z_timeorder.date_end > NOW()
					WHERE z_site.userid=30');
					tools::print_r($row);
					$this->Youtube= new Youtube;
					$response=$this->Youtube->getYoutubechanel('http://www.youtube.com/user/OurMarines');
					echo count($response);
					
					preg_match('/\/user\/(\w+)?$/', $url, $match);
				$graph_url=sprintf('http://gdata.youtube.com/feeds/api/users/%s/uploads?alt=json&start-index=1&max-results=10', 'OurMarines');
				$user = json_decode(file_get_contents(utf8_encode($graph_url)));
					echo $user->feed->{'openSearch$totalResults'}->{'$t'};
					tools::print_r($user);
					
				}*/
		function test2Action(){
			
			if($_SESSION['sescode']==$_GET['sescode']){
				$db=db::init();
				$result=$db->queryFetchRowAssoc('
				SELECT * 
				FROM z_auth 
				WHERE z_auth.authkey="'.tools::str($_GET['authkey']).'"
				AND ip=INET_ATON("'.$_SERVER['REMOTE_ADDR'].'") 
				AND z_auth.siteid='.tools::int($_SESSION['Site']['id']).' AND z_auth.expires>'.time().'');
				if($result['id']>0){
					$db->queryFetchRowAssoc('DELETE FROM z_auth WHERE z_auth.siteid='.tools::int($_SESSION['Site']['id']).' AND z_auth.userid='.$result['id'].'');	
					$_SESSION['sescode']=null;
				}
			}
			
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
							$this->error['login']=$this->registry->trans['incorrectlogin'];
							else{
								if($this->Valid->loginExists($this->Post->login)==false)
								$this->error['login']=$this->registry->trans['loginexists'];
							}
						}
						elseif(strlen($this->Post->login)<1 && !$this->Post->check) 
						$this->error['login']=$this->registry->trans['typeinlogin'];
						
						#Проверка Email
						if(strlen($this->Post->email)>0){
							if(!$this->Valid->isEmail($this->Post->email))
							$this->error['email']=$this->registry->trans['incorrectemail'];
							else{
								if($this->Valid->emailExists($this->Post->email)==false)
								$this->error['email']=$this->registry->trans['emailexists'];
							}
						}
						elseif(strlen($this->Post->email)<1 && !$this->Post->check) 
						$this->error['email']=$this->registry->trans['typeinemail'];
						
						if(strlen($this->Post->password)>0){
							if(strlen($this->Post->passwordcheck)>0){
								if($this->Post->password!=$this->Post->passwordcheck){
								$this->error['password']='&nbsp;';
								$this->error['password_check']=$this->registry->trans['passdismatch'];
								}
								
							}
							elseif(strlen($this->Post->password_check)<1 && !$this->Post->check) 
							$this->error['password_check']=$this->registry->trans['typeinpassword'];
							
						}
						elseif(strlen($this->Post->password)<1 && !$this->Post->check) 
						$this->error['password']=$this->registry->trans['typeinpassword'];
						
						
					
					if(!is_array($this->error) && !$this->Post->check)
					{
						$User=new user();
						$User->addUser($this->Post->asIterator());
						//$this->registry->get->redirect('/');
						if($this->registry->langid==1)
						$success='Вы успешно зарегистрированы! На ваш email отправлено письмо с активацией вашего аккаунта.';
						else
						$success='You registered successfully! Activate you account with the link sent to your email.';
						echo json_encode(array(
						'error'=>false, 
						'status'=>$success,
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
				
				
				
				$this->content=$this->view->AddView('register', $this);
				$this->view->renderLayout('layout', $this);
		}
		function activateAction(){
			$User=new user;
			if($User->activateUser($_GET['act']))
			$this->registry->get->redirect('/user/profile/');
			else
			$this->registry->get->redirect('/error/?error=1');
			
		}
		
		function helpAction(){
			
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
			$this->Support = new Support;
			$this->helpdata=$this->Support->getHelp($_GET['id']);
			if(!$this->helpdata || $_GET['id']<1)
			$this->helpdata=array('name'=>'Помощь', 'text'=>'В стадии наполнения.');
			$this->content=$this->view->AddView('/admin/popups/help', $this);
			$this->view->renderLayout('blank', $this);
		}
		function testAction(){
			//echo tools::getDirectorySize($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$SESSION['Site']['id'].'/');
			
			echo $this->registry->hddtotal;			
			//echo $directory_size->sizein;
		}
		function testformAction(){
		?>
		<form action="/test/" method="post" enctype="multipart/form-data">
   		<? if($this->view->requestdata['id']){?>
		<input name="id" type="hidden" value="<?=$this->view->requestdata['id'];?>" >
		<?}?>
		<? if($this->view->requestdata['file_name']){?>
		<input name="fileurl" type="hidden" value="<?=$this->view->requestdata['file_name'];?>" >
		<?}?>
		<? if($this->view->requestdata['file_oldname']){?>
		<input name="filename" type="hidden" value="<?=$this->view->requestdata['file_oldname'];?>" >
		<?}?>
		  <div class="field-message field">
		      <div class="label"><label>Описание</label></div>
		      <div class="textarea">
		          <textarea name="report"><?=$this->view->requestdata['report'];?></textarea>
		          <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
		      </div>
		  </div>
	
		  <div class="button-set">
		      <div class="upload widget">
		          <input type="file" name="file" class="file-input">
		          <div class="button button-attach"><div class="r"><div class="l">
		              <div style="overflow: hidden; width:35px; height:35px; margin:0 -20px 0 0; background:url('/img/club/icons/icon-attach-file.png') no-repeat center center;">
		              </div>
		          </div></div></div>
		          <span class="filename"></span>
		      </div>
	
		      <div class="button button-submit"><div class="r"><div class="l"><button type="submit">Отправить</button></div></div></div>
		  </div>


  		</form>
		<?}
}


?>