<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Payrequest.php';

Class Payrequest_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
            $this->Payrequest=new Payrequest;
		}

        function indexAction() {

            if($_REQUEST['confirm']>0){
                $this->Payrequest->confirmRequest($_GET['confirm']);
            }
            $this->list=$this->Payrequest->getList();
			$this->content =$this->view->AddView('payrequest/index', $this);
			$this->view->renderLayout('admin', $this);
		}
}


?>