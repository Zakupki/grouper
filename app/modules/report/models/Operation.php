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
		$statusArr=array('new'=>1, 'success'=>2, 'wait_secure'=>3, 'fail'=>4);
		
		$stmt=$db->prepare("UPDATE z_operation SET status=?, date_update=NOW(), xml=? WHERE id=?");
		$res=$stmt->execute(array(tools::int($statusArr[''.$status.'']), $xmlStr, tools::int($id)));
		//$stmt=$db->prepare("UPDATE z_operation SET status=?, date_update=NOW(), xml=? WHERE id=? AND userid=?");
		//$res=$stmt->execute(array(tools::int($statusArr[''.$status.'']), $xmlStr, tools::int($id)));
		echo tools::int($statusArr[''.$status.'']).'--'.tools::int($id);
		if($res)
		return $oper_id;
	}
    public function getOperationTypes(){
        $db=db::init();
        $result=$db->queryFetchAllAssoc('
                    SELECT 
                      *
                    FROM
                      z_operationtype
                    ');
        return $result;
    }
    public function getOperaytions($data){
        
        
        if($data['start']<1)
        $data['start']=0;
        if($data['take']<1)
        $data['take']=5;
        
        $data['take']=$data['take']+1;
        
        if($data['operationtypeid']>0)
        $Where.=' AND z_operation.operationtypeid='.tools::int($data['operationtypeid']);
        
        $db=db::init();    
        $result=$db->queryFetchAllAssoc('
            SELECT 
              z_operation.id,
              z_operation.date_create,
              z_operation.value,
              z_operation.balance,
              z_operationtype.name,
              z_public_group.publicid,
              z_public_group.groupid,
              z_group.url as groupurl,
              z_operation.publicgroupid,
              if(z_operationstatustype.id, z_operationstatustype.name,z_operation.status) AS status
            FROM
              z_operation 
              INNER JOIN
              z_operationtype 
              ON z_operationtype.id = z_operation.operationtypeid
              LEFT JOIN z_operationstatustype
              ON z_operationstatustype.id=z_operation.status
            LEFT JOIN z_public_group
            ON z_public_group.id=z_operation.publicgroupid
            LEFT JOIN z_group
            ON z_group.id=z_public_group.groupid
            WHERE z_operation.userid = '.tools::int($_SESSION['User']['id']).'
              AND z_operation.status>0
              '.$Where.'
            ORDER by date_create DESC
            LIMIT '.tools::int($data['start']).','.tools::int($data['take']).'
            ');

        if(count($result)>($data['take']-1)){
        $hasmore=1;
        unset($result[count($result)-1]);
        }
        //print_r(array('operations'=>$result,'hasmore'=>$hasmore));
        return array('operations'=>$result,'hasmore'=>$hasmore);
    }
    public function getBalanceTotal(){
        $db=db::init();
        $result=$db->queryFetchAllFirst('
                SELECT
                  SUM(z_operation.VALUE) AS total
                FROM
                  z_operation
                WHERE z_operation.userid = '.tools::int($_SESSION['User']['id']).'
                  AND z_operation.status = 2
                ');
        return $result[0]-self::getBalanceReserved();
    }
    public function getBalanceReserved(){
        $db=db::init();
        $result=$db->queryFetchAllFirst('
                SELECT
                  SUM(z_public_group.price) AS total
                FROM
                  z_public_group
                INNER JOIN z_public
                    ON z_public.id=z_public_group.publicid AND z_public.userid='.tools::int($_SESSION['User']['id']).' AND z_public_group.payed=0
                ');
        return $result[0];
    }
    public function payForPost($id){
        $db=db::init();
        $result=$db->queryFetchRowAssoc('
        SELECT
            z_public_group.price,
            z_group.userid
        FROM z_group
        INNER JOIN z_public_group
            ON z_public_group.groupid=z_group.id
        WHERE
            z_public_group.id='.tools::int($id));
        $db->exec('INSERT INTO z_operation (operationtypeid,active,value,userid,status) VALUES (2,1,-'.$result['price'].','.tools::int($_SESSION['User']['id']).',2)');
        $db->exec('INSERT INTO z_operation (operationtypeid,active,value,userid,status) VALUES (3,1,'.$result['price'].','.$result['userid'].',2)');
        $db->exec('UPDATE z_public_group SET z_public_group.payed=1 WHERE z_public_group.id='.tools::int($id));
    }
    public function addWithdraw($data){
        if(intval($data['value'])>0)
        {
            echo 1;
            if(self::getBalanceTotal()>$data['value']){
                $db=db::init();
                $w_res=$db->exec('INSERT INTO z_withdraw (userid,account,firstname,name,value,detail_text)
                VALUES (
                '.tools::int($_SESSION['User']['id']).',
                "'.tools::str($data['account']).'",
                "'.tools::str($data['firstname']).'",
                "'.tools::str($data['name']).'",
                '.$data['value'].',
                "'.tools::str($data['comments']).'"
                )');
                echo ('INSERT INTO z_withdraw (userid,account,firstname,name,value,detail_text)
                VALUES (
                '.tools::int($_SESSION['User']['id']).',
                "'.tools::str($data['account']).'",
                "'.tools::str($data['firstname']).'",
                "'.tools::str($data['name']).'",
                '.$data['value'].',
                "'.tools::str($data['comments']).'"
                )');
            }
        }
        //echo $db->exec('INSERT INTO z_withdraw (userid,paytypeid,firstname,name,value) VALUES ('.tools::int($_SESSION['User']['id']).',1,'.$result['price'].','.$result['userid'].',2)');
        if($w_res)
            return true;
        else
            return false;
    }
    public function getPaytype($data){
        $db=db::init();
        $result=$db->queryFetchAllAssoc('
        SELECT
            *
        FROM z_paytype
        WHERE
            z_paytype.active=1');
        return $result;
    }
}
?>