<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Mail.php';

Class Mail_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Mail=new Mail;
		}

        function indexAction() {
        	$this->mailist=$this->Mail->getMailList();
        	$this->content =$this->view->AddView('mail', $this);
			$this->view->renderLayout('admin', $this);
		}
		function mailinnerAction() {
        	$this->mailinner=$this->Mail->getMailInner($this->registry->rewrites[1]);
        	$this->content =$this->view->AddView('mailinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatemailinnerAction(){
			$this->Mail->updateMailInner($_POST);
			$this->registry->get->redirect('/admin/mail/');
		}
		function sendmailAction(){
		$db=db::init();
		
		switch ($_POST['send']) {
		    case 1:
		        $result=$db->queryFetchAllAssoc('
				SELECT email FROM z_user WHERE email IS NOT NULL
				');
				break;
		    case 2:
		        $result=$db->queryFetchAllAssoc('SELECT 
				  z_user.email,
				  z_site.sitetypeid 
				FROM
				  z_user 
				  INNER JOIN
				  z_site 
				  ON z_site.userid = z_user.id 
				  INNER JOIN
				  z_sitetype 
				  ON z_sitetype.id = z_site.sitetypeid AND z_sitetype.parentid=1
				GROUP BY z_user.id ');
		        break;
		    case 3:
		        $result=$db->queryFetchAllAssoc('SELECT 
				  z_user.email,
				  z_site.sitetypeid 
				FROM
				  z_user 
				  INNER JOIN
				  z_site 
				  ON z_site.userid = z_user.id 
				  INNER JOIN
				  z_sitetype 
				  ON z_sitetype.id = z_site.sitetypeid AND z_sitetype.parentid=10
				GROUP BY z_user.id ');
		        break;
			case 4:
		        $result=$db->queryFetchAllAssoc('SELECT 
				  z_user.email 
				FROM
				  z_user 
				  LEFT OUTER JOIN
				  z_site 
				  ON z_site.userid = z_user.id 
				WHERE z_site.userid IS NULL
				GROUP BY z_user.id');
		        break;
		}
		if(is_array($result)){
			$subject = $_POST['subject'];
			$message = $_POST['detail_text'];
			
			foreach($result as $user){
				$smtp=new smtp;
				$smtp->Connect(SMTP_HOST);
				$smtp->Hello(SMTP_HOST);
				$smtp->Authenticate('reactor@reactor-pro.ru', '123qwe123');
				$smtp->Mail('reactor@reactor-pro.ru');
				$smtp->Recipient($user['email']);
				$smtp->Data($message, $subject);
			}
			
		}
		$this->registry->get->redirect('/admin/mail/');
		}
	
}


?>