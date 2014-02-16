<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Brand.php';
require_once 'modules/admin/models/Geo.php';
require_once 'modules/admin/models/Users.php';

Class Brands_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Brand=new Brand;
		}

        function indexAction() {
        	$this->sitelist=$this->Brand->getBrandList();
        	$this->content =$this->view->AddView('brands', $this);
			$this->view->renderLayout('admin', $this);
		}
		function requestsAction() {
			$this->sitelist=$this->Brand->getBrandRequests();
			$this->content =$this->view->AddView('brandrequests', $this);
			$this->view->renderLayout('admin', $this);
		}
		function offersAction() {
			$this->sitelist=$this->Brand->getClubOffers();
			$this->content =$this->view->AddView('brandoffers', $this);
			$this->view->renderLayout('admin', $this);
		}
		function offerinnerAction() {
			$this->Users=new Users;
			$this->sitelist=$this->Brand->getOfferInner($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('offerinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function brandinnerAction() {
			$this->Users=new Users;
			$this->userlist=$this->Users->getAllUsers();
			$this->brandinner=$this->Brand->getBrandInner($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('brandinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatebrandinnerAction() {
			$this->Brand->updateBrand($_POST,$_FILES);
			$this->registry->get->redirect('/admin/brands/');
		}
		function sendaccessAction(){
			$this->Users=new Users;
			$this->Users->sendAccess($_GET['id']);
			$this->registry->get->redirect('/admin/brands/');
		}
}


?>