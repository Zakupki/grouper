<?
require_once 'modules/base/models/Basemodel.php';

Class Banner Extends Basemodel {

	private $registry;
	public function __construct($registry){
		$this->registry=$registry;
	}
	
	public function getBannerRequest($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_brand_banner.id,
		  z_brand_banner.link,
		  DATE_FORMAT(z_brand_banner.date_start,"%d.%m.%Y") AS date_start,
		  DATE_FORMAT(z_brand_banner.date_end,"%d.%m.%Y") AS date_end,
		  z_brand_banner.filtertype,
		  CONCAT("/uploads/brands/",z_brand_banner.brandid,"/",z_brand_banner.file_name) AS fileurl,
		  if(char_length(z_brand_banner.file_name)>0,CONCAT("/uploads/brands/",z_brand_banner.brandid,"/14_",z_brand_banner.file_name),null) AS fileurl2,
		  z_brand_banner.file_oldname AS filename
		FROM
		  z_brand_banner
		WHERE z_brand_banner.brandid='.tools::int($_SESSION['User']['brandid']).' AND z_brand_banner.id='.tools::int($id).'
		LIMIT 0,1
		');
		$allbanner=$db->queryFetchRowAssoc('
		SELECT 
          SUM(z_analytics_day.visits) AS visits,
          COUNT(DISTINCT (z_site.id)) AS sites
        FROM
          z_site
          LEFT JOIN
          z_analytics_day
          ON z_analytics_day.siteid = z_site.id
          AND z_analytics_day.date_start =
          (SELECT
            MAX(z_analytics_day.date_start)
          FROM
            z_analytics_day)
        WHERE z_site.sitetypeid = 7
          AND z_site.recommend = 1
		');
		if($result['filtertype']==2){
		$castbanner=$db->queryFetchRowAssoc('		
		SELECT 
		  SUM(z_analytics_day.visits) AS visits,
		  COUNT(DISTINCT (z_banner_site.siteid)) AS sites 
		FROM
		  z_banner_site 
		  LEFT JOIN z_analytics_day 
		    ON z_analytics_day.siteid = z_banner_site.siteid 
		    AND z_analytics_day.date_start = 
		    (SELECT 
		      MAX(z_analytics_day.date_start) 
		    FROM
		      z_analytics_day) 
		WHERE z_banner_site.`bannerid` = '.tools::int($id).'
		');
		}
		$favbanner=$db->queryFetchRowAssoc('
        SELECT
          SUM(z_analytics_day.visits) AS visits,
          COUNT(DISTINCT (z_site.id)) AS sites
        FROM
          z_site
          INNER JOIN
          z_favclubs
          ON z_favclubs.siteid = z_site.id
          AND z_favclubs.userid = '.tools::int($_SESSION['User']['id']).'
          LEFT JOIN
          z_analytics_day
          ON z_analytics_day.siteid = z_site.id
          AND z_analytics_day.date_start =
          (SELECT
            MAX(z_analytics_day.date_start)
          FROM
            z_analytics_day)
        WHERE z_site.sitetypeid = 7
          AND z_site.recommend = 1
		');
		if($result['filtertype']==2){
			$sites=$db->queryFetchAllAssoc('
			SELECT 
			  z_site.id,
			  z_site.name 
			FROM
			  z_banner_site 
			  INNER JOIN
			  z_site 
			  ON z_site.id = z_banner_site.siteid 
			  AND z_site.sitetypeid = 7 
			WHERE z_banner_site.bannerid = '.$result['id'].'');
			foreach($sites as $site){
				$sitenames[$site['id']]=$site['name'];
				$siteids[$site['id']]=$site['id'];
			}
			$result['sitenames']=$sitenames;
			$result['siteids']=$siteids;
		}
		return array('banner'=>$result,'allbanner'=>$allbanner,'favbanner'=>$favbanner,'castbanner'=>$castbanner);
	}
	
	public function updateBannerRequest($data,$file){
		$db=db::init();
		$data['dateFrom']=explode('.', $data['dateFrom']);
		$data['dateTo']=explode('.', $data['dateTo']);
		if($data['deletefile']){
			tools::delImg($_SERVER['DOCUMENT_ROOT'].$data['deletefile']);
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
				$updatefile=', file_name="'.$newfilename.'"';
				$updatefilename=', file_oldname="'.$file['file']['name'].'"';
			}
		}
		if($data['delete']>0){
			$db->exec('DELETE FROM z_brand_banner
			WHERE id='.tools::int($data['delete']).' AND brandid='.tools::int($_SESSION['User']['brandid']).'');
			
		}else{
			if($data['id']){
				$db->exec('UPDATE z_brand_banner
				SET 
				link="'.tools::str($data['link']).'",
				date_start="'.tools::getSqlDate($data['dateFrom'][2],$data['dateFrom'][1],$data['dateFrom'][0]).'",
				date_end="'.tools::getSqlDate($data['dateTo'][2],$data['dateTo'][1],$data['dateTo'][0]).'",
				filtertype='.tools::int($data['clubsFilter']).'
				'.$updatefile.'
				'.$updatefilename.'
				WHERE id='.tools::int($data['id']).' AND brandid='.tools::int($_SESSION['User']['brandid']).'
				');
			}
			else{
				$db->exec('INSERT INTO z_brand_banner (link,brandid,date_start,date_end,filtertype,file_name,file_oldname) 
				VALUES			
				("'.tools::str($data['link']).'",'.tools::int($_SESSION['User']['brandid']).',"'.tools::getSqlDate($data['dateFrom'][2],$data['dateFrom'][1],$data['dateFrom'][0]).'","'.tools::getSqlDate($data['dateTo'][2],$data['dateTo'][1],$data['dateTo'][0]).'",'.tools::int($data['clubsFilter']).', "'.$newfilename.'","'.$file['file']['name'].'")');
				$data['id']=$db->lastInsertId();
				/*
				if($data['id']>0){
									$db->exec('INSERT INTO z_brand_visits (datatypeid,itemid,brandid,date_visit) VALUES (13,'.$data['id'].','.tools::int($_SESSION['User']['brandid']).',NOW())');
									$subject2 = "Р’Р°С€Р° Р·Р°СЏРІРєР° РЅР° СЂР°Р·РјРµС‰РµРЅРёРµ Р‘Р°РЅРЅРµСЂР° РІ СЃРёСЃС‚РµРјРµ Clubsreport";
									$message2 = "Р—РґСЂР°РІСЃС‚РІСѓР№С‚Рµ.\n\n".date("j.n.Y")." Р’С‹ РїРѕРґР°Р»Рё Р·Р°СЏРІРєСѓ РЅР° СЂР°Р·РјРµС‰РµРЅРёРµ Р‘Р°РЅРЅРµСЂР° РІ СЃРёСЃС‚РµРјРµ Clubsreport.\n\nР’ С‚РµС‡РµРЅРёРµ РѕРґРЅРѕРіРѕ СЂР°Р±РѕС‡РµРіРѕ РґРЅСЏ, СЃ Р’Р°РјРё СЃРІСЏР¶РµС‚СЃСЏ РїСЂРµРґСЃС‚Р°РІРёС‚РµР»СЊ Clubsreport РґР»СЏ РїРѕРґС‚РІРµСЂР¶РґРµРЅРёСЏ СѓРєР°Р·Р°РЅРЅРѕР№ РёРЅС„РѕСЂРјР°С†РёРё.\n\nРЎ СѓРІР°Р¶РµРЅРёРµРј, РєРѕРјР°РЅРґР° Clubsreport.\n\n";
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
				$currentclubs=$db->queryFetchAll('SELECT siteid FROM z_banner_site where bannerid='.tools::int($data['id']).'');
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
					$db->exec('INSERT INTO z_banner_site (bannerid,siteid) VALUES ('.tools::int($data['id']).','.tools::int($clubid).')');
				}
				
			}
			elseif($data['clubsFilter']==1){
				$currentclubs=$db->queryFetchAll('SELECT siteid FROM z_banner_site where bannerid='.tools::int($data['id']).'');
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
				$db->exec('DELETE FROM z_banner_site WHERE siteid NOT IN('.implode(',',$clubs).') AND bannerid='.tools::int($data['id']).'');
				
				foreach($clubs as $clubid){
					if(!in_array($clubid,$currentclubsArr))
					$db->exec('INSERT INTO z_banner_site (bannerid,siteid) VALUES ('.tools::int($data['id']).','.tools::int($clubid).')');
				}
			}elseif($data['clubsFilter']==2){
				$clubsArr=explode(',',$data['clubs-filter-ids']);
				if(strlen(trim($data['clubs-filter-ids']))>0 && count($clubsArr)>0){
				$db->exec('DELETE FROM z_banner_site WHERE siteid NOT IN('.$data['clubs-filter-ids'].') AND bannerid='.tools::int($data['id']).'');
				}
				else{ $db->exec('DELETE FROM z_banner_site WHERE bannerid='.tools::int($data['id']).'');
				}
				$currentclubs=$db->queryFetchAll('SELECT siteid FROM z_banner_site where bannerid='.tools::int($data['id']).'');
				foreach($currentclubs as $curclub)
					$currentclubsArr[$curclub[0]]=$curclub[0];
				foreach($clubsArr as $clubid){
					if(!in_array($clubid,$currentclubsArr))
					$db->exec('INSERT INTO z_banner_site (bannerid,siteid) VALUES ('.tools::int($data['id']).','.tools::int($clubid).')');
				}
			}
			
		}
	}
	
	public function getBanners(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_brand_banner.id,
		  z_brand_banner.date_start,
		  z_brand_banner.date_end,
		  if(z_brand_banner.date_start>=NOW(),1,0) AS future,
		  CONCAT("/uploads/brands/",z_brand_banner.brandid,"/",z_brand_banner.file_name) AS fileurl,
		  if(char_length(z_brand_banner.file_name)>0,CONCAT("/uploads/brands/",z_brand_banner.brandid,"/2_",z_brand_banner.file_name),null) AS url
		FROM
		  z_brand_banner
		WHERE  z_brand_banner.brandid='.tools::int($_SESSION['User']['brandid']).'
		ORDER BY z_brand_banner.id DESC
		');
		foreach($result as $banner)
		$bannerids[$banner['id']]=$banner['id'];
		if(count($bannerids)>0)
		$newsitesresult=$db->queryFetchAllAssoc('
		SELECT 
		  COUNT(DISTINCT z_banner_site.`id`) AS count,
		  z_banner_site.`bannerid`,
		  z_banner_site.`siteid`,
		  z_banner_site.`date_update`,
		  z_brand_banner.`brandid` 
		FROM
		  z_banner_site 
		  INNER JOIN z_brand_banner 
		    ON z_brand_banner.`id` = z_banner_site.`bannerid` 
		  LEFT JOIN z_brand_visits 
		    ON z_brand_visits.`brandid` = z_brand_banner.`brandid` 
		    AND z_brand_visits.`datatypeid` = 13 
		    AND z_brand_visits.`itemid` = z_banner_site.`bannerid` 
		WHERE z_banner_site.`status` = 3 
		  AND z_banner_site.`date_update` > z_brand_visits.`date_visit` AND z_brand_banner.`brandid`='.tools::int($_SESSION['User']['brandid']).' 
		  OR z_brand_visits.`date_visit` IS NULL 
		  AND z_banner_site.`status` = 3  AND z_brand_banner.`brandid`='.tools::int($_SESSION['User']['brandid']).' 
		GROUP BY z_banner_site.`bannerid` 
		
		');
		foreach($newsitesresult as $newsite)
		$newsites[$newsite['bannerid']]=$newsite['count'];
		
		if($result){
			$plan=$db->queryFetchAllAssoc('SELECT 
			  COUNT(DISTINCT z_banner_site.`siteid`) AS sites,
			  SUM(z_analytics_day.visitors)*DATEDIFF(z_brand_banner.date_end,z_brand_banner.date_start) AS visitors,
			  z_brand_banner.id,
			  z_brand_banner.date_start,
			  z_brand_banner.date_end 
			FROM
			  z_brand_banner 
			  INNER JOIN z_banner_site 
			    ON z_banner_site.`bannerid` = z_brand_banner.id 
			  LEFT JOIN z_analytics_day 
			    ON z_analytics_day.siteid = z_banner_site.siteid 
			    AND z_analytics_day.date_start = 
			    (SELECT 
			      MAX(z_analytics_day.date_start) 
			    FROM
			      z_analytics_day) 
			WHERE z_brand_banner.brandid = 1 
			GROUP BY z_brand_banner.id 
			ORDER BY z_brand_banner.id DESC'); 
		foreach($plan as $p){
				$planArr[$p['id']]=$p;
			}
		}
		
		if($result)
		return array('banners'=>$result,'plan'=>$planArr,'newsites'=>$newsites);
	}
	public function getBannerRequestInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_brand_banner.id,
		  z_brand_banner.link,
		  z_brand_banner.date_start,
		  z_brand_banner.date_end,
		  z_brand_banner.filtertype,
		  if(char_length(z_brand_banner.file_name)>3,CONCAT("/uploads/brands/",z_brand_banner.brandid,"/14_",z_brand_banner.file_name),null) AS fileurl,
		  z_brand_banner.file_oldname AS filename
		FROM
		  z_brand_banner
		WHERE  z_brand_banner.brandid='.tools::int($_SESSION['User']['brandid']).' AND z_brand_banner.id='.tools::int($id).'
		LIMIT 0,1
		');
		if($result){
			$result['sites']=$db->queryFetchAllAssoc('
			SELECT 
			  COUNT(z_event.siteid) AS evcount,
			  z_site.id,
			  z_site.name,
			  z_clubform.espresso+z_clubform.mohito+z_clubform.longisland AS checks,
			  z_clubform.age,
			  z_clubform.visits,
			  z_favclubs.id AS favourite,
			  if(z_brand_visits.date_visit<z_banner_site.date_update OR z_brand_visits.id IS NULL,1,0) AS new 
			FROM
			  z_banner_site 
			  INNER JOIN
			  z_site 
			  ON z_site.id = z_banner_site.siteid 
			  AND z_site.sitetypeid = 7 
			  LEFT JOIN z_brand_visits
			  ON z_brand_visits.itemid='.$result['id'].' AND z_brand_visits.datatypeid=13 AND z_brand_visits.brandid='.tools::int($_SESSION['User']['brandid']).'
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
			WHERE z_banner_site.bannerid = '.$result['id'].' AND z_banner_site.status=3
			GROUP BY z_site.id');
			

            $result['plan']=$db->queryFetchRowAssoc('
                SELECT
                  SUM(z_analytics_day.visits)*DATEDIFF(z_brand_banner.date_end,z_brand_banner.date_start) AS visits,
              	  SUM(z_analytics_day.visitors)*DATEDIFF(z_brand_banner.date_end,z_brand_banner.date_start) AS visitors,
                  COUNT(DISTINCT (z_banner_site.siteid)) AS sites
                FROM
                  z_banner_site
                  INNER JOIN z_brand_banner
                  ON z_brand_banner.id=z_banner_site.bannerid
                  LEFT JOIN
                  z_analytics_day
                  ON z_analytics_day.siteid = z_banner_site.siteid
                                AND z_analytics_day.date_start =
                  (SELECT
                    MAX(z_analytics_day.date_start)
                  FROM
                    z_analytics_day)
                WHERE z_banner_site.bannerid='.$result['id'].'');
			$result['displayfact']=$db->queryFetchRowAssoc('
                SELECT 
				  COUNT(z_banner_display.`siteid`) AS value 
				FROM
				  z_banner_display 
				  INNER JOIN z_banner_site 
				    ON z_banner_site.`id` = z_banner_display.`bannersiteid` 
				  INNER JOIN z_brand_banner 
				    ON z_brand_banner.id = z_banner_site.bannerid 
				    WHERE z_banner_site.`bannerid`='.$result['id'].' AND z_banner_display.`date_create` BETWEEN z_brand_banner.`date_start` AND z_brand_banner.`date_end`
                ');
			$result['fact']=$db->queryFetchRowAssoc('
                SELECT 
				  SUM(z_analytics_day.visits) AS visits,
				  SUM(z_analytics_day.visitors) AS visitors,
				  COUNT(DISTINCT (z_banner_site.siteid)) AS sites 
				FROM
				  z_banner_site 
				  INNER JOIN z_brand_banner 
				    ON z_brand_banner.`id` = z_banner_site.`bannerid` 
				  LEFT JOIN z_analytics_day 
				    ON z_analytics_day.siteid = z_banner_site.siteid 
				    AND z_analytics_day.date_start >= z_brand_banner.date_start 
				    AND z_analytics_day.date_start <= z_brand_banner.date_end 
                WHERE z_banner_site.bannerid='.$result['id'].' AND z_banner_site.status=3');


			$analitycs=$db->queryFetchAllAssoc('
			SELECT 
			  z_analytics_day.siteid,
			  SUM(z_analytics_day.visits) AS visits,
			  SUM(z_analytics_day.visitors) AS visitors
			FROM
			  z_analytics_day 
			INNER JOIN z_banner_site
			ON z_banner_site.siteid=z_analytics_day.siteid AND z_banner_site.status=3
			INNER JOIN z_brand_banner
			ON z_brand_banner.id=z_banner_site.bannerid
			WHERE z_banner_site.bannerid = '.$result['id'].' AND z_analytics_day.date_start>=z_brand_banner.date_start AND z_analytics_day.date_start<=z_brand_banner.date_end
			GROUP BY z_analytics_day.siteid
			');
			foreach($analitycs as $a){
				$result['analytics'][$a['siteid']]=$a;
			}

			$displays=$db->queryFetchAllAssoc('
			SELECT 
			  z_banner_display.`siteid`,
			  COUNT(z_banner_display.`siteid`) AS value 
			FROM
			  z_banner_display 
			  INNER JOIN z_banner_site 
			    ON z_banner_site.`id` = z_banner_display.`bannersiteid` AND z_banner_site.status=3
			  INNER JOIN z_brand_banner 
			    ON z_brand_banner.`id` = z_banner_site.`bannerid` 
			WHERE z_banner_site.`bannerid` = '.$result['id'].' 
			  AND z_banner_display.`date_create` BETWEEN z_brand_banner.`date_start` 
			  AND z_brand_banner.`date_end` 
			GROUP BY z_banner_site.`siteid`  
			');
			foreach($displays as $d){
				$result['displays'][$d['siteid']]=$d['value'];
			}
			$clicks=$db->queryFetchAllAssoc('
			SELECT 
			  z_banner_click.`siteid`,
			  COUNT(z_banner_click.`siteid`) AS value 
			FROM
			  z_banner_click 
			  INNER JOIN z_banner_site 
			    ON z_banner_site.`id` = z_banner_click.`bannersiteid` AND z_banner_site.status=3
			  INNER JOIN z_brand_banner 
			    ON z_brand_banner.`id` = z_banner_site.`bannerid` 
			WHERE z_banner_site.`bannerid` = '.$result['id'].' 
			  AND z_banner_click.`date_create` BETWEEN z_brand_banner.`date_start` 
			  AND z_brand_banner.`date_end` 
			GROUP BY z_banner_site.`siteid`  
			');
			foreach($clicks as $c){
				$result['clicks'][$c['siteid']]=$c['value'];
			}
			
			
			
		}
		if($result)
		return $result;
	}
	public function visitBanner($id){
		if(!$id)
		return;
		$db=db::init();
		$result=$db->exec('UPDATE z_brand_visits SET date_visit=NOW() WHERE itemid='.tools::int($id).' AND datatypeid=13 AND brandid='.tools::int($_SESSION['User']['brandid']).'');
		if(!$result)
		$db->exec('INSERT INTO z_brand_visits (datatypeid,brandid,date_visit,itemid) VALUES (13,'.tools::int($_SESSION['User']['brandid']).',NOW(),'.tools::int($id).')');
	}

}
?>