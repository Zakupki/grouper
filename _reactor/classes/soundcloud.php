<?
Class Soundcloud {
	private $client_id='525b3f847036860020a8812bd249f85f';
	public function getTrack($url,$imgsize=4){
		$trackdata=array('error'=>false, 'status'=>'');
		//$url='http://soundcloud.com/lavibeats/summer-time-pool-party-teaser';
		$graph_url="http://api.soundcloud.com/resolve.json?url=".trim($url)."&client_id=".$this->client_id."";
		$userdata = json_decode(file_get_contents(utf8_encode($graph_url)));
		
		if($userdata->kind=='track'){
			$date=preg_match('/^(\d+)?\/(\d+)?\/(\d+)?/',$userdata->created_at, $match);
			$trackdata['date_create']=$match[3].".".$match[2].".".$match[1];
			$trackdata['title']=$userdata->title;
			$trackdata['musictype']=$userdata->genre;
			$trackdata['socialid']=234;
			$trackdata['stream']=$userdata->stream_url;
			$trackdata['cover']=tools::GetImageFromUrl(str_replace('-large.','-crop.',$userdata->artwork_url),$imgsize);
		}
		else {
			$trackdata['error']=true;
			$trackdata['status']='Данная ссылка не является треком';
		}
		return $trackdata;
	}
	public function getUser($url){
		$graph_url="http://api.soundcloud.com/resolve.json?url=".urlencode(trim($url))."&client_id=".$this->client_id."";
		$user = json_decode(file_get_contents(utf8_encode($graph_url)));
		return $user; 
	}
	public function getUserTracks($url){
		$user=self::getUser($url);
		$graph_url="http://api.soundcloud.com/users/".$user->id."/tracks.json?client_id=".$this->client_id."";
		$userdata = json_decode(file_get_contents(utf8_encode($graph_url)));
		return $userdata; 
	}
}
?>