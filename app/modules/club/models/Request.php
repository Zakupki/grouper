<?
require_once 'modules/base/models/Basemodel.php';

Class Request Extends Basemodel {

private $registry;
public function __construct($registry){
	$this->registry=$registry;
}

public function getRequests(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				(SELECT 
				  IF(z_banner_site.bannerid, 1, 0) AS requesttype,
				  IF(NOW()>z_brand_banner.date_start,1,0) AS passed,
				  "Баннер" AS requesttypename,
				  z_banner_site.bannerid AS requestid,
				  z_banner_site.confirm,
				  z_banner_site.status,
				  z_brand_banner.date_create,
				  z_brand_banner.date_start,
				  z_brand_banner.brandid,
				  z_banner_site.new,
				  z_brand.NAME AS brandname,
				  NULL AS hasreport
				FROM
				  z_banner_site 
				  INNER JOIN
				  z_brand_banner 
				  ON z_brand_banner.id = z_banner_site.bannerid 
				  INNER JOIN
				  z_brand 
				  ON z_brand_banner.brandid = z_brand.id 
				WHERE z_banner_site.siteid = '.tools::int($_SESSION['Site']['id']).') 
				UNION
				(SELECT 
				  IF(z_event_site.eventid, 2, 0) AS requesttype,
				  IF(NOW()>z_brand_event.date_start,1,0) AS passed,
				  "InDoor" AS requesttypename,
				  z_event_site.eventid AS requestid,
				  z_event_site.confirm,
				  z_event_site.status,
				  z_brand_event.date_create,
				  z_brand_event.date_start,
				  z_brand_event.brandid,
				  z_event_site.new,
				  z_brand.NAME AS brandname,
				  if(CHAR_LENGTH(z_event_site.report)>0 || CHAR_LENGTH(z_event_site.file_name)>0,1,0) AS hasreport
				FROM
				  z_event_site 
				  INNER JOIN
				  z_brand_event 
				  ON z_brand_event.id = z_event_site.eventid 
				  INNER JOIN
				  z_brand 
				  ON z_brand_event.brandid = z_brand.id 
				WHERE z_event_site.siteid = '.tools::int($_SESSION['Site']['id']).') 
				UNION
				(SELECT 
				  IF(z_public_site.publicid, 3, 0) AS requesttype,
				  IF(NOW()>z_brand_public.date_start,1,0) AS passed,
				  "Паблик" AS requesttypename,
				  z_public_site.publicid AS requestid,
				  z_public_site.confirm,
				  z_public_site.status,
				  z_brand_public.date_create,
				  z_brand_public.date_start,
				  z_brand_public.brandid,
				  z_public_site.new,
				  z_brand.NAME AS brandname,
				  z_public_report.`id` AS hasreport
				FROM
				  z_public_site 
				  INNER JOIN
				  z_brand_public 
				  ON z_brand_public.id = z_public_site.publicid 
				  INNER JOIN
				  z_brand 
				  ON z_brand_public.brandid = z_brand.id
				  LEFT JOIN z_public_report
				  ON z_public_report.`publicrequestid` = z_public_site.id 
				WHERE z_public_site.siteid = '.tools::int($_SESSION['Site']['id']).'
				GROUP BY z_public_site.`id`) 
				UNION
				(SELECT 
				  IF(z_recard_site.recardid, 4, 0) AS requesttype,
				  IF(NOW()>z_brand_recard.date_start,1,0) AS passed,
				  "Recard" AS requesttypename,
				  z_recard_site.recardid AS requestid,
				  z_recard_site.confirm,
				  z_recard_site.status,
				  z_brand_recard.date_create,
				  z_brand_recard.date_start,
				  z_brand_recard.brandid,
				  z_recard_site.new,
				  z_brand.NAME AS brandname,
				  NULL AS hasreport
				FROM
				  z_recard_site 
				  INNER JOIN
				  z_brand_recard 
				  ON z_brand_recard.id = z_recard_site.recardid 
				  INNER JOIN
				  z_brand 
				  ON z_brand_recard.brandid = z_brand.id 
				WHERE z_recard_site.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_recard_site.status>1) 
				ORDER BY date_create DESC 
				');
				
				
	if($result)
	return $result;
}
public function acceptRequest($id,$requesttype,$action){
	$db=db::init();
	$confirmacts=array(1=>3,2=>4);
	switch ($requesttype) {
        case 1:
            $db->exec('
            UPDATE z_banner_site
            SET 
			status='.$confirmacts[$action].',
			date_update=NOW()
            WHERE siteid='.tools::int($_SESSION['Site']['id']).'
            AND bannerid='.tools::int($id).'
            ');           
			if(tools::int($action)==1)
            echo json_encode(array('url'=>'/admin/teasers/','status'=>'Вы добавили новый баннер от спонсора на ваш сайт. Перейти на список баннеров вашего сайта?'));
            break;
        case 2:
            $db->exec('
            UPDATE z_event_site
            SET 
			status='.$confirmacts[$action].'
            WHERE siteid='.tools::int($_SESSION['Site']['id']).'
            AND eventid='.tools::int($id).'
            ');
            break;
        case 3:
            $db->exec('
            UPDATE z_public_site
            SET 
			status='.$confirmacts[$action].'
            WHERE siteid='.tools::int($_SESSION['Site']['id']).'
            AND publicid='.tools::int($id).'
            ');
            if(tools::int($action)==1)
            echo json_encode(array('url'=>'/','status'=>'Вы добавили новый паблик. Разместите материалы на страницах ваших соцсетей и отправьте отчеты бренду. Возможность добавить отчет появится по прошествию даты публикации. Перейти на главную страницу?'));
            break;
        case 4:
			
			$db->exec('
			UPDATE z_recard_site
			SET	status='.$confirmacts[$action].'
			WHERE siteid='.tools::int($_SESSION['Site']['id']).'
			AND recardid='.tools::int($id).'
			');
			/*
			$result=$db->queryFetchRowAssoc('
			SELECT name,detail_text,if(z_brand_recard.file_name,concat("/uploads/brands/",z_brand_recard.brandid,"/",z_brand_recard.file_name),NULL) AS url,file_name,date_start FROM z_brand_recard WHERE id='.tools::int($id).'');
			if(copy($_SERVER['DOCUMENT_ROOT'].$result['url'],$_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.tools::int($_SESSION['Site']['id']).'/files/'.$result['file_name']))
			{
			$filecol=',file_name';
			$fileval=', "'.$result['file_name'].'"';
			}
			$db->exec('
			INSERT INTO z_card (name,detail_text,date_start,siteid,recardid'.$filecol.') VALUES ("'.tools::str($result['name']).'", "'.tools::str($result['detail_text']).'","'.tools::str($result['date_start']).'",'.tools::int($_SESSION['Site']['id']).','.tools::int($id).''.$fileval.')');
			if(tools::int($action)==1 && $db->lastInsertId()>0)*/
            //echo json_encode(array('url'=>'/admin/recard/','status'=>'Вы добавили новый рекард от спонсора на ваш сайт. Перейти на список рекардов вашего сайта?'));
            break;
    }

}
    public function getBannerRequest($id){
        $db=db::init();
        $result=$db->queryFetchRowAssoc('
		SELECT
		  z_brand_banner.id,
		  z_brand_banner.date_start,
		  z_brand_banner.date_end,
		  z_brand_banner.filtertype,
		  z_brand_banner.file_name,
		  z_brand_banner.link,
		  z_brand.name AS brand,
		  CONCAT("/uploads/brands/",z_brand_banner.brandid,"/14_",z_brand_banner.file_name) AS url
		FROM
		  z_brand_banner
		  INNER JOIN z_brand
		  ON z_brand.id=z_brand_banner.brandid
		WHERE z_brand_banner.id='.tools::int($id).'
		LIMIT 0,1
		');
        if($result)
            return $result;
    }
public function getEventRequest($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_brand_event.id,
		  z_brand_event.name,
		  z_brand_event.detail_text,
		  z_brand_event.date_start,
		  z_brand_event.filtertype,
		  z_brand_event.file_name,
		  z_brand.name AS brand,
		  CONCAT("/uploads/brands/",z_brand_event.brandid,"/",z_brand_event.file_name) AS fileurl
		FROM
		  z_brand_event
		  INNER JOIN z_brand
		  ON z_brand.id=z_brand_event.brandid
		WHERE z_brand_event.id='.tools::int($id).'
		LIMIT 0,1
		');
		if($result)
		return $result;
	}
public function getPublicRequest($id){
        $db=db::init();
        $result=$db->queryFetchRowAssoc('
		SELECT
		  z_brand_public.id,
		  z_brand_public.detail_text,
		  z_brand_public.date_start,
		  z_brand_public.filtertype,
		  z_brand_public.file_name,
		  z_brand.name AS brand,
		  CONCAT("/uploads/brands/",z_brand_public.brandid,"/",z_brand_public.file_name) AS fileurl
		FROM
		  z_brand_public
		  INNER JOIN z_brand
		  ON z_brand.id=z_brand_public.brandid
		WHERE z_brand_public.id='.tools::int($id).'
		LIMIT 0,1
		');
        if($result)
        return $result;
    }
public function getRecardRequest($id){
		$db=db::init();
        $result=$db->queryFetchRowAssoc('
		SELECT
		  z_brand_recard.id,
		  z_card.name,
		  z_card.detail_text,
		  z_card.date_start,
		  z_card.date_end,
		  z_brand_recard.filtertype,
		  z_card.file_name,
		  z_brand.name AS brand,
		  CONCAT("/uploads/sites/",z_card.siteid,"/files/",z_card.file_name) AS fileurl
		FROM
		  z_brand_recard
		  INNER JOIN z_brand
		  ON z_brand.id=z_brand_recard.brandid
		  INNER JOIN z_recard_site
		  ON z_recard_site.recardid=z_brand_recard.id AND z_recard_site.siteid='.tools::int($_SESSION['Site']['id']).'
		  INNER JOIN z_card
		  ON z_recard_site.id=z_card.requestid
		WHERE z_brand_recard.id='.tools::int($id).'
		LIMIT 0,1
		');
        if($result)
        return $result;
}
public function getEventSiteRequest($id){
        $db=db::init();
        $result=$db->queryFetchRowAssoc('
		SELECT
		  z_event_site.report,
		  CONCAT("/uploads/sites/",z_event_site.siteid,"/files/",z_event_site.file_name) AS file_name,
		  z_event_site.file_oldname,
		  z_event_site.id
		FROM
		  z_event_site
        WHERE z_event_site.eventid='.tools::int($id).' AND  z_event_site.siteid='.tools::int($_SESSION['Site']['id']).'
		LIMIT 0,1
		');
        if($result)
        return $result;
}
public function getReportSiteRequest($id){
        $db=db::init();
        $result=$db->queryFetchAllAssoc('
		SELECT
		  z_public_report.id,
		  z_public_site.id AS requestid,
          z_public_site.publicid,
          z_site_social.socialid,
          z_site_social.url,
          z_statstype_social.statstypeid,
          z_public_report.link,
          CONCAT(
            "/uploads/",
            z_file.subdir,
            "/",
            z_file.file_name
          ) AS image
        FROM
          z_public_site
          LEFT JOIN
          z_site_social
          ON z_site_social.siteid = z_public_site.siteid
          INNER JOIN
          z_statstype_social
          ON z_statstype_social.socialid = z_site_social.socialid
          LEFT JOIN
          z_public_report
          ON z_public_report.publicrequestid = z_public_site.id
          AND z_public_report.socialid = z_site_social.socialid
          INNER JOIN
          z_social
          ON z_social.id = z_site_social.socialid
          LEFT JOIN
          z_file
          ON z_social.preview_image = z_file.id
        WHERE z_public_site.siteid = '.tools::int($_SESSION['Site']['id']).'
          AND z_public_site.publicid = '.tools::int($id).'
          AND z_public_site.status = 3
		');

        if($result)
        return $result;
    }
    public function sendEventReport($data,$file){
			
		if($data['deletefile']){
			tools::delImg($data['deletefile']);
			$updatefile=', file_name=NULL';
			$updatefilename=', file_oldname=NULL';
		}	
			
        	
		if (!empty($file['file'])) {
			$tempFile = $file['file']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/sites/'.$_SESSION['Site']['id'].'/files/';
			$path_parts=pathinfo($file['file']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$newfilenameS=$newfilename;
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
				if(move_uploaded_file($tempFile,$targetFile)){
					echo $targetFile;
				$updatefile=', file_name="'.$newfilename.'"';
				$updatefilename=', file_oldname="'.$file['file']['name'].'"';
		        }
				//echo json_encode($data);
		}
			
			
        if(strlen(trim($data['report']))>0)
            $data['report']=' report="'.tools::str($data['report']).'"';
        else
            $data['report']=' report=NULL';
        $db=db::init();
		
        $db->exec('UPDATE z_event_site SET '.$data['report'].',date_update=NOW()'.$updatefile.$updatefilename.' WHERE id='.tools::int($data['id']).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
    }
    public function sendPublicReport($data){
        	$db=db::init();
        foreach($data['id'] as $k=>$reportid){
        	if($data['requestid'][$k]>0)
			$requestid=$data['requestid'][$k];
            if($reportid>0){
              if(strlen(trim($data['link'][$k]))>0)
                  $db->exec('UPDATE z_public_report SET link="'.$data['link'][$k].'" WHERE id='.tools::int($reportid).' AND siteid='.tools::int($_SESSION['Site']['id']).' AND publicrequestid='.tools::int($data['requestid'][$k]).'');
              else
                  $db->exec('DELETE FROM z_public_report WHERE id='.tools::int($reportid).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
            }else{
                  $db->exec('INSERT INTO z_public_report (socialid, siteid, userid, link, publicrequestid) VALUES
                  ('.tools::int($data['socialid'][$k]).', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', "'.tools::str($data['link'][$k]).'", '.tools::int($data['requestid'][$k]).')
                  ');
			}
        }
			if($reportid>0)
			$db->exec('
            UPDATE z_public_site
            SET 
			date_update=NOW()
            WHERE siteid='.tools::int($_SESSION['Site']['id']).'
            AND id='.tools::int($requestid).'
            ');
        /*if(strlen(trim($data['link']))>0)
            $data['link']=' link="'.tools::str($data['link']).'"';
        else
            $data['link']=' link=NULL';
        $db=db::init();
        $db->exec('UPDATE z_event_site SET '.$data['link'].' WHERE id='.tools::int($data['id']).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
        echo ('UPDATE z_event_site SET link="'.tools::str($data['link']).'" WHERE id='.tools::int($data['id']).' AND siteid='.tools::int($_SESSION['Site']['id']).'');*/
    }

public function markRead($requesttype,$requestid){
    $db=db::init();
    switch ($requesttype) {
        case 1:
            $db->exec('UPDATE z_banner_site SET new=2 WHERE bannerid='.tools::int($requestid).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
            break;
        case 2:
            $db->exec('UPDATE z_event_site SET new=2 WHERE eventid='.tools::int($requestid).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
            break;
        case 3:
            $db->exec('UPDATE z_public_site SET new=2 WHERE publicid='.tools::int($requestid).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
            break;
        case 4:
			$db->exec('UPDATE z_recard_site SET new=2 WHERE recardid='.tools::int($requestid).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
			echo ('UPDATE z_recard_site SET new=2 WHERE recardid='.tools::int($requestid).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
            break;
    }
}
public function unreadRequestNum(){
	$db=db::init();
		$result=$db->queryFetchAllAssoc('
        (SELECT
          "Баннер" AS requesttypename,
          z_banner_site.bannerid AS requestid,
          z_banner_site.confirm,
          z_banner_site.STATUS
        FROM
          z_banner_site
        WHERE z_banner_site.siteid = '.tools::int($_SESSION['Site']['id']).'
          AND z_banner_site.new = 1)
        UNION
        (SELECT
          "Ивент" AS requesttypename,
          z_event_site.eventid AS requestid,
          z_event_site.confirm,
          z_event_site.STATUS
        FROM
          z_event_site
        WHERE z_event_site.siteid = '.tools::int($_SESSION['Site']['id']).'
          AND z_event_site.new = 1)
        UNION
        (SELECT
          "Паблик" AS requesttypename,
          z_public_site.publicid AS requestid,
          z_public_site.confirm,
          z_public_site.STATUS
        FROM
          z_public_site
        WHERE z_public_site.siteid = '.tools::int($_SESSION['Site']['id']).'
          AND z_public_site.new = 1)
        UNION
        (SELECT
          "Recard" AS requesttypename,
          z_recard_site.recardid AS requestid,
          z_recard_site.confirm,
          z_recard_site.STATUS
        FROM
          z_recard_site
        WHERE z_recard_site.siteid = '.tools::int($_SESSION['Site']['id']).'
          AND z_recard_site.new = 1 AND z_recard_site.status>1)
        ');
		
		$result2=$db->queryFetchAllFirst('SELECT COUNT(z_card.id) FROM z_card
		WHERE `new`=1 AND siteid='.tools::int($_SESSION['Site']['id']).'');
		
    return json_encode(array('notice'=>count($result),'recard'=>$result2[0]));
}
public function bannerDisplay($id){
	$db=db::init();
	$db->exec('INSERT INTO z_banner_display (bannersiteid,siteid) VALUES('.tools::int($id).','.tools::int($_SESSION['Site']['id']).')');
}
public function bannerClick($id){
	$db=db::init();
	$db->exec('INSERT INTO z_banner_click (bannersiteid,siteid) VALUES('.tools::int($id).','.tools::int($_SESSION['Site']['id']).')');
}
}
?>