<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Reccount.php';
require_once 'modules/admin/models/Geo.php';

Class Sites_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Reccount=new Reccount;
		}

        function indexAction() {
        	$this->sitelist=$this->Reccount->getSiteList();
        	$this->content =$this->view->AddView('sites', $this);
			$this->view->renderLayout('admin', $this);
		}
		function artistAction() {
        	$this->sitelist=$this->Reccount->getSiteList(1);
        	$this->content =$this->view->AddView('sites', $this);
			$this->view->renderLayout('admin', $this);
		}
		function clubAction() {
        	$this->sitelist=$this->Reccount->getSiteList(10);
        	$this->content =$this->view->AddView('sites', $this);
			$this->view->renderLayout('admin', $this);
		}
		
		function siteinnerAction() {
			$this->siteinner=$this->Reccount->getSiteInner($this->registry->rewrites[1]);
			if($this->siteinner['sitetypeid']==7){
				$this->Geo=new Geo;
				$this->city=$this->Geo->getCities();
			}
			$this->content =$this->view->AddView('siteinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatesiteinnerAction(){
			$this->Reccount->updateSiteInner($_POST);
			if($_POST['sitetypeid']==7)
			$this->registry->get->redirect('/admin/sites/club/');
			else
			$this->registry->get->redirect('/admin/sites/artist/');
		}
}


?>