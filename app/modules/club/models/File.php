<?
require_once 'modules/base/models/Basemodel.php';

Class File Extends Basemodel {
	
	public function getYoutube($url=null){
		if(!$url)
		return;
		$id=tools::youtube_id_from_url($url);
		$graph_url=sprintf('http://gdata.youtube.com/feeds/api/videos/%s?alt=json', urlencode($id));
		$video = json_decode(file_get_contents(utf8_encode($graph_url)));
		$dateArr=explode('-',mb_substr($video->entry->published->{'$t'},0,10,'UTF-8'));
		return array('name'=>$video->entry->title->{'$t'},'url'=>$video->entry->{'media$group'}->{'media$thumbnail'}[0]->url,'date'=>$dateArr[2].'.'.$dateArr[1].'.'.$dateArr[0]);
	}
	public function getYoutubechanel($url=null){
		if(!$url)
		return;
		preg_match('/\/user\/(\w+)?$/', $url, $match);
		$graph_url=sprintf('http://gdata.youtube.com/feeds/api/users/%s/uploads?alt=json', urlencode($match[1]));
		$user = json_decode(file_get_contents(utf8_encode($graph_url)));
		if(is_array($user->feed->entry))
		return $user->feed->entry;
	}
	function GetImageFromUrl($link)
 	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch,CURLOPT_URL,$link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result=curl_exec($ch);
	curl_close($ch);
	return $result;
	}
}
?>