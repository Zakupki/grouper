<?
								require_once "/var/www/reactorpro/reactor-pro.ru/_reactor/classes/smtp.php";
								
								define('SMTP_HOST', 'ds139.mirohost.net');
								define('MAIN_HOST', 'reactor.ua');
								define('MAIN_NAME', 'Reactor-PRO');
		
			
							
								$link1 = mysql_connect("localhost","u_reactorp","yvbfasdhZ4p");
								mysql_select_db("reactorp", $link1);
								mysql_query("SET NAMES 'utf8'");
								
								$query=mysql_query('
								(SELECT 
								  COUNT(z_banner_site.siteid) AS cnt,
								  z_banner_site.`bannerid` AS requestid,
								  "banner" AS request,
								  z_banner_site.siteid,
								  z_user.email,
								  z_site.name,
								  IF(z_domain.id>0,z_domain.name,CONCAT("r",z_site.id,".reactor.ua")) AS domain
								FROM
								  z_banner_site 
								INNER JOIN z_site
								ON z_site.id=z_banner_site.siteid 
								INNER JOIN z_user
								ON z_user.id=z_site.userid
								LEFT JOIN z_domain
								ON z_domain.`siteid`=z_site.id
								WHERE z_banner_site.new = 1 
								GROUP BY z_banner_site.siteid) 
								UNION
								(SELECT 
								  COUNT(z_public_site.siteid) AS cnt,
								  z_public_site.`publicid` AS requestid,
								  "public" AS request,
								  z_public_site.siteid,
								  z_user.email,
								  z_site.name,
								  IF(z_domain.id>0,z_domain.name,CONCAT("r",z_site.id,".reactor.ua")) AS domain
								FROM
								  z_public_site
								INNER JOIN z_site
								ON z_site.id=z_public_site.siteid 
								INNER JOIN z_user
								ON z_user.id=z_site.userid
								LEFT JOIN z_domain
								ON z_domain.`siteid`=z_site.id
								WHERE z_public_site.new = 1 
								GROUP BY z_public_site.siteid) 
								UNION
								(SELECT 
								  COUNT(z_event_site.siteid) AS cnt,
								  z_event_site.`eventid` AS requestid,
								  "event" AS request,
								  z_event_site.siteid,
								  z_user.email,
								  z_site.name,
								  IF(z_domain.id>0,z_domain.name,CONCAT("r",z_site.id,".reactor.ua")) AS domain 
								FROM
								  z_event_site
								INNER JOIN z_site
								ON z_site.id=z_event_site.siteid 
								INNER JOIN z_user
								ON z_user.id=z_site.userid
								LEFT JOIN z_domain
								ON z_domain.`siteid`=z_site.id
								WHERE z_event_site.new = 1 
								GROUP BY z_event_site.siteid) 
								UNION
								(SELECT 
								  COUNT(z_recard_site.siteid) AS cnt,
								  z_recard_site.`recardid` AS requestid,
								  "recard" AS request,
								  z_recard_site.siteid,
								  z_user.email,
								  z_site.name,
								  IF(z_domain.id>0,z_domain.name,CONCAT("r",z_site.id,".reactor.ua")) AS domain 
								FROM
								  z_recard_site
								INNER JOIN z_site
								ON z_site.id=z_recard_site.siteid 
								INNER JOIN z_user
								ON z_user.id=z_site.userid
								LEFT JOIN z_domain
								ON z_domain.`siteid`=z_site.id
								WHERE z_recard_site.new = 1 
								  AND z_recard_site.status > 1 
								GROUP BY z_recard_site.siteid)
								order by `siteid`
								');
								while($site=mysql_fetch_assoc($query)){
								$data[$site['siteid']]['notices']=$data[$site['siteid']]['notices']+$site['cnt'];
								$data[$site['siteid']]['email']=$site['email'];
								$data[$site['siteid']]['domain']=$site['domain'];
								$data[$site['siteid']]['name']=$site['name'];
								
								$data2[]=$site;
									//echo $site['yocardid'];
								
									
										
										
										/*
										if($site['id']>0)
																				$q='UPDATE z_coupons
																				SET 
																				TotalCoupon='.$data->TotalCoupon.',
																				CouponsRedempt='.$data->CouponsRedempt.',
																				RedemptionRatio="'.$data->RedemptionRatio.'",
																				ActiveCoupons='.$data->ActiveCoupons.',
																				CouponsExpired='.$data->CouponsExpired.',
																				ParticipantsCount='.$data->ParticipantsCount.'
																				WHERE id='.$site['id'].' AND couponid='.$site['yocardid'].'';
																				else
																				$q='INSERT INTO z_coupons
																				(TotalCoupon,CouponsRedempt,RedemptionRatio,ActiveCoupons,CouponsExpired,ParticipantsCount,couponid) VALUES
																				('.$data->TotalCoupon.','.$data->CouponsRedempt.',"'.$data->RedemptionRatio.'",'.$data->ActiveCoupons.','.$data->CouponsExpired.','.$data->ParticipantsCount.',
																				'.$site['yocardid'].')';
																				$query2=mysql_query($q);
										
									
																
								  curl_close($curl);
							*/
							}
							foreach ($data as $notice){
								//if($notice['email']=='bozhok@ukr.net'){	
									$subject=null;
									$message=null;
									$smtp=null;
									$subject = "Новые уведомления на сайте ".$notice['name']."!";
									$message = "Здравствуйте, ".$notice['name'].".\n\nНа ".date('d.m.Y')." у вас ".$notice['notices']." новых заявок.\n\nВ течение двух рабочих дней, с Вами свяжется представитель Clubsreport для подтверждения указанной информации.\n\nhttp://".$notice['domain']."/admin/requests/\n\nС уважением, команда Clubsreport.\n\n";
									
									
									$smtp=new smtp;
									$smtp->Connect(SMTP_HOST);
									$smtp->Hello(SMTP_HOST);
									$smtp->Authenticate('support@clubsreport.com', 'Z1IRldqU');
									$smtp->Mail('support@clubsreport.com');
									$smtp->Recipient($notice['email']);
									$smtp->Data($message, $subject);
								//}
								//break;
							}
			/*
			echo "<pre>";
						print_r($data);
						echo "</pre>";*/
			
			
	echo date('Y-m-d h:i:s');		

?>