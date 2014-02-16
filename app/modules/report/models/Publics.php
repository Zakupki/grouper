<?
require_once 'modules/base/models/Basemodel.php';

Class Publics Extends Basemodel {

	private $registry;
	public function __construct($registry){
		$this->registry=$registry;
	}
	
	public function getPublicRequest($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_public.id,
		  z_public.detail_text,
		  DATE_FORMAT(z_public.date_start,"%d.%m.%Y") AS date_start,
		  z_public.filtertype,
		  CONCAT("/uploads/users/",z_public.userid,"/",z_public.file_name) AS fileurl,
		  z_public.file_oldname AS filename
		FROM
		  z_public
		WHERE z_public.userid='.tools::int($_SESSION['User']['id']).' AND z_public.id='.tools::int($id).'
		LIMIT 0,1
		');
		if($result['filtertype']==2){
		$custpublic=$db->queryFetchRowAssoc('		
		SELECT 
		  SUM(z_social_stats.value) AS followers,
		  COUNT(DISTINCT (z_public_group.groupid)) AS sites 
		FROM
		  z_public_group 
		  LEFT JOIN z_social_stats 
		    ON z_social_stats.groupid = z_public_group.groupid 
		    AND z_social_stats.date = 
		    (SELECT 
		      MAX(z_social_stats.date) 
		    FROM
		      z_social_stats) 
		WHERE z_public_group.`publicid` = '.tools::int($id).'
		');
		}
        
        $allpublic=$db->queryFetchRowAssoc('
		SELECT 
		  COUNT(DISTINCT (z_public_group.groupid)) AS groups,
          SUM(z_social_stats.VALUE) AS followers,
          SUM(z_group.price) AS totalprice		   
		FROM
              z_public_group
            INNER JOIN z_group
            ON z_group.id=z_public_group.groupid
            LEFT JOIN z_social_stats
              ON z_social_stats.groupid=z_public_group.groupid
		');
		$favpublic=$db->queryFetchRowAssoc('
		SELECT 
          COUNT(DISTINCT (z_public_group.groupid)) AS groups,
          SUM(z_social_stats.VALUE) AS followers,
          SUM(z_group.price) AS totalprice         
        FROM
          z_public_group
        INNER JOIN z_group
          ON z_group.id=z_public_group.groupid
        LEFT JOIN z_social_stats
          ON z_social_stats.groupid=z_public_group.groupid
		INNER JOIN z_favgroups
          ON z_favgroups.groupid=z_public_group.groupid AND z_favgroups.userid='.tools::int($_SESSION['User']['id']).'
        ');
		if($result['filtertype']==2){
			$sites=$db->queryFetchAllAssoc('
			SELECT 
			  z_site.id,
			  z_site.name 
			FROM
			  z_public_group 
			  INNER JOIN
			  z_site 
			  ON z_site.id = z_public_group.groupid 
			  AND z_site.sitetypeid = 7 
			WHERE z_public_group.publicid = '.$result['id'].'');
			foreach($sites as $site){
				$sitenames[$site['id']]=$site['name'];
				$siteids[$site['id']]=$site['id'];
			}
			$result['sitenames']=$sitenames;
			$result['siteids']=$siteids;
		}
		return array('public'=>$result,'allpublic'=>$allpublic,'favpublic'=>$favpublic,'custpublic'=>$custpublic);
	}
    public function updatePublicRequest($data,$file){
        $db=db::init();
        $filterArr=$data;
        unset($filterArr['route']);
        unset($filterArr['id']);
        unset($filterArr['date']);
        unset($filterArr['url']);
        unset($filterArr['image']);
        unset($filterArr['url_deleted']);
        unset($filterArr['__utma']);
        unset($filterArr['__utmz']);
        unset($filterArr['PHPSESSID']);
        unset($filterArr['react']);

        if(!$data['id'])
            $new=true;
        //$data['date']=explode('.', $data['date']);
        if($data['url_deleted']){
            unlink($_SERVER['DOCUMENT_ROOT'].$data['url_deleted']);
            $updatefile=', file_name=NULL';
            $updatefilename=', file_oldname=NULL';
        }
       // print_r($file);


        if($data['image']){
            $image=str_replace("12_","",$data['image']);
            $newfile='"NULL"';
            $tempfile="".$_SERVER['DOCUMENT_ROOT'].$image."";

            if(file_exists($tempfile)){
                $image=pathinfo($image);
                $newfile=md5(uniqid().microtime()).'.'.$image['extension'];
                if(rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/users/".tools::int($_SESSION['User']['id'])."/img/".$newfile.""))
                {
                    $updatefile=', file_name="'.tools::str($newfile).'"';
                    $updatefilename=', file_oldname="'.$file['file']['name'].'"';
                }

            }
        }


        if($data['delete']>0){
            $db->exec('DELETE FROM z_public
			WHERE id='.tools::int($data['delete']).' AND userid='.tools::int($_SESSION['User']['id']).'');
        }else{
            if($data['id']){
                $db->exec('UPDATE z_public
				SET
				detail_text="'.tools::str($data['publication']).'",
				publictypeid='.tools::int($data['publictypeid']).',
				date_start="'.$data['date'].':00",
				filters="'.addslashes(serialize($filterArr)).'",
				filtertype='.tools::int($data['groupsFilter']).'
				'.$updatefile.'
				'.$updatefilename.'
				WHERE id='.tools::int($data['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
				');
            }
            else{
                $db->exec('INSERT INTO z_public (publictypeid,detail_text,userid,date_start,filtertype,file_name,file_oldname,filters)
				VALUES
				('.tools::int($data['publictypeid']).',"'.tools::str($data['publication']).'",'.tools::int($_SESSION['User']['id']).',"'.$data['date'].':00",'.tools::int($data['groupsFilter']).', "'.$newfile.'","'.$file['file']['name'].'","'.addslashes(serialize($filterArr)).'")');
                $data['id']=$db->lastInsertId();
                /*
                if($data['id']>0){
                                    $db->exec('INSERT INTO z_brand_visits (datatypeid,itemid,brandid,date_visit) VALUES (14,'.$data['id'].','.tools::int($_SESSION['User']['brandid']).',NOW())');
                                    $subject2 = "Р’Р°С€Р° Р·Р°СЏРІРєР° РЅР° СЂР°Р·РјРµС‰РµРЅРёРµ РџР°Р±Р»РёРєР° РІ СЃРёСЃС‚РµРјРµ Clubsreport";
                                    $message2 = "Р—РґСЂР°РІСЃС‚РІСѓР№С‚Рµ.\n\n".date("j.n.Y")." Р’С‹ РїРѕРґР°Р»Рё Р·Р°СЏРІРєСѓ РЅР° СЂР°Р·РјРµС‰РµРЅРёРµ РџР°Р±Р»РёРєР° РІ СЃРёСЃС‚РµРјРµ Clubsreport.\n\nР’ С‚РµС‡РµРЅРёРµ РѕРґРЅРѕРіРѕ СЂР°Р±РѕС‡РµРіРѕ РґРЅСЏ, СЃ Р’Р°РјРё СЃРІСЏР¶РµС‚СЃСЏ РїСЂРµРґСЃС‚Р°РІРёС‚РµР»СЊ Clubsreport РґР»СЏ РїРѕРґС‚РІРµСЂР¶РґРµРЅРёСЏ СѓРєР°Р·Р°РЅРЅРѕР№ РёРЅС„РѕСЂРјР°С†РёРё.\n\nРЎ СѓРІР°Р¶РµРЅРёРµРј, РєРѕРјР°РЅРґР° Clubsreport.\n\n";
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
            if($data['id']>0){
                $currentclubsArr=array();
                $db=db::init();
                    if($data['groupsFilter']==2)
                    $join='INNER JOIN z_favgroups
                    ON z_favgroups.groupid=z_group.id AND z_favgroups.userid='.tools::int($_SESSION['User']['id']).'';
                    elseif($data['groupsFilter']==3 && count($data['specialGroups'])>0)
                        $where.=' AND z_group.id IN('.implode(',',$data['specialGroups']).')';
                    if(count($data['topics'])>0)
                        $where.=' AND z_group.groupsubjectid IN('.implode(',',$data['topics']).')';
                    if(count($data['countries'])>0)
                        $where.=' AND z_group.countryid IN('.implode(',',$data['countries']).')';
                    if(count($data['ageRange'])>0)
                        $where.=' AND z_group.age BETWEEN '.tools::int($data['ageRange'][0]).' AND '.tools::int($data['ageRange'][1]).'';
                    if($data['genderFilter']>0)
                        $where.=' AND z_group.gender='.tools::int($data['genderFilter']).'';
                    if(count($data['priceRange'])>0)
                    $where.=' AND z_group.price BETWEEN '.tools::int($data['priceRange'][0]).' AND '.tools::int($data['priceRange'][1]).'';
                    if(count($data['subscribersRange'])>0){
                        $where.=' AND z_social_stats.value BETWEEN '.tools::int($data['subscribersRange'][0]).' AND '.tools::int($data['subscribersRange'][1]).'';
                    }
                $oldgroups=array_flip($db->queryFetchAllFirst('
                    SELECT
                      z_public_group.groupid
                    FROM z_public_group
                    WHERE z_public_group.publicid='.tools::int($data['id']).'
                    '));

                $groups=$db->queryFetchAllAssoc('
                    SELECT
                      z_group.*
                    FROM z_group
                    INNER JOIN z_social_stats
                        ON z_social_stats.groupid=z_group.id AND z_social_stats.date=(SELECT MAX(DATE) FROM z_social_stats)
                    '.$join.'
                    WHERE z_group.userid!='.tools::int($_SESSION['User']['id']).' AND z_group.notconnected=0
                    '.$where.'
                    GROUP BY z_group.id
                    ');
                foreach($groups as $g){
                    if(!in_array($g['id'],array_keys($oldgroups))){
                        if($data['type']=='repost')
                            $price=$g['repostprice'];
                        else
                            $price=$g['price'];
                        if(intval($price)<1)
                            $price=0;
                        $db->exec('INSERT INTO z_public_group (publicid,groupid,price) VALUES ('.tools::int($data['id']).','.tools::int($g['id']).', '.$price.')');

                    }else{
                        unset($oldgroups[$g['id']]);
                    }
                }
                //tools::print_r($oldgroups);
                if(count($oldgroups)>0)
                    $db->exec('DELETE FROM z_public_group WHERE publicid='.tools::int($data['id']).' AND groupid in('.implode(',',array_keys($oldgroups)).') AND confirm=0');
                //echo ('DELETE FROM z_public_group WHERE publicid='.tools::int($data['id']).' AND groupid in('.implode(',',$oldgroups).') AND confirm=0');

            }


        }
        if($data['id']>0)
            echo json_encode(array('error'=>'false', 'status'=>'','url'=>'/public/'));
        else
            echo json_encode(array('error'=>'true', 'status'=>'Промзошла ошибка','url'=>'/public/'));
    }
	public function updatePublicRequest_2($data,$file){
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
			$db->exec('DELETE FROM z_public
			WHERE id='.tools::int($data['delete']).' AND userid='.tools::int($_SESSION['User']['id']).'');
		}else{
			if($data['id']){
				$db->exec('UPDATE z_public
				SET 
				detail_text="'.tools::str($data['desc']).'",
				date_start="'.tools::getSqlDate($data['date'][2],$data['date'][1],$data['date'][0]).'",
				filtertype='.tools::int($data['clubsFilter']).'
				'.$updatefile.'
				'.$updatefilename.'
				WHERE id='.tools::int($data['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
				');
			}
			else{
				$db->exec('INSERT INTO z_public (detail_text,userid,date_start,filtertype,file_name,file_oldname) 
				VALUES			
				("'.tools::str($data['desc']).'",'.tools::int($_SESSION['User']['id']).',"'.tools::getSqlDate($data['date'][2],$data['date'][1],$data['date'][0]).'",'.tools::int($data['clubsFilter']).', "'.$newfilename.'","'.$file['file']['name'].'")');
				$data['id']=$db->lastInsertId();
				/*
				if($data['id']>0){
									$db->exec('INSERT INTO z_brand_visits (datatypeid,itemid,brandid,date_visit) VALUES (14,'.$data['id'].','.tools::int($_SESSION['User']['brandid']).',NOW())');
									$subject2 = "Р’Р°С€Р° Р·Р°СЏРІРєР° РЅР° СЂР°Р·РјРµС‰РµРЅРёРµ РџР°Р±Р»РёРєР° РІ СЃРёСЃС‚РµРјРµ Clubsreport";
									$message2 = "Р—РґСЂР°РІСЃС‚РІСѓР№С‚Рµ.\n\n".date("j.n.Y")." Р’С‹ РїРѕРґР°Р»Рё Р·Р°СЏРІРєСѓ РЅР° СЂР°Р·РјРµС‰РµРЅРёРµ РџР°Р±Р»РёРєР° РІ СЃРёСЃС‚РµРјРµ Clubsreport.\n\nР’ С‚РµС‡РµРЅРёРµ РѕРґРЅРѕРіРѕ СЂР°Р±РѕС‡РµРіРѕ РґРЅСЏ, СЃ Р’Р°РјРё СЃРІСЏР¶РµС‚СЃСЏ РїСЂРµРґСЃС‚Р°РІРёС‚РµР»СЊ Clubsreport РґР»СЏ РїРѕРґС‚РІРµСЂР¶РґРµРЅРёСЏ СѓРєР°Р·Р°РЅРЅРѕР№ РёРЅС„РѕСЂРјР°С†РёРё.\n\nРЎ СѓРІР°Р¶РµРЅРёРµРј, РєРѕРјР°РЅРґР° Clubsreport.\n\n";
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
				$currentclubs=$db->queryFetchAll('SELECT groupid FROM z_public_group where publicid='.tools::int($data['id']).'');
				foreach($currentclubs as $curclub)
					$currentclubsArr[$curclub[0]]=$curclub[0];
					
				$clubs=$db->queryFetchAllFirst('
					SELECT 
					  z_group.id
					FROM
					  z_group
					');
				foreach($clubs as $clubid){
					if(!in_array($clubid,$currentclubsArr))
					$db->exec('INSERT INTO z_public_group (publicid,groupid) VALUES ('.tools::int($data['id']).','.tools::int($clubid).')');
				}
				
			}
			elseif($data['clubsFilter']==1){
				$currentclubs=$db->queryFetchAll('SELECT groupid FROM z_public_group where publicid='.tools::int($data['id']).'');
				foreach($currentclubs as $curclub)
					$currentclubsArr[$curclub[0]]=$curclub[0];
					
				$clubs=$db->queryFetchAllFirst('
					SELECT 
					  z_favgroups.groupid
					FROM
					  z_favgroups 
					WHERE z_favgroups.userid='.tools::int($_SESSION['User']['id']).'
					');
				
				if(count($clubs)>0)
				$db->exec('DELETE FROM z_public_group WHERE groupid NOT IN('.implode(',',$clubs).') AND publicid='.tools::int($data['id']).'');
				
				foreach($clubs as $clubid){
					if(!in_array($clubid,$currentclubsArr))
					$db->exec('INSERT INTO z_public_group (publicid,groupid) VALUES ('.tools::int($data['id']).','.tools::int($clubid).')');
				}
			}elseif($data['clubsFilter']==2){
				$clubsArr=explode(',',$data['clubs-filter-ids']);
				if(strlen(trim($data['clubs-filter-ids']))>0 && count($clubsArr)>0){
				$db->exec('DELETE FROM z_public_group WHERE groupid NOT IN('.$data['clubs-filter-ids'].') AND publicid='.tools::int($data['id']).'');
				}
				else{ $db->exec('DELETE FROM z_public_group WHERE publicid='.tools::int($data['id']).'');
				}
				$currentclubs=$db->queryFetchAll('SELECT groupid FROM z_public_group where publicid='.tools::int($data['id']).'');
				foreach($currentclubs as $curclub)
					$currentclubsArr[$curclub[0]]=$curclub[0];
				foreach($clubsArr as $clubid){
					if(!in_array($clubid,$currentclubsArr))
					$db->exec('INSERT INTO z_public_group (publicid,groupid) VALUES ('.tools::int($data['id']).','.tools::int($clubid).')');
				}
			}
			
		}
	}
	public function getPublicRequests(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  COUNT(z_public_group.groupid) AS sites,
		  z_public.id,
		  z_public.detail_text,
		  z_public.date_start,
		  z_public.publictypeid,
		  CONCAT("/uploads/users/",z_public.userid,"/",z_public.file_name) AS fileurl,
		  if(DATE_ADD(z_public.date_start,INTERVAL 1 DAY)>=NOW(),1,0) AS future
		FROM
		  z_public
		LEFT JOIN
		  z_public_group 
		  ON z_public_group.publicid = z_public.id 
		WHERE  z_public.userid='.tools::int($_SESSION['User']['id']).'
		GROUP BY z_public.id 
		ORDER BY z_public.date_start DESC
		');
		
		foreach($result as $public)
		$publicids[$public['id']]=$public['id'];
		if(count($publicids)>0)
		$newsitesresult=$db->queryFetchAllAssoc('
		SELECT 
		 SUM(IF(z_public_report.`date_create`>z_page_visit.`date_visit` OR z_page_visit.`date_visit` IS NULL AND z_public_report.id>0,1,0)) as count,
		  z_public_group.`publicid` 
		FROM
		  z_public_group 
		INNER JOIN z_public_report 
		  ON z_public_report.`publicrequestid` = z_public_group.id
		LEFT JOIN z_page_visit
		ON z_page_visit.itemid=z_public_group.`publicid`
		WHERE z_public_group.`publicid` IN ('.implode(',',$publicids).')
		GROUP BY z_public_group.`publicid`
		');
		foreach($newsitesresult as $newsite)
		$newsites[$newsite['publicid']]=$newsite['count'];
		
		if($result)
		return array('publics'=>$result,'newsites'=>$newsites);
	}
	public function getPublicRequestInner($id){
		$db=db::init();

        $date=$db->queryFetchRowAssoc('SELECT MAX(DATE) as date FROM z_social_stats');
        $result=$db->queryFetchRowAssoc('
		SELECT 
		  z_public.id,
		  z_public.detail_text,
		  z_public.date_start,
		  z_public.filtertype,
		  z_public.filters,
		  CONCAT("/uploads/users/",z_public.userid,"/img/",z_public.file_name) AS fileurl,
		  CONCAT("/uploads/users/",z_public.userid,"/img/12_",z_public.file_name) AS filethumb,
		  z_public.file_name AS filename
		FROM
		  z_public
		WHERE  z_public.userid='.tools::int($_SESSION['User']['id']).' AND z_public.id='.tools::int($id).'
		LIMIT 0,1
		');
		if($result){
            $result['plan']=$db->queryFetchRowAssoc('
            SELECT
              COUNT(DISTINCT (z_public_group.groupid)) AS groups,
              SUM(z_social_stats.VALUE) AS followers,
              SUM(z_group.price) AS totalprice
            FROM
              z_public_group
            INNER JOIN z_group
            ON z_group.id=z_public_group.groupid AND z_group.notconnected=0
            LEFT JOIN z_social_stats
              ON z_social_stats.groupid=z_public_group.groupid
            WHERE z_public_group.publicid = '.$result['id'].'
            ');
             $result['fact']=$db->queryFetchRowAssoc('
            SELECT
              COUNT(DISTINCT (z_public_group.groupid)) AS groups,
              SUM(z_social_stats.VALUE) AS followers,
              SUM(z_group.price) AS totalprice
            FROM
              z_public_group
            INNER JOIN z_group
            ON z_group.id=z_public_group.groupid AND z_group.notconnected=0
            INNER JOIN z_public_report
            ON z_public_report.publicrequestid=z_public_group.id
            LEFT JOIN z_social_stats
              ON z_social_stats.groupid=z_public_group.groupid
            WHERE z_public_group.publicid = '.$result['id'].'
            ');
            
            $result['sites']=$db->queryFetchAllAssoc('
            SELECT
              z_public_group.id,
              z_public_group.publicid,
              z_public_group.payed,
              z_group.name,
              z_group.price,
              z_public_report.link,
              CONCAT(
                "/uploads/",
                z_file.subdir,
                "/",
                z_file.file_name
              ) AS image,
              z_social_stats.value as likes
            FROM
              z_public_group 
              INNER JOIN z_public_report 
                ON z_public_report.`publicrequestid`=z_public_group.id
              INNER JOIN z_group
                ON z_group.id=z_public_group.groupid  AND z_group.notconnected=0
              INNER JOIN
              z_social
              ON z_social.id = z_group.socialid
              LEFT JOIN
              z_file
              ON z_social.preview_image = z_file.id
              LEFT JOIN z_social_stats
              ON z_social_stats.groupid=z_group.id AND z_social_stats.date="'.$date['date'].'"
            WHERE z_public_group.publicid = '.$result['id'].'
            ');

		}
		if($result)
		return $result;
	}
    public function getPublicRequestData($id){
        $db=db::init();

        $date=$db->queryFetchRowAssoc('SELECT MAX(DATE) as date FROM z_social_stats');
        $result=$db->queryFetchRowAssoc('
		SELECT
		  z_public.id,
		  z_public.detail_text,
		  z_public.date_start,
		  z_public.filtertype,
		  z_public.filters,
		  if(char_length(z_public.file_name)>5,CONCAT("/uploads/users/",z_public.userid,"/img/",z_public.file_name),NULL) AS fileurl,
		  if(char_length(z_public.file_name)>5,CONCAT("/uploads/users/",z_public.userid,"/img/12_",z_public.file_name),NULL) AS filethumb,
		  z_public.file_name AS filename
		FROM
		  z_public
		WHERE  z_public.userid='.tools::int($_SESSION['User']['id']).' AND z_public.id='.tools::int($id).'
		LIMIT 0,1
		');
        if($result){
            $result['plan']=$db->queryFetchRowAssoc('
            SELECT
              COUNT(DISTINCT (z_public_group.groupid)) AS groups,
              SUM(z_social_stats.VALUE) AS followers,
              SUM(z_group.price) AS totalprice
            FROM
              z_public_group
            INNER JOIN z_group
            ON z_group.id=z_public_group.groupid AND z_group.notconnected=0
            LEFT JOIN z_social_stats
              ON z_social_stats.groupid=z_public_group.groupid
            WHERE z_public_group.publicid = '.$result['id'].'
            ');
            $result['fact']=$db->queryFetchRowAssoc('
            SELECT
              COUNT(DISTINCT (z_public_group.groupid)) AS groups,
              SUM(z_social_stats.VALUE) AS followers,
              SUM(z_group.price) AS totalprice
            FROM
              z_public_group
            INNER JOIN z_group
            ON z_group.id=z_public_group.groupid AND z_group.notconnected=0
            INNER JOIN z_public_report
            ON z_public_report.publicrequestid=z_public_group.id
            LEFT JOIN z_social_stats
              ON z_social_stats.groupid=z_public_group.groupid
            WHERE z_public_group.publicid = '.$result['id'].'
            ');

            $result['sites']=$db->queryFetchAllAssoc('
            SELECT
              z_public_group.id,
              z_public_group.publicid,
              z_public_group.payed,
              z_public_group.groupid,
              z_group.name,
              z_group.price,
              CONCAT(
                "/uploads/",
                z_file.subdir,
                "/",
                z_file.file_name
              ) AS image,
              z_social_stats.value as likes
            FROM
              z_public_group
              INNER JOIN z_group
                ON z_group.id=z_public_group.groupid  AND z_group.notconnected=0
              INNER JOIN
              z_social
              ON z_social.id = z_group.socialid
              LEFT JOIN
              z_file
              ON z_social.preview_image = z_file.id
              LEFT JOIN z_social_stats
              ON z_social_stats.groupid=z_group.id AND z_social_stats.date="'.$date['date'].'"
            WHERE z_public_group.publicid = '.$result['id'].'
            ');

        }
        if($result)
            return $result;
    }
	public function visitPublic($id){
		if(!$id)
		return;
		$db=db::init();
		$result=$db->exec('UPDATE z_page_visit SET date_visit=NOW() WHERE itemid='.tools::int($id).' AND datatypeid=1 AND userid='.tools::int($_SESSION['User']['id']).'');
		if(!$result)
		$db->exec('INSERT INTO z_page_visit (datatypeid,userid,date_visit,itemid) VALUES (1,'.tools::int($_SESSION['User']['id']).',NOW(),'.tools::int($id).')');
	}
}
?>