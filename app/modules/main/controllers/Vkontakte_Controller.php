<?
require_once 'modules/base/controllers/Base_Controller.php';
Class Vkontakte_Controller Extends Base_Controller {
		private $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->ApplicationId = '3295306';
    		$this->Key ='lq0t0PggcK9YpWsCrkmp';
			$this->redirect_uri='http://reactor-pro.ru/vkontakte/callback/';
    	}
        function indexAction() {		
		}
	
		
		
		public function connectAction(){
			//$this->registry->get->redirect('https://oauth.vk.com/authorize?client_id='.$this->ApplicationId.'&scope=offline&redirect_uri='.$this->redirect_uri.'&response_type=code');
			//$this->registry->get->redirect('https://oauth.vk.com/authorize?client_id='.$this->ApplicationId.'&scope=offline&redirect_uri='.$this->redirect_uri.'&response_type=token');
			//$this->registry->get->redirect('https://oauth.vk.com/authorize/?client_id='.$this->ApplicationId.'&scope=stats,offline&redirect_uri='.$this->redirect_uri.'');
			//$this->registry->get->redirect('https://oauth.vk.com/authorize?client_id='.$this->ApplicationId.'&scope=offline,wall&redirect_uri='.$this->redirect_uri.'&response_type=token');
			$this->registry->get->redirect('http://api.vk.com/oauth/authorize?client_id='.$this->ApplicationId.'&redirect_uri='.$this->redirect_uri.'&display=page&response_type=token&scope=offline');
		}
		public function callbackAction(){
			tools::print_r($_REQUEST);	
			
			//if (!empty($_GET['code'])){
			        // вконтакт присылает нам код        
			        $vkontakteCode=$_REQUEST['code'];
			        
			        // получим токен 
			       // $sUrl = 'https://api.vkontakte.ru/oauth/access_token?client_id='.$this->ApplicationId.'&client_secret='.$this->Key.'&code='.$vkontakteCode.'';
					// $sUrl = 'https://api.vk.com/oauth/token?client_id='.$this->ApplicationId.'&code='.$vkontakteCode.'&client_secret='.$this->Key.'';
					//echo $sUrl;
					
					$sUrl='https://api.vk.com/method/groups.getMembers?gid=radioleika&access_token=edb0dbc7edc7597eedc7597e40edf51134eedc7edc6597ebd0c7c92d76da7cb6d2940fa';
					
					
					//создадим объект, содержащий ответ сервера Вконтакте, который приходит в формате JSON
			        $oResponce = json_decode(file_get_contents($sUrl));
			        //echo file_get_contents($sUrl);
			        tools::print_r($oResponce);
			        
			//}		
		}
		
		
}
?>