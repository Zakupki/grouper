<?
require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/api/models/Geo.php';

Class Geo_Controller Extends Base_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			header('Content-Type: application/json; charset=utf-8');
			$this->Geo=new Geo;
		}
        function indexAction() {
        	
        }
		function countriesAction() {
        	echo json_encode($this->Geo->getCountries());
        }
		function citiesAction() {
        	echo json_encode($this->Geo->getClubCities());
        }
}
?>