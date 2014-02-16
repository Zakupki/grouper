<?
require_once 'modules/base/models/Basemodel.php';

Class Reccount Extends Basemodel {
	
	private $no_cache;
	
	public function __construct(){
		if(MAIN_DEBUG==true)
		$this->no_cache='SQL_NO_CACHE';
	}
	
	public function getTitle($siteid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_site.name
					FROM
					  z_site 
					WHERE z_site.id = '.tools::int($siteid).'
					AND z_site.userid = '.tools::int($_SESSION['User']['id']).'
					LIMIT 0,1
					');
		if($result['name'])
		return $result['name'];
	}
	
	public function startTransfer($receiverid,$siteid,$email){
		$db=db::init();
		$db->exec('DELETE FROM z_transfer WHERE siteid='.tools::int($siteid).'');
		
		$ownerdata=$db->queryFetchRowAssoc('
		SELECT 
		  z_user.id,
		  z_user.email 
		FROM
		  z_user 
		  INNER JOIN
		  z_site 
		  ON z_site.userid = z_user.id 
		WHERE z_site.id='.tools::int($siteid).'
		LIMIT 0,1
		');
		if($ownerdata['id']==$_SESSION['User']['id']){
		
			$activation=md5(microtime().$receiverid.$siteid.rand());
			$db->exec('
			DELETE FROM z_transfer
			WHERE siteid='.tools::int($siteid).' AND senderid='.tools::int($_SESSION['User']['id']).' AND confirmed=0
			');
			$res=$db->exec('
			INSERT INTO z_transfer
			(siteid,senderid,receiverid,activation) VALUES('.tools::int($siteid).', '.tools::int($_SESSION['User']['id']).', '.tools::int($receiverid).', "'.$activation.'")
			');
			//if($res>0){
				$subject = "Подтверждение передачи реккаунта";
$message = "Здравствуйте!\n
C Вашего аккаунта на сайте ".$_SERVER['HTTP_HOST']." был сделан запрос на передачу прав на реккаунт r".$siteid." пользователю c e-mail: ".$email."\n
Для подтверждения передачи аккаунта перейдите по ссылке:\n
http://".$_SERVER['HTTP_HOST']."/transfer/?act=".$activation."\n
Если вы не делали запрос на передачу реккаунта, то просто проигнорируйте это письмо.\n
После подтверждения передачи у Вас будет еще 24 часа для возврата реккаунта.\n
С уважением, Администрация сайта ".$_SERVER['HTTP_HOST']."";
				$smtp=new smtp;
				$smtp->Connect('ds139.mirohost.net');
				$smtp->Hello('ds139.mirohost.net');
				$smtp->Authenticate('reactor@reactor-pro.ru', '123qwe123');
				$smtp->Mail('reactor@reactor-pro.ru');
				$smtp->Recipient($ownerdata['email']);
				$smtp->Data($message, $subject);
			//}
		}
		//return $result;
	}
	public function activateTransfer($activation){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT siteid,senderid,receiverid
		FROM z_transfer
		WHERE activation="'.tools::str($activation).'"		
		');
		if($result['siteid']>0){
			$db->exec('
			UPDATE z_transfer
			SET confirmed=1
			WHERE activation="'.tools::str($activation).'" AND siteid='.tools::int($result['siteid']).'
			');
			$db->exec('
			UPDATE z_site
			SET userid='.$result['receiverid'].'
			WHERE id='.tools::int($result['siteid']).' AND userid='.$result['senderid'].'
			');
		return $result['siteid'];
		}
		
	}
	public function cancelTransfer($transferid, $siteid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
			SELECT id,
			   siteid,
			   senderid,
			   receiverid
			FROM z_transfer 
			WHERE siteid='.tools::int($siteid).' 
			AND senderid='.tools::int($_SESSION['User']['id']).' 
			AND id='.tools::int($transferid).' AND confirmed=1
			AND 1440-TIMESTAMPDIFF(MINUTE, date_create, NOW())>0');
		if($result['id']>0){
			$db->exec('
			DELETE FROM z_transfer
			WHERE id='.$result['id'].'
			');
			$db->exec('
			UPDATE z_site
			SET userid='.$result['senderid'].'
			WHERE id='.$result['siteid'].' AND userid='.$result['receiverid'].'
			');
			return $result['siteid'];
		}
	}
	public function siteDiscSpace($userid){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_site.id,
		  SUM(z_discorder.value) AS value 
		FROM
		  z_site 
		  INNER JOIN
		  z_discorder 
		  ON z_discorder.siteid = z_site.id 
		WHERE z_site.userid = '.tools::int($userid).' 
		GROUP BY z_site.id');
		foreach($result as $row)
		$out[$row['id']]=$row['value'];
		if($out)
		return $out;
	}
	public function getUserSites($userid){
		 	$db=db::init();
			
			if($userid>1)
			$whereSql=' WHERE z_site.userid = '.tools::int($userid).' ';
			
			$result=$db->queryFetchAllAssoc('
			(SELECT 
			  z_site.id AS `id`,
			  z_site.NAME AS title,
			  z_site.sitetypeid,
			  z_sitetype.parentid AS parentsitetypeid,
			  z_sitetype.NAME AS sitetypename,
			  MAX(z_timeorder.date_end) AS `date_end`,
			  PERIOD_DIFF(
			    DATE_FORMAT(MAX(z_timeorder.date_end), "%Y%m"),
			    DATE_FORMAT(NOW(), "%Y%m")
			  ) AS time_left,
			  NULL AS confirmed,
			  NULL AS receiverlogin,
			  NULL AS receiveremail,
			  NULL AS transferid,
			  z_site.free AS free
			FROM
			  z_site 
			  INNER JOIN
			  z_sitetype 
			  ON z_sitetype.id = z_site.sitetypeid 
			  INNER JOIN
			  z_timeorder 
			  ON z_timeorder.siteid = z_site.id 
			  AND z_timeorder.date_end > NOW() 
			'.$whereSql.'
			GROUP BY z_site.id) 
			UNION
			(SELECT 
			  z_transfer.siteid AS `id`,
			  z_site.NAME AS title,
			  z_site.sitetypeid,
			  z_sitetype.parentid AS parentsitetypeid,
			  z_sitetype.NAME AS sitetypename,
			  MAX(z_timeorder.date_end) AS `date_end`,
			  TIME_FORMAT(TIMEDIFF(
			    DATE_ADD(
			      z_transfer.date_create,
			      INTERVAL 1 DAY
			    ),
			    NOW()
			  ),"%H"),
			  z_transfer.confirmed,
			  z_user.login AS receiverlogin,
			  z_user.email AS receiveremail,
			  z_transfer.id AS transferid,
			  NULL AS free
			FROM
			  z_transfer 
			  INNER JOIN
			  z_user 
			  ON z_user.id = z_transfer.receiverid 
			  INNER JOIN
			  z_site 
			  ON z_site.id = z_transfer.siteid 
			  INNER JOIN
			  z_sitetype 
			  ON z_sitetype.id = z_site.sitetypeid 
			  LEFT JOIN
			  z_timeorder 
			  ON z_timeorder.siteid = z_site.id 
			  AND z_timeorder.date_end > NOW() 
			WHERE z_transfer.siteid>0 AND z_transfer.senderid = '.tools::int($userid).' 
			  AND z_transfer.confirmed = 1
			  AND TIME_FORMAT(
			    TIMEDIFF(
			      DATE_ADD(
			        z_transfer.date_create,
			        INTERVAL 1 DAY
			      ),
			      NOW()
			    ),
			    "%H"
			  ) > 0  
			GROUP BY z_site.id)
			ORDER BY id
			');
			if($result)
			return $result;
	}
	public function activateDiscount($code){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT id FROM z_discount WHERE code="'.tools::str($code).'"
		');
		if($result['id']>0){
		$db->exec('
		DELETE FROM z_user_discount WHERE userid='.tools::int($_SESSION['User']['id']).'');	
		$db->exec('
		INSERT INTO z_user_discount (userid,discountid) VALUES ('.tools::int($_SESSION['User']['id']).','.tools::int($result['id']).')
		');
		return true;
		}
	}
	public function getUserDiscount(){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_discount.value 
		FROM
		  z_user_discount 
		  INNER JOIN
		  z_discount 
		  ON z_discount.id = z_user_discount.discountid 
		WHERE z_user_discount.userid = '.tools::int($_SESSION['User']['id']).' 
		LIMIT 0,1
		');
		if($result)
		return $result['value'];
	}
	function fillpartyAction($useridto=null,$siteidto=null,$siteidfrom=null){
			if(tools::int($useridto)<1 || tools::int($siteidto)<1 || tools::int($siteidfrom)<1)
			return;
			
			$db=db::init();
			$result=$db->queryFetchAllAssoc('SELECT 
				z_event.name,
				z_event.date_start,
				z_event.detail_text,
				z_event.itemid,
				z_event.coverid,
				z_event.posterid,
				CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/",
				    z_cover.url
				  ) AS cover,
				CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/",
				    z_poster.url
				  ) AS poster
			FROM z_event
			LEFT JOIN z_cover
			ON z_cover.id=z_event.coverid
			LEFT JOIN z_poster
			ON z_poster.id=z_event.posterid
			WHERE z_event.siteid='.$siteidfrom.'');
			
			foreach($result as $event){
				$newcoverid='NULL';
				$newposterid='NULL';
				$path_parts=null;
				$path_parts2=null;
				if($event['coverid']>0){
					$path_parts=pathinfo($event['cover']);
					$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
					copy($_SERVER['DOCUMENT_ROOT'].$event['cover'], $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteidto.'/img/'.$newfilename);
					$db->exec('INSERT INTO z_cover (url, siteid, userid, active) VALUES ("'.$newfilename.'", '.$siteidto.', '.$useridto.',1)');
					$newcoverid=$db->lastInsertId();
				}
				if($event['posterid']>0){
					$path_parts2=pathinfo($event['poster']);
					$newfilename=md5(uniqid().microtime()).".".$path_parts2['extension'];
					copy($_SERVER['DOCUMENT_ROOT'].$event['poster'], $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteidto.'/img/'.$newfilename);
					$db->exec('INSERT INTO z_poster (url, siteid, userid, active) VALUES ("'.$newfilename.'", '.$siteidto.', '.$useridto.',1)');
					$newposterid=$db->lastInsertId();
				}
						
				
				$artistresult=$db->queryFetchAllAssoc('SELECT * from z_artist WHERE itemid='.$event['itemid'].'');
				$itemid=null;
				$db->exec('INSERT INTO _items (datatypeid, siteid, userid) VALUES (9, '.$siteidto.', '.$useridto.')');
				$itemid=$db->lastInsertId();
				$db->exec('INSERT INTO z_event (name, date_start, detail_text, active, userid, siteid, itemid, coverid, posterid) 
				VALUES 
				("'.$event['name'].'", "'.$event['date_start'].'", "'.$event['detail_text'].'", 1, '.$useridto.', '.$siteidto.', '.$itemid.', '.$newcoverid.', '.$newposterid.')');
				if(is_array($artistresult))
				foreach($artistresult as $artist){
					$db->exec('INSERT INTO z_artist(name,comment,itemid,siteid,userid,support,sort) VALUES 
					("'.$artist['name'].'", "'.$artist['comment'].'", '.$itemid.', '.$siteidto.', 
					'.$useridto.', '.$artist['support'].', '.$artist['sort'].')
					'); 
				}
			}
			#Баннера
			$teaserresult=$db->queryFetchAllAssoc(
			'SELECT
			z_teaser.link,
			CONCAT(
			 "/uploads/sites/",
			 z_teaser.siteid,
			 "/img/",
			 z_teaser.file_name
			) AS url,
			z_teaser.sort
			FROM z_teaser WHERE z_teaser.siteid='.$siteidfrom.'');
			if(is_array($teaserresult))
			foreach($teaserresult as $teaser){
				$path_parts3=null;
				$newfilename=null;
				$path_parts3=pathinfo($teaser['url']);
				$newfilename=md5(uniqid().microtime()).".".$path_parts3['extension'];
				copy($_SERVER['DOCUMENT_ROOT'].$teaser['url'], $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteidto.'/img/'.$newfilename);
					
				$db->exec('INSERT INTO z_teaser (link, active, file_name, siteid, userid, sort) VALUES
				("'.$teaser['link'].'", 1, "'.$newfilename.'", '.$siteidto.', '.$useridto.', '.$teaser['sort'].')
				');
			}
		}
}
?>