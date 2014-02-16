<?
require_once 'modules/base/models/Basemodel.php';

Class Place Extends Basemodel {

public function getPlaces($start=0,$end=8){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_site.id,
				  z_site.name,
				  z_site.address,
				  z_site.maplink 
				FROM
				  z_site 
				  INNER JOIN
				  z_sitetype 
				  ON z_sitetype.id = z_site.sitetypeid 
				  AND z_sitetype.parentid = 10 
				');
	
	if($result)
	return $result;
}
}
?>