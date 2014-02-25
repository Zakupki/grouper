<?
require_once 'modules/base/models/Basemodel.php';

Class Publics Extends Basemodel {


	public function getPublicCount(){
	$db=db::init();
	$result=$db->queryFetchAllFirst('
				SELECT
				  COUNT(z_public.id)
				FROM
				  z_public
				');
	if($result[0])
	return $result[0];
}


	public function getPublicList($start=0,$take=50){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT
				z_public.id,
				z_public.detail_text,
				z_user.email,
				date_format(z_public.date_create,"%d.%m.%Y") AS date_create,
				date_format(z_public.date_start,"%d.%m.%Y") AS date_start
				FROM z_public
				INNER JOIN z_user
				ON z_user.id=z_public.userid
				Order by z_public.date_create DESC
				LIMIT '.$start.','.$take.'
				');
    foreach($result as $row){
        $publicArr[$row['id']]=$row['id'];
    }

        $data['publics']=$result;

    if($data)
	return $data;
}
	public function getPublicInner($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT
				  z_group.id,
                  z_group.name,
                  z_user.`email`,
                  z_public_group.price,
                  z_public_group.payed,
                  z_public_group.`status`,
                  z_public_report.`link`
                FROM
                  `z_public_group`
                  INNER JOIN z_group
                    ON z_group.id = z_public_group.`groupid`
                  INNER JOIN z_user
                    ON z_user.id = z_group.`userid`
                  LEFT JOIN `z_public_report`
                    ON z_public_report.`publicrequestid`=z_public_group.`id`
                WHERE z_public_group.`publicid` ='.tools::int($id).'
				');
	if($result)
	return $result;
}
}
?>