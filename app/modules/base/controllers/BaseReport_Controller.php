<?
require_once 'modules/report/models/Operation.php';
Abstract Class BaseReport_Controller Extends Controller{
        private $registry;
		public $Session;
        public $currencyname='грн.';
		function __construct($registry) {
				parent::__construct($registry);
      /* $ipArr=array('77.90.194.106','77.52.149.200','193.34.72.205','95.133.181.99','46.200.215.212','94.248.2.34','178.94.76.24'); 
		if(!in_array($_SERVER['REMOTE_ADDR'], $ipArr)){
			require_once 'atelier.html';
			die();
		}*/	


                $this->registry=$registry;
				if(!is_object($this->registry->get))
				$this->registry->get=new get;
				$this->registry->user=new user;
				
				if(!$_SESSION['sescode'])
				$_SESSION['sescode']=md5(MD5_KEY.microtime());
				
				if(!$_SESSION['sescode'])
				$_SESSION['sescode']=md5(MD5_KEY.microtime());
				
				if($_SESSION['User']['noemail']){
                    if($this->registry->controller=='user' && $this->registry->action=='profile' OR $this->registry->controller=='user' && $this->registry->action=='updateprofile'){
                    }else{
                        $this->registry->get->redirect('/user/profile/');
                    }
                }
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
				
				if(isset($_COOKIE['report']) && $this->Session->User['id']<1){
					$userData=$this->registry->user->loginReportByCookie($_COOKIE['report']);
						if($userData){
							$_SESSION['User']=$userData;
							$this->User=$_SESSION['User'];		
						}
						else
						setcookie("report", '', time()-62*60*24*15, '/');					
				}
				
				
				/*
				#COUNTRY SELECTION
								if(!isset($_SESSION['countryid'])){
									if(isset($_COOKIE['countryid'])){
										$_SESSION['countryid']=$_COOKIE['countryid'];
									}else{
										$countrydata=$this->registry->user->defineCountry();
										if($countrydata['id']>0){
											$_SESSION['countryid']=$countrydata['id'];
											setcookie("countryid", $countrydata['id'], time()+60*60*24*30, '/');
											if(!isset($_SESSION['languageid']) && !isset($_COOKIE['languageid'])){
												$_SESSION['languageid']=$countrydata['langeageid'];
												setcookie("languageid", $countrydata['langeageid'], time()+60*60*24*30, '/');
											}
											
										}
									}		
								}
								#LANGUAGE SELECTION
								if(!isset($_SESSION['languageid'])){
									
									if(isset($_COOKIE['languageid'])){
										$_SESSION['languageid']=$_COOKIE['languageid'];
									}else{
										$langdata=$this->registry->user->defineCountry();
										if($langdata['id']>0){
											$_SESSION['languageid']=$langdata['languageid'];
											setcookie("languageid", $langdata['languageid'], time()+60*60*24*30, '/');
										}
									}
								}*/
				
				
				
				if($this->registry->brandcode && $this->Session->User['id']<1 && $this->registry->controller!='user')
				if($this->registry->action=='login' && $this->registry->controller=='index'){}
				else{
				$this->registry->get->redirect('/login/');
				}
				$this->sharetitle=$this->registry->sitetitle;
				$this->sharedesc=$this->registry->sitedesc;
				$this->sharehost=$this->registry->sitehost;
				$this->shareimage="http://".$_SERVER['HTTP_HOST']."/img/reactor/share.jpg";
				$this->banner='<div class="side-bn"><a target="_blank" href="http://www.fabriclondon.com/club/listings/"><img src="/img/reactor/banners/ec8b613e0d52eac698a3bd6388068d1d.gif" alt="side-bn1" width="160" height="600"></a></div>';
                $this->Operation = new Operation;
                $_SESSION['User']['money']=$this->balance=$this->Operation->getBalanceTotal();
        }
        abstract function indexAction();
}
?>