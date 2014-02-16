<?
require_once 'modules/base/models/Basemodel.php';

Class Social Extends Basemodel {

public function findSocial($url){
	$url=urldecode($url);
	if(strlen($url)<4)
	return;
	
	
	$db=db::init();
	/*str_replace('http://.','',$url);
	str_replace('www.','',$url);
	$urldata=parse_url('http://'.$url);
	*/
	/*if(gethostbyname($urldata['host']))
	return;*/
	
	$urldata['host']=tools::getDomain($url);
	if(!$urldata['host'])
	return;
	
	
	
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_social.id,
				  CONCAT("/uploads/",z_file.subdir,"/",z_file.file_name) as url
				FROM
				  z_social
				LEFT JOIN z_file
				ON z_social.preview_image=z_file.id
				WHERE z_social.url LIKE "'.$urldata['host'].'"
				LIMIT 0,1
				');
	if(!$result){
		
		$db->exec('
					insert into z_social 
						(name, url, active, new) 
					values 
					  	("'.$urldata['host'].'", "'.$urldata['host'].'", 1, 1)
				');
		$result=array('id'=>$db->lastInsertId(),'url'=>'');
		return $result;
	}
	else
		return $result;
	
}

public function getUserSocial($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_site_social.id,
				  z_social.id as socialid,
				  CONCAT(
				    "/uploads/",
				    z_file.subdir,
				    "/",
				    z_file.file_name
				  ) AS img,
				  z_site_social.url,
				  z_site_social.active
				FROM
				  z_site_social 
				  INNER JOIN
				  z_social 
				  ON z_social.id = z_site_social.socialid 
				  LEFT JOIN
				  z_file 
				  ON z_social.preview_image = z_file.id 
				WHERE z_site_social.siteid = '.tools::int($id).'
				order by z_site_social.sort');
	if($result)
	return $result;
}
public function getSocialMode($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_site.socialmodeid
				FROM
				  z_site 
				WHERE z_site.id = '.tools::int($id).'
				LIMIT 0,1');
	if($result['socialmodeid'])
	return $result['socialmodeid'];
}
public function updateSocialMode($data, $twitter){
	if(!$twitter)
	$twitterSTR=', twitter=NULL';
	else
	$twitterSTR=', twitter="'.$twitter.'"';
		
	$db=db::init();
	if($data)
	$_SESSION['Site']['socialmodeid']=$data;
	if($twitter)
	$_SESSION['Site']['twitter']=$twitter;
	$db->exec('
	update z_site 
	SET socialmodeid='.$data.'
	'.$twitterSTR.'
	WHERE id='.tools::int($_SESSION['Site']['id']).'
	AND userid='.tools::int($_SESSION['User']['id']).'
	');
}
public function updateSocialList($data){
	$db=db::init();
	foreach($data as $row)
	if($row['id']>0)
	$socidArr[$row['id']]=$row['id'];
	if(count($socidArr)>0){
	$db->exec('
	DELETE 
	FROM
	  z_site_social 
	WHERE z_site_social.id NOT IN ('.implode(",",$socidArr).') 
	  AND z_site_social.siteid='.tools::int($_SESSION['Site']['id']).'
	  AND z_site_social.userid='.tools::int($_SESSION['User']['id']).'
	  ');
	}
	else{
	$db->exec('
	DELETE 
	FROM
	  z_site_social 
	WHERE z_site_social.siteid='.tools::int($_SESSION['Site']['id']).'
	  AND z_site_social.userid='.tools::int($_SESSION['User']['id']).'
	  ');
	}
	
	foreach($data as $k=>$social){
		
		/*if($social['socialid']==222){
			$twitter=end(explode('/',$social['url']));
		}*/
		
		if($social['id']){
			$sdata=self::findSocial($social['url']);
			
			if($sdata['id']>0)
			$db->exec('
					update z_site_social 
						SET socialid='.tools::int($sdata['id']).', url="'.tools::str($social['url']).'", sort='.$k.'
					where id='.tools::int($social['id']).' 
					AND z_site_social.siteid='.tools::int($_SESSION['Site']['id']).'
					AND z_site_social.userid='.tools::int($_SESSION['User']['id']).'
					');
		}
		else{
			//if($sdata['id']>0)
			$sdata=self::findSocial($social['url']);
			$db->exec('
					insert into z_site_social 
						(socialid, url, active, siteid, userid, sort) 
					values 
					  	('.tools::int($sdata['id']).', "'.tools::str($social['url']).'", 1, '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', '.$k.' )');
		}
	}
	//self::updateSocialMode($data['socialmode'],$twitter);
}
public function getSiteSocial(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	  z_social.id,
	  z_social.name,
	  z_site_social.url,
	  if(z_file.id>0,CONCAT(
	    "/uploads/social/",
	    z_file.file_name
	  ),"/uploads/social-club/default.png") AS img
	FROM
	  z_site_social 
	  INNER JOIN
	  z_social 
	  ON z_social.id = z_site_social.socialid 
	  LEFT JOIN
	  z_file 
	  ON z_file.id = z_social.detail_image 
	WHERE z_site_social.siteid = '.tools::int($_SESSION['Site']['id']).' 
	  AND z_site_social.active = 1 
	ORDER BY z_site_social.sort ASC
	');
	return $result;
}
public function getTwitter(){
	if($_SESSION['Site']['socialmodeid']==3){
	 //Создаём новый объект. Также можно писать и в процедурном стиле
    $memcache_obj = new Memcache;
 
    //Соединяемся с нашим сервером
    $memcache_obj->connect('127.0.0.1', 11211) or die("Could not connect");
 
    //Попытаемся получить объект с ключом our_var
    $return = @$memcache_obj->get('site_twit_'.$_SESSION['Site']['id']);
 	//$memcache_obj->delete('site_twit_'.$_SESSION['Site']['id']);
    if(!empty($return) && strlen($return)>1)
    {
        //Если объект закэширован, выводим его значение
        $memcache_obj->close();
		return $return;
    }
 
    else
    {
    	$username=$_SESSION['Site']['twitter'];
		$format='xml';
		if(@$tweet=simplexml_load_file("http://api.twitter.com/1/statuses/user_timeline/{$username}.{$format}")){
		$post=$tweet->status[0]->text;	
		$post = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]",
                    "<a target='blank' href=\"\\0\">\\0</a>", $post);	
		}
        //Если в кэше нет объекта с ключом our_var, создадим его
        //Объект our_var будет храниться 5 секунд и не будет сжат
        $memcache_obj->set('site_twit_'.$_SESSION['Site']['id'], "$post", false, 10*60);
 		$return=$memcache_obj->get('site_twit_'.$_SESSION['Site']['id']);
        //Выведем закэшированные данные
        $memcache_obj->close();
		return $return;
    }
    //Закрываем соединение с сервером Memcached
	}
	elseif($_SESSION['Site']['socialmodeid']==2){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('SELECT 
		  name,
		  itemid
		FROM
		  z_news 
		WHERE active = 1 
		AND siteid='.$_SESSION['Site']['id'].'');
		if($result)
		return $result;
	}
    
}
}
?>