<?php
require_once 'modules/club/models/Menu.php';

Abstract Class BaseClubAdmin_Controller Extends Controller{

        private $registry;
		private $Session;
		function __construct($registry) {
				parent::__construct($registry);
        		$this->registry=$registry;
				$translate_array = parse_ini_file("config/clublang/".$_SESSION['Site']['languageid'].".ini");
				$this->registry->trans=$translate_array;
				$this->registry->langid=$_SESSION['Site']['languageid'];
				if(!is_object($this->registry->get))
				$this->registry->get=new get;
				$this->registry->user=new user;
				$this->Menu = new Menu;
				
				#hdd space
				
				
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
                if(!$_SESSION['Site']['metatitle'])
                $this->sitetitle=$this->sitename;
                else
                $this->sitetitle=$_SESSION['Site']['metatitle'];
                
                
				if($_SESSION['Site']['disk']>0){
					//$this->registry->hddtotal=$_SESSION['Site']['disk'];
				}
				if($_SESSION['Site']['disk']>(1024*1024*1024*20)){
					$this->registry->hdderror=1;
					$this->registry->hddtotal=tools::sizeFormat($_SESSION['Site']['disk']);
					$this->registry->hddlimit='20 Gb';
				}

				if(!$_SESSION['User']['id'])
				$this->registry->get->redirect('/');		
		}
		abstract function indexAction();

}


?>