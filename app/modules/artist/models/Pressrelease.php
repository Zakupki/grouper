<?
require_once 'modules/base/models/Basemodel.php';

Class Pressrelease Extends Basemodel {

	public function getAdminPressrelease($itemid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_pressrelease.id,
					  z_pressrelease.itemid,
					  z_pressrelease.name,
					  z_pressrelease.preview_text,
					  z_pressrelease.detail_text,
					  z_pressrelease.incut 
					FROM
					  z_pressrelease 
					WHERE z_pressrelease.itemid = '.tools::int($itemid).'
					');
			
		if($result)
		return $result;
	}
	public function updatePressrelease($data, $itemid){
		
		$db=db::init();
				if($data['id']>0){
					
					$db->exec('UPDATE z_pressrelease
					set 
					name="'.tools::str($data['name']).'",
					preview_text="'.tools::str($data['preview_text']).'",
					detail_text="'.tools::str($data['detail_text']).'",
					incut='.tools::int($data['incut']).' 
					WHERE itemid='.tools::int($itemid).' AND id='.tools::int($data['id']).' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
				}
				else{
					$db->exec('INSERT INTO z_pressrelease
					(itemid,name,preview_text,detail_text,siteid,userid,incut)
					 VALUES 
					 ('.tools::int($itemid).',
					 "'.tools::str($data['name']).'",
					 "'.tools::str($data['preview_text']).'",
					 "'.tools::str($data['detail_text']).'",
					 '.tools::int($_SESSION['Site']['id']).',
					 '.tools::int($_SESSION['User']['id']).',
					 '.$data['incut'].'
					 )');
				}		
	}
}
?>