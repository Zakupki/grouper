<?
Abstract Class Base_Controller Extends Controller{
        private $registry;
		public $Session;
		function __construct($registry) {
				parent::__construct($registry);
        		$this->registry=$registry;
				if(!is_object($this->registry->get))
				$this->registry->get=new get;
				$this->registry->user=new user;
				
				
				if(!$_SESSION['sescode'])
				$_SESSION['sescode']=md5(MD5_KEY.microtime());
				
				
				if($_SESSION['sescode']==$_GET['sescode']){
					$db=db::init();
					$result=$db->queryFetchRowAssoc('
					SELECT * 
					FROM z_auth 
					WHERE z_auth.authkey="'.tools::str($_GET['authkey']).'"
					AND ip=INET_ATON("'.$_SERVER['REMOTE_ADDR'].'") 
					AND z_auth.siteid=1 AND z_auth.expires>'.time().'');
					if($result['userid']>0){
						$db->queryFetchRowAssoc('DELETE FROM z_auth WHERE z_auth.siteid=1 AND z_auth.userid='.$result['userid'].'');	
						$_SESSION['sescode']=null;
						if($this->registry->user->loginUserById($result['userid']))
						$this->registry->get->redirect('/');
					}
				}
				
				if(isset($_COOKIE['react']) && $this->Session->User['id']<1){
					$userData=$this->registry->user->loginByCookie($_COOKIE['react']);
						if($userData){
							$_SESSION['User']=$userData;
							$this->User=$_SESSION['User'];		
						}
						else
						setcookie("react", '', time()-62*60*24*15, '/');					
				}
				
				$this->sharetitle=$this->registry->sitetitle;
				$this->sharedesc=$this->registry->sitedesc;
				$this->sharehost=$this->registry->sitehost;
				$this->shareimage="http://".$_SERVER['HTTP_HOST']."/img/reactor/share.jpg";
				$this->banner='<div class="side-bn"><a target="_blank" href="[12:19:58] Alexey Hozyainov: http://www.fabriclondon.com/club/listings/"><img src="/img/reactor/banners/ec8b613e0d52eac698a3bd6388068d1d.gif" alt="side-bn1" width="160" height="600"></a></div>';
		}
        abstract function indexAction();
}
?>