<?
require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/api/models/Event.php';

Class Events_Controller Extends Base_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			header('Content-Type: application/json; charset=utf-8');
			$this->Event=new Event;
		}
        function indexAction() {
        	echo json_encode($this->Event->getEvents($_GET));
        }
		 function geteventAction() {
        	echo json_encode($this->Event->getEventInner($_GET['id']));
        }
}
?>