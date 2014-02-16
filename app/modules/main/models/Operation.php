<?
require_once 'modules/base/models/Basemodel.php';

Class Operation Extends Basemodel {
	
	public function popUp($sum){
		$db=db::init();
		$stmt=$db->prepare("INSERT INTO z_operation (operationtypeid,value,userid,status) VALUES (?,?,?,?)");
		$res=$stmt->execute(array(1,$sum,$_SESSION['User']['id'],1));
		if($res)
		$oper_id=$db->lastInsertId();
		return $oper_id;
	}
	public function updateOperation($id,$status,$transactionid,$xmlStr){
		$db=db::init();
		$statusArr=array('new'=>1, 'success'=>2, 'wait_secure'=>3, 'failure'=>4);
		
		$stmt=$db->prepare("UPDATE z_operation SET status=?, date_update=NOW(), xml=? WHERE id=?");
		$res=$stmt->execute(array(tools::int($statusArr[''.$status.'']), $xmlStr, tools::int($id)));
		//$stmt=$db->prepare("UPDATE z_operation SET status=?, date_update=NOW(), xml=? WHERE id=? AND userid=?");
		//$res=$stmt->execute(array(tools::int($statusArr[''.$status.'']), $xmlStr, tools::int($id)));
		echo tools::int($statusArr[''.$status.'']).'--'.tools::int($id);
		if($res)
		return $oper_id;
	}
}
?>