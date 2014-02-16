<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/Operation.php';

Class Operation_Controller Extends Base_Controller {
		public $registry;
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
		}
		
		function indexAction() {
        
		}
		
		function operationresponseAction(){
			
			
			//$merc_sig=
			//tools::print_r($_SERVER);
			$xmlStr=base64_decode($_POST['operation_xml']);
			$rec_sign=base64_decode($_POST['signature']);
			
			$db=db::init();
			$stmt=$db->prepare("INSERT INTO _request (ip,xml,sign) VALUES (?,?,?)");
			$stmt->execute(array($_SERVER['REMOTE_ADDR'],$xmlStr,$rec_sign));
			
			/*$sign=base64_encode(sha1($merc_sig.$xml($rec_sign).$merc_sig,1)); 
			*/
			/*$xmlStr="
			<response>
			<sender_phone>+380931520242</sender_phone>
			<status>failure</status>
			<version>1.2</version>
			<order_id>22</order_id>
			<merchant_id>i8584647759</merchant_id>
			<pay_details></pay_details>
			<description>Пополнение счета</description>
			<currency>UAH</currency>
			<amount>0.20</amount>
			<pay_way>card</pay_way>
			<transaction_id>15870043</transaction_id>
			<action>server_url</action>
			<code></code>
			</response>";*/
			$xml = simplexml_load_string($xmlStr);
			$this->Operation=new Operation;
			$this->Operation->updateOperation(trim($xml->order_id), trim($xml->status), trim($xml->transaction_id), $xmlStr);
			//tools::print_r($xml);
		}
}


?>