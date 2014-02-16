<?
require_once 'modules/base/models/Basemodel.php';

Class News Extends Basemodel {
	
	private $no_cache;
	
	public function __construct(){
		if(MAIN_DEBUG==true)
		$this->no_cache='SQL_NO_CACHE';
	}
	
	public function getNewsLine($start=0,$end=10){
		if($this->Session->User['id'])
		return;
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT '.$this->no_cache.'
		  z_news.itemid,
		  z_news.name 
		FROM
		  z_news 
		WHERE z_news.active = 1 AND z_news.recommend = 1
		GROUP BY z_news.itemid 
		ORDER BY z_news.date_start DESC
		LIMIT '.$start.','.$end.'');
		if($result)
		return $result;
	}
	
	public function getNewsCount($newstype, $tag=null){
				if($newstype==1){
					$whereSql=' AND z_news.recommend=1';
				}
				if($tag){
					$tagJoin='INNER JOIN z_tags_owner
					ON z_tags_owner.ownerid=z_news.id AND z_tags_owner.tagid='.tools::int($tag).'';
				}
		$db=db::init();
		$result=$db->queryFetchColAssoc('
		SELECT '.$this->no_cache.'
		  COUNT(z_news.id) AS cnt
		FROM
		  z_news 
		'.$tagJoin.'
		  WHERE z_news.active = 1'.$whereSql.'
		  ');
		return $result;
	}
	
	public function getLatestNews($start=0,$end=10, $newstype, $tag=null){
		$db=db::init();
				if($newstype==1){
					$whereSql=' AND z_news.recommend=1';
				}
				if($tag){
					$tagSelect='z_tags.name AS tagname, ';
					$tagJoin='INNER JOIN z_tags_owner
					ON z_tags_owner.ownerid=z_news.id AND z_tags_owner.tagid='.tools::int($tag).'
					INNER JOIN z_tags
					ON z_tags_owner.tagid=z_tags.id';
				}
				
				if(tools::int($_SESSION['User']['id'])>0){
					$visitJoin='LEFT JOIN
								z_commentvisit 
								ON z_commentvisit.itemid = z_news.itemid 
								AND z_commentvisit.userid = '.tools::int($_SESSION['User']['id']).'';
					$visitSelect=' z_commentvisit.date_visit,';
				}
		
		$result=$db->queryFetchAllAssoc('
					SELECT '.$this->no_cache.'
					  z_news.id,
					  z_news.itemid,
					  z_news.name,
					  z_news.preview_text,
					  z_news.detail_text,
					  z_news.date_start,
					  z_news.userid,
					  z_news.siteid,
					  z_user.login,
					  z_site2.name AS sitename,
					  IF(
					    z_user.siteid > 0,
					    z_site.NAME,
					    IFNULL(z_user.displayname,z_user.login)
					  ) AS `displayname`,
					  '.$visitSelect.'
					  '.$tagSelect.'
					  CONCAT(
					    "/uploads/sites/",
					    z_image.siteid,
					    "/img/1_",
					    z_image.file_name
					  ) AS url,
					  CONCAT(
					    "/uploads/sites/",
					    z_image.siteid,
					    "/img/6_",
					    z_image.file_name
					  ) AS url2,
					  z_domain.name AS domain
					FROM
					  z_news 
					  INNER JOIN
					  z_user 
					  ON z_user.id = z_news.userid 
					  LEFT JOIN
					  z_image 
					  ON z_image.itemid = z_news.itemid 
					  LEFT JOIN
					  z_site 
					  ON z_site.id = z_user.siteid
					  LEFT JOIN
					  z_site z_site2
					  ON z_site2.id = z_news.siteid
					  LEFT JOIN
					  z_domain
					  ON z_domain.siteid = z_news.siteid
					  '.$visitJoin.'
					  '.$tagJoin.'
					WHERE z_news.active = 1'.$whereSql.'
					GROUP BY z_news.itemid 
					ORDER BY z_news.date_start DESC
					LIMIT '.$start.','.$end.'
					');
		if(is_array($result))
		{
			foreach($result as $row)
			if($row['itemid']>0)
			$itemidArr[$row['itemid']]=$row['itemid'];
			
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
		}
		return array('news'=>$result, 'comments'=>$comments, 'rate'=>$rates);
	}
	public function getSingleNews($itemid){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT '.$this->no_cache.'
					  z_news.id,
					  z_news.itemid,
					  z_news.name,
					  z_news.preview_text,
					  z_news.detail_text,
					  z_news.date_start,
					  z_news.video,
					  z_news.userid,
					  z_news.siteid,
					  z_news.incut,
					  z_site2.name AS sitename,
					  z_user.login,
					  IF(
					    z_user.siteid > 0,
					    z_site.NAME,
					    IFNULL(z_user.displayname,z_user.login)
					  ) AS `displayname`,
					  z_image.id AS imageid,
					  CONCAT(
					    "/uploads/sites/",
					    z_image.siteid,
					    "/img/7_",
					    z_image.file_name
					  ) AS url,
					  CONCAT(
					    "/uploads/sites/",
					    z_image.siteid,
					    "/img/4_",
					    z_image.file_name
					  ) AS socurl,
					  z_tags_owner.tagid,
					  z_rate.rate,
					  z_domain.name AS domain
					FROM
					  z_news 
					  LEFT JOIN z_rate
					  ON z_rate.itemid=z_news.itemid AND z_rate.userid='.tools::int($_SESSION['User']['id']).'
					  INNER JOIN
					  z_user 
					  ON z_user.id = z_news.userid 
					  LEFT JOIN
					  z_site 
					  ON z_site.id = z_user.siteid
					  LEFT JOIN
					  z_site z_site2
					  ON z_site2.id = z_news.siteid
					  LEFT JOIN
					  z_domain
					  ON z_domain.siteid = z_news.siteid
					  LEFT JOIN
					  z_image 
					  ON z_image.itemid = z_news.itemid
					  LEFT JOIN z_tags_owner
					  ON z_tags_owner.ownerid=z_news.id
					  
					WHERE z_news.active = 1 
					  AND z_news.itemid = '.tools::int($itemid).'
					');
		if($result)
		foreach($result as $row){
			$news=$row;
			if($row['imageid']>0)
			$pictureArr[$row['imageid']]=$row['url'];
			if($row['tagid']>0)
			$tagArr[$row['tagid']]=$row['tagid'];
		}
		if(is_array($tagArr))
		$tagresult=$db->queryFetchAllAssoc('
					SELECT '.$this->no_cache.'
					  COUNT(z_tags_owner.tagid) AS cnt,
					  z_tags.id,
					  z_tags.name 
					FROM
					  z_tags_owner 
					  INNER JOIN
					  z_tags 
					  ON z_tags.id = z_tags_owner.tagid 
					WHERE z_tags_owner.tagid IN ('.implode(',',$tagArr).')
					GROUP BY z_tags_owner.tagid
					');
		
		$tracks=$db->queryFetchAllAssoc('
					SELECT '.$this->no_cache.'
					  z_release.id,
					  z_release.name,
					  z_release.remix,
					  z_release.author,
					  z_release.promocut,
					  z_release.download,
					  z_musictype.id AS musictupeid,
					  z_musictype.NAME AS musictupename,
					  z_releasetype.label,
					  z_releasetype.date_start,
					  IF(DATE_ADD(z_releasetype.date_start, INTERVAL 1 MONTH)>NOW(),1,0) AS fresh,
					  CONCAT(
					    "/uploads/sites/",
					    z_release.siteid,
					    "/mp3/",
					    z_mp3.file_name
					  ) AS mp3,
					  CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/3_",
					    z_cover.url
					  ) AS cover 
					FROM
					  z_item_track 
					  INNER JOIN
					  z_release 
					  ON z_item_track.trackid = z_release.id 
					  INNER JOIN
					  z_releasetype 
					  ON z_releasetype.id = z_release.releasetypeid 
					  LEFT JOIN
					  z_cover 
					  ON z_cover.id = z_releasetype.coverid 
					  LEFT JOIN
					  z_musictypelink 
					  ON z_musictypelink.linkid = z_release.id 
					  AND z_musictypelink.datatypeid = 6 
					  LEFT JOIN
					  z_musictype 
					  ON z_musictype.id = z_musictypelink.musictypeid 
					  INNER JOIN
					  z_mp3 
					  ON z_mp3.id = z_release.fileid 
					WHERE z_item_track.itemid = '.tools::int($itemid).'
					  AND z_release.active = 1');
		
		if($news){
			$rateresult=$db->queryFetchRowAssoc('
				SELECT '.$this->no_cache.'
				  SUM(z_rate.rate) AS rate
				FROM
				  z_rate 
				WHERE z_rate.itemid='.tools::int($news['itemid']).'');
			$news['totalrate']=$rateresult['rate'];
		}
		
		foreach($tracks as $res){
				$ret['musictypes']=$our[$res['id']]['musictypes'];
				$out[$res['id']]=$res;
				$out[$res['id']]['musictypes'][$res['musictupeid']]=$res['musictupename'];
				
			}
		return array('news'=>$news, 'images'=>$pictureArr, 'tags'=>$tagresult, 'tracks'=>$out);
	}
	public function getPopularNews($itemid){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT '.$this->no_cache.'
					  z_news.id,
					  z_news.itemid,
					  z_news.name,
					  z_news.preview_text,
					  z_news.detail_text,
					  z_news.date_start,
					  z_news.userid,
					  z_user.login,
					  IF(z_user.displayname, z_user.login, z_user.displayname) AS displayname
					FROM
					  z_news 
					  INNER JOIN
					  z_user 
					  ON z_user.id = z_news.userid 
					WHERE z_news.active = 1 
					  AND z_news.itemid != '.tools::int($itemid).'
					  LIMIT 0,3
					');
		if($result)
		return $result;
	}
	public function getCommentNewsType($itemid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT '.$this->no_cache.' DISTINCT 
					  (z_news.id) AS id,
					  z_news.name,
					  z_news.itemid,
					  z_news.siteid,
					  z_news.date_start,
					  z_news.userid,
					  z_news.incut,
					  z_rate.rate
					FROM
					  z_news
					  LEFT JOIN z_rate
					  ON z_rate.itemid=z_news.itemid AND z_rate.userid='.tools::int($_SESSION['User']['id']).'
					WHERE z_news.active = 1 
					  AND z_news.itemid = '.tools::int($itemid).'
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
}
?>