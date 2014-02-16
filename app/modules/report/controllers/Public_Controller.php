<?
require_once 'modules/base/controllers/BaseReport_Controller.php';
require_once 'modules/report/models/Group.php';
require_once 'modules/report/models/Publics.php';

Class Public_Controller Extends BaseReport_Controller {
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
            $this->publicpage=1;
        	$this->Group=new Group;
			$this->clubsnum=$this->Group->getGroupscount();
			$this->clubsfav=$this->Group->getGroupsfav();
			$this->Publics=new Publics;
			$this->publics=$this->Publics->getPublicRequests();
			$this->content=$this->view->AddView('public', $this);
			$this->view->renderLayout('layout', $this);
		}
		function publicinnerAction() {
            $this->Group=new Group;
			$this->clubsnum=$this->Group->getGroupscount();
			$this->clubsfav=$this->Group->getGroupsfav();
			$this->Publics=new Publics;
			$this->publicinner=$this->Publics->getPublicRequestInner($this->registry->rewrites[1]);
			$this->Publics->visitPublic($this->registry->rewrites[1]);
			$this->content=$this->view->AddView('publicinner', $this);
			$this->view->renderLayout('layout', $this);
		}
        function addAction() {
            $this->Group=new Group;
            if($_GET['group_id']>0){
                $this->groupdata=$this->Group->getGroupInner($_GET['group_id']);
                $this->publicinner['filtertype']=3;
            }
            if($_GET['id']>0){
                $this->Publics=new Publics;
                $this->publicinner=$this->Publics->getPublicRequestData($_GET['id']);
                $this->filterdata=json_encode(unserialize($this->publicinner['filters']));
            }
            $this->clubsnum=$this->Group->getGroupscount();
            $this->clubsfav=$this->favnum=$this->Group->getGroupsfav();
            $this->subjects=$this->Group->getSubjects();
            $this->othergroups=$this->Group->getOthergroups();
            $this->countries=$this->Group->getCountries();
            $this->agerange=$this->Group->getAgerange();
            $this->pricerange=$this->Group->getPricerange();
            $this->repostpricerange=$this->Group->getPricerange();
            $this->statsrange=$this->Group->getStatsrange();
            $this->gender=$this->Group->getGenderFilters();

            $this->content=$this->view->AddView('addpublic', $this);
            $this->view->renderLayout('layout', $this);
        }
        function filterAction() {
            $this->Group=new Group;
            $data=$this->Group->getFilters($_POST);
            //if($_SERVER['REMOTE_ADDR']=='31.42.52.10')
            //print_r($_POST);
            echo json_encode($data);
            //print_r($_POST);            
        }
		function getpublicAction() {
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
			$this->Group=new Group;
			$this->clubsnum=$this->Group->getGroupscount();
			$this->clubsfav=$this->Group->getGroupsfav();
			$this->Publics=new Publics;
			$this->publicinner=$this->Publics->getPublicRequest($_GET['id']);
        	$this->content=$this->view->AddView('popups/getpublic', $this);
			$this->view->renderLayout('blank', $this);
		}
		function updatepublicAction() {
			$this->Publics=new Publics;
        	$this->Publics->updatePublicRequest($_REQUEST,$_FILES);
		}
		function getgroupgrpAction(){
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
			$this->Group=new Group;
			echo json_encode(array('grp'=>tools::int($this->Group->getGroupsGrp($_REQUEST['id']))));
		}
		/* function getmoreAction() {
        	$this->Group=new Group;
			$this->clubs=$this->Group->getGroups(tools::int($_GET['start']),tools::int($_GET['take']),$_GET);
			$this->content=$this->view->AddView('moreclubs', $this);
			$this->view->renderLayout('blank', $this);
		}*/
		
}
?>