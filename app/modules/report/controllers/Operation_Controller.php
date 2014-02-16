<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/report/models/Operation.php';

Class Operation_Controller Extends Base_Controller {
		public $registry;
        public function __construct($registry){
            parent::__construct($registry);
            $this->registry=$registry;
            $this->view = new View($this->registry);
        }
		
		function indexAction() {
        
		}
		
		function operationresponseAction(){
			$data=$_POST;
			$db=db::init();
			$stmt=$db->prepare("INSERT INTO _request (ip,xml,sign) VALUES (?,?,?)");
			$stmt->execute(array($_SERVER['REMOTE_ADDR'],serialize($data),123));

            $this->Operation=new Operation;
            $this->Operation->updateOperation($data['ik_payment_id'], $data['ik_payment_state'], $data['ik_trans_id'], serialize($data));
		}
        function successAction(){
            $this->content ='<div class="centerwrap clearfix">Ваш платеж принят и ожидает подтверждения.</div>';
            $this->view->renderLayout('layout', $this);
        }
}


?>