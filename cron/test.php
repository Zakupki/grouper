<?
error_reporting(1);
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
ini_set('display_errors', 1);
require_once "/var/www/groupo/group.reactor.ua/_reactor/classes/tools.php";
require_once "/var/www/groupo/group.reactor.ua/_reactor/classes/vkapi.php";
define('DEBUG',false);

$link1 = mysql_connect("localhost","u_groupd","4KIWvcEc");
mysql_select_db("groupd", $link1);
mysql_query("SET NAMES 'utf8'");

#VKONTAKTE
$query=mysql_query("
        SELECT
          z_group.id,
          z_group.gid,
          z_group.socialid,
          z_social_account.token
        FROM
          z_group
        INNER JOIN z_social_account
          ON z_social_account.`accountid`=z_group.`accountid` AND z_social_account.`socialid`=257
        ");
$yesterday=date('Y-m-d', strtotime(' -4 day'));
$cnt=0;
$tcnt=1;
$scnt=0;
while($group=mysql_fetch_assoc($query)){
    #Запрос количества подписчиков
    $Vkapi = new Vkapi();
    #groups.getMembers
    $resp=null;
    $resp = $Vkapi->api('groups.getMembers',
        array('gid'=>$group['gid'],
            'access_token'=>$group['token']
        ));
    $resp2=null;
    $resp2 = $Vkapi->api('stats.get',
        array('gid'=>$group['gid'],
            'access_token'=>$group['token'],
            'date_from'=>$yesterday,
            'date_to'=>$yesterday
        ));
    if($resp2)
        $scnt++;
    //tools::print_r($resp);

   /* if(isset($resp2['response'][0]['cities'])){
        foreach($resp2['response'][0]['cities'] as $city){
            $sql2='
                      SELECT
                        *
                      FROM
                        z_vkcity
                      WHERE z_vkcity.title="'.tools::str($city['name']).'"
                      ';
            $query2=mysql_query($sql2);

            if(!mysql_fetch_row($query2)){
                mysql_query('INSERT INTO z_vkcity (id,title) VALUES ('.tools::int($city['value']).',"'.tools::str($city['name']).'")');
            }
            mysql_query('INSERT INTO z_vkcity_visitors (vkcityid,visitors,date,groupid) VALUES ('.tools::int($city['value']).','.tools::int($city['visitors']).',"'.$yesterday.' 00:00:00", '.$group['id'].')');
        }
    }*/

    if(isset($resp2['response'][0]['age'])){
        foreach($resp2['response'][0]['age'] as $age){
            $sql3='
                          SELECT
                            *
                          FROM
                            z_vkage
                          WHERE z_vkage.title="'.tools::str($age['value']).'"
                          ';
            $query3=mysql_query($sql3);
            $result3=mysql_fetch_row($query3);
            //print_r($result3);
            if(!$result3){
                mysql_query('INSERT INTO z_vkage (title) VALUES ("'.tools::str($age['value']).'")');
                $new=mysql_fetch_row(mysql_query('SELECT LAST_INSERT_ID()'));
                if($new[0]>0)
                    $newid=$new[0];
            }
            else
                $newid=$result3[0];

            mysql_query('INSERT INTO z_vkage_visitors (vkageid,visitors,date,groupid) VALUES ('.tools::int($newid).','.tools::int($age['visitors']).',"'.$yesterday.' 00:00:00", '.$group['id'].')');
        }
    }
    $sql3='
               INSERT INTO z_social_stats
                   (socialid,groupid,date,value,views,visitors,subscribed,unsubscribed,f_visitors,m_visitors,reach,reach_subscribers)
               VALUES
                   ('.$group['socialid'].',
                    '.$group['id'].',
                    "'.$yesterday.' 00:00:00",
                    '.tools::int($resp['response']['count']).',
                    '.tools::int($resp2['response'][0]['views']).',
                    '.tools::int($resp2['response'][0]['visitors']).',
                    '.tools::int($resp2['response'][0]['subscribed']).',
                    '.tools::int($resp2['response'][0]['unsubscribed']).',
                    '.tools::int($resp2['response'][0]['sex'][0]['visitors']).',
                    '.tools::int($resp2['response'][0]['sex'][1]['visitors']).',
                    '.tools::int($resp2['response'][0]['reach']).',
                    '.tools::int($resp2['response'][0]['reach_subscribers']).'
                    )';
    //mysql_query($sql3);
    $cnt++;
    $tcnt++;
    //echo 1;
}
echo $scnt;
echo "<br>";
echo $cnt;
?>