<?
require_once 'modules/base/models/Basemodel.php';

Class Design Extends Basemodel {

public function getSitecolor(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  color
				FROM
				  z_site
				WHERE z_site.id='.tools::int($_SESSION['Site']['id']).'
				LIMIT 0,1
				');
	if($result)
	return $result['color'];
}
public function updateSitecolor($data){
	$db=db::init();
	$result=$db->exec('
				UPDATE 
				z_site
				SET color="'.$data.'"
				WHERE z_site.id='.tools::int($_SESSION['Site']['id']).'
				AND z_site.userid='.tools::int($_SESSION['User']['id']).'
				');
}
public function getLogo(){
	$db=db::init();
		$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_logo.id,
				  z_logo.siteid,
				  CONCAT("/uploads/sites/",z_logo.siteid,"/img/",z_logo.url) as url,
				  z_logo.position
				FROM
				  z_logo
				WHERE z_logo.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_logo.userid='.tools::int($_SESSION['User']['id']).'
				LIMIT 0,1
				');
	if($result)
	return $result;
	}
public function updateLogo($data,$deleted){
	$db=db::init();
	            if(!$data['id'] && $data['url']){
	            $tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['url']."";
				$data['url']=pathinfo($data['url']);
				$newfile=md5(uniqid().microtime()).'.'.$data['url']['extension'];
				if($deleted)
				$result=$db->exec('
					DELETE FROM z_logo 
					WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
				');	
				rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
		            $result=$db->exec('
					INSERT INTO z_logo 
					(siteid, userid, url, position, active)
					VALUES 
					('.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', "'.$newfile.'",
					'.$data['position'].', 1)
					');
	            }
				elseif($data['id']){
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['url']."";
				$data['url']=pathinfo($data['url']);
				$newfile=md5(uniqid().microtime()).'.'.$data['url']['extension'];
				
				rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
		            $result=$db->exec('
					UPDATE z_logo 
					SET 
					url="'.$newfile.'",
					position='.$data['position'].'
					WHERE id='.tools::int($data['id']).' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
					');	
				}
				else{
					$result=$db->exec('
					DELETE FROM z_logo 
					WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
					');	
				}
				if($deleted)
				tools::delImg($deleted);
}
public function getBackground(){
	$db=db::init();
		$result=$db->queryFetchAllAssoc('
				SELECT 
				z_background.id,
				z_background.major,
				z_background.major AS compare,
				CONCAT("/uploads/sites/",z_background.siteid,"/img/1_",z_background.file_name) AS url
				FROM
				z_background
				WHERE z_background.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_background.userid='.tools::int($_SESSION['User']['id']).'
				');
	if($result)
	return $result;
}
public function updateBackground($data, $deleted, $menuid){
	$db=db::init();
	//tools::print_r($menuid);
	/*if(is_array($menuid)){
		#update menubackground
				foreach($menuid as $m){
					$menuidArr[$m['menuid']]=$m['menuid'];
					$db->exec('
						DELETE FROM z_menu_background
						WHERE itemid='.tools::int($m['menuid']).'
						');	
						echo ('
						DELETE FROM z_menu_background
						WHERE itemid='.tools::int($m['menuid']).'
						');	
						
					$db->exec('
						INSERT INTO z_menu_background (itemid, backgroundid)
						VALUES ('.tools::int($m['menuid']).', '.tools::int($m['backgroundid']).')
						');
						echo ('
						INSERT INTO z_menu_background (itemid, backgroundid)
						VALUES ('.tools::int($m['menuid']).', '.tools::int($m['backgroundid']).')
						');
				}
				if(is_array($menuidArr))
				$db->exec('
						DELETE FROM z_menu_background
						INNER JOIN z_background
						ON z_background.id=z_menu_background.backgroundid
						WHERE itemid not in('.implode(',',$menuidArr).') AND z_background.siteid='.tools::int($_SESSION['Site']['id']).'
						');	
				
	}*/
	
	
	if(is_array($data))
	foreach($data as $bg){
		if($bg['id']>0 && $bg['major']!=$bg['compare']){
			$stmt=$db->prepare("UPDATE z_background SET major=? WHERE id=? AND siteid=? AND userid=?");
			$res=$stmt->execute(array(
			  tools::int($bg['major']),
			  tools::int($bg['id']),
			  tools::int($_SESSION['Site']['id']),
			  tools::int($_SESSION['User']['id'])
			 ));
		}
		if($bg['id']<1){
			$bg['url']=str_replace('1_', '', $bg['url']);
			$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['url']."";
			if(file_exists($tempfile)){
				$bg['url']=pathinfo($bg['url']);
				$newfile=md5(uniqid().microtime()).'.'.$bg['url']['extension'];
				
				rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
				$result=$db->exec('
				INSERT INTO z_background 
				(file_name, siteid, active, userid, major)
				VALUES
				("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).','.$bg['major'].')
				');
				$data['id']=$db->lastInsertId();
			}
		}
	}
	if(is_array($deleted))
	foreach($deleted as $delbg){
		if($delbg['id']>0){
			
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			$delbg['url']=str_replace('1_', '', $delbg['url']);
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			
			$db->exec('
				DELETE FROM 
				z_background
				WHERE 
				z_background.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_background.userid='.tools::int($_SESSION['User']['id']).'
				AND z_background.id='.$delbg['id'].'
				');
		}
	}
}
public function getSiteLogo($siteid){
	$db=db::init();
		$result=$db->queryFetchRowAssoc('
				SELECT 
				CONCAT("/uploads/sites/",z_logo.siteid,"/img/",z_logo.url) AS url,
				if(position=1,"right","left") AS position
				FROM
				z_logo
				WHERE z_logo.siteid='.tools::int($siteid).'
				');
	if($result)
	return $result;
}
public function getMenuIds($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_menu.itemid AS menuid
		FROM
		  z_menu 
		  INNER JOIN
		  z_menu_background 
		  ON z_menu_background.itemid = z_menu.itemid 
		WHERE z_menu_background.backgroundid='.tools::int($id).' AND z_menu.siteid ='.tools::int($_SESSION['Site']['id']).'');
	if($result)
	return $result;
}

/*public function getBackgroundinner($id){
	$db=db::init();
		$result=$db->queryFetchRowAssoc('
				SELECT 
				z_background.id,
				z_background.major,
				z_background.position,
				z_background.type,
				CONCAT("/uploads/sites/",z_background.siteid,"/img/1_",z_background.file_name) AS url
				FROM
				z_background
				WHERE z_background.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_background.userid='.tools::int($_SESSION['User']['id']).'
				AND id='.tools::int($id).'
				');
	if($result)
	return $result;
}*/

public function updateBackgroundinner($menu, $deleted){
				$db=db::init();
				if(is_array($deleted))
				foreach($deleted as $del){
					if($del['menuid']>0)
					$dellidArr[$del['menuid']]=$del['menuid'];
					if($del['bgid']>0)
					$bgid=$del['bgid'];
				}
				if(is_array($dellidArr)){
				$db->exec('
				DELETE FROM z_menu_background
				WHERE backgroundid='.tools::int($bgid).' AND itemid in('.implode(',',$dellidArr).')
				');
				}
				
				
				#update menubackground
				$db->exec('
				DELETE FROM z_menu_background
				WHERE backgroundid='.tools::int($data['id']).'
				');
				if(is_array($menu))
				foreach($menu as $m){
					if($m['menuid']>0){
					$db->exec('
						DELETE FROM z_menu_background
						WHERE itemid='.tools::int($m['menuid']).'
						');	
						
					$db->exec('
						INSERT INTO z_menu_background (itemid, backgroundid)
						VALUES ('.tools::int($m['menuid']).', '.tools::int($m['bgid']).')
						');
					}
				}
				
	
}
public function getVideopreview(){
	$db=db::init();
		$result=$db->queryFetchAllAssoc('
				SELECT 
				z_videopreview.id,
				z_videopreview.major,
				CONCAT("/uploads/sites/",z_videopreview.siteid,"/img/1_",z_videopreview.url) AS url
				FROM
				z_videopreview
				WHERE z_videopreview.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_videopreview.userid='.tools::int($_SESSION['User']['id']).'
				ORDER BY z_videopreview.id ASC
				');
	if($result)
	return $result;
}
public function updateVideopreview($data, $deleted){
	$db=db::init();
	if(is_array($data))
	foreach($data as $bg){
		if($bg['id']<1){
			$bg['url']=str_replace('1_', '', $bg['url']);
			$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['url']."";
			if(file_exists($tempfile)){
				$bg['url']=pathinfo($bg['url']);
				$newfile=md5(uniqid().microtime()).'.'.$bg['url']['extension'];
				
				rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
				$result=$db->exec('
				INSERT INTO z_videopreview 
				(url, siteid, active, userid, major)
				VALUES
				("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', 0)
				');
			}
		}
		if($bg['id']>0){
				if(intval($bg['major'])==1){
					$result=$db->exec('
					UPDATE z_videopreview
					SET major=0
					WHERE
					id!='.$bg['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
					
					$result=$db->exec('
					UPDATE z_videopreview
					SET major='.$bg['major'].'
					WHERE
					id='.$bg['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
				}
		}
	}
	if(is_array($deleted))
	foreach($deleted as $delbg){
		if($delbg['id']>0){
			
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			$delbg['url']=str_replace('1_', '', $delbg['url']);
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			
			$db->exec('
				DELETE FROM 
				z_videopreview
				WHERE 
				z_videopreview.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_videopreview.userid='.tools::int($_SESSION['User']['id']).'
				AND z_videopreview.id='.$delbg['id'].'
				');
		}
	}
}
public function getCover(){
	$db=db::init();
		$result=$db->queryFetchAllAssoc('
				SELECT 
				z_cover.id,
				z_cover.major,
				CONCAT("/uploads/sites/",z_cover.siteid,"/img/2_",z_cover.url) AS url
				FROM
				z_cover
				WHERE z_cover.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_cover.userid='.tools::int($_SESSION['User']['id']).'
				ORDER BY z_cover.id ASC
				');
	if($result)
	return $result;
}
public function updateCover($data, $deleted){
	$db=db::init();
	if(is_array($data))
	foreach($data as $bg){
		if($bg['id']<1){
			$bg['url']=str_replace('2_', '', $bg['url']);
			$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['url']."";
			if(file_exists($tempfile)){
				$bg['url']=pathinfo($bg['url']);
				$newfile=md5(uniqid().microtime()).'.'.$bg['url']['extension'];
				
				rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
				$result=$db->exec('
				INSERT INTO z_cover 
				(url, siteid, active, userid, major)
				VALUES
				("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', 0)
				');
			}
		}
		if($bg['id']>0){
				if(intval($bg['major'])==1){
					$result=$db->exec('
					UPDATE z_cover
					SET major=0
					WHERE
					id!='.$bg['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
					
					$result=$db->exec('
					UPDATE z_cover
					SET major='.$bg['major'].'
					WHERE
					id='.$bg['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
				}
		}
	}
	if(is_array($deleted))
	foreach($deleted as $delbg){
		if($delbg['id']>0){
			
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			
			$delbg['url']=str_replace('2_', '4_', $delbg['url']);
			
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			
			$delbg['url']=str_replace('4_', '5_', $delbg['url']);
			
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			
			$delbg['url']=str_replace('5_', '', $delbg['url']);
			
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			
			
			
			$delbg['url']=str_replace('2_', '', $delbg['url']);
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			
			$db->exec('
				DELETE FROM 
				z_cover
				WHERE 
				z_cover.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_cover.userid='.tools::int($_SESSION['User']['id']).'
				AND z_cover.id='.$delbg['id'].'
				');
		}
	}
}
public function getFavicon(){
	$db=db::init();
		$result=$db->queryFetchRow('
				SELECT 
				z_favicon.id,
				CONCAT("/uploads/sites/",z_favicon.siteid,"/img/",z_favicon.url) AS url
				FROM
				z_favicon
				WHERE z_favicon.siteid='.tools::int($_SESSION['Site']['id']).'
				LIMIT 0,1
				');
	if($result)
	return $result;
	else
	return array('id'=>'', 'url'=>'');
}
public function updateFavicon($data, $deleted){
	$db=db::init();
	if(is_array($data)){
		if($data['id']<1){
			//$bg['url']=str_replace('1_', '', $bg['url']);
			$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['url']."";
			if(file_exists($tempfile)){
				$data['url']=pathinfo($data['url']);
				$newfile=md5(uniqid().microtime()).'.ico';
				
				/*try
			    {*/
			        /*** set the image name ***/
			        $img = $tempfile;
			
			        /*** read the image into imagick ***/
			        $Imagick = new Imagick($img);
			
			        /*** crop and thumbnail the image ***/
			        $Imagick->cropThumbnailImage(16,16);
			
			        /*** set the format to ico ***/
			        $Imagick->setFormat('ico');
			
			        /*** write the favicon.ico file ***/
			        $Imagick->writeImage("".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					if(file_exists($tempfile))
					unlink($tempfile);
					
					$result=$db->exec('
					INSERT INTO z_favicon 
					(url, siteid, active, userid)
					VALUES
					("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).')
					');
			   /* }
			    catch(Exception $e)
			    {
			        echo $e->getMessage();
			    }*/
				
			}
		}
	}
	if(is_array($deleted)){
		if($deleted['id']>0){
			
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$deleted['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$deleted['url']);
			
				$db->exec('
				DELETE FROM 
				z_favicon
				WHERE 
				z_favicon.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_favicon.userid='.tools::int($_SESSION['User']['id']).'
				AND z_favicon.id='.$deleted['id'].'
				');
		}
	}
}
public function getPagebg($controller){
	$db=db::init();
	$result=$db->queryFetchRow('
	SELECT 
	  CONCAT(
	    "/uploads/sites/",
	    z_background.siteid,
	    "/img/",
	    z_background.file_name
	  ) AS url 
	FROM
	  z_menu 
	  INNER JOIN
	  z_menu_background 
	  ON z_menu_background.itemid = z_menu.itemid 
	  INNER JOIN
	  z_background 
	  ON z_background.id = z_menu_background.backgroundid
	WHERE z_menu.siteid = '.tools::int($_SESSION['Site']['id']).' 
	  AND z_menu.CODE = "'.$controller.'"
	  LIMIT 0,1
	');
	if(!$result['url'])
	$result=$db->queryFetchRow('
	SELECT 
	  CONCAT("/uploads/sites/",z_background.siteid,"/img/",z_background.file_name) AS url 
	FROM
	  z_background
	WHERE z_background.major=1
	AND z_background.siteid='.tools::int($_SESSION['Site']['id']).'
	LIMIT 0,1
	');
	if($result)
	return $result['url'];
}
public function getDefaultCover($siteid){
	$db=db::init();
	$result=$db->queryFetchRow('SELECT 
	  CONCAT(
	    "/uploads/sites/",
	    z_cover.siteid,
	    "/img/2_",
	    z_cover.url
	  ) AS url 
	FROM
	  z_cover 
	WHERE siteid = '.tools::int($siteid).' AND major=1');
	if($result['url'])
	return $result['url'];
}
public function getDefaultPreview($siteid){
	$db=db::init();
	$result=$db->queryFetchRow('SELECT 
	  CONCAT(
	    "/uploads/sites/",
	    z_videopreview.siteid,
	    "/img/1_",
	    z_videopreview.url
	  ) AS url 
	FROM
	  z_videopreview 
	WHERE siteid = '.tools::int($siteid).' AND major=1');
	if($result['url'])
	return $result['url'];
}
}
?>