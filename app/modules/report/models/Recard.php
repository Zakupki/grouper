<?
require_once 'modules/base/models/Basemodel.php';

Class Recard Extends Basemodel {

	private $registry;
	public function __construct($registry){
		$this->registry=$registry;
	}
	public function updateRecardRequest($data,$file){
		$db=db::init();
		$data['dateFrom']=explode('.', $data['dateFrom']);
		$data['dateTo']=explode('.', $data['dateTo']);
		if($data['deletefile']){
			tools::delImg($data['deletefile']);
			$updatefile=', file_name=NULL';
			$updatefilename=', file_oldname=NULL';
		}
		if($data['delete']>0){
			$db->exec('DELETE FROM z_brand_recard
			WHERE id='.tools::int($data['delete']).' AND brandid='.tools::int($_SESSION['User']['brandid']).'');
		}else{
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
				//echo json_encode($data);
			}
			if($data['id']){
				$db->exec('UPDATE z_brand_recard
				SET 
				name="'.tools::str($data['title']).'",
				detail_text="'.tools::str($data['desc']).'",
				date_start="'.tools::getSqlDate($data['dateFrom'][2],$data['dateFrom'][1],$data['dateFrom'][0]).'",
				date_end="'.tools::getSqlDate($data['dateTo'][2],$data['dateTo'][1],$data['dateTo'][0]).'",
				filtertype='.tools::int($data['clubsFilter']).'
				'.$updatefile.'
				'.$updatefilename.'
				WHERE id='.tools::int($data['id']).' AND brandid='.tools::int($_SESSION['User']['brandid']).'
				');
			}
			else{
				
				$db->exec('INSERT INTO z_brand_recard (name,detail_text,brandid,date_start,date_end,filtertype,file_name,file_oldname) 
				VALUES			
				("'.tools::str($data['title']).'","'.tools::str($data['desc']).'",'.tools::int($_SESSION['User']['brandid']).',"'.tools::getSqlDate($data['dateFrom'][2],$data['dateFrom'][1],$data['dateFrom'][0]).'",
				"'.tools::getSqlDate($data['dateTo'][2],$data['dateTo'][1],$data['dateTo'][0]).'",
				'.tools::int($data['clubsFilter']).',"'.$newfilename.'","'.$file['file']['name'].'")');
				$data['id']=$db->lastInsertId();
				if($data['id']>0){
					$subject = "Новая рекард от бренда";
					$message = "".$_SESSION['User']['brandname']." добавил новый рекард. Для его модерации перейдите на http://reactor.ua/admin/recards/\n\n";
					$smtp=new smtp;
					$smtp->Connect(SMTP_HOST);
					$smtp->Hello(SMTP_HOST);
					$smtp->Authenticate('reactor@reactor-pro.ru', '123qwe123');
					$smtp->Mail('reactor@reactor-pro.ru');
					$smtp->Recipient('selina@reactor.ua');
					$smtp->Recipient('inna.merk@reactor.ua');
					$smtp->Recipient('dmitriy.bozhok@gmail.com');
					$smtp->Data($message, $subject);
					
					/*
					$subject2 = "Р’Р°С€Р° Р·Р°СЏРІРєР° РЅР° СЂР°Р·РјРµС‰РµРЅРёРµ ReCard РІ СЃРёСЃС‚РµРјРµ Clubsreport";
										$message2 = "Р—РґСЂР°РІСЃС‚РІСѓР№С‚Рµ.\n\n".date("j.n.Y")." Р’С‹ РїРѕРґР°Р»Рё Р·Р°СЏРІРєСѓ РЅР° СЂР°Р·РјРµС‰РµРЅРёРµ ReCard РІ СЃРёСЃС‚РµРјРµ Clubsreport.\n\nР’ С‚РµС‡РµРЅРёРµ РѕРґРЅРѕРіРѕ СЂР°Р±РѕС‡РµРіРѕ РґРЅСЏ, СЃ Р’Р°РјРё СЃРІСЏР¶РµС‚СЃСЏ РїСЂРµРґСЃС‚Р°РІРёС‚РµР»СЊ Clubsreport РґР»СЏ РїРѕРґС‚РІРµСЂР¶РґРµРЅРёСЏ СѓРєР°Р·Р°РЅРЅРѕР№ РёРЅС„РѕСЂРјР°С†РёРё.\n\nРЎ СѓРІР°Р¶РµРЅРёРµРј, РєРѕРјР°РЅРґР° Clubsreport.\n\n";
										$smtp2=new smtp;
										$smtp2->Connect(SMTP_HOST);
										$smtp2->Hello(SMTP_HOST);
										$smtp2->Authenticate('support@clubsreport.com', 'Z1IRldqU');
										$smtp2->Mail('support@clubsreport.com');
										$smtp2->Recipient('selina@reactor.ua');
										$smtp2->Recipient('inna.merk@reactor.ua');
										$smtp2->Recipient($_SESSION['User']['email']);
										$smtp2->Data($message2, $subject2);*/
					
				}
				
			}
			if($data['clubsFilter']==0){
				$currentclubs=$db->queryFetchAll('SELECT siteid FROM z_recard_site where recardid='.tools::int($data['id']).'');
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
					$db->exec('INSERT INTO z_recard_site (recardid,siteid) VALUES ('.tools::int($data['id']).','.tools::int($clubid).')');
				}
				
			}
			elseif($data['clubsFilter']==1){
				$currentclubs=$db->queryFetchAll('SELECT siteid FROM z_recard_site where recardid='.tools::int($data['id']).'');
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
				$db->exec('DELETE FROM z_recard_site WHERE siteid NOT IN('.implode(',',$clubs).') AND recardid='.tools::int($data['id']).'');
				
				foreach($clubs as $clubid){
					if(!in_array($clubid,$currentclubsArr))
					$db->exec('INSERT INTO z_recard_site (recardid,siteid) VALUES ('.tools::int($data['id']).','.tools::int($clubid).')');
				}
			}
			elseif($data['clubsFilter']==2){
				$clubsArr=explode(',',$data['clubs-filter-ids']);
				if(strlen(trim($data['clubs-filter-ids']))>0 && count($clubsArr)>0){
				$db->exec('DELETE FROM z_recard_site WHERE siteid NOT IN('.$data['clubs-filter-ids'].') AND recardid='.tools::int($data['id']).'');
				}
				else{ $db->exec('DELETE FROM z_recard_site WHERE recardid='.tools::int($data['id']).'');
				}
				$currentclubs=$db->queryFetchAll('SELECT siteid FROM z_recard_site where recardid='.tools::int($data['id']).'');
				foreach($currentclubs as $curclub)
					$currentclubsArr[$curclub[0]]=$curclub[0];
				foreach($clubsArr as $clubid){
					if(!in_array($clubid,$currentclubsArr))
					$db->exec('INSERT INTO z_recard_site (recardid,siteid) VALUES ('.tools::int($data['id']).','.tools::int($clubid).')');
				}
			}
		}
	}
	public function getRecardRequests(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  COUNT(z_recard_site.siteid) AS sites,
		  z_brand_recard.id,
		  z_brand_recard.name,
		  z_brand_recard.detail_text,
		  z_brand_recard.date_start,
		  z_brand_recard.date_end,
		  if(DATE_ADD(z_brand_recard.date_start,INTERVAL 1 DAY)>=NOW(),1,0) AS future
		FROM
		  z_brand_recard
		LEFT JOIN
		  z_recard_site 
		  ON z_recard_site.recardid = z_brand_recard.id 
		WHERE  z_brand_recard.brandid='.tools::int($_SESSION['User']['brandid']).'
		GROUP BY z_brand_recard.id 
		ORDER BY z_brand_recard.date_start DESC
		');
		foreach($result as $site)
		$siteids[$site['id']]=$site['id'];
		
		if(is_array($siteids))
		$newsitesresult=$db->queryFetchAllAssoc('
		SELECT 
		  COUNT(z_recard_site.`id`) as count,
		  z_recard_site.`recardid` 
		FROM
		  z_recard_site 
		  INNER JOIN z_card 
		    ON z_card.requestid = z_recard_site.id 
		    AND z_card.yocardid > 0 
		  INNER JOIN z_brand_visits 
		    ON z_brand_visits.itemid IN ('.implode(',',$siteids).') 
		    AND z_brand_visits.datatypeid = 12 
		    AND z_brand_visits.brandid = '.tools::int($_SESSION['User']['brandid']).' 
		    AND z_brand_visits.date_visit<z_card.date_update
		WHERE z_recard_site.`recardid` IN ('.implode(',',$siteids).')
		GROUP BY z_recard_site.`recardid`
		');
		foreach($newsitesresult as $newsite)
		$newsites[$newsite['recardid']]=$newsite['count'];
		
		if($result)
		return array('recards'=>$result,'newsites'=>$newsites);
	}
	public function getRecardRequest($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_brand_recard.id,
		  z_brand_recard.name,
		  z_brand_recard.detail_text,
		  DATE_FORMAT(z_brand_recard.date_start,"%d.%m.%Y") AS date_start,
		  DATE_FORMAT(z_brand_recard.date_end,"%d.%m.%Y") AS date_end,
		  z_brand_recard.filtertype,
		  CONCAT("/uploads/brands/",z_brand_recard.brandid,"/",z_brand_recard.file_name) AS fileurl,
		  z_brand_recard.file_oldname AS filename
		FROM
		  z_brand_recard
		WHERE  z_brand_recard.brandid='.tools::int($_SESSION['User']['brandid']).' AND z_brand_recard.id='.tools::int($id).'
		LIMIT 0,1
		');
		if($result['filtertype']==2){
			$sites=$db->queryFetchAllAssoc('
			SELECT 
			  z_site.id,
			  z_site.name 
			FROM
			  z_recard_site 
			  INNER JOIN
			  z_site 
			  ON z_site.id = z_recard_site.siteid 
			  AND z_site.sitetypeid = 7 
			WHERE z_recard_site.recardid = '.$result['id'].'');
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
	public function getRecardRequestInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_brand_recard.id,
		  z_brand_recard.name,
		  z_brand_recard.detail_text,
		  z_brand_recard.date_start,
		  z_brand_recard.date_end,
		  z_brand_recard.filtertype,
		  if(CHAR_LENGTH(z_brand_recard.file_name)>3,CONCAT("/uploads/brands/",z_brand_recard.brandid,"/",z_brand_recard.file_name),null) AS fileurl,
		  z_brand_recard.file_oldname AS filename
		FROM
		  z_brand_recard
		WHERE  z_brand_recard.brandid='.tools::int($_SESSION['User']['brandid']).' AND z_brand_recard.id='.tools::int($id).'
		LIMIT 0,1
		');
		if($result){
			$result['sites']=$db->queryFetchAllAssoc('
			SELECT 
			  COUNT(z_event.siteid) AS evcount,
			  z_site.id,
			  z_site.name,
			  z_favclubs.id AS favourite,
			  z_card.price,
			  z_coupons.`ActiveCoupons`,
			  z_coupons.`CouponsExpired`,
			  z_coupons.`CouponsRedempt`,
			  z_coupons.`ParticipantsCount`,
			  z_coupons.`RedemptionRatio`,
			  z_coupons.`TotalCoupon`,
			  if(z_brand_visits.date_visit<z_card.date_update,1,0) AS new
			FROM
			  z_recard_site 
			  INNER JOIN
			  z_site 
			  ON z_site.id = z_recard_site.siteid 
			  AND z_site.sitetypeid = 7 
			  LEFT JOIN z_brand_visits
			  ON z_brand_visits.itemid='.$result['id'].' AND z_brand_visits.datatypeid=12 AND z_brand_visits.brandid='.tools::int($_SESSION['User']['brandid']).'
			  INNER JOIN z_card
			  ON z_card.requestid=z_recard_site.id AND z_card.yocardid>0
			  LEFT JOIN z_coupons
			  ON z_coupons.couponid=z_card.yocardid
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
			WHERE z_recard_site.recardid = '.$result['id'].'
			GROUP BY z_site.id');
		}
		if($result)
		return $result;
	}
	public function visitRecard($id){
		if(!$id)
		return;
		$db=db::init();
		$result=$db->exec('UPDATE z_brand_visits SET date_visit=NOW() WHERE itemid='.tools::int($id).' AND datatypeid=12 AND brandid='.tools::int($_SESSION['User']['brandid']).'');
		if(!$result)
		$db->exec('INSERT INTO z_brand_visits (datatypeid,brandid,date_visit,itemid) VALUES (12,'.tools::int($_SESSION['User']['brandid']).',NOW(),'.tools::int($id).')');
	}
}
?>