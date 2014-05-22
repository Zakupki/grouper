<?
require_once 'modules/base/models/Basemodel.php';
require_once 'modules/report/models/Users.php';

Class Group Extends Basemodel {

	private $registry;
	public function __construct($registry){
		$this->registry=$registry;
	}

	public function getSubjects($filters){
        $db=db::init();
        if(count($filters['countries'])>0)
            $where=' AND z_group.countryid IN('.implode(',',$filters['countries']).')';
        if(count($filters['ageRange'])>0)
            $where.=' AND z_group.age BETWEEN '.tools::int($filters['ageRange'][0]).' AND '.tools::int($filters['ageRange'][1]).'';
        if($filters['groupsFilter']==2)
            $join='INNER JOIN z_favgroups
            ON z_favgroups.groupid=z_group.id AND z_favgroups.userid='.tools::int($_SESSION['User']['id']).'';
        if($filters['genderFilter']>0)
            $where.=' AND z_group.gender='.tools::int($filters['genderFilter']).'';
        if(count($filters['priceRange'])>0)
            $where.=' AND z_group.price BETWEEN '.tools::int($filters['priceRange'][0]).' AND '.tools::int($filters['priceRange'][1]).'';
        if(count($filters['subscribersRange'])>0){
            $where.=' AND z_social_stats.value BETWEEN '.tools::int($filters['subscribersRange'][0]).' AND '.tools::int($filters['subscribersRange'][1]).'';
        }
	    $result=$db->queryFetchAllAssoc('
	    SELECT 
	       z_groupsubject.id,
	       z_groupsubject.name,
	       count(z_group.id) as cnt
	    FROM z_groupsubject
	    INNER JOIN z_group
	    ON z_group.groupsubjectid=z_groupsubject.id  AND z_group.notconnected=0
	    INNER JOIN z_social_stats
            ON z_social_stats.groupid=z_group.id AND z_social_stats.date=(SELECT MAX(DATE) FROM z_social_stats)
	    '.$join.'
	    WHERE z_group.userid!='.tools::int($_SESSION['User']['id']).'
	    '.$where.'
        GROUP BY z_groupsubject.id
	    ');
        
        if($result)
        return $result;
    }
    public function getCountries($filters){
        $db=db::init();
        if(count($filters['topics'])>0)
        $where=' AND z_group.groupsubjectid IN('.implode(',',$filters['topics']).')';    
        if(count($filters['ageRange'])>0)
            $where.=' AND z_group.age BETWEEN '.tools::int($filters['ageRange'][0]).' AND '.tools::int($filters['ageRange'][1]).'';
        if($filters['groupsFilter']==2)
            $join='INNER JOIN z_favgroups
            ON z_favgroups.groupid=z_group.id AND z_favgroups.userid='.tools::int($_SESSION['User']['id']).'';
        if($filters['genderFilter']>0)
            $where.=' AND z_group.gender='.tools::int($filters['genderFilter']).'';
        if(count($filters['priceRange'])>0)
            $where.=' AND z_group.price BETWEEN '.tools::int($filters['priceRange'][0]).' AND '.tools::int($filters['priceRange'][1]).'';
        if(count($filters['subscribersRange'])>0){
            $where.=' AND z_social_stats.value BETWEEN '.tools::int($filters['subscribersRange'][0]).' AND '.tools::int($filters['subscribersRange'][1]).'';
        }
        $result=$db->queryFetchAllAssoc('
        SELECT 
           z_country.id,
           z_country.name_ru as name,
           count(z_group.id) as cnt
        FROM z_country
        INNER JOIN z_group
        ON z_group.countryid=z_country.id  AND z_group.notconnected=0
        INNER JOIN z_social_stats
            ON z_social_stats.groupid=z_group.id AND z_social_stats.date=(SELECT MAX(DATE) FROM z_social_stats)
        '.$join.'
        WHERE z_group.userid!='.tools::int($_SESSION['User']['id']).'
        '.$where.'
        GROUP BY z_country.id
        ');
        
        if($result)
        return $result;
    }
    public function getGenderFilters($filters){
        $db=db::init();
        if(count($filters['countries'])>0)
            $where=' AND z_group.countryid IN('.implode(',',$filters['countries']).')';
        if(count($filters['topics'])>0)
            $where=' AND z_group.groupsubjectid IN('.implode(',',$filters['topics']).')';
        if(count($filters['ageRange'])>0)
            $where.=' AND z_group.age BETWEEN '.tools::int($filters['ageRange'][0]).' AND '.tools::int($filters['ageRange'][1]).'';
        if($filters['groupsFilter']==2)
            $join='INNER JOIN z_favgroups
            ON z_favgroups.groupid=z_group.id AND z_favgroups.userid='.tools::int($_SESSION['User']['id']).'';
        if(count($filters['priceRange'])>0)
            $where.=' AND z_group.price BETWEEN '.tools::int($filters['priceRange'][0]).' AND '.tools::int($filters['priceRange'][1]).'';
        IF(COUNT($filters['subscribersRange'])>0){
            $where.=' AND z_social_stats.value BETWEEN '.tools::INT($filters['subscribersRange'][0]).' AND '.tools::INT($filters['subscribersRange'][1]).'';
        }
        $result=$db->queryFetchRowAssoc('
        SELECT
        SUM(IF(z_group.gender=1,1,0)) AS male,
        SUM(IF(z_group.gender=2,1,0)) AS female
        FROM z_group
        INNER JOIN z_social_stats
            ON z_social_stats.groupid=z_group.id AND z_social_stats.date=(SELECT MAX(DATE) FROM z_social_stats)
        '.$join.'
        WHERE z_group.userid!='.tools::int($_SESSION['User']['id']).'  AND z_group.notconnected=0
        '.$where.'
        ');
        if($result)
        return $result;
    }
    public function getOthergroups($filters){
        $db=db::init();
        if(count($filters['topics'])>0)
            $where.=' AND z_group.groupsubjectid IN('.implode(',',$filters['topics']).')';
        if(count($filters['countries'])>0)
            $where.=' AND z_group.countryid IN('.implode(',',$filters['countries']).')';
        if(count($filters['ageRange'])>0)
            $where.=' AND z_group.age BETWEEN '.tools::int($filters['ageRange'][0]).' AND '.tools::int($filters['ageRange'][1]).'';
        if($filters['genderFilter']>0)
            $where.=' AND z_group.gender='.tools::int($filters['genderFilter']).'';
        if(count($filters['priceRange'])>0)
            $where.=' AND z_group.price BETWEEN '.tools::int($filters['priceRange'][0]).' AND '.tools::int($filters['priceRange'][1]).'';

        if(count($filters['subscribersRange'])>0){
           $where.=' AND z_social_stats.value BETWEEN '.tools::int($filters['subscribersRange'][0]).' AND '.tools::int($filters['subscribersRange'][1]).'';
        }
        $result=$db->queryFetchAllFirst('
        SELECT 
           count(z_group.id)
        FROM z_group
        INNER JOIN z_social_stats
            ON z_social_stats.groupid=z_group.id AND z_social_stats.date=(SELECT MAX(date) from z_social_stats)
        WHERE z_group.userid!='.tools::int($_SESSION['User']['id']).' AND z_group.notconnected=0
        '.$where.'
        ');
      /*  echo ('
        SELECT
           count(z_group.id)
        FROM z_group
        INNER JOIN z_social_stats
            ON z_social_stats.groupid=z_group.id AND z_social_stats.date=(SELECT MAX(date) from z_social_stats)
        WHERE z_group.userid!='.tools::int($_SESSION['User']['id']).'
        '.$where.'
        ');*/
        if($result[0])
        return $result[0];
    }
    public function getOtherfavgroups($filters){
        $db=db::init();
        if(count($filters['topics'])>0)
            $where.=' AND z_group.groupsubjectid IN('.implode(',',$filters['topics']).')';
        if(count($filters['countries'])>0)
            $where.=' AND z_group.countryid IN('.implode(',',$filters['countries']).')';
        if(count($filters['ageRange'])>0)
            $where.=' AND z_group.age BETWEEN '.tools::int($filters['ageRange'][0]).' AND '.tools::int($filters['ageRange'][1]).'';
        if($filters['genderFilter']>0)
            $where.=' AND z_group.gender='.tools::int($filters['genderFilter']).'';
        if(count($filters['priceRange'])>0)
            $where.=' AND z_group.price BETWEEN '.tools::int($filters['priceRange'][0]).' AND '.tools::int($filters['priceRange'][1]).'';
        if(count($filters['subscribersRange'])>0){
            $where.=' AND z_social_stats.value BETWEEN '.tools::int($filters['subscribersRange'][0]).' AND '.tools::int($filters['subscribersRange'][1]).'';
        }
        $result=$db->queryFetchAllFirst('
        SELECT 
           count(z_group.id)
        FROM z_group
        INNER JOIN z_favgroups
            ON z_favgroups.groupid=z_group.id AND z_favgroups.userid='.tools::int($_SESSION['User']['id']).'
        INNER JOIN z_social_stats
            ON z_social_stats.groupid=z_group.id AND z_social_stats.date=(SELECT MAX(DATE) FROM z_social_stats)
        WHERE z_group.userid!='.tools::int($_SESSION['User']['id']).'
        '.$where.'
        ');
        if($result[0])
        return $result[0];
    }
    public function getAgerange($filters){
        $db=db::init();
        if(count($filters['topics'])>0)
            $where.=' AND z_group.groupsubjectid IN('.implode(',',$filters['topics']).')';
        if(count($filters['countries'])>0)
            $where.=' AND z_group.countryid IN('.implode(',',$filters['countries']).')';
        if($filters['groupsFilter']==2)
            $join='INNER JOIN z_favgroups
            ON z_favgroups.groupid=z_group.id AND z_favgroups.userid='.tools::int($_SESSION['User']['id']).'';
        if($filters['genderFilter']>0)
            $where.=' AND z_group.gender='.tools::int($filters['genderFilter']).'';
        if(count($filters['priceRange'])>0)
            $where.=' AND z_group.price BETWEEN '.tools::int($filters['priceRange'][0]).' AND '.tools::int($filters['priceRange'][1]).'';
        if(count($filters['subscribersRange'])>0){
            $where.=' AND z_social_stats.value BETWEEN '.tools::int($filters['subscribersRange'][0]).' AND '.tools::int($filters['subscribersRange'][1]).'';
        }
        $result=$db->queryFetchRowAssoc('
        SELECT 
        MIN(z_group.age) AS agemin,
        MAX(z_group.age) AS agemax
        FROM z_group
        INNER JOIN z_social_stats
            ON z_social_stats.groupid=z_group.id AND z_social_stats.date=(SELECT MAX(DATE) FROM z_social_stats)
        '.$join.'
        WHERE z_group.userid!='.tools::int($_SESSION['User']['id']).'  AND z_group.notconnected=0
        '.$where.'
        ');

        if($result)
        return $result;
    }
    public function getPricerange($filters){
        $db=db::init();

        if(count($filters['topics'])>0 && $filters['groupsFilter']!=3)
            $where.=' AND z_group.groupsubjectid IN('.implode(',',$filters['topics']).')';
        if(count($filters['countries'])>0 && $filters['groupsFilter']!=3)
            $where.=' AND z_group.countryid IN('.implode(',',$filters['countries']).')';
        if(count($filters['ageRange'])>0 && $filters['groupsFilter']!=3)
            $where.=' AND z_group.age BETWEEN '.tools::int($filters['ageRange'][0]).' AND '.tools::int($filters['ageRange'][1]).'';

        if($filters['groupsFilter']==2)
            $join='INNER JOIN z_favgroups
            ON z_favgroups.groupid=z_group.id AND z_favgroups.userid='.tools::int($_SESSION['User']['id']).'';
        elseif($filters['groupsFilter']==3 && count($filters['specialGroups'])>0)
            $where.=' AND z_group.id IN('.implode(',',$filters['specialGroups']).')';
        if($filters['genderFilter']>0 && $filters['groupsFilter']!=3)
            $where.=' AND z_group.gender='.tools::int($filters['genderFilter']).'';
        if($filters['type']=='repost')
            $selectSql='
            FLOOR(MIN(z_group.pricerepost)) AS pricemin,
            FLOOR(MAX(z_group.pricerepost)) AS pricemax,
            SUM(z_group.pricerepost) pricetotal';
        else
            $selectSql='
            FLOOR(MIN(z_group.price)) AS pricemin,
            FLOOR(MAX(z_group.price)) AS pricemax,
            SUM(z_group.price) pricetotal';

        $result=$db->queryFetchRowAssoc('
        SELECT 
        '.$selectSql.'
        FROM z_group
        '.$join.'
        WHERE z_group.userid!='.tools::int($_SESSION['User']['id']).'  AND z_group.notconnected=0
        '.$where.'
        ');
        if($filters['groupsFilter']==3 && count($filters['specialGroups'])<1)
            $result=array('pricemin'=>0,'pricemax'=>0,'pricetotal'=>0);
        $result['balance']=$_SESSION['User']['money'];
        if($result)
        return $result;
    }
    public function getStatsrange($filters){
        $db=db::init();
        if(count($filters['topics'])>0 && $filters['groupsFilter']!=3)
            $where.=' AND z_group.groupsubjectid IN('.implode(',',$filters['topics']).')';
        if(count($filters['countries'])>0 && $filters['groupsFilter']!=3)
            $where.=' AND z_group.countryid IN('.implode(',',$filters['countries']).')';
        if(count($filters['ageRange'])>0 && $filters['groupsFilter']!=3)
            $where.=' AND z_group.age BETWEEN  '.tools::int($filters['ageRange'][0]).' AND '.tools::int($filters['ageRange'][1]).'';
        if($filters['groupsFilter']==2)
            $join='INNER JOIN z_favgroups
            ON z_favgroups.groupid=z_group.id AND z_favgroups.userid='.tools::int($_SESSION['User']['id']).'';
        elseif($filters['groupsFilter']==3 && count($filters['specialGroups'])>0)
            $where.=' AND z_social_stats.groupid IN('.implode(',',$filters['specialGroups']).')';
        if($filters['genderFilter']>0 && $filters['groupsFilter']!=3)
            $where.=' AND z_group.gender='.tools::int($filters['genderFilter']).'';
        if(count($filters['priceRange'])>0 && $filters['groupsFilter']!=3)
            $where.=' AND z_group.price BETWEEN '.tools::int($filters['priceRange'][0]).' AND '.tools::int($filters['priceRange'][1]).'';
        $date=$db->queryFetchAllFirst('
        SELECT 
            MAX(z_social_stats.DATE)
        FROM
            z_social_stats');
        $db=db::init();    
        $result=$db->queryFetchRowAssoc('              
        SELECT 
          MAX(z_social_stats.VALUE) AS statsmax,
          MIN(z_social_stats.VALUE) AS statsmin,
          SUM(z_social_stats.VALUE) statstotal
        FROM
          `z_social_stats`
        INNER JOIN z_group
        ON z_social_stats.groupid=z_group.id  AND z_group.notconnected=0
        '.$join.'
        WHERE z_social_stats.DATE = "'.$date[0].'"
        AND z_group.userid!='.tools::int($_SESSION['User']['id']).'
        '.$where.'
        ');
        if($filters['groupsFilter']==3 && count($filters['specialGroups'])<1)
            $result=array('statsmax'=>0,'statsmin'=>0,'statstotal'=>0);
        if($result)
        return $result;
    }
    public function getFilters($filters){
        $data['allgroups']=intval(self::getOthergroups($filters));
        $data['favgroups']=intval(self::getOtherfavgroups($filters));
        $data['topics']=self::getSubjects($filters);
        $data['countries']=self::getCountries($filters);
        $data['genderFilter']=self::getGenderFilters($filters);
        $data['ageRange']=self::getAgerange($filters);
        $data['priceRange']=self::getPricerange($filters);
        $date['repostPriceRange']=self::getPricerange($filters);
        $data['subscribersRange']=self::getStatsrange($filters);
        return $data;
    }
	public function getGroups($params=array()){
        if($params['take']<1)
            $params['take']=20;
        if($params['start']<1)
            $params['start']=0;

        if($params['listtype']==3)
		    $favJoinType='INNER';
        else
            $favJoinType='LEFT';
        if($params['listtype']==2)
            $whereStr.='AND z_group.userid='.tools::int($_SESSION['User']['id']);

        $params['take']++;


		$db=db::init();
        

		$oderStr='ORDER BY z_social_stats.value DESC';
				//$take=$take+1;
				
				if($params['sort']=="age"){
					if($params['dir']=='asc')
					$oderStr='ORDER BY z_group.age ASC';
					if($params['dir']=='desc')
					$oderStr='ORDER BY z_group.age DESC';
				}
				if($params['sort']=="price"){
					if($params['dir']=='asc')
					$oderStr='ORDER BY z_group.price ASC';
					if($params['dir']=='desc')
					$oderStr='ORDER BY z_group.price DESC';
				}
				if($params['sort']=="contactprice"){
					if($params['dir']=='asc')
					$oderStr='ORDER BY `contactprice` ASC';
					if($params['dir']=='desc')
					$oderStr='ORDER BY `contactprice` DESC';
				}
				if($params['sort']=="likes"){
					if($params['dir']=='asc')
					$oderStr='ORDER BY z_social_stats.value ASC';
					if($params['dir']=='desc')
					$oderStr='ORDER BY z_social_stats.value DESC';
				}
              	if($params['groupsubject']>0){
					$whereStr=' AND z_group.groupsubjectid='.tools::int($params['groupsubject']).' ';
				}
		$date=$db->queryFetchRowAssoc('SELECT 
                      MAX(z_social_stats.DATE) as date
                    FROM
                      z_social_stats');
		$result=$db->queryFetchAllAssoc('SELECT 
                      z_group.name as name,
                      z_group.url,
                      z_group.id,
                      z_group.gid,
                      z_group.code,
                      z_group.socialid,
                      z_group.notconnected,
                      z_group.userid,
                      z_social_stats.value AS likes,
                      z_group.price/z_social_stats.value AS `contactprice`,
                      z_group.age,
                      z_group.price,
                      z_groupsubject.name as subject,
                      CONCAT(
                           "/uploads/users/",
                           z_group.userid,
                           "/img/12_",
                           z_group.file_name
                         ) AS logo,
                      CONCAT(
                           "/uploads/users/",
                           z_group.userid,
                           "/img/13_",
                           z_group.file_name
                         ) AS logogray,
                      z_favgroups.id AS favourite
                    FROM
                      z_group
                    INNER JOIN z_groupsubject
                    ON z_groupsubject.id=z_group.groupsubjectid
                    LEFT JOIN z_social_stats
                    ON z_social_stats.groupid=z_group.id AND z_social_stats.date="'.$date['date'].'"
                    '.$favJoinType.' JOIN z_favgroups
                    ON z_favgroups.groupid=z_group.id AND z_favgroups.userid='.tools::int($_SESSION['User']['id']).'
                    WHERE
                    1=1
                    '.$whereStr.'
                    '.$oderStr.'
                    LIMIT '.$params['start'].','.$params['take'].'
                    ');

		if(count($result)>($params['take']-1)){
		$hasmore=1;
		unset($result[count($result)-1]);
		}
		
		foreach($result as $club){
			$clubid[$club['id']]=$club['id'];
		}
		if($result)
		return array('sites'=>$result,'data'=>$out,'hasmore'=>$hasmore);
		
	}
	
	public function getGroupscount($type=1, $is_user=false){
	        
	    if($is_user)
        $whereSql.='AND z_group.userid='.tools::int($_SESSION['User']['id']);
		$favjoin=array(1=>'LEFT',2=>'INNER');
		$db=db::init();
		$result=$db->queryFetchAllFirst('
							SELECT 
							  COUNT(z_group.id)
							FROM
							  z_group 
							'.$favjoin[$type].' JOIN z_favgroups
							ON z_favgroups.groupid=z_group.id AND z_favgroups.userid='.tools::int($_SESSION['User']['id']).'
							WHERE 1=1 '.$whereSql.' AND z_group.notconnected=0
							');
		
		if($result[0])
		return $result[0];
	}
	public function getGroupsfav(){
		$db=db::init();
		$result=$db->queryFetchAllFirst('
					SELECT 
					  COUNT(z_favgroups.groupid)
					FROM
					  z_favgroups
					INNER JOIN z_group
					ON z_group.id=z_favgroups.groupid
					WHERE z_favgroups.userid='.tools::int($_SESSION['User']['id']).'
					');
		if($result[0])
		return $result[0];
	}
    public function findGroup($name){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_group.id,
					  z_group.name as value,
					  z_group.name as label,
					  concat("http://vk.com/",z_group.code) AS url
					FROM
					  z_group
					INNER JOIN z_social_stats
                        ON z_social_stats.groupid=z_group.id AND z_social_stats.date=(SELECT MAX(DATE) FROM z_social_stats)
					WHERE z_group.NAME LIKE "%'.tools::str($name).'%"  AND z_group.notconnected=0
					ORDER BY z_group.NAME
					');
		if($result)
		return $result;
	}
	public function getGroupsGa($id){
		$db=db::init();
		if($id)
		$result=$db->queryFetchAllFirst('
					SELECT 
					  SUM(z_analytics_day.visits) 
					FROM
					  z_analytics_day 
					WHERE z_analytics_day.`siteid` IN ('.$id.') 
					  AND z_analytics_day.`date_start` = 
					  (SELECT 
					    MAX(z_analytics_day.date_start) 
					  FROM
					    z_analytics_day)
					');
		if($result[0])
		return $result[0];
	}
	public function getGroupsGrp($id){
		$db=db::init();
		if($id)
		$result=$db->queryFetchAllFirst('
					SELECT 
					  SUM(z_social_stats.value)
					FROM
					  z_social_stats 
					WHERE z_social_stats.`groupid` IN ('.$id.')
					 AND z_social_stats.date = 
					 (SELECT 
					   MAX(z_social_stats.date) 
					 FROM
					   z_social_stats) 
					');
		if($result[0])
		return $result[0];
	}
	public function addToFav($data){
		$db=db::init();
		if($data['action']=='add')
		$db->exec('INSERT INTO z_favgroups (groupid,userid) VALUES ('.tools::int($data['id']).','.tools::int($_SESSION['User']['id']).')');
		elseif($data['action']=='remove')
		$db->exec('DELETE FROM z_favgroups WHERE  groupid='.tools::int($data['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
	}
	public function getVistors(){
		/*$db=db::init();
		$result=$db->queryFetchAllFirst('
		SELECT SUM(visits) FROM `z_clubform`');
		if($result[0])
		return $result[0];*/
	}
	public function getFollowers(){
		$db=db::init();
		$result=$db->queryFetchAllFirst('
		SELECT 
		  SUM(VALUE) 
		FROM
		  `z_social_stats`
		INNER JOIN z_group
		ON z_group.id=z_social_stats.groupid AND z_group.notconnected=0
		WHERE `date` IN 
		  (SELECT 
		    MAX(`date`) 
		  FROM
		    `z_social_stats`)');
		if($result[0])
		return $result[0];
	}
    public function save($data,$files){
        $db=db::init();
        
        if($data['url_deleted']){
        tools::delImg($data['url_deleted']);
        $update_file=', file_name=NULL';
        }
        
        if($data['remoteimage']==1){
            $image=tools::GetImageFromUrl($data['image']);
        }else{
          $image=str_replace("12_","",$data['image']);
        }
        $newfile='NULL';
        $tempfile="".$_SERVER['DOCUMENT_ROOT'].$image."";
        
        if(file_exists($tempfile)){
            $image=pathinfo($image);
            $newfile=md5(uniqid().microtime()).'.'.$image['extension'];
            if(rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/users/".tools::int($_SESSION['User']['id'])."/img/".$newfile.""))
            {
                $update_file=', file_name="'.tools::str($newfile).'"';
                $newfile='"'.$newfile.'"';
            }
            else
                $newfile='NULL';
            
        }
        if($data['groupsubjectid']>0)
        $groupsubjectid=tools::int($data['groupsubjectid']);
        else $groupsubjectid='"NULL"';
         if($data['countryid']>0)
        $countryid=tools::int($data['countryid']);
        else $countryid='"NULL"';
        
        if($data['gender']<1)
        $data['gender']=0;
        else 
        $data['gender']=1;
        
        if($data['id']<1){

            $result=$db->exec('
            INSERT INTO z_group
            (name,age,price,pricerepost,gid,code,type,screen_name,socialid,accountid,userid,groupsubjectid,countryid,gender,file_name) VALUES (
            "'.tools::str($data['name']).'",
            "'.tools::str($data['age']).'",
            "'.tools::str($data['price']).'",
            "'.tools::str($data['pricerepost']).'",
            '.tools::str($data['gid']).',
            "'.tools::str($data['code']).'",
            "'.tools::str($data['type']).'",
            "'.tools::str($data['screen_name']).'",
            '.tools::str($data['socialid']).',
            "'.tools::str($data['accountid']).'",
            '.tools::int($_SESSION['User']['id']).',
            '.$groupsubjectid.',
            '.$countryid.',
            '.$data['gender'].',
            '.$newfile.'
            )
        ');

        if($result)
        $data['id']=$db->lastInsertId();
        
        $members=self::loadGroupMemberNum($data['url']);
        
        if($members>0 && $data['id']>0){
            $datemax=$db->queryFetchAllFirst('SELECT MAX(date) from z_social_stats');
            $result=$db->exec('
            INSERT INTO z_social_stats 
                (socialid,groupid,date,value) 
            VALUES 
            (257,'.$data['id'].',"'.$datemax[0].'",'.tools::int($members).')
            ');
        }
        
        
        }else{
            $db->exec('UPDATE z_group
            SET name="'.tools::str($data['name']).'",
            age="'.tools::int($data['age']).'",
            price="'.tools::str($data['price']).'",
            pricerepost="'.tools::str($data['pricerepost']).'",
            groupsubjectid='.$groupsubjectid.',
            countryid='.$countryid.',
            gender='.$data['gender'].'
            '.$update_file.'
            WHERE id='.tools::int($data['id']).'
            ');
        }
        
        
        if($data['id']>0)
        return $data['id'];
        
    }

     public function delete($id){
        $db=db::init();
        $result=$db->exec('DELETE FROM z_group
        WHERE id='.tools::int($id).' AND userid='.tools::int($_SESSION['User']['id']).'');
        if($result)
        return $result;
     }
     public function findAll($data){
        $db=db::init();
        
        foreach($data as $k=>$v)
        $whereArr[]=$k.'='.$v;
        
        $result=$db->queryFetchAllObj('
            SELECT t.*, CONCAT("/uploads/users/",t.userid,"/img/12_",t.file_name) as photo_big FROM z_group as t
            WHERE '.implode(' AND ', $whereArr).'
        ');
        if($result)
        return $result;
    }
      public function find($data){
        $db=db::init();
        
        foreach($data as $k=>$v)
        $whereArr[]=$k.'='.$v;
        
        $result=$db->queryFetchObj('
            SELECT t.*,CONCAT("/uploads/users/",t.userid,"/img/12_",t.file_name) as photo_big FROM z_group as t
            WHERE '.implode(' AND ', $whereArr).'
        ');
        if($result)
        return $result;
    }

    public function checkGroup($data){

        $social=new Social;
        $data['url']=trim($data['url']);
        $socdata=$social->findSocial($data['url']);
        $returndata = new stdClass();
        //print_r($socdata['id']);
        if(in_array($socdata['id'],array(341))){

            $returndata->socialid=$socdata['id'];
            $returndata->url=$data['url'];
            $returndata->gid=123;

        }elseif(in_array($socdata['id'],array(257))){

            $returndata=self::getVkData(array('url'=>$data['url']));

        }elseif(in_array($socdata['id'],array(255))){

            $returndata=self::getFbData(array('url'=>$data['url']));

        }else{

            $returndata->socialid=$socdata['id'];
            $returndata->url=$data['url'];
            $returndata->gid=123;

        }

        //print_r($returndata);

        return $returndata;



    }
    public function groupExist($id,$socialid){
        $db=db::init();
        $data=$db->queryFetchAll('SELECT id from z_group WHERE gid='.$id.' AND socialid='.tools::int($socialid).'');
        return $data;
    }
    public function getFullData($id){

    }
    public function getGroupTypes($params=array()){
        if($params['listtype']==3){
            $join='
            INNER JOIN z_favgroups ON z_favgroups.groupid=z_group.id AND z_favgroups.userid='.tools::int($_SESSION['User']['id']);
        }

        $db=db::init();
        $result=$db->queryFetchAllAssoc('
                    SELECT 
                      z_groupsubject.id,
                      z_groupsubject.name
                    FROM
                      z_groupsubject
                    INNER JOIN z_group
                      ON z_group.groupsubjectid=z_groupsubject.id  AND z_group.notconnected=0
                    '.$join.'
                    GROUP BY z_groupsubject.id
                    ');
        if($result)
        return $result;
    }
    public function loadGroupMemberNum($url){
                        $url=trim($url);
          
                         if(preg_match('%^
                            (?:https?://)
                            (?:
                            www\.
                            )?      # Optional www subdomain
                            (?:             # Group host alternatives
                              vk\.com/  # or youtube.com
                            | vkontakte\.ru/ 
                            )
                                                            club(\d+)
                            %xui', $url, $match))
                            $id=$match[1];
                        elseif(preg_match('%^
                            (?:https?://)
                            (?:
                            www\.
                            )?      # Optional www subdomain
                            (?:             # Group host alternatives
                              vk\.com/  # or youtube.com
                            | vkontakte\.ru/
                            )
                            public(\d+)
                            %xui', $url, $match))
                            $id=$match[1];
                        elseif(preg_match('%^
                            (?:https?://)
                            (?:
                            www\.
                            )?      # Optional www subdomain
                            (?:             # Group host alternatives
                            vk\.com/  # or youtube.com
                            | vkontakte\.ru/
                            )
                            ([\w\d_.-]+)?
                            %xui', $url, $match))
                            $id=$match[1];
          if($id){
                $sUrl='https://api.vk.com/method/groups.getMembers?gid='.$id.'&access_token=a1173ba0be6f05b7127fae01cfceaeaebea18f5ffb76931a3492b8a06a07e259e91b34c37212079be16d7';
                //создадим объект, содержащий ответ сервера Вконтакте, который приходит в формате JSON
                $oResponce=null;
                $oResponce = json_decode(file_get_contents($sUrl));
                if($oResponce->error->error_code>0){
                        
                }else{
                return $oResponce->response->count;         
                }
          }
        return false;
    }
    public function getGraphData($id){
            $db=db::init();
            $date=$db->queryFetchFirst('SELECT MAX(`date`) FROM `z_social_stats` WHERE groupid='.tools::int($id));
            $total=$db->queryFetchFirst('SELECT SUM(z_vkcity_visitors.`visitors`) FROM `z_vkcity_visitors` WHERE z_vkcity_visitors.`groupid` = '.tools::int($id).' AND z_vkcity_visitors.date="'.$date.'"');
            $citydata=$db->queryFetchAllAssoc('
                                              SELECT
                                                SUM(z_vkcity_visitors.`visitors`) AS visitors,
                                                z_vkcity.`title`
                                              FROM
                                                `z_vkcity_visitors`
                                              INNER JOIN z_vkcity
                                                ON z_vkcity.`id` = z_vkcity_visitors.vkcityid
                                              WHERE z_vkcity_visitors.`groupid` = '.tools::int($id).' AND z_vkcity_visitors.date="'.$date.'"
                                              GROUP BY z_vkcity_visitors.vkcityid
                                              ORDER BY visitors DESC
                                              LIMIT 0,5
                                              ');
        $statsdata=$db->queryFetchRowAssoc('
                                              SELECT
                                                  *
                                              FROM
                                                 `z_social_stats`
                                              WHERE z_social_stats.`groupid` = '.tools::int($id).' AND z_social_stats.date="'.$date.'"
                                             ');
        $statsdatamonth=$db->queryFetchAllAssoc('
                                              SELECT
                                                  DATE_FORMAT(z_social_stats.date,"%Y-%m-%d") AS date,
                                                  z_social_stats.visitors,
                                                  z_social_stats.views,
                                                  z_social_stats.reach,
                                                  z_social_stats.reach_subscribers
                                              FROM
                                                 `z_social_stats`
                                              WHERE z_social_stats.`groupid` = '.tools::int($id).' AND z_social_stats.date BETWEEN  "'.date('Y-m-d', strtotime(' -1 month')).' 00:00:00" AND "'.$date.'"
                                             ');
        $agedata=$db->queryFetchAllAssoc('
                                            SELECT
                                              SUM(`z_vkage_visitors`.`visitors`) AS visitors,
                                              `z_vkage`.`title`
                                            FROM
                                              `z_vkage_visitors`
                                              INNER JOIN z_vkage
                                                ON z_vkage.`id` = z_vkage_visitors.vkageid
                                            WHERE z_vkage_visitors.`groupid` = '.tools::int($id).'
                                              AND z_vkage_visitors.date = "'.$date.'"
                                            GROUP BY z_vkage_visitors.vkageid
                                            ORDER BY `z_vkage`.`title` ASC
                                            LIMIT 0,6
                                              ');
           foreach($citydata as $city){
               $cityArr[]=array($city['title'],ceil(($city['visitors']/$total)*100));
               $totalcitypercent=$totalcitypercent+ceil(($city['visitors']/$total)*100);
           }
           $cityArr[]=array("Другие",100-$totalcitypercent);;
           usort($cityArr, "tools::keyOneSort");
        foreach($agedata as $age){
            $totalagevisitors=$totalagevisitors+$age['visitors'];
        }
        $out='{
                 "avg_reach": "0",
                 "avg_views": "144",
                 "reach": [
                     {"values": [';
                    foreach($statsdatamonth as $dat){
                        $out.='["'.$dat['date'].'", '.tools::int($dat['reach']).'],';
                    }
                    $out.='
                           ],
                      "title": "Охват"},
                     {"values": [';
                    foreach($statsdatamonth as $dat){
                        $out.='["'.$dat['date'].'", '.tools::int($dat['reach_subscribers']).'],';
                    }
                    $out.='
                           ],
                      "title": "\u041e\u0445\u0432\u0430\u0442 \u043f\u043e \u043f\u043e\u0434\u043f\u0438\u0441\u0447\u0438\u043a\u0430\u043c"}],
                 "ages": [';
        foreach($agedata as $age){
            $age['visitors']=($age['visitors']/$totalagevisitors)*100;
            if($age['visitors']>0){

            }else
                $age['visitors']=0;

            $out.='["'.$age['title'].'", '.$age['visitors'].'],';
        }
        $out.='
                          ],
                 "visits": [
                            {"values": [';
                    foreach($statsdatamonth as $dat){
                        $out.='["'.$dat['date'].'", '.tools::int($dat['visitors']).'],';
                    }
                        $out.='
                           ],
                             "title": "Посетители"
                            },
                            {"values": [';
                    foreach($statsdatamonth as $dat){
                        $out.='["'.$dat['date'].'", '.tools::int($dat['views']).'],';
                    }
                    $out.='
                           ],
                             "title": "Просмотры"
                            }
                           ],
                 "sex": [["Женщины", '.tools::int($statsdata['f_visitors']).'], ["Мужчины", '.tools::int($statsdata['m_visitors']).']],
                 "stat_avg_cpm": 0,
                 "avg_reach_sub": "0",
                 "cities": [';
        foreach($cityArr as $c){
            $out.='["'.$c[0].'", '.$c[1].'],';
        }
        $out.='
                            ],
                 "stat_avg_reach_sub_by_orders": 0,
                 "avg_visitors": "46"
                }
                ';
    return $out;
    }
    public function getGroupInner($id){
        $db=db::init();
        $result=$db->queryFetchRowAssoc('
	    SELECT
	       *
	    FROM z_group
	    WHERE z_group.id='.tools::int($id).'
	    ');
        return $result;
    }
    public function getVkData($params=array()){
        $socialid=257;
        if(preg_match('%^
                (?:https?://)
                (?:
                www\.
                )?      # Optional www subdomain
                (?:             # Group host alternatives
                  vk\.com/  # or youtube.com
                | vkontakte\.ru/
                )

                club(\d+)
                %xui', $params['url'], $match)){
        }
        elseif(preg_match('%^
                (?:https?://)
                (?:
                www\.
                )?      # Optional www subdomain
                (?:             # Group host alternatives
                  vk\.com/  # or youtube.com
                | vkontakte\.ru/
                )
                public(\d+)
                %xui', $params['url'], $match))
        {
        }
        elseif(preg_match('%^
                (?:https?://)
                (?:
                www\.
                )?      # Optional www subdomain
                (?:             # Group host alternatives
                vk\.com/  # or youtube.com
                | vkontakte\.ru/
                )
                ([\w\d_.-]+)?
                %xui', $params['url'], $match))
        {
        }
        $id=$match[1];

        if($id){
            $sUrl='https://api.vk.com/method/groups.getById?gid='.$id.'&access_token=a1173ba0be6f05b7127fae01cfceaeaebea18f5ffb76931a3492b8a06a07e259e91b34c37212079be16d7';
            //создадим объект, содержащий ответ сервера Вконтакте, который приходит в формате JSON
            $oResponce=null;
            $oResponce = json_decode(file_get_contents($sUrl));
            if($oResponce->error->error_code>0){

            }else{
                //$this->Users=new Users;
                //$socgroups=$this->Users->getUserSocialGroups();
                if(self::groupExist($oResponce->response[0]->gid,$socialid))
                    die('"Такая группа уже есть в базе"');
                /*if(array_key_exists($oResponce->response[0]->gid,$socgroups[257]))
                {*/
                if($oResponce->response[0]->type=='group' || $oResponce->response[0]->type=='page'){
                    //$oResponce->response[0]->accountid=$socgroups[257][$oResponce->response[0]->gid]['accountid'];
                    //$oResponce->response[0]->token=$socgroups[257][$oResponce->response[0]->gid]['token'];
                    $oResponce->response[0]->socialid=$socialid;
                    return $oResponce->response[0];
                    /*}*/
                }
            }
        }
    }
    public function getFbData($params=array()){
        if(preg_match('%^
                (?:https?://)
                (?:
                www\.
                )?      # Optional www subdomain
                (?:             # Group host alternatives
                vk\.com/  # or youtube.com
                | facebook\.com/
                )
                ([\w\d_.-]+)?
                %xui', $params['url'], $match))
        {
            $socialid=255;
            $id=$match[1];
        }
        if($id){
            $sUrl='https://graph.facebook.com/v1.0/'.$id;
            //создадим объект, содержащий ответ сервера Вконтакте, который приходит в формате JSON
            $oResponce=null;
            $oResponce = json_decode(file_get_contents($sUrl));
            if($oResponce->id>0){
                if(self::groupExist($oResponce->id,$socialid))
                    die('"Такая группа уже есть в базе"');
                $oResponce->socialid=$socialid;
                $oResponce->gid=$oResponce->id;
                $oResponce->screen_name=$oResponce->username;
                $oResponce->photo_big=$oResponce->cover->source;

                $picUrl='https://graph.facebook.com/'.$oResponce->id.'/?fields=picture.type(large)';
                //создадим объект, содержащий ответ сервера Вконтакте, который приходит в формате JSON
                $picResponce=null;
                $picResponce = json_decode(file_get_contents($picUrl));
                if(isset($picResponce->picture->data->url))
                    $oResponce->photo_big=$picResponce->picture->data->url;

                unset($oResponce->id);
                return $oResponce;
            }
        }
    }
}
?>