<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/News.php';

Class News_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->News=new News;
		}

        function indexAction() {
        	$this->newslist=$this->News->getNewsList();
			$this->content =$this->view->AddView('newslist', $this);
			$this->view->renderLayout('admin', $this);
		}
		function newsinnerAction(){
			$this->newsinner=$this->News->getNewsInner($this->registry->rewrites[1]);
			$this->content = $this->view->AddView('newsinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatenewsinnerAction(){
			$this->News->updateNewsInner($_POST);
			$this->registry->get->redirect('/admin/news/');
		}
}


?>