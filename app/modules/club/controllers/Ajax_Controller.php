<?php

require_once 'modules/base/controllers/BaseClub_Controller.php';
require_once 'modules/club/models/Request.php';
require_once 'modules/club/models/Brand.php';



Class Ajax_Controller Extends BaseClub_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
            if(!tools::IsAjaxRequest())
            $this->registry->get->redirect('/');
			$this->Request=new Request;
			}

        function indexAction() {
        }
		function getunreadnoticesAction() {
			echo $this->Request->unreadRequestNum();
        }
		function bannerdisplayAction() {
			$this->Request->bannerDisplay($_REQUEST['id']);
        }
		function bannerclickAction() {
			$this->Request->bannerClick($_REQUEST['id']);
        }
		function findbrandAction(){
			header('Content-Type: application/json; charset=utf-8');
			$this->Brand=new Brand;
			$this->clublist=$this->Brand->findBrand($_GET['term']);
			echo json_encode($this->clublist);
		}
}
?>