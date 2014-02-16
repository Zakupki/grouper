<?php

require_once 'modules/base/controllers/Base_Controller.php';

Class Index_Controller Extends Base_Controller {
		private $registry;
		
		public function __construct($registry){
			$this->registry=$registry;
			$this->view = new View($this->registry);
		}

        function indexAction() {
        	echo 'index';
		}
		function testAction() {
		}
		


}


?>