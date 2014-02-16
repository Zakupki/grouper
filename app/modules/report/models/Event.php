<?
require_once 'modules/base/models/Basemodel.php';

Class Event Extends Basemodel {

	private $registry;
	public function __construct($registry){
		$this->registry=$registry;
	}
	public function getClubEvents($id){
				$db=db::init();
				$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_event.id,
				  z_event.name,
				  z_event.itemid,
				  z_event.offertype,
				  z_social_item.url AS concertua,
				  z_eventoffer.id AS offer,
				  DATE_FORMAT(z_event.date_start,"%Y%m%d") AS date_start,
				  MONTH(z_event.date_start) AS month,
  				  DAYOFWEEK(z_event.date_start) AS dayinweek,
				  DAYOFMONTH(z_event.date_start) AS dayinmonth,
				  z_event.detail_text,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/9_",
				    z_cover.url
				  ),CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/9_",
				    z_cover2.url
				  )) AS avatar,
				  if(z_cover.id>0,
				  CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/2_",
				    z_cover.url
				  ),CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/2_",
				    z_cover2.url
				  )) AS avatar2
				FROM
				  z_event 
				LEFT JOIN z_eventoffer
				ON z_eventoffer.eventid=z_event.id AND z_eventoffer.brandid='.tools::int($_SESSION['User']['brandid']).'
				LEFT JOIN z_cover
				ON z_cover.id=z_event.coverid
				LEFT JOIN z_cover z_cover2
				ON z_cover2.siteid = z_event.siteid AND z_cover2.major=1
				LEFT JOIN z_social_item 
				ON z_social_item.itemid=z_event.itemid AND z_social_item.socialid=354
				WHERE z_event.siteid = '.tools::int($id).' 
				  AND z_event.active = 1  
				  AND DATE_FORMAT(DATE_ADD(z_event.date_start,INTERVAL 1 DAY), "%Y%m%d")>=DATE_FORMAT(NOW(), "%Y%m%d")
				  AND (z_event.`offertype`<1 OR z_eventoffer.id>0)
				ORDER BY z_event.date_start ASC
				');
				
	if($result){
		foreach($result as $item)
		$itemidArr[$item['itemid']]=$item['itemid'];
		
		$artistres=$db->queryFetchAllAssoc('SELECT id,name,comment,support,itemid FROM z_artist WHERE itemid IN('.implode(',',$itemidArr).') ORDER BY sort ASC');
		if(is_array($artistres))
		foreach($artistres as $artist)
		$artislist[$artist['itemid']][$artist['id']]=$artist;
	}
	if($result)
	return array('events'=>$result, 'artists'=>$artislist);
	}

	public function getAllClubEvents($start=0,$take=10,$type,$get=null){
				switch ($type) {
					case 1:
					$selectSql='if(z_eventoffer.id>0,1,0) AS offer,';
					$joinSql.='LEFT JOIN z_eventoffer
					ON z_eventoffer.eventid=z_event.id AND z_eventoffer.brandid='.tools::int($_SESSION['User']['brandid']).'
					';
					$joinSql.='LEFT JOIN
					z_favclubs 
					ON z_favclubs.siteid = z_site.id 
					AND z_favclubs.userid = '.tools::int($_SESSION['User']['id']).'
					';
					$whereSql='AND (z_event.`offertype`<1 OR z_eventoffer.id>0)';
					$orderSql=', `offer`';
						break;
					case 2:
					$joinSql.='INNER JOIN
					z_favclubs 
					ON z_favclubs.siteid = z_site.id 
					AND z_favclubs.userid = '.tools::int($_SESSION['User']['id']).'
					';
					$whereSql='AND z_event.`offertype`<1';	
						break;
					case 3:
					$selectSql='if(z_eventoffer.id>0,1,0) AS offer,';
					$joinSql.='INNER JOIN z_eventoffer
					ON z_eventoffer.eventid=z_event.id AND z_eventoffer.brandid='.tools::int($_SESSION['User']['brandid']).'
					';
					$joinSql.='LEFT JOIN
					z_favclubs 
					ON z_favclubs.siteid = z_site.id 
					AND z_favclubs.userid = '.tools::int($_SESSION['User']['id']).'
					';
					$whereSql='AND (z_event.`offertype`<1 OR z_eventoffer.id>0)';
						break;
				}
				
				//$take=$take+1;
				$db=db::init();
				$take=$take+1;
				$itemid_result=$db->queryFetchAllFirst('
				SELECT DISTINCT 
				  (
				    z_event.`date_start`
				  ) AS date_start 
				FROM
				  z_event 
				INNER JOIN z_site
				ON z_site.id=z_event.siteid
				'.$joinSql.'
				WHERE z_site.sitetypeid = 7 
				 AND z_site.recommend=1
				 AND
				 DATE_FORMAT(
				    DATE_ADD(
				      z_event.date_start,
				      INTERVAL 1 DAY
				    ),
				    "%Y%m%d"
				  ) >= DATE_FORMAT(NOW(), "%Y%m%d") 
				ORDER BY z_event.`date_start` DESC 
				LIMIT '.tools::int($start).', '.tools::int($take).'');
				
				if(count($itemid_result)>($take-1)){
					$hasmore=1;
					unset($itemid_result[count($itemid_result)-1]);
				}
				
				if(!is_array($itemid_result))
				return;
				
				$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_event.id,
				  z_event.name,
				  z_event.itemid,
				  z_event.offertype,
				  z_event.siteid,
				  z_favclubs.id AS favourite,
				  z_site.name AS sitename,
				  z_site.address,
				  if(DATE_ADD(z_site.date_create,INTERVAL 1 MONTH)<=NOW(),0,1) AS newclub,
				  IF(
				    z_domain.id > 0,
				    z_domain.NAME,
				    CONCAT("r", z_site.id, ".reactor.ua")
				  ) AS domain,
				  CONCAT(
				    "/uploads/sites/",
				    z_clublogo.siteid,
				    "/img/12_",
				    z_clublogo.file_name
				  ) AS logo,
				  CONCAT(
				    "/uploads/sites/",
				    z_clublogo.siteid,
				    "/img/13_",
				    z_clublogo.file_name
				  ) AS logogray,
				  z_social_item.url AS concertua,
				  '.$selectSql.'
				  DATE_FORMAT(z_event.date_start,"%Y%m%d") AS date_start,
				  MONTH(z_event.date_start) AS month,
  				  DAYOFWEEK(z_event.date_start) AS dayinweek,
				  DAYOFMONTH(z_event.date_start) AS dayinmonth,
				  z_event.detail_text,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/9_",
				    z_cover.url
				  ),CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/9_",
				    z_cover2.url
				  )) AS avatar,
				  if(z_cover.id>0,
				  CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/2_",
				    z_cover.url
				  ),CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/2_",
				    z_cover2.url
				  )) AS avatar2
				FROM
				  z_event
				INNER JOIN z_site
				ON z_site.id=z_event.siteid
				LEFT JOIN
				z_domain 
				ON z_domain.siteid = z_site.id 
				LEFT JOIN
				z_clublogo 
				ON z_clublogo.siteid = z_site.id 
				'.$joinSql.'
				LEFT JOIN z_cover
				ON z_cover.id=z_event.coverid
				LEFT JOIN z_cover z_cover2
				ON z_cover2.siteid = z_event.siteid AND z_cover2.major=1
				LEFT JOIN z_social_item 
				ON z_social_item.itemid=z_event.itemid AND z_social_item.socialid=354
				WHERE z_site.sitetypeid = 7 
				AND z_site.recommend=1
				AND z_event.date_start BETWEEN STR_TO_DATE("'.$itemid_result[count($itemid_result)-1].'", "%Y-%m-%d %H:%i:%s") AND STR_TO_DATE("'.$itemid_result[0].'", "%Y-%m-%d %H:%i:%s")
				'.$whereSql.'
				ORDER BY z_event.date_start DESC
				'.$orderSql.'
				');
				foreach($result as $itemid){
				$itemidArr[$itemid['itemid']]=$itemid['itemid'];
				$clubid[$itemid['siteid']]=$itemid['siteid'];
				}
				//tools::print_r($result);
				
				#События
				if(count($clubid)>0)
				$data=$db->queryFetchAllAssoc('
				SELECT 
				  COUNT(z_event.id) AS eventnum,
				  z_event.siteid
				FROM
				  z_event 
				  LEFT JOIN z_eventoffer
				  ON z_eventoffer.eventid=z_event.id AND z_eventoffer.brandid='.tools::int($_SESSION['User']['brandid']).'
				WHERE z_event.siteid IN('.implode(',',$clubid).')
				  AND z_event.active = 1 
				  AND DATE_FORMAT(
				    DATE_ADD(
				      z_event.date_start,
				      INTERVAL 1 DAY
				    ),
				    "%Y%m%d"
				  ) >= DATE_FORMAT(NOW(), "%Y%m%d")
				  AND (z_event.`offertype`<1 OR z_eventoffer.id>0)
				GROUP BY z_event.siteid');
				foreach($data as $row){
					$eventnums[$row['siteid']]=$row['eventnum'];
				}	
						
				
	if($itemid_result){
		$artistres=$db->queryFetchAllAssoc('SELECT id,name,comment,support,itemid FROM z_artist WHERE itemid IN('.implode(',',$itemidArr).') ORDER BY sort ASC');
		if(is_array($artistres))
		foreach($artistres as $artist)
		$artislist[$artist['itemid']][$artist['id']]=$artist;
	}
	if($result)
	return array('events'=>$result, 'artists'=>$artislist, 'hasmore'=>$hasmore, 'datenum'=>count($itemid_result), 'eventnums'=>$eventnums);
	}
public function getAllClubPosters($start=0,$take=10){
				//$take=$take+1;
				$db=db::init();
				$take=$take+1;
				
				$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_event.id,
				  z_event.name,
				  z_event.itemid,
				  z_event.offertype,
				  z_event.siteid,
				  z_favclubs.id AS favourite,
				  z_site.name AS sitename,
				  z_site.address,
				  z_user.email,
				  if(z_poster.id>0,z_poster.id,z_poster2.id) AS posterid,
				  if(DATE_ADD(z_site.date_create,INTERVAL 1 MONTH)<=NOW(),0,1) AS newclub,
				  IF(
				    z_domain.id > 0,
				    z_domain.NAME,
				    CONCAT("r", z_site.id, ".reactor.ua")
				  ) AS domain,
				  z_social_item.url AS concertua,
				  if(z_eventoffer.id>0,1,0) AS offer,
				
				  z_event.detail_text,
				  if(z_poster.id>0,CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/8_",
				    z_poster.url
				  ),CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/8_",
				    z_poster2.url
				  )) AS poster,
				   if(z_poster.id>0,CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/",
				    z_poster.url
				  ),CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/",
				    z_poster2.url
				  )) AS posterbig,
				  if(z_event_approve.id,1,0) as approve,
				  z_poster_change.posterid AS posterchangeid
				FROM
				  z_event
				INNER JOIN z_site
				ON z_site.id=z_event.siteid
				LEFT JOIN
				z_domain 
				ON z_domain.siteid = z_site.id 
				INNER JOIN
				z_favclubs 
				ON z_favclubs.siteid = z_site.id 
				AND z_favclubs.userid = '.tools::int($_SESSION['User']['id']).'
				INNER JOIN z_user
				ON z_user.id=z_site.userid				
				LEFT JOIN z_eventoffer
				ON z_eventoffer.eventid=z_event.id AND z_eventoffer.brandid='.tools::int($_SESSION['User']['brandid']).'
				LEFT JOIN z_poster
				ON z_poster.id=z_event.posterid
				LEFT JOIN z_poster z_poster2
				ON z_poster2.siteid = z_event.siteid AND z_poster2.major=1
				LEFT JOIN z_social_item 
				ON z_social_item.itemid=z_event.itemid AND z_social_item.socialid=354
				LEFT JOIN z_event_approve
				ON z_event_approve.eventid=z_event.id AND z_event_approve.brandid='.tools::int($_SESSION['User']['brandid']).'
				LEFT JOIN z_poster_change
				ON z_poster_change.eventid=z_event.id AND z_poster_change.brandid='.tools::int($_SESSION['User']['brandid']).'
				WHERE z_site.sitetypeid = 7 
				  AND z_site.recommend=1
				  AND z_event.active = 1 
				  AND DATE_FORMAT(
				    DATE_ADD(
				      z_event.date_start,
				      INTERVAL 1 DAY
				    ),
				    "%Y%m%d"
				  ) >= DATE_FORMAT(NOW(), "%Y%m%d")
				  AND (z_event.`offertype`<1 OR z_eventoffer.id>0)
				ORDER BY z_event.date_start DESC
				LIMIT '.tools::int($start).','.tools::int($take).'
				');
				foreach($result as $ev)
				if($ev['posterchangeid']>0 &&$ev['posterchangeid']!=$ev['posterid'])
				$eventIdArr[$ev['id']]=$ev['id'];
				if(count($eventIdArr)>0)
				$db->exec('DELETE FROM z_poster_change WHERE eventid in('.implode(',',$eventIdArr).') AND brandid='.tools::int($_SESSION['User']['brandid']).'');
				if(count($result)>($take-1)){
					$hasmore=1;
					unset($result[count($result)-1]);
				}
	if($result)
	return array('events'=>$result, 'hasmore'=>$hasmore);
	}
	
	public function getEventRequest($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_brand_event.id,
		  z_brand_event.name,
		  z_brand_event.detail_text,
		  DATE_FORMAT(z_brand_event.date_start,"%d.%m.%Y") AS date_start,
		  z_brand_event.filtertype,
		  CONCAT("/uploads/brands/",z_brand_event.brandid,"/",z_brand_event.file_name) AS fileurl,
		  z_brand_event.file_oldname AS filename
		FROM
		  z_brand_event
		WHERE z_brand_event.brandid='.tools::int($_SESSION['User']['brandid']).' AND z_brand_event.id='.tools::int($id).'
		LIMIT 0,1
		');
		if($result['filtertype']==2){
			$sites=$db->queryFetchAllAssoc('
			SELECT 
			  z_site.id,
			  z_site.name 
			FROM
			  z_event_site 
			  INNER JOIN
			  z_site 
			  ON z_site.id = z_event_site.siteid 
			  AND z_site.sitetypeid = 7 
			WHERE z_event_site.eventid = '.$result['id'].'');
			foreach($sites as $site){
				$sitenames[$site['id']]=$site['name'];
				$siteids[$site['id']]=$site['id'];
			}
			$result['sitenames']=$sitenames;
			$result['siteids']=$siteids;
		}
		if($result)
		return $result;
	}
	
	public function updateEventRequest($data,$file){
		$db=db::init();
		$data['date']=explode('.', $data['date']);
		if($data['deletefile']){
			unlink($_SERVER['DOCUMENT_ROOT'].$data['deletefile']);
			$updatefile=', file_name=NULL';
			$updatefilename=', file_oldname=NULL';
		}
		if (!empty($file['file'])) {
			$tempFile = $file['file']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/brands/'.$_SESSION['User']['brandid'].'/';
			$path_parts=pathinfo($file['file']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$newfilenameS=$newfilename;
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
				if(move_uploaded_file($tempFile,$targetFile)){
				//	$targetFile=str_replace($newfilename,$newfilenameS, $targetFile);
				//	$data['src'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
		        }
				//echo json_encode($data);
			$updatefile=', file_name="'.$newfilename.'"';
			$updatefilename=', file_oldname="'.$file['file']['name'].'"';
		}
		
		if($data['delete']>0){
			$db->exec('DELETE FROM z_brand_event
			WHERE id='.tools::int($data['delete']).' AND brandid='.tools::int($_SESSION['User']['brandid']).'');
		}else{
			if($data['id']){
				$db->exec('UPDATE z_brand_event
				SET 
				name="'.tools::str($data['title']).'",
				detail_text="'.tools::r_str($data['desc']).'",
				date_start="'.tools::getSqlDate($data['date'][2],$data['date'][1],$data['date'][0]).'",
				filtertype='.tools::int($data['clubsFilter']).'
				'.$updatefile.'
				'.$updatefilename.'
				WHERE id='.tools::int($data['id']).' AND brandid='.tools::int($_SESSION['User']['brandid']).'
				');
			}
			else{
				$db->exec('INSERT INTO z_brand_event (name,detail_text,brandid,date_start,filtertype,file_name,file_oldname) 
				VALUES			
				("'.tools::str($data['title']).'","'.tools::r_str($data['desc']).'",'.tools::int($_SESSION['User']['brandid']).',"'.tools::getSqlDate($data['date'][2],$data['date'][1],$data['date'][0]).'",'.tools::int($data['clubsFilter']).', "'.$newfilename.'","'.$file['file']['name'].'")');
				$data['id']=$db->lastInsertId();
				/*
				if($data['id']>0){
									$db->exec('INSERT INTO z_brand_visits (datatypeid,itemid,brandid,date_visit) VALUES (15,'.$data['id'].','.tools::int($_SESSION['User']['brandid']).',NOW())');
									$subject2 = "Р’Р°С€Р° Р·Р°СЏРІРєР° РЅР° СЂР°Р·РјРµС‰РµРЅРёРµ InDoor РІ СЃРёСЃС‚РµРјРµ Clubsreport";
									$message2 = "Р—РґСЂР°РІСЃС‚РІСѓР№С‚Рµ.\n\n".date("j.n.Y")." Р’С‹ РїРѕРґР°Р»Рё Р·Р°СЏРІРєСѓ РЅР° СЂР°Р·РјРµС‰РµРЅРёРµ InDoor РІ СЃРёСЃС‚РµРјРµ Clubsreport.\n\nР’ С‚РµС‡РµРЅРёРµ РѕРґРЅРѕРіРѕ СЂР°Р±РѕС‡РµРіРѕ РґРЅСЏ, СЃ Р’Р°РјРё СЃРІСЏР¶РµС‚СЃСЏ РїСЂРµРґСЃС‚Р°РІРёС‚РµР»СЊ Clubsreport РґР»СЏ РїРѕРґС‚РІРµСЂР¶РґРµРЅРёСЏ СѓРєР°Р·Р°РЅРЅРѕР№ РёРЅС„РѕСЂРјР°С†РёРё.\n\nРЎ СѓРІР°Р¶РµРЅРёРµРј, РєРѕРјР°РЅРґР° Clubsreport.\n\n";
									$smtp2=new smtp;
									$smtp2->Connect(SMTP_HOST);
									$smtp2->Hello(SMTP_HOST);
									$smtp2->Authenticate('support@clubsreport.com', 'Z1IRldqU');
									$smtp2->Mail('support@clubsreport.com');
									$smtp2->Recipient('selina@reactor.ua');
									$smtp2->Recipient('inna.merk@reactor.ua');
									$smtp2->Recipient($_SESSION['User']['email']);
									$smtp2->Data($message2, $subject2);
								}*/
				
			}
			if($data['clubsFilter']==0){
				$currentclubs=$db->queryFetchAll('SELECT siteid FROM z_event_site where eventid='.tools::int($data['id']).'');
				foreach($currentclubs as $curclub)
					$currentclubsArr[$curclub[0]]=$curclub[0];
					
				$clubs=$db->queryFetchAllFirst('
					SELECT 
					  z_site.id
					FROM
					  z_site 
					WHERE z_site.sitetypeid = 7 
					AND z_site.recommend=1
					');
				foreach($clubs as $clubid){
					if(!in_array($clubid,$currentclubsArr))
					$db->exec('INSERT INTO z_event_site (eventid,siteid) VALUES ('.tools::int($data['id']).','.tools::int($clubid).')');
				}
				
			}
			elseif($data['clubsFilter']==1){
				$currentclubs=$db->queryFetchAll('SELECT siteid FROM z_event_site where eventid='.tools::int($data['id']).'');
				foreach($currentclubs as $curclub)
					$currentclubsArr[$curclub[0]]=$curclub[0];
					
				$clubs=$db->queryFetchAllFirst('
					SELECT 
					  z_favclubs.siteid
					FROM
					  z_favclubs 
					WHERE z_favclubs.userid='.tools::int($_SESSION['User']['id']).'
					');
				
				if(count($clubs)>0)
				$db->exec('DELETE FROM z_event_site WHERE siteid NOT IN('.implode(',',$clubs).') AND eventid='.tools::int($data['id']).'');
				
				foreach($clubs as $clubid){
					if(!in_array($clubid,$currentclubsArr))
					$db->exec('INSERT INTO z_event_site (eventid,siteid) VALUES ('.tools::int($data['id']).','.tools::int($clubid).')');
				}
			}elseif($data['clubsFilter']==2){
				$clubsArr=explode(',',$data['clubs-filter-ids']);
				if(strlen(trim($data['clubs-filter-ids']))>0 && count($clubsArr)>0){
				$db->exec('DELETE FROM z_event_site WHERE siteid NOT IN('.$data['clubs-filter-ids'].') AND eventid='.tools::int($data['id']).'');
				}
				else{ $db->exec('DELETE FROM z_event_site WHERE eventid='.tools::int($data['id']).'');
				}
				$currentclubs=$db->queryFetchAll('SELECT siteid FROM z_event_site where eventid='.tools::int($data['id']).'');
				foreach($currentclubs as $curclub)
					$currentclubsArr[$curclub[0]]=$curclub[0];
				foreach($clubsArr as $clubid){
					if(!in_array($clubid,$currentclubsArr))
					$db->exec('INSERT INTO z_event_site (eventid,siteid) VALUES ('.tools::int($data['id']).','.tools::int($clubid).')');
				}
			}
			
		}
	}
	public function getEventRequests(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  (SELECT COUNT(DISTINCT id) FROM z_event_site WHERE z_event_site.eventid=z_brand_event.id) AS sites,
          (SELECT COUNT(DISTINCT id) FROM z_event_site WHERE z_event_site.eventid=z_brand_event.id  AND (CHAR_LENGTH(z_event_site.report)>0 OR z_event_site.file_name IS NOT NULL)) AS sitesrequested,
		  z_brand_event.id,
		  z_brand_event.name,
		  z_brand_event.detail_text,
		  z_brand_event.date_start,
		  CONCAT("/uploads/brands/",z_brand_event.brandid,"/",z_brand_event.file_name) AS fileurl,
		  if(DATE_ADD(z_brand_event.date_start,INTERVAL 1 DAY)>=NOW(),1,0) AS future
		FROM
		  z_brand_event
		WHERE  z_brand_event.brandid='.tools::int($_SESSION['User']['brandid']).'
		ORDER BY z_brand_event.date_start DESC
		');
		
		foreach($result as $event)
		$eventids[$event['id']]=$event['id'];
		if(count($eventids)>0)
		$newsitesresult=$db->queryFetchAllAssoc('
		SELECT 
		  COUNT(distinct z_event_site.`id`) as count,
		  z_event_site.`eventid` 
		FROM
		  z_event_site 
		  INNER JOIN z_brand_visits 
		    ON z_brand_visits.itemid IN ('.implode(',',$eventids).') 
		    AND z_brand_visits.datatypeid = 15 
		    AND z_brand_visits.brandid = '.tools::int($_SESSION['User']['brandid']).' 
		    AND z_brand_visits.date_visit<z_event_site.date_update
		WHERE z_event_site.`eventid` IN ('.implode(',',$eventids).') AND (CHAR_LENGTH(z_event_site.report)>0 OR z_event_site.file_name IS NOT NULL)
		GROUP BY z_event_site.`eventid`
		');
		foreach($newsitesresult as $newsite)
		$newsites[$newsite['eventid']]=$newsite['count'];
		
		if($result)
		return array('events'=>$result,'newsites'=>$newsites);
	}
	public function getEventRequestInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_brand_event.id,
		  z_brand_event.name,
		  z_brand_event.detail_text,
		  z_brand_event.date_start,
		  z_brand_event.filtertype,
		  CONCAT("/uploads/brands/",z_brand_event.brandid,"/",z_brand_event.file_name) AS fileurl,
		  z_brand_event.file_oldname AS filename
		FROM
		  z_brand_event
		WHERE  z_brand_event.brandid='.tools::int($_SESSION['User']['brandid']).' AND z_brand_event.id='.tools::int($id).'
		LIMIT 0,1
		');
		if($result){

            $sitestrequested=$db->queryFetchAllFirst('SELECT COUNT(DISTINCT id) FROM z_event_site WHERE z_event_site.eventid='.$result['id'].'');
            $result['sitesrequested']=$sitestrequested[0];
            $result['sites']=$db->queryFetchAllAssoc('
			SELECT 
			  COUNT(z_event.siteid) AS evcount,
			  z_event_site.id AS requestid,
			  z_site.id,
			  z_site.name,
			  z_clubform.espresso+z_clubform.mohito+z_clubform.longisland AS checks,
			  z_clubform.age,
			  z_clubform.visits,
			  z_favclubs.id AS favourite,
		  	 if(z_brand_visits.date_visit<z_event_site.date_update,1,0) AS new  
			FROM
			  z_event_site 
			  INNER JOIN
			  z_site 
			  ON z_site.id = z_event_site.siteid 
			  AND z_site.sitetypeid = 7 
			  LEFT JOIN z_brand_visits
			  ON z_brand_visits.itemid='.$result['id'].' AND z_brand_visits.datatypeid=15 AND z_brand_visits.brandid='.tools::int($_SESSION['User']['brandid']).'
			  LEFT JOIN
			  z_event 
			  ON z_event.siteid = z_site.id 
			  AND DATE_FORMAT(
			    DATE_ADD(
			      z_event.date_start,
			      INTERVAL 1 DAY
			    ),
			    "%Y%m%d"
			  ) >= DATE_FORMAT(NOW(), "%Y%m%d") 
			  LEFT JOIN z_favclubs
			  ON z_favclubs.siteid=z_site.id AND z_favclubs.userid='.tools::int($_SESSION['User']['id']).'
			  LEFT JOIN z_clubform
			  ON z_clubform.siteid=z_site.id
			WHERE z_event_site.eventid = '.$result['id'].' AND (CHAR_LENGTH(z_event_site.report)>0 OR z_event_site.file_name IS NOT NULL)
			GROUP BY z_site.id');
			
			$likes=$db->queryFetchAllAssoc('
			SELECT 
			  SUM(z_social_stats.VALUE) AS likesum,
			  z_event_site.siteid 
			FROM
			  z_event_site 
			  LEFT JOIN
			  z_social_stats 
			  ON z_social_stats.siteid = z_event_site.siteid 
			  AND z_social_stats.statstypeid IN (4, 5, 6) 
			  AND z_social_stats.VALUE > 0 
			  AND z_social_stats.DATE = 
			  (SELECT 
			    MAX(z_social_stats.DATE) 
			  FROM
			    z_social_stats) 
			  AND z_social_stats.DATE > 0 
			WHERE z_event_site.eventid = '.$result['id'].' AND z_event_site.confirm=1 AND  z_social_stats.VALUE>0 
			GROUP BY z_social_stats.siteid,
			  z_social_stats.DATE ');
			  foreach($likes as $like){
			  	$result['likes'][$like['siteid']]=$like['likesum'];
			  }
		}
		if($result)
		return $result;
	}
	public function visitEvent($id){
		if(!$id)
		return;
		$db=db::init();
		$result=$db->exec('UPDATE z_brand_visits SET date_visit=NOW() WHERE itemid='.tools::int($id).' AND datatypeid=15 AND brandid='.tools::int($_SESSION['User']['brandid']).'');
		if(!$result)
		$db->exec('INSERT INTO z_brand_visits (datatypeid,brandid,date_visit,itemid) VALUES (15,'.tools::int($_SESSION['User']['brandid']).',NOW(),'.tools::int($id).')');
	}
	public function getEventReport($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_event_site.report,
		  CONCAT("/uploads/sites/",z_event_site.siteid,"/files/",z_event_site.file_name) AS file_name,
		  z_event_site.file_oldname
		FROM
		  z_event_site 
		WHERE z_event_site.`id`='.tools::int($id).'
		');
		if($result)
		return $result;
	}
public function approvePoster($id,$action){
		if(tools::int($id)<1)
		return false;	
		$db=db::init();
		if($action==1){
			if($db->exec('INSERT INTO z_event_approve (eventid,brandid,userid) VALUES ('.tools::int($id).','.tools::int($_SESSION['User']['brandid']).','.tools::int($_SESSION['User']['id']).')'))
			return 1;
		}elseif($action==2){
			if($db->exec('DELETE FROM z_event_approve WHERE  eventid='.tools::int($id).' AND brandid='.tools::int($_SESSION['User']['brandid']).''))
			return 2;
		}
}
public function applyPosterChange($data){
		$db=db::init();
		$db->exec('DELETE FROM z_poster_change WHERE z_poster_change.eventid='.tools::int($data['eventid']).' AND brandid='.tools::int($_SESSION['User']['brandid']).'');
		$db->exec('INSERT INTO z_poster_change (eventid, posterid, brandid, userid) VALUES ('.tools::int($data['eventid']).', '.tools::int($data['posterid']).', '.tools::int($_SESSION['User']['brandid']).', '.tools::int($_SESSION['User']['id']).')');
		
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_user.`email`,
		  z_event.name AS eventname,
		  z_event.id AS eventid,
		  IF(
		    z_domain.id > 0,
		    z_domain.NAME,
		    CONCAT("r", z_site.id, ".reactor.ua")
		  ) AS domain 
		FROM
		  z_event 
		  INNER JOIN z_site 
		    ON z_site.id = z_event.`siteid` 
		  INNER JOIN z_user 
		    ON z_user.id = z_site.`userid` 
		  LEFT JOIN z_domain 
		    ON z_domain.siteid = z_site.id 
		WHERE z_event.id = '.tools::int($data['eventid']).' ');
		if($result){
			$subject= "Замечания от бренда \"".$_SESSION['User']['brandname']."\" по поводу постера к ивенту \"".$result['eventname']."\"";
			$message= "Вам пришло замечания от бренда \"".$_SESSION['User']['brandname']."\"  по поводу постера на событие \"".$result['eventname']."\" http://".$result['domain']."/event/".$result['eventid']."/.\n\n";
			$message.= "Текст замечание:\n\n";
			$message.= $data['message']."\n\n";
			$message.= "Отвечать на него не нужно. Внесите правки и залейте постер еще раз.";
			$smtp=new smtp;
			$smtp->Connect(SMTP_HOST);
			$smtp->Hello(SMTP_HOST);
			$smtp->Authenticate('support@clubsreport.com', 'Z1IRldqU');
			$smtp->Mail('support@clubsreport.com');
			$smtp->Recipient('dmitriy.bozhok@gmail.com');
			//$smtp->Recipient($result['email']);
			$smtp->Data($message, $subject, 'Clubsreport');
		}
}

}
?>