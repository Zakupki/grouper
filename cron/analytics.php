<?	
	
	require_once "/var/www/reactorpro/reactor-pro.ru/_reactor/classes/tools.php";
	require_once "/var/www/reactorpro/reactor-pro.ru/googlephp/src/Google_Client.php";
	require_once "/var/www/reactorpro/reactor-pro.ru/googlephp/src/contrib/Google_PlusService.php";
	require_once "/var/www/reactorpro/reactor-pro.ru/googlephp/src/contrib/Google_AnalyticsService.php";
	$client = new Google_Client();
	$client->setApplicationName('Hello Analytics API Sample');
	
	// Visit //code.google.com/apis/console?api=analytics to generate your
	// client id, client secret, and to register your redirect uri.
	$client->setClientId('900009800982.apps.googleusercontent.com');
	$client->setClientSecret('7Zpis56B9TWYqEs_POnajLjQ');
	$client->setRedirectUri('http://clubsreport.com/HelloAnalyticsApi.php');
	$client->setDeveloperKey('AIzaSyCxsG1za2r06tPNyDya_JhGs41QrRpPPQE');
	$client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));
	
	// Magic. Returns objects from the Analytics Service instead of associative arrays.
	$client->setUseObjects(true);
	
	$client->setAccessToken('{"access_token":"ya29.AHES6ZQqJg_Odzre-CrZ8nJjAixHVjOJmp9grzQg8blugJI","token_type":"Bearer","expires_in":3600,"refresh_token":"1\/1tYm2MNl8Ojyz17-toRewJ5p7MThDBnry5YFp6YRsgU","created":1351782349}');
    $analytics = new Google_AnalyticsService($client);
	
	$link1 = mysql_connect("localhost","u_reactorp","yvbfasdhZ4p");
	mysql_select_db("reactorp", $link1);
	mysql_query("SET NAMES 'utf8'");
	
	$query=mysql_query("SELECT
	  z_site.id,
	  z_site.name,
	  z_domain.id AS domainid,
	  z_domain.name AS domain
	FROM
	  z_site
	  LEFT JOIN
	  z_domain
	  ON z_domain.siteid = z_site.id
	WHERE z_site.sitetypeid = 7
	  AND z_site.recommend = 1");
	  //while($row=mysql_fetch_array($result))
	  tools::print_r($resut);
	  
/*    echo "<pre>";
    print_r($result);
    echo "</pre>";*/


/*
echo '<table border="1">
		<tr><td></td><td>РЎРѓР В°Р в„–РЎвЂљ</td><td>Р С—Р С•РЎРѓР ВµРЎвЂ°Р ВµР Р…Р С‘Р в„–</td><td>РЎС“Р Р…Р С‘Р С”Р В°Р В»РЎРЉР Р…РЎвЂ№РЎвЂ¦</td></tr>';*/

	  $cnt=1;
	  $yesterday=date('Y-m-d',mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
	  //echo $yesterday."<br>";
	  
	  $checkday=mysql_fetch_assoc(mysql_query('SELECT * from z_analytics_day where date_start="'.$yesterday.' 00:00:00" LIMIT 0,1'));
	  if(!$checkday){
	  	echo 'данные за'.$yesterday;
	 	
	 while($site=mysql_fetch_assoc($query)){

		  	$filters[$site['id']]=array('ga:hostname==www.r'.$site['id'].'.reactor.ua','ga:hostname==r'.$site['id'].'.reactor.ua','ga:hostname==www.r'.$site['id'].'.reactor-pro.ru','ga:hostname==r'.$site['id'].'.reactor-pro.ru');
		  	if($site['domainid']>0){
			$filters[$site['id']][]='ga:hostname==www.'.$site['domain'];
			$filters[$site['id']][]='ga:hostname=='.$site['domain'];
			}
			
			$optParams = array(
		      'metrics' => 'ga:visits,ga:visitors',
		      'filters' => ''.implode(',',$filters[$site['id']]).'',
		      'max-results' => time());
			//  tools::print_r($optParams);
		   	$results=$analytics->data_ga->get(
		       'ga:65684985',
		       $yesterday,
		       $yesterday,
		       'ga:visits',
			   $optParams);
		 	$row=$results->getRows();
			
			$rest = mysql_query('INSERT INTO z_analytics_day (siteid,date_start,visits,visitors) VALUES ('.$site['id'].',"'.$yesterday.' 00:00:00",'.tools::int($row[0][0]).','.tools::int($row[0][1]).')');
			if (!$rest) {
			    die('Invalid query: ' . mysql_error());
			}
			 
			/*
			echo '
						<tr><td>'.$cnt.'</td><td>'.$site['name'].'</td><td>'.$row[0][0].'</td><td>'.$row[0][1].'</td></tr>';*/
			
		  $cnt++;
		  //break;
		  }
	  }else
	  echo 'уже есть данные за'.$yesterday;
	  
	  /*echo '</table>';*/

?>