<?php
require_once 'modules/artist/models/Menu.php';
require_once 'modules/artist/models/Design.php';

Abstract Class BaseArtist_Controller Extends Controller{

        private $registry;
		public $Session;
		function __construct($registry) {
				parent::__construct($registry);
        		$this->registry=$registry;
				if(!is_object($this->registry->get))
				$this->registry->get=new get;
				$this->registry->user=new user;
				$this->Menu = new Menu($this->registry);
				$this->Design = new Design;
				
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
				$this->sitedesc=$_SESSION['Site']['about'];
				if(strlen($this->sitedesc)>2)
				$this->sitedesc=strip_tags(str_replace('&nbsp;',' ',$this->sitedesc));
				else
				$this->sitedesc=$this->registry->sitedesc;
				
				if(!$_SESSION['Site']['active'] && !$_SESSION['User']['id'] && $this->registry->action!="login"){
				$this->registry->token=new token;
				$this->token=$this->registry->token->getToken(5);
				$this->pagebg=$this->Design->getPagebg($this->registry->controller);
				$this->view = new View($this->registry);
				$this->content =$this->view->AddView('unactive', $this);
				$this->view->renderLayout('unactive', $this);
				die();
				}
				
		}
		abstract function indexAction();

}


?>