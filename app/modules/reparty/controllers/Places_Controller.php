<?php
require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/reparty/models/Place.php';

Class Places_Controller Extends Base_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Place=new Place;
		}

        function indexAction() {
        	$this->places=$this->Place->getPlaces();
			$this->content=$this->view->AddView('places', $this);
			$this->view->renderLayout('layout', $this);
        }
		
}
?>