<?
abstract class Controller{
	private $registry;
	public $Post;
	public $Valid;
	public $User;
	function __construct($registry) {
		$this->request_uri=$_SERVER['REQUEST_URI'];
		$this->registry=$registry;
		$this->Post=new post;
		$this->Valid=new valid;
		$this->Tools=new tools;
		$this->Session=session::init();
		$this->Cookies=cookies::init();
		$this->User=$this->Session->User;
	}
	public function print_r($arr){
		echo "<pre style='color:black;'>";
		print_r($arr);
		echo "</pre>";
	}
}
?>