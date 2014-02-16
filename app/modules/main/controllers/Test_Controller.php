<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/Release.php';
require_once 'modules/main/models/News.php';
require_once 'modules/main/models/Support.php';
require_once 'modules/main/models/Geo.php';
require_once 'modules/club/models/Social.php';
require_once 'modules/main/models/Reccount.php';

Class Test_Controller Extends Base_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->News=new News;
			$this->newsline=$this->News->getNewsLine();
			$this->newslineblock=$this->view->AddView('blocks/newslineblock', $this);
			$this->messageum=$this->registry->user->getMessages($this->Session->User['id']);
		}

        function indexAction() {
        }
		function testAction(){
			tools::print_r($_SERVER);
			/*$db=db::init();
			$sth=$db->prepare('SELECT 
					*
					FROM
					  z_user
					WHERE z_user.login=:login
					LIMIT 0,1');
			//$sth->bindParam(':calories', $calories, PDO::PARAM_INT);
			$login='orange';
			$sth->bindParam(':login', $login, PDO::PARAM_STR);
			$sth->execute();
			
			$result=$sth->fetchAll();
			
			tools::var_dump($sth);*/
			
			//$exobj=$pObj->execute(array("orange"));
			
			/*$row=$db->queryFetchRow('SELECT 
					*
					FROM
					  z_user
					WHERE z_user.login="orange"
					LIMIT 0,1');*/
			
			//echo $pObj->queryString;
			
			/*$data = file_get_contents($_SERVER['DOCUMENT_ROOT']."/111.txt"); //read the file
			$convert = explode("\n", $data); //create array separate by new line
			$db=db::init();
			$cnt=0;
			for ($i=0;$i<count($convert);$i++) 
			{
			    $data=null;
				$fileid=null;
			    $data=explode(';',trim($convert[$i]));
				echo $data[0].' - '.$data[1].'<br/>';
				$row1=$db->exec('insert into z_file (subdir,file_name) values ("social","'.$data[1].'")');
				
				$fileid=$db->lastInsertId();
				
				$row=$db->exec('insert into z_social (name,url,preview_image,active) values ("'.$data[0].'","'.$data[0].'",'.$fileid.',1)');
				//echo $db->lastInsertId();
				
				//echo $convert[$i].', '; //write value by index
			$cnt++;    
			}
			echo $cnt;*/
		}
		function test2Action(){
			//die();
			$db=db::init();
			$result=$db->queryFetchAllAssoc('
			SELECT 
			  z_site.id,
			  z_site.userid 
			FROM
			  z_site 
			WHERE z_site.sitetypeid = 7 
			');
			foreach($result as $row){
				$itemid=null;
				$db->exec('INSERT INTO _items (datatypeid,siteid,userid) VALUES (1,'.$row['id'].','.$row['userid'].')');
				$itemid=$db->lastInsertId();
				$db->exec('INSERT INTO z_menu (itemid,name,active,menutypeid,sort,original,siteid,code,userid) VALUES 
				('.$itemid.',
				 "Главная",
				 1,
				 59,
				 0,
				 1,
				 '.$row['id'].',
				 "main",
				 '.$row['userid'].')');
			}
		}
		function fillpartyAction(){
			if(tools::int($_GET['id'])<1)
			die();
			$siteidfrom=151;
			$siteidto=$_GET['id'];
			$useridto=40;
			
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
		function fillpartybannerAction(){
			die();
			$db=db::init();
			/*if(tools::int($_GET['id'])<1)
			die();*/
			$sitetoArr=array(228,227,226,225,224,223,222,221,220,219,218,217,216,215,214,213,212,206,205,203,202,201,200,199,198,191,190,189,188,186,185,184,183,182,181,180,179,
			178,177,175,174,173,172,171,170,169,164,163,161,160,158,156,155,154,152,142);
			
			$siteidfrom=151;
			//$siteidto=$_GET['id'];
			$useridto=40;
			
			
			/*$result=$db->queryFetchAllAssoc('
			SELECT 
			  CONCAT("/uploads/sites/",z_teaser.siteid,"/img/",z_teaser.file_name) AS url 
			FROM
			  z_teaser 
			where siteid in('.implode(',',$sitetoArr).')
			');
			$cnt=1;
			foreach($result as $teaser){
				
				echo "<br/>".$cnt;
				echo '<img src="http://reactor.ua'.$teaser['url'].'">';
				echo "<br/>";
				$cnt++;
			}*/
			/*$db->exec('DELETE FROM z_teaser where siteid in('.implode(',',$sitetoArr).')');*/
			
			$result=$db->queryFetchAllAssoc('SELECT id,userid from z_site where id in('.implode(',',$sitetoArr).')
			');
			foreach($result as $site){
				$siteuserArr[$site['id']]=$site['userid'];
			}
			tools::print_r($siteuserArr);
			/*$db=db::init();
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
			}*/
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
				
				
				foreach($siteuserArr as $k=>$ste){	
					$newfilename=md5(uniqid().microtime()).".".$path_parts3['extension'];
					copy($_SERVER['DOCUMENT_ROOT'].$teaser['url'], $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$k.'/img/'.$newfilename);
					$db->exec('INSERT INTO z_teaser (link, active, file_name, siteid, userid, sort) VALUES
					("'.$teaser['link'].'", 1, "'.$newfilename.'", '.$k.', '.$ste.', '.$teaser['sort'].')
					');
				}
				
				
			}
		}
		public function setvideosocialAction(){
			die();
			$db=db::init();
			$this->Social=new Social;
			$result=$db->queryFetchAllAssoc(
			'SELECT url,id from z_video
			');
			$cnt=0;
			foreach($result as $video){
				$socialdata=null;
				$socialdata=$this->Social->findSocial($video['url']);
				if($socialdata['id']>0){
				$db->exec('Update z_video SET socialid='.tools::int($socialdata['id']).' WHERE id='.$video['id'].'');
				$cnt++;
				}
			}
			echo 'Всего-'.count($result).'<br/>';
			echo 'Обновлено-'.$cnt.'<br/>';
			tools::print_r($result);
		}
		public function videoitemidAction(){
		die();
		$db=db::init();
		$result=$db->queryFetchAllAssoc(
		'SELECT * from z_video
		WHERE z_video.itemid<1');
		foreach($result as $video){
			echo $video['id'].'-'.$video['itemid'];
			echo "<br/>";
			if($video['itemid']<1){
			$db->exec('
			INSERT INTO _items (datatypeid,siteid,userid) VALUES (10,'.tools::int($video['siteid']).','.tools::int($video['userid']).')');
			$itemid=$db->lastInsertId();
			if($itemid)
			$db->exec('UPDATE z_video SET itemid='.$itemid.' WHERE id='.$video['id'].''); 
			}
		}
		}
		public function galleryitemidAction(){
		die();
		$db=db::init();
		$result=$db->queryFetchAllAssoc(
		'SELECT * from z_gallerytype
		WHERE z_gallerytype.itemid<1');
		foreach($result as $video){
			echo $video['id'].'-'.$video['itemid'];
			echo "<br/>";
			if($video['itemid']<1){
			$db->exec('
			INSERT INTO _items (datatypeid,siteid,userid) VALUES (11,'.tools::int($video['siteid']).','.tools::int($video['userid']).')');
			$itemid=$db->lastInsertId();
			if($itemid)
			$db->exec('UPDATE z_gallerytype SET itemid='.$itemid.' WHERE id='.$video['id'].''); 
			}
		}
		}
		
}


?>