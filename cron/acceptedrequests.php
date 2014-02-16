<?
								require_once "/var/www/reactorpro/reactor-pro.ru/_reactor/classes/smtp.php";
								require_once "/var/www/reactorpro/reactor-pro.ru/_reactor/classes/tools.php";
								
								define('SMTP_HOST', 'ds139.mirohost.net');
								define('MAIN_HOST', 'reactor.ua');
								define('MAIN_NAME', 'Reactor-PRO');
		
			
							
								$link1 = mysql_connect("localhost","u_reactorp","yvbfasdhZ4p");
								mysql_select_db("reactorp", $link1);
								mysql_query("SET NAMES 'utf8'");
								
								/*
								#select BANNERS
								
								SELECT 
								  COUNT(DISTINCT z_banner_site.`id`) AS COUNT,
								  z_banner_site.`bannerid`,
								  z_banner_site.`siteid`,
								  z_banner_site.`date_update`,
								  z_brand_banner.`brandid`,
								  z_brand.name AS brandname,
								  z_brand.`urlcode`,
								  z_brand_user.`userid`,
								  z_user.email 
								FROM
								  z_banner_site 
								  INNER JOIN z_brand_banner 
								    ON z_brand_banner.`id` = z_banner_site.`bannerid` 
								  INNER JOIN z_brand 
								    ON z_brand.id = z_brand_banner.`brandid` 
								  INNER JOIN z_brand_user 
								    ON z_brand_user.`brandid` = z_brand_banner.`brandid` 
								  INNER JOIN z_user 
								    ON z_user.id = z_brand_user.`userid` 
								  LEFT JOIN z_brand_visits 
								    ON z_brand_visits.`brandid` = z_brand_banner.`brandid` 
								    AND z_brand_visits.`datatypeid` = 13 
								    AND z_brand_visits.`itemid` = z_banner_site.`bannerid` 
								WHERE z_banner_site.`status` = 3 
								  AND z_banner_site.`date_update` > z_brand_visits.`date_visit` 
								  OR z_brand_visits.`date_visit` IS NULL 
								  AND z_banner_site.`status` = 3 
								GROUP BY z_brand_banner.`brandid` 
								
								
								#select indors
								SELECT 
								  COUNT(DISTINCT z_event_site.`id`) AS COUNT,
								  z_event_site.`eventid`,
								  z_event_site.`siteid`,
								  z_event_site.`date_update`,
								  z_brand_event.`brandid`,
								  z_brand.name AS brandname,
								  z_brand.`urlcode`,
								  z_brand_user.`userid`,
								  z_user.email 
								FROM
								  z_event_site 
								  INNER JOIN z_brand_event 
								    ON z_brand_event.`id` = z_event_site.`eventid` 
								  INNER JOIN z_brand 
								    ON z_brand.id = z_brand_event.`brandid` 
								  INNER JOIN z_brand_user 
								    ON z_brand_user.`brandid` = z_brand_event.`brandid` 
								  INNER JOIN z_user 
								    ON z_user.id = z_brand_user.`userid` 
								  LEFT JOIN z_brand_visits 
								    ON z_brand_visits.`brandid` = z_brand_event.`brandid` 
								    AND z_brand_visits.`datatypeid` = 15
								    AND z_brand_visits.`itemid` = z_event_site.`eventid` 
								WHERE z_brand_visits.date_visit<z_event_site.date_update AND (CHAR_LENGTH(z_event_site.report)>0 OR z_event_site.file_name IS NOT NULL)
								GROUP BY z_brand_event.`brandid` 
								
								#public 
								SELECT 
								  COUNT(DISTINCT z_public_site.`id`) AS COUNT,
								  z_public_site.`publicid`,
								  z_public_site.`siteid`,
								  z_public_site.`date_update`,
								  z_brand_public.`brandid`,
								  z_brand.name AS brandname,
								  z_brand.`urlcode`,
								  z_brand_user.`userid`,
								  z_user.email,
								  z_brand_visits.date_visit
								FROM
								  z_public_site 
								  INNER JOIN z_brand_public 
								    ON z_brand_public.`id` = z_public_site.`publicid` 
								 INNER JOIN z_brand 
								    ON z_brand.id = z_brand_public.`brandid` 
								  INNER JOIN z_brand_user 
								    ON z_brand_user.`brandid` = z_brand_public.`brandid` 
								  INNER JOIN z_user 
								    ON z_user.id = z_brand_user.`userid`
								  INNER JOIN z_public_report
								  ON z_public_report.`publicrequestid`=z_public_site.id
								  LEFT JOIN z_brand_visits 
								    ON z_brand_visits.`brandid` = z_brand_public.`brandid` 
								    AND z_brand_visits.`datatypeid` = 14 
								    AND z_brand_visits.`itemid` = z_public_site.`publicid` 
								WHERE z_brand_visits.date_visit < z_public_site.date_update
								GROUP BY z_brand_public.`brandid`
								*/
								
								
								$query=mysql_query('
								(SELECT 
								  z_brand_visits.`datatypeid`,
								  COUNT(DISTINCT z_banner_site.`id`) AS COUNT,
								  z_brand_banner.`brandid`,
								  z_brand.name AS brandname,
								  z_brand.`urlcode`,
								  z_brand_user.`userid`,
								  z_user.email 
								FROM
								  z_banner_site 
								  INNER JOIN z_brand_banner 
								    ON z_brand_banner.`id` = z_banner_site.`bannerid` 
								  INNER JOIN z_brand 
								    ON z_brand.id = z_brand_banner.`brandid` 
								  INNER JOIN z_brand_user 
								    ON z_brand_user.`brandid` = z_brand_banner.`brandid` 
								  INNER JOIN z_user 
								    ON z_user.id = z_brand_user.`userid` 
								  LEFT JOIN z_brand_visits 
								    ON z_brand_visits.`brandid` = z_brand_banner.`brandid` 
								    AND z_brand_visits.`datatypeid` = 13 
								    AND z_brand_visits.`itemid` = z_banner_site.`bannerid` 
								WHERE z_banner_site.`status` = 3 
								  AND z_banner_site.`date_update` > z_brand_visits.`date_visit` 
								  OR z_brand_visits.`date_visit` IS NULL 
								  AND z_banner_site.`status` = 3 
								GROUP BY z_brand_banner.`brandid`) 
								UNION
								(SELECT 
								  z_brand_visits.`datatypeid`,
								  COUNT(DISTINCT z_event_site.`id`) AS COUNT,
								  z_brand_event.`brandid`,
								  z_brand.name AS brandname,
								  z_brand.`urlcode`,
								  z_brand_user.`userid`,
								  z_user.email 
								FROM
								  z_event_site 
								  INNER JOIN z_brand_event 
								    ON z_brand_event.`id` = z_event_site.`eventid` 
								  INNER JOIN z_brand 
								    ON z_brand.id = z_brand_event.`brandid` 
								  INNER JOIN z_brand_user 
								    ON z_brand_user.`brandid` = z_brand_event.`brandid` 
								  INNER JOIN z_user 
								    ON z_user.id = z_brand_user.`userid` 
								  LEFT JOIN z_brand_visits 
								    ON z_brand_visits.`brandid` = z_brand_event.`brandid` 
								    AND z_brand_visits.`datatypeid` = 15 
								    AND z_brand_visits.`itemid` = z_event_site.`eventid` 
								WHERE z_brand_visits.date_visit < z_event_site.date_update 
								  AND (
								    CHAR_LENGTH(z_event_site.report) > 0 
								    OR z_event_site.file_name IS NOT NULL
								  ) 
								GROUP BY z_brand_event.`brandid`) 
								UNION
								(SELECT 
								  z_brand_visits.`datatypeid`,
								  COUNT(DISTINCT z_public_site.`id`) AS COUNT,
								  z_brand_public.`brandid`,
								  z_brand.name AS brandname,
								  z_brand.`urlcode`,
								  z_brand_user.`userid`,
								  z_user.email 
								FROM
								  z_public_site 
								  INNER JOIN z_brand_public 
								    ON z_brand_public.`id` = z_public_site.`publicid` 
								  INNER JOIN z_brand 
								    ON z_brand.id = z_brand_public.`brandid` 
								  INNER JOIN z_brand_user 
								    ON z_brand_user.`brandid` = z_brand_public.`brandid` 
								  INNER JOIN z_user 
								    ON z_user.id = z_brand_user.`userid` 
								  INNER JOIN z_public_report 
								    ON z_public_report.`publicrequestid` = z_public_site.id 
								  LEFT JOIN z_brand_visits 
								    ON z_brand_visits.`brandid` = z_brand_public.`brandid` 
								    AND z_brand_visits.`datatypeid` = 14 
								    AND z_brand_visits.`itemid` = z_public_site.`publicid` 
								WHERE z_brand_visits.date_visit < z_public_site.date_update 
								GROUP BY z_brand_public.`brandid`)
								
								');
								while($row=mysql_fetch_assoc($query)){
								$data[$row['userid']]['reply'][$row['datatypeid']]=$row['COUNT'];
								$data[$row['userid']]['data']=$row;
								
								}
								//tools::print_r($data);
								$datatype[12]['name']='Рекард';
								$datatype[12]['url']='recards';
								
								$datatype[13]['name']='Баннер';
								$datatype[13]['url']='banners';
								
								$datatype[14]['name']='Паблик';
								$datatype[14]['url']='public';
								
								$datatype[15]['name']='Indoor';
								$datatype[15]['url']='events';
								
							foreach ($data as $uid=>$user){
								
								$subject=null;
								$message=null;
								$smtp=null;
								$subject = "Новые ответы от заведений в системе Clubsreport";
								$message .= "У Вас есть новые ответы от заведений в следующих разделах:\n\n";
								foreach($user['reply'] as $datatypeid=>$cnt)
								$message .= $datatype[$datatypeid]['name'].": http://".$user['data']['urlcode'].".clubsreport.com/".$datatype[$datatypeid]['url']."/ - ($cnt новых)\n\n";											
								$message .= "С уважением, команда Clubsreport.\n\n";
								
								$smtp=new smtp;
								$smtp->Connect(SMTP_HOST);
								$smtp->Hello(SMTP_HOST);
								$smtp->Authenticate('support@clubsreport.com', 'Z1IRldqU');
								$smtp->Mail('support@clubsreport.com');
								$smtp->Recipient($user['data']['email']);
								$smtp->Data($message, $subject,'Clubsreport');
							}
			/*
			echo "<pre>";
						print_r($data);
						echo "</pre>";*/
			
			
	echo date('Y-m-d h:i:s');		

?>