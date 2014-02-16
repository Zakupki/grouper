<?
require_once 'modules/base/models/Basemodel.php';

Class Reccount Extends Basemodel {
	
	
	public function getSiteList($sitetype=null){
	$db=db::init();
	if($sitetype){
	$sitetypeStr=' AND z_sitetype.parentid='.tools::int($sitetype);
	}
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_site.id,
				  z_site.name,
				  z_site.userid,
				  z_site.recommend,
				  z_user.login,
				  z_user.email,
				  z_city.name AS cityname,
				  z_sitetype.name AS sitetype,
				  z_domain.name AS domain,
				  z_clubform.id AS formid,
				  if(z_clublogo.id>0,CONCAT(
				    "/uploads/sites/",
				    z_clublogo.siteid,
				    "/img/3_",
				    z_clublogo.file_name
				  ),CONCAT(
				    "/uploads/sites/",
				    z_background.siteid,
				    "/img/3_",
				    z_background.file_name
				  )) AS url
				FROM
				  z_site 
				  INNER JOIN
				  z_user 
				  ON z_user.id = z_site.userid 
				  INNER JOIN
				  z_sitetype 
				  ON z_sitetype.id = z_site.sitetypeid '.$sitetypeStr.' 
				  LEFT JOIN
				  z_domain 
				  ON z_domain.siteid = z_site.id 
				  LEFT JOIN
				  z_background 
				  ON z_background.siteid = z_site.id  AND z_background.major=1
				  LEFT JOIN
				  z_clublogo 
				  ON z_clublogo.siteid = z_site.id
				  LEFT JOIN z_clubform
				  ON z_clubform.siteid=z_site.id
				  LEFT JOIN z_city
				  ON z_city.id=z_site.cityid
				  LEFT JOIN z_site_social
				  ON z_site_social.siteid=z_site.id AND z_site_social.socialid in(244,257)
				  GROUP BY z_site.id
				  ORDER BY z_site.date_create desc
				');
	if($result)
	return $result;
}
	public function getSiteInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				z_site.id,
				z_site.name,
				z_site.cityid,
				z_site.recommend,
				z_site.sitetypeid,
				z_site.userid,
				z_site_social.id AS socialid,
				z_site_social.url AS socialurl,
				CONCAT(
				   "/uploads/sites/",
				   z_clublogo.siteid,
				   "/img/",
				   z_clublogo.file_name
				 ) AS logo,
				z_clublogo.id as logoid 
				FROM z_site
				LEFT JOIN z_clublogo
				ON z_clublogo.siteid=z_site.id
				LEFT JOIN z_site_social
				ON z_site_social.siteid=z_site.id AND z_site_social.socialid in(244,257)
				WHERE z_site.id='.tools::int($id).'
				');
	if($result)
	return $result;
	}
	
	public function updateSiteInner($data){
		if($data['cityid']>0)
		$data['cityid']=tools::int($data['cityid']);
		else
		$data['cityid']='null';
		
		if($data['id']>0){
			$db=db::init();
			$db->exec('UPDATE z_site SET name="'.tools::str($data['name']).'", recommend='.tools::int($data['recommend']).', cityid='.$data['cityid'].'
			WHERE z_site.id='.tools::int($data['id']).'');
		
		if($_FILES['logo_image']['tmp_name']){
			if($data['logo'] && $data['logoid']){
				$db->exec('DELETE FROM z_clublogo WHERE id='.tools::int($data['logoid']).'');
				tools::delImg($data['logo']);
			}
			$tempFile = $_FILES['logo_image']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/sites/'.$data['id'].'/img/';
			$path_parts=pathinfo($_FILES['logo_image']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			move_uploaded_file($tempFile,$targetFile);
			$db->exec('INSERT INTO z_clublogo (file_name,siteid,userid,extension) VALUES ("'.$newfilename.'",'.$data['id'].','.$data['userid'].',"'.$path_parts['extension'].'")');
			/*$data['logo_image']=$db->lastInsertId();
			 $Sql.=', logo_image='.$data['logo_image'];*/
		}
		
		
		/*if($deleted)
		tools::delImg($deleted);
		if(!$data['url'])
		$db->exec('DELETE FROM z_clublogo WHERE id='.tools::int($data['id']).'
		AND siteid='.tools::int($_SESSION['Site']['id']).'
		AND userid='.tools::int($_SESSION['User']['id']).'');
		
		if($data['url']){
			if(!$data['id'] || $deleted){
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['url']."";
				if(file_exists($tempfile)){
					$data['url']=pathinfo($data['url']);
					$newfile=md5(uniqid().microtime()).'.'.$data['url']['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
				}
			}
		}
		
		if($data['url'] && !$data['id'])
		$db->exec('INSERT INTO z_clublogo (file_name,siteid,userid,extension) VALUES ("'.$newfile.'",'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).',"'.$data['url']['extension'].'")');
		if($data['url'] && $data['id'] && $deleted)
		$db->exec('UPDATE z_clublogo SET file_name="'.$newfile.'", extension="'.$data['url']['extension'].'"
		WHERE id='.tools::int($data['id']).'
		AND siteid='.tools::int($_SESSION['Site']['id']).'
		AND userid='.tools::int($_SESSION['User']['id']).'');*/
		
		}
	}
}
?>