<?
require_once 'modules/base/models/Basemodel.php';

Class System Extends Basemodel {
	
	
	public function getSupporttypes(){
	$db=db::init();
	
	$result=$db->queryFetchAllAssoc('
				SELECT id,name FROM z_supporttype
				WHERE sitetypeid=7
				  ');
	if($result)
	return $result;
}
	
	
}
?>