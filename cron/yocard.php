<?

			//require_once "/var/www/reactorpro/reactor-pro.ru/_reactor/classes/tools.php";
			/*
					$curl = curl_init();
												   //СѓcС‚Р°РЅР°РІР»РёРІР°РµРј СѓСЂР», Рє РєРѕС‚РѕСЂРѕРјСѓ РѕР±СЂР°С‚РёРјСЃСЏ
						curl_setopt($curl,CURLOPT_URL, 'http://api.yocard.biz/Coupons/Redemption');
						curl_setopt($curl,CURLOPT_HTTPHEADER,array('Token: 03dc5efd-3c07-41b8-bf6f-5bbc630e7b35'));
						//curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json; charset=utf-8'));
						
						//curl_setopt($curl, CURLOPT_PORT, 5000);
												   //РІРєР»СЋС‡Р°РµРј РІС‹РІРѕРґ Р·Р°РіРѕР»РѕРІРєРѕРІ
						curl_setopt($curl, CURLOPT_HEADER, 0);
												   //РїРµСЂРµРґР°РµРј РґР°РЅРЅС‹Рµ РїРѕ РјРµС‚РѕРґСѓ post
						curl_setopt($curl, CURLOPT_POST, 1);
												   //С‚РµРїРµСЂСЊ curl РІРµСЂРЅРµС‚ РЅР°Рј РѕС‚РІРµС‚, Р° РЅРµ РІС‹РІРµРґРµС‚
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
												   //РїРµСЂРµРјРµРЅРЅС‹Рµ, РєРѕС‚РѕСЂС‹Рµ Р±СѓРґСѓС‚ РїРµСЂРµРґР°РЅРЅС‹Рµ РїРѕ РјРµС‚РѕРґСѓ post
						curl_setopt($curl, CURLOPT_POSTFIELDS, array("CouponId"=>"294","FromDate"=>"11/20/2012","ToDate"=>"11/27/2012"));
						//СЏ РЅРµ СЃРєСЂРёРїС‚, СЏ Р±СЂР°СѓР·РµСЂ РѕРїРµСЂР°
						//curl_setopt($curl, CURLOPT_USERAGENT, 'Opera 10.00');
												   $res = curl_exec($curl);
						echo "<pre>"; 
						print_r(json_decode($res));
						echo "</pre>";
						curl_close($curl);*/
			
		
			
							
								$link1 = mysql_connect("localhost","u_reactorp","yvbfasdhZ4p");
								mysql_select_db("reactorp", $link1);
								mysql_query("SET NAMES 'utf8'");
								
								$query=mysql_query("
								SELECT 
								  z_card.yocardid,
								  DATE_FORMAT(z_card.date_start,'%m/%d/%Y') AS date_start,
								  DATE_FORMAT(z_card.date_end,'%m/%d/%Y') AS date_end,
								  z_coupons.`id` 
								FROM
								  z_card 
								  INNER JOIN z_recard_site 
								    ON z_recard_site.`id` = z_card.`requestid` 
								    AND z_recard_site.`status` = 3 
								  LEFT JOIN z_coupons 
								    ON z_coupons.`couponid` = z_card.`yocardid` 
								WHERE z_card.`yocardid` > 0 AND DATE_ADD(z_card.date_end, INTERVAL 2 DAY)>=NOW()
								GROUP BY z_card.id 
								");
								while($site=mysql_fetch_assoc($query)){
									//echo $site['yocardid'];
								
										$curl = curl_init();
			 
										//уcтанавливаем урл, к которому обратимся
										curl_setopt($curl,CURLOPT_URL, 'http://api.yocard.biz/Coupons/Redemption');
										curl_setopt($curl,CURLOPT_HTTPHEADER,array('Token: 03dc5efd-3c07-41b8-bf6f-5bbc630e7b35'));
										//curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json; charset=utf-8'));
										
										//curl_setopt($curl, CURLOPT_PORT, 5000);
										 
										//включаем вывод заголовков
										curl_setopt($curl, CURLOPT_HEADER, 0);
										 
										//передаем данные по методу post
										curl_setopt($curl, CURLOPT_POST, 1);
										 
										//теперь curl вернет нам ответ, а не выведет
										curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
										 
										//переменные, которые будут переданные по методу post
										curl_setopt($curl, CURLOPT_POSTFIELDS, array("CouponId"=>"294","FromDate"=>$site['date_start'],"ToDate"=>$site['date_end']));
										//я не скрипт, я браузер опера
										//curl_setopt($curl, CURLOPT_USERAGENT, 'Opera 10.00');
										 
										$res = curl_exec($curl);
										
										curl_close($curl);
										$res=json_decode($res);
										$data=$res->Data->Summary[0];
										
										
										/*
										echo "<pre>"; 
																					print_r($data);
																				echo "</pre>";*/
										
										
										
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
										//scurl_close($curl);
										/*curl_setopt($curl, CURL;OPT_POSTFIELDS, array("CouponId"=>"294","FromDate"=>"11/20/2012","ToDate"=>"11/27/2012"));
																$res = curl_exec($curl);
																																$data=$res->Data->Summary[0];
																																print_r($data);
																																if(is_array($data))
																																$query=mysql_query('INSERT INTO z_coupons
																																(TotalCoupon,CouponsRedempt,RedemptionRatio,ActiveCoupons,CouponsExpired,ParticipantsCount,couponid) VALUES
																																('.$data['TotalCoupon'].','.$data['CouponsRedempt'].','.$data['RedemptionRatio'].','.$data['ActiveCoupons'].','.$data['CouponsExpired'].','.$data['ParticipantsCount'].',
																																'.$site['yocardid'].')');
																																			}
																
								  curl_close($curl);
				*/
				}
			
	echo date('Y-m-d h:i:s');		

?>