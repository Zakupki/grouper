<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/News.php';
require_once 'modules/main/models/Reccount.php';


Class Reccounts_Controller Extends Base_Controller {
		private $registry;
		public $error;
		public $language=2;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->messageum=$this->registry->user->getMessages($this->Session->User['id']);
			
		}

        function indexAction() {
        		$db=db::init();
				$result=$db->queryFetchRow('
				SELECT 
				  SUM(z_operation.VALUE) AS total
				FROM
				  z_operation 
				WHERE z_operation.userid = '.intval($this->Session->User['id']).' 
				  AND z_operation.status = 2 
				');	
				$this->total=$result['total'];
				if(!$this->total)
				$this->total=0;
				$this->User['money']=$this->total;
				$this->Session->User=$this->User;
				
				$this->userid=$this->Session->User['id'];
				$this->token=$this->registry->token->getToken();
				$this->Reccount=new Reccount;
				$this->discount=$this->Reccount->getUserDiscount();
				$this->price=2000;
				$this->discprice=$this->price-$this->price/100*$this->discount;
				
				$db=db::init();
				$result=$db->queryFetchAllAssoc('SELECT * FROM z_sitetype WHERE onsite="Y"');
				foreach($result as $k=>$v){
					if(!$v['parentid'])
					$this->sitetypes[$v['id']]['data']=$v;
					else
					$this->sitetypes[$v['parentid']]['subcats'][$v['id']]=$v;
				}
				$this->News=new News;
				$this->newsline=$this->News->getNewsLine();
				$this->newslineblock=$this->view->AddView('blocks/newslineblock', $this);
				$this->content=$this->view->AddView('reccounts', $this);
				$this->view->renderLayout('layout', $this);
				
        }
		function buyAction() {
				if ($this->Post->isSent() && $this->Session->User['id']>0) {
					if ($this->Post->userid==$this->Session->User['id']) {
						$db=db::init();
						$result=$db->queryFetchRowAssoc("CALL addsite(".$this->Post->kind.",".$this->Session->User['id'].", ".$this->Post->quota.", ".$this->Post->period.", ".$this->Post->final_cost.", ".tools::int($_SESSION['langid']).")");
						if($result['siteid']>0){
						$_SESSION['User']['reccounts'][]=1;
						mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/');
						mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/img/');
						mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/mp3/');
						mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/files/');
						copy($_SERVER['DOCUMENT_ROOT'].'/img/reactor/profile/image-na.jpg', $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/img/image-na.jpg');
						copy($_SERVER['DOCUMENT_ROOT'].'/img/reactor/profile/video-na.jpg', $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/img/video-na.jpg');
						copy($_SERVER['DOCUMENT_ROOT'].'/img/reactor/profile/poster-na.jpg', $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/img/poster-na.jpg');
						if($this->Post->kind==7){
							$this->Reccount=new Reccount;
							$lagtempl=array(1=>151,2=>151);
							$this->Reccount->fillpartyAction($_SESSION['User']['id'],$result['siteid'],$lagtempl[$_SESSION['langid']]);
						}
						}
						$this->registry->get->redirect('/cabinet/myreccounts/#content'.$result['siteid']);
					}
				}
				else $this->registry->get->redirect('/reccounts/');
				
        }
		public function freeAction(){
				if ($this->Post->isSent() && $this->Session->User['id']>0) {
					if ($this->Post->userid==$this->Session->User['id']) {
						$db=db::init();
						$result=$db->queryFetchRowAssoc("CALL addfreesite(".$this->Post->kind.",".$this->Session->User['id'].")");
						if($result['siteid']>0){
						$_SESSION['User']['reccounts'][]=1;
						mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/');
						mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/img/');
						mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/mp3/');
						mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/files/');
						copy($_SERVER['DOCUMENT_ROOT'].'/img/reactor/profile/image-na.jpg', $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/img/image-na.jpg');
						copy($_SERVER['DOCUMENT_ROOT'].'/img/reactor/profile/video-na.jpg', $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/img/video-na.jpg');
						copy($_SERVER['DOCUMENT_ROOT'].'/img/reactor/profile/poster-na.jpg', $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$result['siteid'].'/img/poster-na.jpg');
						}
						$this->registry->get->redirect('/cabinet/myreccounts/'.$result['siteid']);
					}
				}
				else $this->registry->get->redirect('/reccounts/');
		}

}


?>