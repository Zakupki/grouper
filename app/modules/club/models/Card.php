<?
require_once 'modules/base/models/Basemodel.php';

Class Card Extends Basemodel {

public function getAdminCards(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_card.id,
				  z_card.name,
				  z_card.price,
				  z_coupons.`ActiveCoupons`,
				  z_coupons.`CouponsExpired`,
				  z_coupons.`CouponsRedempt`,
				  z_coupons.`ParticipantsCount`,
				  z_coupons.`RedemptionRatio`,
				  z_coupons.`TotalCoupon`,
				  z_card.new
				FROM
				  z_card 
				INNER JOIN z_recard_site
				ON z_recard_site.id=z_card.requestid AND z_recard_site.status=3
				LEFT JOIN z_coupons
				ON z_coupons.`couponid`=z_card.`yocardid`
				WHERE z_card.siteid='.tools::int($_SESSION['Site']['id']).'
				');
	
	if($result)
	return $result;
}
public function getCard($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_card.id,
		  z_card.name,
		  z_card.detail_text,
		  DATE_FORMAT(z_card.date_start,"%d.%m.%Y") AS date_start,
		  DATE_FORMAT(z_card.date_end,"%d.%m.%Y") AS date_end,
		  if(z_card.file_name IS NOT NULL,CONCAT("/uploads/sites/",z_card.siteid,"/files/",z_card.file_name),null) AS fileurl,
		  z_card.file_oldname AS filename
		FROM z_card 
		WHERE z_card.id='.tools::int($id).'');
		return $result;
}
public function updateCard($data,$file){
		$db=db::init();
		$data['date']=explode('.', $data['date']);
		
		if($data['deletefile']){
			tools::delImg($data['deletefile']);
			$updatefile=', file_name=NULL';
			$updatefilename=', file_oldname=NULL';
		}
		if($data['delete']>0){
			$db->exec('DELETE FROM z_card
			WHERE id='.tools::int($data['delete']).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
		}else{
			if (!empty($file['file'])) {
			$tempFile = $file['file']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/sites/'.$_SESSION['Site']['id'].'/files/';
			$path_parts=pathinfo($file['file']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$newfilenameS=$newfilename;
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
				if(move_uploaded_file($tempFile,$targetFile)){
				$updatefile=', file_name="'.$newfilename.'"';
				$updatefilename=', file_oldname="'.$file['file']['name'].'"';
		        }
				//echo json_encode($data);
			}
			if($data['id']){
				$db->exec('UPDATE z_card
				SET 
				name="'.tools::str($data['title']).'",
				detail_text="'.tools::str($data['desc']).'",
				date_start="'.tools::getSqlDate($data['date'][2],$data['date'][1],$data['date'][0]).'"
				'.$updatefile.'
				'.$updatefilename.'
				WHERE id='.tools::int($data['id']).' AND siteid='.tools::int($_SESSION['Site']['id']).'
				');
			}
			else{
				$db->exec('INSERT INTO z_card (name,detail_text,siteid,date_start,file_name,file_oldname) 
				VALUES			
				("'.tools::str($data['title']).'","'.tools::str($data['desc']).'",'.tools::int($_SESSION['Site']['id']).',"'.tools::getSqlDate($data['date'][2],$data['date'][1],$data['date'][0]).'","'.$newfilename.'","'.$file['file']['name'].'")');
				$data['id']=$db->lastInsertId();
			}
		}
	}
	public function readcard($id){
		$db=db::init();
		$result=$db->exec('UPDATE z_card SET new=0 WHERE id='.tools::int($id).'');
	}
}
?>