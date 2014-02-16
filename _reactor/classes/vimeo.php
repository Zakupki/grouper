<?
Class Vimeo {
	
	public function getSingleVideo($url=null){
		if(!$url)
		return;
		preg_match('/vimeo.com\/(\d+)?/', trim($url), $match);
		$graph_url=sprintf('http://vimeo.com/api/v2/video/%s.json', tools::int($match[1]));
		$video = json_decode(file_get_contents(utf8_encode($graph_url)));
		
		$dateArr=explode('-',mb_substr($video[0]->upload_date,0,10,'UTF-8'));
		return array('name'=>$video[0]->title,'url'=>tools::GetImageFromUrl($video[0]->thumbnail_large,1),'date'=>tools::int($dateArr[2]).'.'.$dateArr[1].'.'.$dateArr[0]);
	}
	
	public function checkChanel($url=null){
		if(!$url)
		return;
		if(preg_match('/vimeo.com\/user(\d+)?/', $url, $match)){
			$graph_url="http://vimeo.com/api/v2/user/".tools::int($match[1])."/info.json";
		}
		elseif (preg_match('/vimeo.com\/(\w+)?/', $url, $match)){
			$graph_url="http://vimeo.com/api/v2/user/".tools::str($match[1])."/info.json";
		}
		$user = json_decode(file_get_contents(utf8_encode($graph_url)));
		return $user;
	}
	
	public function getChanel($url=null, $page=1){
		if(!$url)
		return;
			if(preg_match('/vimeo.com\/user(\d+)?/', $url, $match)){
			$graph_url="http://vimeo.com/api/v2/".tools::int($match[1])."/videos.json?page=".$page."";
		}
		elseif (preg_match('/vimeo.com\/(\w+)?/', $url, $match)){
			$graph_url="http://vimeo.com/api/v2/".tools::str($match[1])."/videos.json?page=".$page."";
		}
		$user = json_decode(file_get_contents(utf8_encode($graph_url)));
		return $user;
	}
}
?>