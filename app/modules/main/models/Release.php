<?
require_once 'modules/base/models/Basemodel.php';

Class Release Extends Basemodel {
	
	private $no_cache;
	
	public function __construct(){
		if(MAIN_DEBUG==true)
		$this->no_cache='SQL_NO_CACHE';
	}
	
	public function getReleaseCount($type){
		if($type==1){
			$whereSql=' AND z_releasetype.recommend=1';
		}
		$db=db::init();
		$result=$db->queryFetchColAssoc('
		SELECT '.$this->no_cache.'
		  COUNT(DISTINCT z_releasetype.id) AS cnt 
		FROM
		  z_releasetype
		  INNER JOIN z_site
		  ON z_site.id=z_releasetype.siteid
		  INNER JOIN
		  z_release 
		  ON z_release.releasetypeid = z_releasetype.id
		WHERE z_site.sitetypeid=3
		  AND z_releasetype.active = 1 
		  AND z_release.active = 1
		  '.$whereSql.'
		  ');
		return $result;
	}
	
	public function getLatestRelease($start=0,$end=10,$type=null){
		$db=db::init();
		
		if($type==1){
			$whereSql=' AND z_releasetype.recommend=1';
		}
		if(tools::int($_SESSION['User']['id'])>0){
					$visitJoin='LEFT JOIN
								z_commentvisit 
								ON z_commentvisit.itemid = z_releasetype.itemid 
								AND z_commentvisit.userid = '.tools::int($_SESSION['User']['id']).'';
					$visitSelect=' z_commentvisit.date_visit,';
				}
		
		$typeresult=$db->queryFetchAllAssoc('
					SELECT '.$this->no_cache.' DISTINCT 
					  (z_releasetype.id) AS id,
					  z_releasetype.name,
					  z_releasetype.author,
					  z_releasetype.date_start,
					  z_releasetype.label,
					  z_releasetype.itemid,
					  '.$visitSelect.'
					  IF(DATE_ADD(z_releasetype.date_start, INTERVAL 1 MONTH)>NOW(),1,0) AS fresh,
					  if(z_cover.id>0,CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/4_",
					    z_cover.url
					  ),
					  CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/4_",
					    z_cover_default.url
					  )) AS `url`,
					  if(z_cover.id>0,CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/5_",
					    z_cover.url
					  ),
					  CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/5_",
					    z_cover_default.url
					  )) AS `url2`
					FROM
					  z_releasetype
					  INNER JOIN z_site
					  ON z_site.id=z_releasetype.siteid
					  INNER JOIN
					  z_release 
					  ON z_release.releasetypeid = z_releasetype.id 
					  LEFT JOIN
					  z_cover 
					  ON z_cover.id = z_releasetype.coverid
					  LEFT JOIN
				  	  z_cover z_cover_default
				      ON z_cover_default.siteid = z_releasetype.siteid AND z_cover_default.major=1
					  '.$visitJoin.'
					WHERE 
					  z_site.sitetypeid=3
					  AND z_releasetype.active = 1 
					  AND z_release.active = 1
					  '.$whereSql.'
					ORDER BY z_releasetype.date_start DESC
					LIMIT '.$start.','.$end.'
					');
		if(count($typeresult)>0){
			foreach($typeresult as $rel)
				$itemidArr[$rel['itemid']]=$rel['itemid'];
			
			
				$relresult=$db->queryFetchAllAssoc('
				SELECT '.$this->no_cache.' DISTINCT
				  (z_release.id) AS id,
				  z_releasetype.itemid,
				  z_release.name,
				  z_release.remix,
				  z_musictype.id AS musictypeid,
				  z_musictype.NAME AS musictype
				FROM
				  z_release 
				  INNER JOIN
				  z_releasetype 
				  ON z_releasetype.id = z_release.releasetypeid 
				  LEFT JOIN
				  z_musictypelink 
				  ON z_musictypelink.linkid = z_release.id 
				  AND z_musictypelink.datatypeid = 6 
				  LEFT JOIN
				  z_musictype 
				  ON z_musictype.id = z_musictypelink.musictypeid 
				WHERE z_releasetype.itemid IN ('.implode(',',$itemidArr).') 
				ORDER BY z_release.releasetypeid 
				');
			
			foreach($relresult as $r){
				$releasedata[$r['itemid']]['data'][$r['id']]=$r['id'];
				
				if(strlen($r['remix'])>0){
					if($r['remix']!=='Original mix'){
					$releasedata[$r['itemid']]['remixes'][md5($r['remix'])]['sort']++;
					$releasedata[$r['itemid']]['remixes'][md5($r['remix'])]['name']=$r['remix'];
					}
				}
				
				if(strlen($r['musictype'])>0){
					$releasedata[$r['itemid']]['musictype'][$r['musictypeid']]['sort']++;
					$releasedata[$r['itemid']]['musictype'][$r['musictypeid']]['name']=$r['musictype'];
				}
			}
			
			
			if(is_array($itemidArr)){
				
				if(tools::int($_SESSION['User']['id'])>0){
					$visitJoin2='LEFT JOIN
								z_commentvisit 
								ON z_commentvisit.itemid = z_comments.itemid 
								AND z_commentvisit.userid = '.tools::int($_SESSION['User']['id']).' 
								AND z_commentvisit.date_visit < z_comments.date_create';
					$visitSelect2=' COUNT(z_commentvisit.id) AS comvisnum,';
				}
				
				$comresult=$db->queryFetchAllAssoc('
				SELECT '.$this->no_cache.'
				  COUNT(DISTINCT z_comments.id) AS comnum,
				  '.$visitSelect2.'
				  _items.id AS itemid 
				FROM
				  _items 
				  LEFT JOIN
				  z_comments 
				  ON z_comments.itemid = _items.id 
				  '.$visitJoin2.'
				WHERE _items.id IN ('.implode(',',$itemidArr).')
				GROUP BY _items.id ');
				foreach($comresult as $comment)
				$comments[$comment['itemid']]=$comment;
				
				
				$rateresult=$db->queryFetchAllAssoc('
				SELECT '.$this->no_cache.'
				  SUM(z_rate.rate) AS rate,
				  z_rate.itemid 
				FROM
				  z_rate 
				WHERE z_rate.itemid IN ('.implode(',',$itemidArr).')
				GROUP BY z_rate.itemid');
				
				foreach($rateresult as $rate)
				$rates[$rate['itemid']]=$rate['rate'];
		 }
				
			//tools::print_r($comments);
				
			
			/*if(is_array($relTypeId)){
			if(tools::int($_SESSION['User']['id'])>0){
				$visitJoin='LEFT JOIN
							z_commentvisit 
							ON z_commentvisit.itemid = z_releasetype.itemid 
							AND z_commentvisit.userid = '.tools::int($_SESSION['User']['id']).'';
				$visitSelect='IF(
							    z_comments.date_create > z_commentvisit.date_visit,
							    1,
							    NULL
							  ) AS newcom,
							  z_commentvisit.date_visit,';
			}
			$relresult=$db->queryFetchAllAssoc('
			SELECT DISTINCT DISTINCT 
			  (z_release.id) AS id,
			  z_release.releasetypeid,
			  z_release.NAME,
			  z_release.remix,
			  z_musictype.id AS musictypeid,
			  z_musictype.NAME AS musictype,
			  '.$visitSelect.'
			  z_comments.id AS commentid
			FROM
			  z_release 
			  INNER JOIN
			  z_releasetype 
			  ON z_releasetype.id = z_release.releasetypeid 
			  LEFT JOIN
			  z_musictypelink 
			  ON z_musictypelink.linkid = z_release.id 
			  AND z_musictypelink.datatypeid = 6 
			  LEFT JOIN
			  z_musictype 
			  ON z_musictype.id = z_musictypelink.musictypeid 
			  LEFT JOIN
			  z_comments 
			  ON z_comments.itemid = z_releasetype.itemid
			  '.$visitJoin.' 
			WHERE z_release.releasetypeid IN ('.implode(',',$relTypeId).') 
			ORDER BY z_release.releasetypeid 
			');
			
			foreach($relresult as $r){
				$release[$r['releasetypeid']]['data'][$r['id']]=$r;
				
				if(strlen($r['remix'])>0){
					if($r['remix']!=='Original mix'){
					$release[$r['releasetypeid']]['remixes'][md5($r['remix'])]['sort']++;
					$release[$r['releasetypeid']]['remixes'][md5($r['remix'])]['name']=$r['remix'];
					}
				}
				
				if(strlen($r['musictype'])>0){
					$release[$r['releasetypeid']]['musictype'][$r['musictypeid']]['sort']++;
					$release[$r['releasetypeid']]['musictype'][$r['musictypeid']]['name']=$r['musictype'];
				}
				
				if(strlen($r['commentid'])>0){
					$release[$r['releasetypeid']]['comments'][$r['commentid']]=$r['commentid'];
				}
				if(strlen($r['newcom'])>0){
					$release[$r['releasetypeid']]['newcom'][$r['commentid']]=$r['commentid'];
				}
				if(!$r['newcom'] && !$r['date_visit'] && $r['commentid']>0){
					$release[$r['releasetypeid']]['newcom'][$r['commentid']]=$r['commentid'];
				}
			}
			
			
			
			foreach($typeresult as $type){
			
				$type['cnt']=count($release[$type['id']]['data']);
				$type['commentnum']=count($release[$type['id']]['comments']);
				if(count($release[$type['id']]['newcom'])>0)
				$type['newcomnum']=count($release[$type['id']]['newcom']);
				
				if(is_array($release[$type['id']]['musictype'])){
					usort($release[$type['id']]['musictype'], 'tools::sortDesc');
					$release[$type['id']]['musictype']=array_slice($release[$type['id']]['musictype'],0,2);
					foreach($release[$type['id']]['musictype'] as $mtype)
					$mtypeArr[$type['id']][]=$mtype['name'];
					$type['musictypestr']=implode(',',$mtypeArr[$type['id']]);
				}
				if(is_array($release[$type['id']]['remixes'])){
					usort($release[$type['id']]['remixes'], 'tools::sortDesc');
					$release[$type['id']]['remixes']=array_slice($release[$type['id']]['remixes'],0,2);
					foreach($release[$type['id']]['remixes'] as $mtype)
					$remixArr[$type['id']][]=$mtype['name'];
					$type['remixesstr']=implode(',',$remixArr[$type['id']]);
				}
				
				
				
				
				$out[]=$type;
			}
			
			
			}*/
		
		return array('releasetype'=>$typeresult, 'releasedata'=>$releasedata, 'comments'=>$comments, 'rate'=>$rates);
		}
	}
	public function getSingleRelease($itemid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT '.$this->no_cache.' DISTINCT 
					  (z_releasetype.id) AS id,
					  z_releasetype.name,
					  z_releasetype.author,
					  z_releasetype.label,
					  z_releasetype.itemid,
					  z_releasetype.siteid,
					  z_site2.name AS sitename,
					  z_releasetype.date_start,
					  IF(DATE_ADD(z_releasetype.date_start, INTERVAL 1 MONTH)>NOW(),1,0) AS fresh,
					  z_user.id AS userid,
					  z_user.login,
					  IF(
					    z_user.siteid > 0,
					    z_site.NAME,
					    IFNULL(z_user.displayname,z_user.login)
					  ) AS `displayname`,
					  if(z_cover.id>0,CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/4_",
					    z_cover.url
					  ),
					  CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/4_",
					    z_cover_default.url
					  )) AS `url`,
					  if(z_cover.id>0,CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/3_",
					    z_cover.url
					  ),
					  CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/3_",
					    z_cover_default.url
					  )) AS `url2`,
					  z_pressrelease.preview_text,
					  z_pressrelease.detail_text,
					  z_pressrelease.incut,
					  z_pressrelease.NAME pressrelease,
					  z_domain.name AS domain
					FROM
					  z_releasetype
					  LEFT JOIN
					  z_pressrelease 
					  ON z_pressrelease.itemid = z_releasetype.itemid  
					  LEFT JOIN
					  z_cover 
					  ON z_cover.id = z_releasetype.coverid
					  LEFT JOIN
				  	  z_cover z_cover_default
				      ON z_cover_default.siteid = z_releasetype.siteid AND z_cover_default.major=1
					  INNER JOIN
					  z_user 
					  ON z_user.id = z_releasetype.userid 
					  LEFT JOIN
					  z_site 
					  ON z_site.id = z_user.siteid
					  LEFT JOIN
					  z_site z_site2
					  ON z_site2.id = z_releasetype.siteid
					  LEFT JOIN z_domain
					  ON z_domain.siteid=z_releasetype.siteid AND z_domain.active=1
					WHERE z_releasetype.active = 1 
					  AND z_releasetype.id = '.tools::int($itemid).'
					  LIMIT 0,1
					');
		/*if($result){
			$rateresult=$db->queryFetchRowAssoc('
				SELECT '.$this->no_cache.'
				  SUM(z_rate.rate) AS rate
				FROM
				  z_rate 
				WHERE z_rate.itemid='.tools::int($result['itemid']).'');
			$result['totalrate']=$rateresult['rate'];
		}*/
		return $result;
	}
	
	public function getCommentReleaseType($itemid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT '.$this->no_cache.' DISTINCT 
					  (z_releasetype.id) AS id,
					  z_releasetype.name,
					  z_releasetype.author,
					  z_releasetype.label,
					  z_releasetype.itemid,
					  z_releasetype.siteid,
					  z_releasetype.date_start,
					  z_releasetype.userid,
					  z_pressrelease.incut,
					  z_pressrelease.name AS pressrelease,
					  z_rate.rate
					FROM
					  z_releasetype
					  LEFT JOIN z_rate
					  ON z_rate.itemid=z_releasetype.itemid AND z_rate.userid='.tools::int($_SESSION['User']['id']).'
					  LEFT JOIN z_pressrelease
					  ON z_pressrelease.itemid=z_releasetype.itemid
					WHERE z_releasetype.active = 1 
					  AND z_releasetype.itemid = '.tools::int($itemid).'
					  LIMIT 0,1
					');
		if($result){
			$rateresult=$db->queryFetchRowAssoc('
				SELECT '.$this->no_cache.'
				  SUM(z_rate.rate) AS rate
				FROM
				  z_rate 
				WHERE z_rate.itemid='.tools::int($result['itemid']).'');
			$result['totalrate']=$rateresult['rate'];
		}
		return $result;
	}
	
	public function getReleaseLinks($id){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT '.$this->no_cache.'
					  z_release_links.url,
					  z_social.url AS socialurl,
					  CONCAT("/uploads/",z_file.subdir,"/",z_file.file_name) as fileurl
					FROM
					  z_release_links 
					  LEFT JOIN
					  z_social 
					  ON z_social.id = z_release_links.socialid 
					  LEFT JOIN
					  z_file 
					  ON z_file.id = z_social.preview_image 
					WHERE z_release_links.releasetypeid = '.tools::int($id).'
					');
		if($result)
		return $result;
	}
	public function getReleaseTracks($id){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT '.$this->no_cache.'
					  z_release.id,
					  z_release.name,
					  z_release.remix,
					  z_release.author,
					  z_release.promocut,
					  z_release.download,
					  z_release.stream,
					  z_release.socialid,
					  z_musictype.id AS musictupeid,
					  z_musictype.name AS musictupename,
					  CONCAT(
					    "/uploads/sites/",
					    z_release.siteid,
					    "/mp3/",
					    z_mp3.file_name
					  ) AS mp3
					FROM
					  z_release 
					  LEFT JOIN
					  z_musictypelink 
					  ON z_musictypelink.linkid = z_release.id 
					  AND z_musictypelink.datatypeid = 6 
					  LEFT JOIN
					  z_musictype 
					  ON z_musictype.id = z_musictypelink.musictypeid 
					  LEFT JOIN
					  z_mp3 
					  ON z_mp3.id = z_release.fileid 
					WHERE z_release.releasetypeid = '.tools::int($id).' 
					  AND z_release.active = 1
					ORDER BY z_release.sort
					');
		if($result){
			foreach($result as $res){
				$res['musictypes']=$our[$res['id']]['musictypes'];
				$our[$res['id']]=$res;
				$our[$res['id']]['musictypes'][$res['musictupeid']]=$res['musictupename'];
				
			}
		return $our;
		}
	}
}
?>