<?php
require_once 'modules/artist/models/Menu.php';

Abstract Class BaseArtistAdmin_Controller Extends Controller{

        private $registry;
		private $Session;
		function __construct($registry) {
				parent::__construct($registry);
        		$this->registry=$registry;
				if(!is_object($this->registry->get))
				$this->registry->get=new get;
				$this->registry->user=new user;
				$this->Menu = new Menu;
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