<?php

require_once 'modules/base/controllers/BaseArtistAdmin_Controller.php';
require_once 'modules/artist/models/Release.php';

Class Ajax_Controller Extends BaseArtistAdmin_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->registry->token=new token;
		}
        function indexAction() {
		}
		function releaseinfoAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if($data['id']>0){
				$this->Release= new Release;
				echo json_encode($this->Release->getAdminReleaseInfo($data['id']));
			}
		}
		function musicstyleAction(){
			if(strlen(trim($_GET['term']))>2){
				$str=trim($_GET['term']);
				$db=db::init();
				$result=$db->queryFetchAllFirst('	
				SELECT 
					name 
				FROM
				  z_musictype 
				WHERE major=1 AND name LIKE "%'.$str.'%"
				');
				echo json_encode($result);
			}
		}
		
}


?>