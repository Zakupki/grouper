<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Brand.php';
require_once 'modules/admin/models/Geo.php';
require_once 'modules/admin/models/Users.php';

Class Ajax_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
		}

        function indexAction() {
        	
		}
		function sendaccessAction() {
		}
		
}


?>