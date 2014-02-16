<?php
require_once 'modules/club/models/Menu.php';
require_once 'modules/club/models/Design.php';
require_once 'modules/club/models/Social.php';

Abstract Class BaseClub_Controller Extends Controller{

        private $registry;
		public $Session;
		function __construct($registry) {
			
				parent::__construct($registry);
        		$this->registry=$registry;
				
				$translate_array = parse_ini_file("config/clublang/".$_SESSION['Site']['languageid'].".ini");
				$this->registry->trans=$translate_array;
				$this->registry->langid=$_SESSION['Site']['languageid'];
				if(!is_object($this->registry->get))
				$this->registry->get=new get;
				$this->registry->user=new user;
				$this->Menu = new Menu($this->registry);
				$this->Design = new Design();
				$this->Social = new Social();
				
				
				
				
				if(!$_SESSION['sescode'])
				$_SESSION['sescode']=md5(MD5_KEY.microtime());
				
				
				if($_SESSION['sescode']==$_GET['sescode']){
					$db=db::init();
					$result=$db->queryFetchRowAssoc('
					SELECT * 
					FROM z_auth 
					WHERE z_auth.authkey="'.tools::str($_GET['authkey']).'"
					AND ip=INET_ATON("'.$_SERVER['REMOTE_ADDR'].'") 
					/*AND z_auth.siteid='.tools::int($_SESSION['Site']['id']).'*/ AND z_auth.expires>'.time().'');
					if($result['userid']>0){
						$db->queryFetchRowAssoc('DELETE FROM z_auth WHERE z_auth.siteid='.tools::int($_SESSION['Site']['id']).' AND z_auth.userid='.$result['userid'].'');	
						$_SESSION['sescode']=null;
						if($this->registry->user->loginUserById($result['userid']))
						$this->registry->get->redirect('/');
					}
				}
				
				$this->sitename=$_SESSION['Site']['name'];
				if(!$_SESSION['Site']['metatitle'])
                $this->sitetitle=$this->sitename;
                else
				$this->sitetitle=$_SESSION['Site']['metatitle'];
				$this->sitekeywords=$_SESSION['Site']['metakeywords'];
				$this->sitedescription=$_SESSION['Site']['metadescription'];
				/*
				if(strlen($this->sitedesc)>2)
								$this->sitedesc=strip_tags(str_replace('&nbsp;',' ',$this->sitedesc));
								else
								$this->sitedesc=$this->registry->sitedesc;*/
				
				
				if(isset($_COOKIE['react']) && $this->Session->User['id']<1){
					$userData=$this->registry->user->loginByCookie($_COOKIE['react']);
						if($userData){
							$_SESSION['User']=$userData;
							$this->User=$_SESSION['User'];		
						}
						else
						setcookie("react", '', time()-62*60*24*15, '/');					
				}
				
				$this->sitename=$_SESSION['Site']['name'];
		}
		abstract function indexAction();

}


?>