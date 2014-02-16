<?php
require_once 'modules/base/controllers/BaseClubAdmin_Controller.php';
require_once 'modules/club/models/Users.php';

Class Clients_Controller Extends BaseClubAdmin_Controller {
		private $registry;
		public $error;
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			
			if($this->Session->User['id']<1 || $this->Session->User['id']!=$this->Session->Site['userid'])
			$this->registry->get->redirect('/');
			
			$this->view = new View($this->registry);
			//$this->registry->token=new token;
			
			$this->messageum=$this->registry->user->getMessages($this->Session->User['id']);
		}
		
		function indexAction() {
			$this->mainmenudata=$this->Menu->getMenuItems();
        	$this->mainmenu=$this->mainmenudata['html'];
			$this->Users=new Users;
			$this->clients=$this->Users->getSitevisitors();
			$this->content=$this->view->AddView('admin/clients', $this);
        	$this->view->renderLayout('layout', $this);
        }
		
		function cardsAction() {
			$this->mainmenudata=$this->Menu->getMenuItems();
        	$this->mainmenu=$this->mainmenudata['html'];
			$this->Users=new Users;
			$this->cards=$this->Users->getSitevisitors();
			$this->clients=$this->Users->getSitevisitorsShort();
			$this->content=$this->view->AddView('admin/cards', $this);
        	$this->view->renderLayout('layout', $this);
        }
		function getcarddataAction() {
			if (!tools::IsAjaxRequest())
			die();
			$this->Users=new Users;
			=$this->Users->getCardData();
		}

}
?>