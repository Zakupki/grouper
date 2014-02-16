<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Geo.php';

Class Geo_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Geo=new Geo;
		}

        function indexAction() {
        	$this->sitelist=$this->Geo->getCities();
        	$this->content =$this->view->AddView('cities', $this);
			$this->view->renderLayout('admin', $this);
		}
		function countriesAction() {
        	$this->sitelist=$this->Geo->getCountries();
        	$this->content =$this->view->AddView('countries', $this);
			$this->view->renderLayout('admin', $this);
		}
		function cityAction() {
			$this->country=$this->Geo->getCountries();
        	$this->cityinner=$this->Geo->getCity($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('cityinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		
		function updatecityinnerAction(){
			$this->Geo->updateCityinner($_POST);
			$this->registry->get->redirect('/admin/geo/');
		}
}


?>