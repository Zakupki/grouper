<?
require_once 'modules/base/models/Basemodel.php';

Class Comments Extends Basemodel {
	public $registry;
	private $no_cache;
	
	public function __construct($registry){
		//parent::__construct($registry);
		$this->registry=$registry;
		if(MAIN_DEBUG==true)
		$this->no_cache='SQL_NO_CACHE';
	}
	
	public function getIncuts($itemid){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT '.$this->no_cache.'
					  z_comments.id,
					  z_comments.parentid,
					  z_comments.userid,
					  z_comments.preview_text,
					  z_comments.date_create,
					  z_comments.deleted,
					  DATE_FORMAT(
					    z_comments.date_create,
					    "%Y%m%d%H%i%s"
					  ) AS date_create2,
					  z_user.login,
					  IF(
					    z_user.siteid > 0,
					    z_site.name,
					    IFNULL(z_user.displayname,z_user.login)
					  ) AS `displayname`,
					  if(z_site2.id,1,0) AS pro,
					  z_user.file_name,
					  z_quote.id AS quote
					FROM
					  z_comments 
					  INNER JOIN z_quote
					  ON z_quote.commentid=z_comments.id
					  INNER JOIN
					  z_user 
					  ON z_user.id = z_comments.userid
					  LEFT JOIN
					  z_site 
					  ON z_site.id = z_user.siteid
					  LEFT JOIN z_site z_site2
					  ON z_site2.userid=z_user.id
					WHERE z_comments.itemid = '.tools::int($itemid).' AND z_comments.deleted=1
					GROUP BY z_comments.id
					ORDER BY z_comments.date_create ASC
					');
		return $result;
	}
	
	public function getComments($itemid){
		$db=db::init();
		$userid=tools::int($_SESSION['User']['id']);
		if($userid>0){
		$vistitres=$db->queryFetchRowAssoc('
		SELECT '.$this->no_cache.'
		  DATE_FORMAT(
		    date_visit,
		    "%Y%m%d%H%i%s"
		  ) AS date_visit 
		FROM
		  z_commentvisit 
		WHERE itemid = '.$itemid.'
		  AND userid = '.$userid.' 
		');
		}
		$result=$db->queryFetchAllAssoc('
					SELECT '.$this->no_cache.'
					  z_comments.id,
					  z_comments.parentid,
					  z_comments.userid,
					  z_comments.preview_text,
					  z_comments.date_create,
					  z_comments.deleted,
					  DATE_FORMAT(
					    z_comments.date_create,
					    "%Y%m%d%H%i%s"
					  ) AS date_create2,
					  z_user.login,
					  IF(
					    z_user.siteid > 0,
					    z_site.name,
					    IFNULL(z_user.displayname,z_user.login)
					  ) AS `displayname`,
					  if(z_site2.id,1,0) AS pro,
					  z_user.file_name,
					  z_quote.id AS quote
					FROM
					  z_comments 
					  INNER JOIN
					  z_user 
					  ON z_user.id = z_comments.userid
					  LEFT JOIN z_quote
					  ON z_quote.commentid=z_comments.id
					  LEFT JOIN
					  z_site 
					  ON z_site.id = z_user.siteid
					  LEFT JOIN z_site z_site2
					  ON z_site2.userid=z_user.id
					WHERE z_comments.itemid = '.tools::int($itemid).'
					GROUP BY z_comments.id
					ORDER BY z_comments.date_create ASC
					');
		if($result){
		foreach($result as $k => $v){
			if($v['id']){
				if($vistitres['date_visit']<$v['date_create2'])
					$v['new']=1;
				if(!$v['parentid'])
					$out[0][$v['id']]=$v;
				else
					$out[$v['parentid']][$v['id']]=$v;
			}
		}
		}
		if($vistitres['date_visit']<1 && tools::int($_SESSION['User']['id'])>0){
					$db->exec('
					INSERT INTO z_commentvisit(
					  itemid,
					  userid,
					  date_visit
					) 
					VALUES
					  ('.$itemid.', '.tools::int($_SESSION['User']['id']).', NOW()) 
					');
		}
		elseif(tools::int($_SESSION['User']['id'])>0 && $vistitres['date_visit']>0){
					$db->exec('
					UPDATE z_commentvisit
					SET
					date_visit=NOW()
					WHERE itemid='.$itemid.' AND userid='.tools::int($_SESSION['User']['id']).'
					');
		}
		return $out;
		
	}
	
	
	public function addComment($data){
		/* header('Content-Type: application/json; charset=utf-8'); */
		$db=db::init();
		if($_SESSION['User']['id']>0){
			$data['message']=stripslashes($data['message']);
			$db->exec('
			INSERT INTO z_comments(
			  parentid,
			  itemid,
			  userid,
			  siteid,
			  preview_text
			) 
			VALUES
			  ('.tools::int($data['parent_id']).', '.tools::int($data['itemid']).', '.tools::int($_SESSION['User']['id']).', '.tools::int($data['siteid']).', "'.tools::str($data['message']).'") 
			');
			$newid=$db->lastInsertId();
			
			#обновление визита
			$db->exec('
			UPDATE z_commentvisit
			SET
			date_visit=NOW()
			WHERE itemid='.tools::int($data['itemid']).' AND userid='.tools::int($_SESSION['User']['id']).'
			');
			
			$content_pro_class = 'content-pro ';
			$user_url = '/users/'.$_SESSION['User']['login'].'/';
			$user_name = $_SESSION['User']['displayname'];
			if(count($_SESSION['User']['reccounts'])>0){
			$user_pro_icon = '<i class="i-pro"></i>';
			$user_pro_class = 'user-link-pro ';
			}
			$userpic_na_class = '';
			$userpic_image = '<img src="/uploads/users/3_'.$_SESSION['User']['file_name'].'" alt="" />';
			$date = $this->registry->trans['todayat'].' '.date('H:i');
			$message = $data['message'];
			$branch = $_POST['parent_id'] > 0 ? '<div class="branch"></div>' : '';
			$attach = $_FILES['attach']['name'] ? '<div class="attach-link"><div class="r"><div class="l"><span><a href="/'.$_FILES['attach']['name'].'">'.$_FILES['attach']['name'].'</a></span></div></div></div>' : '';
			if($_POST['authorid']==$_SESSION['User']['id'] && $_POST['incut'])
			$likebutton='<div class="quote-link"><i class="i"></i></div>';
			
			$data = array(
			    'error' => false,
			    'status' => 'Ваш комментарий добавлен',
			    'token' => $this->registry->token->getToken(),
			    'content' => '
			        <div class="ti-last ti" id="comment'.$newid.'">
					<input name="userid" value="'.$_SESSION['User']['id'].'" type="hidden" />
			          '.$branch.'
			          <div class="'.$content_pro_class.'content">
			            <div class="'.$userpic_na_class.'userpic"><a href="'.$user_url.'">'.$userpic_image.'</a></div>
			            <div class="author">
			              <div class="'.$user_pro_class.'user-link">
						  	<a href="'.$user_url.'">'.$user_name.'<i class="i"></i>'.$user_pro_icon.'</a></div>
			              <div class="date">'.$date.'</div>
			             	<div class="remove-link"><i class="i"></i></div>
							'.$likebutton.'
			             	<!--<div class="quote-link"><i class="i"></i></div>-->
			            </div>
			            <div class="text">'.$message.' <span class="new">('.$this->registry->trans['newcomment'].')</span></div>
			            '.$attach.'
			            <div class="reply-link"><span>'.$this->registry->trans['reply'].'<i class="i"></i></span></div>
			          </div>
			        </div>
			    '
			);
		return $data;
		}
	}
	public function removeComment(){
		/* header('Content-Type: application/json; charset=utf-8'); */
		if($_SESSION['User']['id']>0){
			$db=db::init();
			if($_SESSION['User']['id']==$_POST['userid']){
				$db->exec('
					UPDATE z_comments
					SET deleted=0
					WHERE z_comments.id='.tools::int($_POST['id']).' AND z_comments.userid='.tools::int($_SESSION['User']['id']).'
				');
			}
			else {
				$db->exec('
					UPDATE z_comments
					INNER JOIN z_releasetype
					ON z_releasetype.itemid=z_comments.itemid
					SET z_comments.deleted=0
					WHERE z_comments.id='.tools::int($_POST['id']).' 
					AND z_releasetype.userid='.tools::int($_SESSION['User']['id']).'
					AND z_comments.userid='.tools::int($_POST['userid']).'
				');
			}
			
		
		$data = array(
	    'error' => false,
	    'status' => 'Комментарий удалён',
	    'token' => $this->registry->token->getToken(),
	    'content' => '<div class="text-removed text">'.$this->registry->trans['delcomment'].'</div>'
		);
		
		return $data;
		
		}
	}
	public function quoteComment(){
		if($_SESSION['User']['id']>0){
			$db=db::init();
			$stmt=$db->prepare("INSERT INTO z_quote (itemid,commentid,userid) VALUES (?,?,?)");
			$num=$stmt->execute(array(tools::int($_POST['itemid']),tools::int($_POST['id']),tools::int($_SESSION['User']['id'])));
		}
		if($_SESSION['User']['id']>0 && $num>0){
			$data = array(
			    'error' => false,
			    'status' => 'Комментарий добавлен в список цитат'
			);
		}
		else{
			$data = array(
			    'error' => true,
		   		'status' => 'Произошла ошибка!'
			);
		}
		return $data;
	}
	public function unquoteComment(){
		if($_SESSION['User']['id']>0){
			$db=db::init();
			$stmt=$db->prepare("DELETE FROM z_quote WHERE itemid=? AND commentid=? AND userid=?");
			$num=$stmt->execute(array(tools::int($_POST['itemid']),tools::int($_POST['id']),tools::int($_SESSION['User']['id'])));	
		}
		if($_SESSION['User']['id']>0 && $num>0){
			$data = array(
			    'error' => false,
			    'status' => 'Комментарий удален из списка цитат'
			);
		}
		else{
			$data = array(
			    'error' => true,
		   		'status' => 'Произошла ошибка!'
			);
		}
		return $data;
	}
	public function rateItem(){
		if($_SESSION['User']['id']>0){
			$db=db::init();
			if($_POST['current_rate']==0 && $_POST['rate']!=0){
				$stmt=$db->prepare("INSERT INTO z_rate (itemid,rate,userid) VALUES (?,?,?)");
				$num=$stmt->execute(array(tools::int($_POST['id']),tools::int($_POST['rate']),tools::int($_SESSION['User']['id'])));
			}
			else
			{
				if($_POST['rate']==0){
					$stmt=$db->prepare("DELETE FROM z_rate WHERE itemid=? AND userid=?");
					$num=$stmt->execute(array(tools::int($_POST['id']),tools::int($_SESSION['User']['id'])));
				}
				else{
					$stmt=$db->prepare("UPDATE z_rate SET rate=? WHERE itemid=? AND userid=?");
					$num=$stmt->execute(array(tools::int($_POST['rate']),tools::int($_POST['id']),tools::int($_SESSION['User']['id'])));
				}
			}
		}
		
		if($_SESSION['User']['id']>0 && $num>0){
			$data = array(
			    'error' => false,
			    'status' => '',
			    'total_rate' => ($_POST['total_rate']-$_POST['current_rate'])+$_POST['rate']
			);
		}
		else{
			$data = array(
			    'error' => true,
		   		'status' => 'Произошла ошибка!'
			);
		}
		return $data;
	}
	
}
?>