<?
require_once 'modules/base/models/Basemodel.php';

Class Payrequest Extends Basemodel {
	
	
	public function getList(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_withdraw.id,
					  z_withdraw.account,
					  z_withdraw.firstname,
					  z_withdraw.name,
					  z_withdraw.value,
					  z_withdraw.date_create,
					  z_withdraw.confirm,
					  z_withdraw.userid,
					  z_withdraw.detail_text,
					  z_user.email
					FROM
					  z_withdraw
					INNER JOIN z_user
					ON z_user.id=z_withdraw.userid
					');
        if($result)
            foreach($result as $r){
                $user_arr[$r['userid']]=$r['userid'];
            }
        if(count($user_arr)>0){

                $bal=$db->queryFetchAllAssoc('
                SELECT
                  z_operation.userid,
                  SUM(z_operation.VALUE) AS total
                FROM
                  z_operation
                WHERE z_operation.userid IN ('.implode(',',$user_arr).')
                  AND z_operation.status = 2
                GROUP BY z_operation.userid
                ');
                foreach($bal as $b)
                    $balances[$b['userid']]=$b['total'];

                $res=$db->queryFetchAllAssoc('
                SELECT
                  z_public.userid,
                  SUM(z_public_group.price) AS total
                FROM
                  z_public_group
                INNER JOIN z_public
                    ON z_public.id=z_public_group.publicid AND z_public.userid IN ('.implode(',',$user_arr).') AND z_public_group.payed=0
                GROUP BY z_public.userid
                ');
                foreach($res as $r)
                    $reserved[$r['userid']]=$r['total'];

        }
        if($result)
		return array('list'=>$result,'balances'=>$balances,'reserved'=>$reserved);
	}
    public function getBalanceTotal($userid){
        $db=db::init();
        $result=$db->queryFetchAllFirst('
                SELECT
                  SUM(z_operation.VALUE) AS total
                FROM
                  z_operation
                WHERE z_operation.userid = '.tools::int($userid).'
                  AND z_operation.status = 2
                ');
        return $result[0]-self::getBalanceReserved($userid);
    }
    public function getBalanceReserved($userid){
        $db=db::init();
        $result=$db->queryFetchAllFirst('
                SELECT
                  SUM(z_public_group.price) AS total
                FROM
                  z_public_group
                INNER JOIN z_public
                    ON z_public.id=z_public_group.publicid AND z_public.userid='.tools::int($userid).' AND z_public_group.payed=0
                ');
        return $result[0];
    }
	public function confirmRequest($id){
		$db=db::init();

                    $wdr=$db->queryFetchRowAssoc('
                    SELECT
                      *
                    FROM
                      z_withdraw
                    WHERE z_withdraw.id='.tools::int($id).' AND z_withdraw.confirm=0
                    ');

                    if($wdr['id']>0 && self::getBalanceTotal($wdr['userid'])>$wdr['value']){
                        $op=$db->exec('INSERT INTO z_operation
                        (
                        operationtypeid,active,value,userid,status,withdrawid
                        ) VALUES (
                        4,1,-'.tools::int($wdr['value']).','.tools::int($wdr['userid']).',2,'.tools::int($wdr['id']).'
                        )');
                        if($op)
                            $wu=$db->exec('
                            UPDATE
                            z_withdraw
                            SET z_withdraw.confirm=1
                            WHERE z_withdraw.id='.tools::int($id).'
                            ');
                    }
		if($wu)
		    return true;
        else
            return false;
	}
}
?>