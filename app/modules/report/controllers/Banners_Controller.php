<?php

require_once 'modules/base/controllers/BaseReport_Controller.php';
require_once 'modules/report/models/Banner.php';
require_once 'modules/report/models/Club.php';

Class Banners_Controller Extends BaseReport_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			if(!$_SESSION['User']['id'])
			$this->registry->get->redirect('/');
			$this->view = new View($this->registry);
			$this->registry->token=new token;
		}

        function indexAction() {
        	$this->Banners=new Banner;
			$this->bannerlist=$this->Banners->getBanners();
       		$this->Club=new Club;
			$this->clubsnum=$this->Club->getClubscount();
			$this->clubsfav=$this->Club->getClubsfav();
			$this->content=$this->view->AddView('banners', $this);
			$this->view->renderLayout('layout', $this);
		}
		function bannerinnerAction() {
        	$this->Club=new Club;
			$this->clubsnum=$this->Club->getClubscount();
			$this->clubsfav=$this->Club->getClubsfav();
			$this->Banner=new Banner;
			$this->bannerinner=$this->Banner->getBannerRequestInner($this->registry->rewrites[1]);
			$this->Banner->visitBanner($this->registry->rewrites[1]);
			$this->content=$this->view->AddView('bannerinner', $this);
			$this->view->renderLayout('layout', $this);
		}
		function getbannerAction() {
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
        	$this->Club=new Club;
			$this->clubsnum=$this->Club->getClubscount();
			$this->clubsfav=$this->Club->getClubsfav();
        	$this->Banner=new Banner;
			$this->bannerinner=$this->Banner->getBannerRequest($_GET['id']);
			$this->content=$this->view->AddView('popups/getbanner', $this);
			$this->view->renderLayout('blank', $this);
		}
		function getclubgaAction(){
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
			$this->Club=new Club;
			echo json_encode(array('ga'=>tools::int($this->Club->getClubsGa($_REQUEST['id']))));
		}
		function updatebannerAction(){
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
			$this->Banners=new Banner;
			$this->Banners->updateBannerRequest($_REQUEST,$_FILES);
		}
		
}?>