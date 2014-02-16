<?
Class Youtube {
	
	public function getSingleVideo($url=null){
		if(!$url)
		return;
		$id=tools::youtube_id_from_url($url);
		$graph_url=sprintf('http://gdata.youtube.com/feeds/api/videos/%s?alt=json', urlencode($id));
		$video = json_decode(file_get_contents(utf8_encode($graph_url)));
		$dateArr=explode('-',mb_substr($video->entry->published->{'$t'},0,10,'UTF-8'));
		return array('name'=>$video->entry->title->{'$t'},'url'=>tools::GetImageFromUrl($video->entry->{'media$group'}->{'media$thumbnail'}[0]->url,1),'date'=>tools::int($dateArr[2]).'.'.$dateArr[1].'.'.$dateArr[0]);
	}
	public function getChanel($url=null, $start=1,$max=50){
		if(!$url)
		return;
		
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
        | youtube\.com/  # or youtube.com
		)
		(?:user/             # Group host alternatives
        )?              # End host alternatives.
        (\w+)?
		# Allow 10-12 for 11 char youtube id.
        %x'
        ;
		
		preg_match($pattern, $url, $match);
		$graph_url=sprintf('http://gdata.youtube.com/feeds/api/users/%s/uploads?alt=json&start-index='.$start.'&max-results='.$max.'', urlencode($match[1]));
		$user = json_decode(file_get_contents(utf8_encode($graph_url)));
		return $user;
	}
}
?>