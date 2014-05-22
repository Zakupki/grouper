<?
class tools
{
	protected $registry;

	function _construct(){
	}
	/*function __get($name){
		$this->db=new db;
		return $this->db;
	}*/
	public static function getSqlDate($y,$m,$d,$h='00',$i='00',$s='00'){
		if($m<10)$m='0'.intval($m);
		if($d<10)$d='0'.intval($d);
		return $y.'-'.$m.'-'.$d.' '.$h.':'.$i.':'.$s;
	}

    public static function GetDate($date,$langid=1) {
	$months[1] = Array ("01" => "января",
					"02" => "февраля",
					"03" => "марта",
					"04" => "апреля",
					"05" => "мая",
					"06" => "июня",
					"07" => "июля",
					"08" => "августа",
					"09" => "сентября",
					"10" => "октября",
					"11" => "ноября",
					"12" => "декабря");
	$months[2] = Array ("01" => "january",
					"02" => "february",
					"03" => "march",
					"04" => "april",
					"05" => "may",
					"06" => "june",
					"07" => "july",
					"08" => "august",
					"09" => "september",
					"10" => "october",
					"11" => "november",
					"12" => "december");
	$date1=explode(" ", $date);
	$out=explode("-",$date1['0']);
	if(date('dmY')==$out['2'].$out['1'].$out['0'])
	$newdate=self::trans('today',$_SESSION['langid']);
	else
	$newdate=self::int($out['2'])." ".$months[$langid][$out['1']]." ".$out['0'];
	return $newdate;
	}
    public static function GetTime($date) {
	$date1=explode(" ", $date);
	$out=explode(":",$date1['1']);
	$newdate=intval($out['0']).":".$out['1'];
	return $newdate;
	}
    public static function GetMonth($date,$langid=1) {
	if(self::int($langid)<1)
	$langid=1;
	$months[1] = Array ("1" => "января",
					"2" => "февраля",
					"3" => "марта",
					"4" => "апреля",
					"5" => "мая",
					"6" => "июня",
					"7" => "июля",
					"8" => "августа",
					"9" => "сентября",
					"10" => "октября",
					"11" => "ноября",
					"12" => "декабря");
	$months[2] = Array ("1" => "januarry",
					"2" => "february",
					"3" => "march",
					"4" => "april",
					"5" => "may",
					"6" => "june",
					"7" => "july",
					"8" => "august",
					"9" => "september",
					"10" => "october",
					"11" => "november",
					"12" => "december");

	return $months[$langid][self::int($date)];
	}
    public static function GetDayOfWeek($date,$langid=1) {
	if(self::int($langid)<1)
	$langid=1;
	$months[1] = Array ("2" => "Понедельник",
					"3" => "Вторник",
					"4" => "Среда",
					"5" => "Четверг",
					"6" => "Пятница",
					"7" => "Суббота",
					"1" => "Воскресенье");
	$months[2] = Array ("2" => "Monday",
					"3" => "Tuesday",
					"4" => "Wednesdey",
					"5" => "Thirthday",
					"6" => "Friday",
					"7" => "Saturday",
					"1" => "Sunday");

	return $months[$langid][$date];
	}
    public static function delMp3($file) {
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$file)){
			unlink($_SERVER['DOCUMENT_ROOT'].$file);
		}
	}
    public static function delImg($file) {
		$imgArr=array(1,2,3,4,5,6,7,8,9,10,11,12,13);

		if(preg_match('/(\d+?)_(.+?)$/', trim($file), $match)){
		$file=str_replace($match['1'].'_','',$file);
		}
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$file)){
			unlink($_SERVER['DOCUMENT_ROOT'].$file);
		}
		$filedata=pathinfo($file);
		foreach($imgArr as $f){
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$filedata['dirname'].'/'.$f.'_'.$filedata['basename']))
			unlink($_SERVER['DOCUMENT_ROOT'].$filedata['dirname'].'/'.$f.'_'.$filedata['basename']);
		}
	}

    public static function int($str) {
		return (!preg_match('/^\-?\d+$/u', trim($str))) ? '0' : intval($str);
	}
    public static function trans($key,$langid)
	{
		$lang[1]['reply']='ответить';
		$lang[1]['deleted_comment']='Комментарий удален';
		$lang[1]['todayat']='сегодня в';
		$lang[1]['today']='сегодня';
		$lang[1]['newcomment']="Новый комментарий";
		$lang[2]['reply']='reply';
		$lang[2]['deleted_comment']='Deleted comment';
		$lang[2]['todayat']='today at';
		$lang[2]['today']='today';
		$lang[2]['newcomment']="New comment";

		return $lang[$langid][$key];
	}
    public static function GetComments($data, $incut=0, $newsowner=0, $parentid=0, $level=0) {
		if(is_array($data[$parentid])){
			$level++;
			$cnt=1;
			foreach($data[$parentid] as $k=>$v){
				if(is_array($data[$v['id']]))$content_hasreply_class='content-has-reply ';else$content_hasreply_class='';
				if($v['pro'])$content_pro_class='content-pro ';else$content_pro_class='';
				if($v['pro'])$user_pro_class='user-link-pro ';else$user_pro_class='';
				if($v['pro'])$user_pro_icon='<i class="i-pro"></i>';else$user_pro_icon='';
				$v['date_create']=tools::getDate($v['date_create'],$_SESSION['langid']).' '.tools::getTime($v['date_create']);
				if($level==5 && is_array($data[$v['id']])){
					$collapsed='ti-collapsed ';
					$expand='<div class="expand-link"><i class="i"></i><i class="i-root"></i></div>';}
				else{$collapsed=''; $expand='';}
				if($cnt==count($data[$parentid]))$last='ti-last '; else $last='';
				if(tools::int($_SESSION['User']['id'])==$v['userid'] || tools::int($_SESSION['User']['id'])==$newsowner)$remove='<div class="remove-link"><i class="i"></i></div>'; else $remove='';
				if($v['quote']>0)$quoteact='quote-link-act ';else$quoteact='';
				if(tools::int($_SESSION['User']['id'])==$newsowner && $incut)$quote='<div class="'.$quoteact.'quote-link"><i class="i"></i></div>'; else $quote='';
				if($v['file_name'])
  				$userpic='<div class="userpic"><a href="/users/'.$v['userid'].'/"><img src="/uploads/users/3_'.$v['file_name'].'" alt="" /></a></div>';
				else
  				$userpic='<div class="userpic-na userpic"><a href="/users/'.$v['userid'].'/"></a></div>';
        if($level>1)$branch='<div class="branch"></div>';else$branch='';

		if($v['deleted']){
		$comStr.='
		<div class="'.$collapsed.$last.'ti" id="comment'.$v['id'].'">
      	<input name="userid" value="'.$v['userid'].'" type="hidden" />
        '.$branch.'';
			$comStr.='
			<div class="'.$content_hasreply_class.$content_pro_class.'content">
              '.$userpic.'
              <div class="author">
                <div class="'.$user_pro_class.'user-link"><a href="/users/'.$v['userid'].'/">'.$v['displayname'].'<i class="i"></i>'.$user_pro_icon.'</a></div>
			          <div class="date">'.$v['date_create'].'</div>
                '.$remove.$quote.'
              </div>
              <div class="text">
                <p>'.$v['preview_text'];
                  if($v['new']==1 && tools::int($_SESSION['User']['id'])>0)
                    $comStr.=' <span class="new">('.self::trans('newcomment',$_SESSION['langid']).')</span>';
                $comStr.='
  				</p>
              </div>
  			      <div class="reply-link"><span>'.self::trans('reply',$_SESSION['langid']).'<i class="i"></i></span></div>
            </div>';
  			    $comStr.=''.$expand;
  				 $comStr.=self::GetComments($data, $incut, $newsowner, $v['id'], $level);
  				$comStr.='
  		</div>';
		}
		else{
		  /*if($level>1)
		  	$branch='<div class="branch-removed branch"></div>';else $branch='';

			$comStr.='<div class="'.$last.'ti" id="comment'.$id.'">
		          '.$branch.'
		          <div class="'.$content_hasreply_class.$content_pro_class.'content-removed content">
		            <div class="text-removed text">'.self::trans('deleted_comment',$_SESSION['langid']).'</div>
		          </div>';
		        $comStr.=''.$expand;
  				  self::GetComments($data, $incut, $newsowner, $v['id'], $level);
  				$comStr.='
			</div>';*/
			$comStr.='
			<div class="'.$collapsed.$last.'ti" id="comment'.$v['id'].'">
	      	<input name="userid" value="'.$v['userid'].'" type="hidden" />
	        '.$branch.'';
				$comStr.='
				<div class="'.$content_hasreply_class.$content_pro_class.'content-removed content">
	              <div class="text-removed text">'.self::trans('deleted_comment',$_SESSION['langid']).'</div>
	  			</div>';
	  			    $comStr.=''.$expand;
	  				 $comStr.=self::GetComments($data, $incut, $newsowner, $v['id'], $level);
	  				$comStr.='
	  		</div>';
		}
			$cnt++;
			}
		}
		return $comStr;
	}
	public static function allowed_ip(){
		$iparr[]='77.120.243.36';
		$iparr[]='91.209.51.157';
		$iparr[]='31.42.52.10';
        $iparr[]='193.93.78.106';
		//$iparr[]='78.27.188.214';
		return $iparr;

	}

	public static function print_r($arr){
		if(in_array($_SERVER['REMOTE_ADDR'],self::allowed_ip())){
			echo "<pre>";
			print_r($arr);
			echo "</pre>";
		}

	}
	public static function var_dump($arr){
		//if($_SERVER['SERVER_ADDR']=='192.168.1.99'){
			echo "<pre>";
			var_dump($arr);
			echo "</pre>";
		//}

	}
	public static function keyOneSort($a, $b) {
	    return $b[1]-$a[1];
	}
    public static function sortDesc($a, $b) {
        return $b['sort']-$a['sort'];
    }
	public static function sortAsc($a, $b) {
	    return $a['sort']-$b['sort'];
	}
    public static function getDomain($domain){
		// get host name from URL
		if(preg_match('@^(?:https://)?([^/]+)@i', $domain, $matches1))
		$matches= $matches1;
		if(preg_match('@^(?:http://)?([^/]+)@i', $domain, $matches2) && $matches1[1]=='http:')
		$matches = $matches2;
		$host=$matches[1];
		$host=str_replace('www.', '', $host);
		//return $host;
		// get last two segments of host name
		$hostArr=array('livejournal.com','beatport.com','promodj.ru','official.fm','topdj.ua');
		preg_match('/[^.]+\.[^.]+$/', $host, $subdom);
		if(in_array($subdom[0],$hostArr))
		return $subdom[0];
		else
		return $host;
	}
	public static function  newend($num,$langid=1)
	{
		if($langid==1){
		$enddigit=substr($num, -1);
		if($enddigit==1)
		return 'новый';
		else
		return 'новыx';
		}elseif($langid==2)
		return 'new';
	}
	public static function IsAjaxRequest() {
     return isset($_SERVER['HTTP_X_REQUESTED_WITH'])?$_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest' : false;
	}
	public static function toJSON($o) {
	switch (gettype($o)) {
		case 'NULL':
			return 'null';
		case 'integer':
		case 'double':
			return strval($o);
		case 'string':
			$o = str_replace(array('\\', '/', '"', "'", "\r", "\n", "\b", "\f", "\t"),
	                         array('\\\\\\\\', '/', '\\\"', "\'", '\r', '\n', '\b', '\f', '\t'), $o);
			return '"' . $o . '"';
		case 'boolean':
			return $o ? 'true' : 'false';
		case 'object':
			$o = (array) $o;
		case 'array':
			$foundKeys = false;

			foreach ($o as $k => $v) {
				if (!is_numeric($k)) {
					$foundKeys = true;
					break;
				}
			}

			$result = array();

			if ($foundKeys) {
				foreach ($o as $k => $v) {
					$result []= self::toJSON($k) . ':' . self::toJSON($v);
				}

				return '{' . implode(',', $result) . '}';
			} else {
				foreach ($o as $k => $v) {
					$result []= self::toJSON($v);
				}

				return '[' . implode(',', $result) . ']';
			}
	}
}
  /*function toJSON($value)
    {
        if (is_int($value)) {
            return (string)$value;
        } elseif (is_string($value)) {
	        $value = str_replace(array('\\', '/', '"', "\r", "\n", "\b", "\f", "\t"),
	                             array('\\\\', '/', '\"', '\r', '\n', '\b', '\f', '\t'), $value);
	        $convmap = array(0x80, 0xFFFF, 0, 0xFFFF);
	        $result = "";
	        for ($i = mb_strlen($value) - 1; $i >= 0; $i--) {
	            $mb_char = mb_substr($value, $i, 1);
	            if (mb_ereg("&#(\\d+);", mb_encode_numericentity($mb_char, $convmap, "UTF-8"), $match)) {
	                $result = sprintf("\\u%04x", $match[1]) . $result;
	            } else {
	                $result = $mb_char . $result;
	            }
	        }
	        return '"' . addslashes($result) . '"';
        } elseif (is_float($value)) {
            return str_replace(",", ".", $value);
        } elseif (is_null($value)) {
            return 'null';
        } elseif (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif (is_array($value)) {
            $with_keys = false;
            $n = count($value);
            for ($i = 0, reset($value); $i < $n; $i++, next($value)) {
                        if (key($value) !== $i) {
			      $with_keys = true;
			      break;
                        }
            }
        } elseif (is_object($value)) {
            $with_keys = true;
        } else {
            return '';
        }
        $result = array();
        if ($with_keys) {
            foreach ($value as $key => $v) {
                $result[] = self::toJSON((string)$key) . ':' . self::toJSON($v);
            }
            return '{' . implode(',', $result) . '}';
        } else {
            foreach ($value as $key => $v) {
                $result[] = self::toJSON($v);
            }
            return '[' . implode(',', $result) . ']';
        }
    }*/
	public static function str($str){
		return str_replace(array("\r\n", "\n", "\r"),' ',trim(stripcslashes($str)));
	}
	public static function r_str($str){
		return trim(stripcslashes($str));
	}
	public static function nulstr($str){
		if(strlen(trim($str))<1)
		return 'null';
		else
		return "'".str_replace(array("\r\n", "\n", "\r"),' ',trim($str))."'";
	}
	public static function txt($str){
		return str_replace(array("\r\n", "\n", "\r"),'<br/>',trim($str));
	}
	public static function tojs($str){
		$str=str_replace(array('\\', '/', '"', "'", "\r", "\n", "\b", "\f", "\t"),
	                         array('\\\\\\\\', '/', '\\\"', "\'", '\r', '\n', '\b', '\f', '\t'), trim($str));
		return $str;
	}
	public static function getFbCount($url=null){
            if(!$url)
			$url=$_SERVER['HTTP_HOST'];
			$url=str_replace('http://','',$url);
			//Создаём новый объект. Также можно писать и в процедурном стиле
		    $memcache_obj = new Memcache;

		    //Соединяемся с нашим сервером
		    $memcache_obj->connect('127.0.0.1', 11211) or die("Could not connect0");

		    //Попытаемся получить объект с ключом our_var
		    $return = @$memcache_obj->get('FbCount_'.$url);
		 	//$memcache_obj->delete('site_twit_'.$_SESSION['Site']['id']);

			if(!empty($return))
					   {
						   $memcache_obj->close();
						   return $return;
					   }
					   else
					   {

		    	$json=file_get_contents('https://api.facebook.com/method/fql.query?query=select%20total_count%20from%20link_stat%20where%20url="http://'.urlencode($url).'"&format=json');
				//tools::print_r('https://api.facebook.com/method/fql.query?query=select%20total_count%20from%20link_stat%20where%20url="http://'.urlencode($url).'"&format=json');
				$result=json_decode($json);
				$num=self::int($result[0]->total_count);
				$memcache_obj->set('FbCount_'.$url, ' '.$num.' ', false, 30*60*6000000);
		 		$return=$memcache_obj->get('FbCount_'.$url);
		        //Выведем закэшированные данные
		        $memcache_obj->close();
				return $return;
		    }
	}
	public static function getTwCount($url=null){

			if(!$url)
			$url=$_SERVER['HTTP_HOST'];
			$url=str_replace('http://','',$url);
		 	//Создаём новый объект. Также можно писать и в процедурном стиле
		    $memcache_obj = new Memcache;

		    //Соединяемся с нашим сервером
		    $memcache_obj->connect('127.0.0.1', 11211) or die("Could not connect1");

		    //Попытаемся получить объект с ключом our_var
		    $return = @$memcache_obj->get('TwCount_'.$url);
		 	//$memcache_obj->delete('site_twit_'.$_SESSION['Site']['id']);
		    if(!empty($return))
		    {
		    	//Если объект закэширован, выводим его значение
		        $memcache_obj->close();
				return $return;
		    }
		    else
		    {

				$json=file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url='.urlencode($url).'');
				$result=json_decode($json);
			    $memcache_obj->set('TwCount_'.$url, ' '.self::int($result->count).' ', false, 30*60*6000000);
		 		$return=$memcache_obj->get('TwCount_'.$url);
		        //Выведем закэшированные данные
		        $memcache_obj->close();
				return $return;
			}
	}
	public static function getVkCount($url=null){
            if(!$url)
			$url=$_SERVER['HTTP_HOST'];
			$url=str_replace('http://','',$url);
			//Создаём новый объект. Также можно писать и в процедурном стиле
		    $memcache_obj = new Memcache;

		    //Соединяемся с нашим сервером
		    $memcache_obj->connect('127.0.0.1', 11211) or die("Could not connect2");

		    //Попытаемся получить объект с ключом our_var
		    $return = @$memcache_obj->get('VkCount_'.$url);
		 	//$memcache_obj->delete('site_twit_'.$_SESSION['Site']['id']);
		    if(!empty($return))
		    {
		    	//Если объект закэширован, выводим его значение
		        $memcache_obj->close();
				return $return;
		    }
		    else
		    {
		    	$vk_request = file_get_contents('http://vkontakte.ru/share.php?act=count&index=1&url=http://'.urlencode($url).'');
				$tmp = array();
				preg_match('/^VK.Share.count\(1, (\d+)\);$/i',$vk_request,$tmp);

			 	$memcache_obj->set('VkCount_'.$url, " ".self::int($tmp[1])." ", false, 30*60*6000000);
		 		$return=$memcache_obj->get('VkCount_'.$url);
		        //Выведем закэшированные данные
		        $memcache_obj->close();
				return $return;
			}
	}
	public static function youtube_id_from_url($url) {
    $pattern =
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:
		www\.
		| m\.
		| www\.m\.
		)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
		  (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
		  | /watch\?feature=player_embedded\&v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        %x'
        ;
    $result = preg_match($pattern, $url, $matches);
    if (false !== $result) {
        return $matches[1];
    }
    return false;
}
	/**
	 * @param string f1 - существительное для числа 1 - 1 голос
	 * @param string f2 - существительное для чисел в диапазоне от 2 до 4-х: 2 голоса
	 * @param string f3 - существительное для остальных чисел:5 голосов
	 * @param int v - число
	 */
    public static function word_render($f1, $f2, $f3, $v)
	{
		$v = str_pad((int)$v, 2, '0', STR_PAD_LEFT);
		$s2 = intval(substr($v, -2, 1));
		$s1 = intval(substr($v, -1, 1));
		if ($s2 == 1 || $s1 == 0 || ($s1 > 4 && $s1 <= 9)) return $f3;
		if ($s1 == 1) return $f1;
		if ($s1 >= 2 && $s1 <= 4) return $f2;
	}
    public static function encodestring($file_name)
  	{
     $tr = array(
        "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
        "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
        "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
        "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
        "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
        "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
        "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", " "=>"_"
    );
    return strtr($file_name,$tr);
  	}
    public static function getStreamParam($id){
		$params=array(234=>'?client_id=525b3f847036860020a8812bd249f85f');
		return $params[$id];
	}
    public static function GetImageFromUrl($link,$size=null)
 	{
 	$linkArr=explode('?',trim($link));
	$link=$linkArr[0];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch,CURLOPT_URL,$link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
	$result=curl_exec($ch);
	curl_close($ch);

		$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/temp/';
		$path_parts=pathinfo($link);
		$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
		$savefile = fopen($_SERVER['DOCUMENT_ROOT'] . '/uploads/temp/'.$newfilename, 'w');
		fwrite($savefile, $result);
		fclose($savefile);
	if($size)
	$size=$size.'_';
	return '/uploads/temp/'.$size.$newfilename;
	}
    public static function GetFacebookImageFromUrl($link,$size=null)
 	{
 	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, true); // header will be at output
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD'); // HTTP request is 'HEAD'
	$content = curl_exec ($ch);
	preg_match('/Location: ([^\s]+)/',$content,$match);
	$link=($match[1]);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch,CURLOPT_URL,$link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result=curl_exec($ch);
	curl_close($ch);

		$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/temp/';
		$path_parts=pathinfo($link);
		$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
		$savefile = fopen($_SERVER['DOCUMENT_ROOT'] . '/uploads/temp/'.$newfilename, 'w');
		fwrite($savefile, $result);
		fclose($savefile);
	if($size)
	$size=$size.'_';
	return '/uploads/temp/'.$size.$newfilename;
	}

    public static function vimeo_id_from_url($url){
		if(!$url)
		return;
		preg_match('/vimeo.com\/(\d+)?/', trim($url), $match);
		if($match['1']>0)
		return $match['1'];
	}
    public static function generatePassword ($length = 8)
	  {

	    // start with a blank password
	    $password = "";

	    // define possible characters - any character in this string can be
	    // picked for use in the password, so if you want to put vowels back in
	    // or add special characters such as exclamation marks, this is where
	    // you should do it
	    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

	    // we refer to the length of $possible a few times, so let's grab it now
	    $maxlength = strlen($possible);

	    // check for length overflow and truncate if necessary
	    if ($length > $maxlength) {
	      $length = $maxlength;
	    }

	    // set up a counter for how many characters are in the password so far
	    $i = 0;

	    // add random characters to $password until $length is reached
	    while ($i < $length) {

	      // pick a random character from the possible ones
	      $char = substr($possible, mt_rand(0, $maxlength-1), 1);

	      // have we already used this character in $password?
	      if (!strstr($password, $char)) {
	        // no, so it's OK to add it onto the end of whatever we've already got...
	        $password .= $char;
	        // ... and increase the counter by one
	        $i++;
	      }

	    }

	    // done!
	    return $password;

	  }




    public static function getDirectorySize($path,$save=false)
	{

	}
    public static function sizeFormat($size)
	{
    if($size<1024)
    {
        return $size." B";
    //return 0;
    }
    else if($size<(1024*1024))
    {
        $size=round($size/1024,1);
        return $size." KB";
    }
    else if($size<(1024*1024*1024))
    {
        $size=round($size/(1024*1024),1);
        return $size." MB";
    }
    else
    {
        $size=round($size/(1024*1024*1024),1);
        return $size." GB";
    }

	}



	#dir size
    public static function calculate_whole_directory($directory)
    {

        if ($handle = opendir($directory))
        {
        $size = 0;
		$folders = 0;
		$files = 0;

        while (false !== ($file = readdir($handle)))
		{
            if ($file != "." && $file != ".." && !is_link ($directory.$file))
			{
			    if(is_dir($directory.$file))
			    {
                $array = $this->calculate_whole_directory($directory.$file.'/');
                $size += $array['size'];
				$files += $array['files'];
				$folders += $array['folders'];
			    }
			    else
			    {
                $size += filesize($directory.$file);
				$files++;
			    }
            }
         }
         closedir($handle);
         }

		 $folders++;

    return array('size' => $size, 'files' => $files, 'folders' => $folders);
    }

	/*
	function size_calculator($size_in_bytes)
		{
			if($this->size_in == 'B')
			{
			$size = $size_in_bytes;
			}
			elseif($this->size_in == 'KB')
			{
			$size = (($size_in_bytes / 1024));
			}
			elseif($this->size_in == 'MB')
			{
			$size = (($size_in_bytes / 1024) / 1024);
			}
			elseif($this->size_in == 'GB')
			{
			$size = (($size_in_bytes / 1024) / 1024) / 1024;
			}
				  $size = round($size, $this->decimals);

			return $size;
		}*/


    public static function size($directory)
	{
	set_time_limit(10000);
	$array = $this->calculate_whole_directory($directory);
	$bytes = $array['size'];
	$size = $bytes;
	$files = $array['files'];
	$folders = $array['folders'] - 1; // exclude the main folder
	$db=db::init();
	$db->query('UPDATE z_site SET disk='.tools::int($size).' WHERE id='.$_SESSION['Site']['id'].'');
	return $size;
	}


}
?>