<?
require_once 'modules/base/controllers/Base_Controller.php';
Class Facebook_Controller Extends Base_Controller {
		private $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
		}

        function indexAction() {		
		echo  $_SESSION['facebookid'];
        }
		public function connectAction(){
		   $this->Facebook=new Facebook;
		   if($this->Facebook->connect()){
		   $this->registry->get->redirect('/');
		   }
		}
		public function connect2Action(){
			$this->Facebook=new Facebook;
			//$_SESSION['referer']=$_SERVER['HTTP_REFERER'];
			//echo $_SESSION['referer'];
			$returndata=$this->Facebook->connect2($_GET['url'],$_GET['sescode']);
			if($returndata['userid']>0)
			$this->registry->get->redirect('http://'.$_SESSION['ref'].'/?sescode='.$_SESSION['scode'].'&authkey='.$returndata['key'].'');
			
		}
		
		public function unlinkAction(){
			if(!$_POST['password'] && $_POST['new_password']==$_POST['new_password_confirm']){
			$this->User = new User;
			$this->User->addPassword($_POST['new_password'],$_POST['new_password_confirm']);
			}
			$this->Facebook = new Facebook;
			$this->Facebook->disconnect($_POST['accountid']);
			$_SESSION['User']['haspasword']=1;
			
			$data=array('error'=>false,'status'=>'');
			echo json_encode($data);
			
			
		}
		
}
?>