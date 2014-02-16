<?
require_once 'modules/base/models/Basemodel.php';

Class Brand Extends Basemodel {
	
	
	public function getBrandList($id){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_brand.id,
					  z_brand.`name`,
					  CONCAT(z_brand.`urlcode`,".clubsreport.com") AS domain,
					  if(char_length(z_brand.logo)>0,CONCAT("/uploads/brands/",z_brand.id,"/",z_brand.`logo`),null) AS url,
					  z_user.id as userid,
					  z_user.`email`,
					  z_user.activation,
					  z_user.password,
					  z_user.activationcode
					FROM
					  z_brand 
					LEFT JOIN z_brand_user
					ON z_brand_user.`brandid`=z_brand.`id`
					LEFT JOIN z_user
					ON z_user.id=z_brand_user.`userid`
					ORDER BY z_brand.type DESC, z_brand.name
					');
					foreach($result as $br){
						$brandidarr[$br['id']]=$br['id'];
					}					
					if(is_array($brandidarr))
					$res=$db->queryFetchAllAssoc('SELECT 
					  COUNT(z_brand_site.`siteid`) AS cnt,
					  z_brand_site.`brandid` 
					FROM
					  z_brand_site 
					WHERE z_brand_site.`brandid` in('.implode(',',$brandidarr).')
					GROUP BY z_brand_site.`brandid` ');
					foreach($res as $c)
					$sitedata[$c['brandid']]=$c['cnt'];
					
		if($result)
		return array('brands'=>$result, 'sites'=>$sitedata);	
	}
	public function getBrandOptions($id){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_brand.id,
					  z_brand.`name`,
					  CONCAT(z_brand.`urlcode`,".clubsreport.com") AS domain,
					  if(char_length(z_brand.logo)>0,CONCAT("/uploads/brands/",z_brand.id,"/",z_brand.`logo`),null) AS url,
					  z_user.id as userid,
					  z_user.`email`,
					  z_user.activation,
					  z_user.password,
					  z_user.activationcode
					FROM
					  z_brand 
					LEFT JOIN z_brand_user
					ON z_brand_user.`brandid`=z_brand.`id`
					LEFT JOIN z_user
					ON z_user.id=z_brand_user.`userid`
					ORDER BY z_brand.type DESC, z_brand.name
					');
		if($result)
		return $result;	
	}
	public function getClubOffers(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  COUNT(z_eventoffer.`id`) AS cnt,
		  z_event.id,
		  z_event.`name`,
		  z_site.`name` AS sitename,
		  z_event.`date_start`,
		  IF(z_domain.id>0,z_domain.name,CONCAT("r",z_site.id,".reactor.ua")) AS domain,
		  IF(z_cover.id>0,CONCAT("/uploads/sites/",z_site.id,"/img/3_",z_cover.`url`),NULL) AS cover,
		  DATE_FORMAT(z_event.date_create,"%d.%m.%Y") AS date_create
		FROM
		  z_event 
		  INNER JOIN z_eventoffer 
		    ON z_eventoffer.`eventid` = z_event.id 
		  INNER JOIN z_site 
		    ON z_site.id = z_event.`siteid`
		  LEFT JOIN z_domain
		  ON z_domain.`siteid`=z_site.id
		  LEFT JOIN z_cover
		  ON z_cover.`id`=z_event.`coverid`
		WHERE z_event.`offertype` > 0 
		GROUP BY z_event.id 
		ORDER BY z_event.`date_create` DESC
		');
		if($result)
		return $result;	
	}
	/*
	public function getBrandRequests($id){
			$db=db::init();
			$result=$db->queryFetchAllAssoc('
						SELECT 
						  z_brand.id,
						  z_brand.`name`,
						  CONCAT(z_brand.`urlcode`,".clubsreport.com") AS domain,
						  if(char_length(z_brand.logo)>0,CONCAT("/uploads/brands/",z_brand.id,"/",z_brand.`logo`),null) AS url,
						  z_user.`email`
						FROM
						  z_brand 
						INNER JOIN z_brand_user
						ON z_brand_user.`brandid`=z_brand.`id`
						INNER JOIN z_user
						ON z_user.id=z_brand_user.`userid`
						');
			if($result)
			return $result;	
		}*/
	public function getBrandInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_brand.id,
					  z_brand.`name`,
					  z_brand.urlcode,
					  z_brand.type,
					  CONCAT(z_brand.`urlcode`,".clubsreport.com") AS domain,
					  if(char_length(z_brand.logo)>0,CONCAT("/uploads/brands/",z_brand.id,"/",z_brand.`logo`),null) AS url,
					  z_user.`email`,
					  z_brand_user.userid
					FROM
					  z_brand 
					LEFT JOIN z_brand_user
					ON z_brand_user.`brandid`=z_brand.`id`
					LEFT JOIN z_user
					ON z_user.id=z_brand_user.`userid`
					WHERE z_brand.id='.tools::int($id).'
					LIMIT 0,1
					');
		if($result)
		return $result;	
	}
	public function getOfferInner($id){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_brand.`name`,
					  z_event.name AS eventname,
					  CONCAT(z_brand.`urlcode`,".clubsreport.com") AS domain,
					  if(char_length(z_brand.logo)>0,CONCAT("/uploads/brands/",z_brand.id,"/",z_brand.`logo`),null) AS url,
					  z_site.name AS clubname,
					  z_user.email
					FROM
					  z_eventoffer 
					  INNER JOIN z_brand 
					    ON z_brand.id = z_eventoffer.`brandid` 
					  INNER JOIN z_event 
					    ON z_event.id = z_eventoffer.`eventid`
					  INNER JOIN z_site
					  ON z_site.id=z_event.siteid
					  INNER JOIN z_user
					  ON z_user.id=z_site.userid
					WHERE z_eventoffer.`eventid` = '.tools::int($id).'
					');
		if($result)
		return $result;	
	}
	public function updateBrand($data,$file){
		$db=db::init();
		if($data['type']==1){
			$newfilename='NULL';
			$password='NULL';
			$email='NULL';
			$username='NULL';
			if(tools::int($data['userid'])<1 && strlen($data['email'])>4){
				$password=md5($data['password'].MD5_KEY);
				$username=strstr($data['email'], '@', true);
				$email=$data['email'];
			}
			if ($file['file']['tmp_name']) {
				if($data['current_file'])
				tools::delImg($data['current_file']);
				
				$tempFile = $file['file']['tmp_name'];
				$path_parts=pathinfo($file['file']['name']);
				$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			}elseif($data['current_file']){
				/*$path_parts=pathinfo($data['current_file']);
				$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
				$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/sites/'.tools::int($data['siteid']).'/files/';
				if(copy($_SERVER['DOCUMENT_ROOT'].$data['current_file'],$targetPath.$newfilename)){
				$filecol=',file_name,file_oldname';
				$fileval=', "'.$newfilename.'","'.$data['file_oldname'].'"';
				}*/
			}
			
			$data['activationcode']=md5(microtime(). $data['email'].MD5_KEY . rand());
			
			if($data['id']>0){
				if($data['email'])
				$username=strstr($data['email'], '@', true);
				if($file['file']['tmp_name']){
						$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/brands/'.tools::int($data['id']).'/';
						$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
						move_uploaded_file($tempFile,$targetFile);
				}
				$result=$db->queryFetchRowAssoc('CALL updatebrand('.tools::int($data['id']).', "'.tools::str($data['name']).'", "'.tools::str($data['code']).'", "'.$newfilename.'", '.tools::int($data['userid']).','.tools::int($data['current_userid']).',
				"'.tools::str($data['email']).'","'.$username.'", '.tools::int($data['usertype']).',"'.$data['activationcode'].'")');
			}else{
				
				$result=$db->queryFetchRowAssoc('CALL updatebrand('.tools::int($data['id']).', "'.tools::str($data['name']).'", "'.tools::str($data['code']).'", "'.$newfilename.'", '.tools::int($data['userid']).','.tools::int($data['current_userid']).',
				"'.$email.'","'.$username.'", '.tools::int($data['usertype']).',"'.$data['activationcode'].'")');
				
				 if($result['brandid']>0){
					$subject = "Новый бренд!";
					$message = "новый бренд-код:".$data['code']."";
					$smtp=new smtp;
					$smtp->Connect(SMTP_HOST);
					$smtp->Hello(SMTP_HOST);
					$smtp->Authenticate('support@clubsreport.com', 'Z1IRldqU');
					$smtp->Mail('support@clubsreport.com');
					$smtp->Recipient('dmitriy.bozhok@gmail.com');
					$smtp->Data($message, $subject);	
						
					mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/brands/'.$result['brandid'].'/');
					if($file['file']['tmp_name']){
						$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/brands/'.tools::int($result['brandid']).'/';
						$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
						move_uploaded_file($tempFile,$targetFile);
					}
				}
			}
		}else{
			if($data['id']>0){
				if($data['mergeto']>0 && $data['mergeto']!=$data['id']){
					if($db->exec('UPDATE z_brand_site SET brandid='.tools::int($data['mergeto']).' WHERE brandid='.tools::int($data['id']).''))
					$db->exec('delete from z_brand where id='.tools::int($data['id']).' AND type=0');
				}else{
					$db->exec('UPDATE z_brand SET name="'.tools::str($data['name']).'" WHERE id='.tools::int($data['id']).'');
				}
			}/*
			else{
							$db->exec('INSERT INTO z_brand (name) VALUES ("'.tools::str($data['name']).'")');
						}*/
			
		}
	}
	public function getBrandRequests(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('(SELECT 
		  12 AS datatypeid,
		  "Рекард" AS `type`,
		  z_brand_recard.id,
		  0 AS sites,
		  z_brand_recard.`name` AS `name`,
		  z_brand_recard.date_create AS dc,
		  DATE_FORMAT(
		    z_brand_recard.date_create,
		    "%d.%m.%Y %h:%i:%s"
		  ) AS date_create,
		  z_brand.`name` AS brandname,
		  IF(
		    CHAR_LENGTH(z_brand.logo) > 0,
		    CONCAT(
		      "/uploads/brands/",
		      z_brand.id,
		      "/",
		      z_brand.`logo`
		    ),
		    NULL
		  ) AS url 
		FROM
		  `z_brand_recard` 
		  INNER JOIN z_brand 
		    ON z_brand.id = z_brand_recard.`brandid`) 
		UNION
		(SELECT 
		  13 AS datatypeid,
		  "Баннер" AS `type`,
		  z_brand_banner.id,
		  COUNT(z_banner_site.siteid) AS sites,
		  `z_brand_banner`.`link` AS `name`,
		  z_brand_banner.date_create AS dc,
		  DATE_FORMAT(
		    z_brand_banner.date_create,
		    "%d.%m.%Y %h:%i:%s"
		  ) AS date_create,
		  z_brand.`name` AS brandname,
		  IF(
		    CHAR_LENGTH(z_brand.logo) > 0,
		    CONCAT(
		      "/uploads/brands/",
		      z_brand.id,
		      "/",
		      z_brand.`logo`
		    ),
		    NULL
		  ) AS url 
		FROM
		  `z_brand_banner` 
		  INNER JOIN z_brand 
		    ON z_brand.id = z_brand_banner.`brandid`
		  LEFT JOIN z_banner_site
		  ON z_banner_site.`bannerid`=z_brand_banner.id
		  GROUP BY z_brand_banner.id) 
		UNION
		(SELECT 
		  15 AS datatypeid,
		  "Indoor" AS `type`,
		  `z_brand_event`.id,
		  COUNT(z_event_site.siteid) AS sites,
		  `z_brand_event`.`name` AS `name`,
		  z_brand_event.date_create AS dc,
		  DATE_FORMAT(
		    z_brand_event.date_create,
		    "%d.%m.%Y %h:%i:%s"
		  ) AS date_create,
		  z_brand.`name` AS brandname,
		  IF(
		    CHAR_LENGTH(z_brand.logo) > 0,
		    CONCAT(
		      "/uploads/brands/",
		      z_brand.id,
		      "/",
		      z_brand.`logo`
		    ),
		    NULL
		  ) AS url 
		FROM
		  `z_brand_event` 
		  INNER JOIN z_brand 
		    ON z_brand.id = z_brand_event.`brandid`
		  LEFT JOIN z_event_site
		  ON z_event_site.`eventid`=z_brand_event.id
		  GROUP BY z_brand_event.id) 
		UNION
		(SELECT
		  14 AS datatypeid, 
		  "Паблик" AS `type`,
		  `z_brand_public`.id,
		  COUNT(z_public_site.siteid) AS sites,
		  `z_brand_public`.`detail_text` AS `name`,
		  z_brand_public.date_create AS dc,
		  DATE_FORMAT(
		    z_brand_public.date_create,
		    "%d.%m.%Y %h:%i:%s"
		  ) AS date_create,
		  z_brand.`name` AS brandname,
		  IF(
		    CHAR_LENGTH(z_brand.logo) > 0,
		    CONCAT(
		      "/uploads/brands/",
		      z_brand.id,
		      "/",
		      z_brand.`logo`
		    ),
		    NULL
		  ) AS url 
		FROM
		  `z_brand_public` 
		  INNER JOIN z_brand 
		    ON z_brand.id = z_brand_public.`brandid`
		  LEFT JOIN z_public_site
		  ON z_public_site.`publicid`=z_brand_public.id
		  GROUP BY z_brand_public.id)
		ORDER BY `dc` DESC');
		/*
		foreach($result as $res){
					$reqarr[$res['datatypeid']][$res['id']]=$res['id'];
				}
				foreach($reqarr as $datak=>$datatype){
					if($datak==14){
						$reqsites[14]=$db->queryFetchAllAssoc('
						SELECT 
						  COUNT(z_public_site.siteid) AS sites,
						  z_public_site.publicid AS id 
						FROM
						  z_public_site 
						WHERE z_public_site.publicid in('.implode(',',$datatype).')
						GROUP BY z_public_site.publicid
						');
						foreach()
					}
					
				}*/
		
		if($result)
		return $result;	
	}
	public function getBrandRequestSites($typeid,$id){
		$db=db::init();
		if($typeid==12)
		$result=$db->queryFetchAllAssoc('
			SELECT 
			  z_site.id,
			   IF(
				    z_domain.id > 0,
				    z_domain.NAME,
				    CONCAT("r", z_site.id, ".reactor.ua")
				  ) AS domain,
			  z_site.name 
			FROM
			  z_recard_site 
			  INNER JOIN
			  z_site 
			  ON z_site.id = z_recard_site.siteid
			  AND z_site.sitetypeid = 7 
			  LEFT JOIN
			  z_domain 
			  ON z_domain.siteid = z_site.id 
			WHERE z_recard_site.recardid = '.tools::int($id).'');
		if($typeid==13)
		$result=$db->queryFetchAllAssoc('
			SELECT 
			  z_site.id,
			   IF(
				    z_domain.id > 0,
				    z_domain.NAME,
				    CONCAT("r", z_site.id, ".reactor.ua")
				  ) AS domain,
			  z_site.name
			FROM
			  z_banner_site 
			  INNER JOIN
			  z_site 
			  ON z_site.id = z_banner_site.siteid
			  AND z_site.sitetypeid = 7
			  LEFT JOIN
			  z_domain 
			  ON z_domain.siteid = z_site.id  
			WHERE z_banner_site.bannerid = '.tools::int($id).'');
		if($typeid==14)
		$result=$db->queryFetchAllAssoc('
			SELECT 
			  z_site.id,
			   IF(
				    z_domain.id > 0,
				    z_domain.NAME,
				    CONCAT("r", z_site.id, ".reactor.ua")
				  ) AS domain,
			  z_site.name 
			FROM
			  z_public_site 
			  INNER JOIN
			  z_site 
			  ON z_site.id = z_public_site.siteid 
			  AND z_site.sitetypeid = 7 
			  LEFT JOIN
			  z_domain 
			  ON z_domain.siteid = z_site.id 
			WHERE z_public_site.publicid = '.tools::int($id).'');
		if($typeid==15)
		$result=$db->queryFetchAllAssoc('
			SELECT 
			  z_site.id,
			   IF(
				    z_domain.id > 0,
				    z_domain.NAME,
				    CONCAT("r", z_site.id, ".reactor.ua")
				  ) AS domain,
			  z_site.name 
			FROM
			  z_event_site 
			  INNER JOIN
			  z_site 
			  ON z_site.id = z_event_site.siteid 
			  AND z_site.sitetypeid = 7 
			  LEFT JOIN
			  z_domain 
			  ON z_domain.siteid = z_site.id 
			WHERE z_event_site.eventid = '.tools::int($id).'');
		return $result;
	}
}
?>