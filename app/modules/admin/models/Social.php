<?
require_once 'modules/base/models/Basemodel.php';

Class Social Extends Basemodel {
	
	
	public function getSocialList(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					z_social.id,
					z_social.name,
					z_social.active,
					z_social.new,
					CONCAT(
					  "/uploads/social/",
					  z_file.file_name
					) AS `url` 
					FROM z_social
					LEFT JOIN z_file
					ON z_file.id=z_social.preview_image
					ORDER BY z_social.id DESC
					');
		if($result)
		return $result;	
	}
	public function getSocialInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_social.id,
					  z_social.name,
					  z_social.url,
					  z_file.id AS previewid,
					  CONCAT(
					  "/uploads/social/",
					  z_file.file_name
					) AS preview,
					z_file2.id AS detailid,
					  CONCAT(
					  "/uploads/social/",
					  z_file2.file_name
					) AS detail
					FROM
					  z_social
					LEFT JOIN z_file
					ON z_file.id=z_social.preview_image 
					LEFT JOIN z_file z_file2
					ON z_file2.id=z_social.detail_image 
					WHERE z_social.id='.tools::int($id).'
					');
		if($result)
		return $result;
	}
	public function updateSocialInner($data,$files){
		$db=db::init();
		if($files['small_image']['tmp_name']){
			if($data['preview'] && $data['previewid']){
				$db->exec('DELETE FROM z_file WHERE id='.tools::int($data['previewid']).'');
				tools::delImg($data['preview']);
			}
			$tempFile = $files['small_image']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/social/';
			$path_parts=pathinfo($files['small_image']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			move_uploaded_file($tempFile,$targetFile);
			$db->exec('INSERT INTO z_file (subdir,file_name) VALUES ("social", "'.$newfilename.'")');
			$data['preview_image']=$db->lastInsertId();
		    $Sql.=', preview_image='.$data['preview_image'];
		}
		if($files['big_image']['tmp_name']){
			if($data['detail'] && $data['detailid']){
				$db->exec('DELETE FROM z_file WHERE id='.tools::int($data['detailid']).'');
				tools::delImg($data['detail']);
			}
			$tempFile = $files['big_image']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/social/';
			$path_parts=pathinfo($files['big_image']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			move_uploaded_file($tempFile,$targetFile);
			$db->exec('INSERT INTO z_file (subdir,file_name) VALUES ("social", "'.$newfilename.'")');
			$data['detail_image']=$db->lastInsertId();
			 $Sql.=', detail_image='.$data['detail_image'];
		}
		if($data['id']>0){
			$db=db::init();
			$db->exec('UPDATE z_social SET name="'.tools::str($data['name']).'", url="'.tools::str($data['url']).'"'.$Sql.'
 			WHERE z_social.id='.tools::int($data['id']).'');
		}
	}	
}
?>