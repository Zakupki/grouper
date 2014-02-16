<?
require_once 'modules/base/models/Basemodel.php';

Class Language Extends Basemodel {

public function getSiteLanguages($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_language.id,
				  z_language.name,
				  z_language.description,
				  z_language.major,
				  z_language.active
				FROM
				  z_language 
				WHERE z_language.siteid = '.tools::int($id).' 
				  AND z_language.active = 1
				  ORDER BY z_language.id
				');
	if($result)
	return $result;
}
public function getSiteAdminLanguages($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc("
				SELECT 
				  z_language.id,
				  z_language.name,
				  z_language.description,
				  z_language.major,
				  z_language.active,
				  IF(
				    z_language.reactorlangid,
				    z_language.reactorlangid,
				    ''
				  ) AS reactorlangid,
				  z_language.reactorlangid
				FROM
				  z_language 
				WHERE z_language.siteid = ".tools::int($id)."
				  ORDER BY z_language.id
				");
	if($result)
	return $result;
}
public function getMainLang(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_language.id
				FROM
				  z_language
				WHERE z_language.siteid = '.tools::int($_SESSION['siteid']).' 
				  AND z_language.active = 1
				  AND z_language.major=1
				LIMIT 0,1
				');
	if($result)
	return $result['id'];
}
public function updateLanguages($data){
	foreach($data as $row)
	if($row['id'])
	$idArr[]=intval($row['id']);
	$db=db::init();
	if(count($idArr)>0)
	$db->exec('delete from z_language where id not in ('.implode(',',$idArr).') AND userid='.tools::int($_SESSION['User']['id']).' and reactorlangid is null');
	foreach($data as $row){
		if($row['id']>0)
		$db->exec('update z_language SET name="'.$row['name'].'", description="'.$row['description'].'", major='.$row['major'].', active='.$row['active'].' where id='.tools::int($row['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
		else 
		$db->exec('insert into z_language (name, description, major, active, siteid, userid) values ("'.$row['name'].'", "'.$row['description'].'", '.$row['major'].', '.$row['active'].', '.tools::int($_SESSION['siteid']).', '.tools::int($_SESSION['User']['id']).')');
	}
}
}
?>