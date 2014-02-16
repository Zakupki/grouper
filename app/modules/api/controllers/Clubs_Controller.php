<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/api/models/Club.php';

Class Clubs_Controller Extends Base_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			header('Content-Type: application/json; charset=utf-8');
		}

        function indexAction() {
       		header('Content-Type: application/json; charset=utf-8');
        	$this->Club=new Club;
			echo json_encode($this->Club->getClubs($_GET));
        }
		function getclubAction() {
       		header('Content-Type: application/json; charset=utf-8');
        	$this->Club=new Club;
			echo json_encode($this->Club->getClubInner($_GET['id']));
		}
}
?>