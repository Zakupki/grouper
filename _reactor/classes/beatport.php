<?
Class Beatport {
	public function getUser($url){
		preg_match('/beatport.com\/artist\/([\w\d_-]+)\/(\d+)?/', trim($url), $match);
		$graph_url='https://api.beatport.com/catalog/3/beatport/artist?id='.tools::int($match[2]);
		$user = json_decode(file_get_contents(utf8_encode($graph_url)));
		return $user; 
	}
	public function checkRelease($url){
		preg_match('/beatport.com\/release\/([\w\d_-]+)\/(\d+)?/', trim($url), $match);
		$graph_url='https://api.beatport.com/catalog/3/beatport/release?id='.tools::int($match[2]);
		$user = json_decode(file_get_contents(utf8_encode($graph_url)));
		return $user; 
	}
	public function getRelease($id){
		if($id<1)
		return;
		$graph_url="https://api.beatport.com/catalog/3/beatport/release?id=".tools::int($id);
		$release = json_decode(file_get_contents(utf8_encode($graph_url)));
		return $release;
	}
	public function getTrack($url,$imgsize=4){
		preg_match('/beatport.com\/track\/([\w\d_-]+)\/(\d+)?/', trim($url), $match);
		$graph_url='https://api.beatport.com/catalog/3/beatport/track?id='.tools::int($match[2]);
		$user = json_decode(file_get_contents(utf8_encode($graph_url)));
		//tools::print_r($user);
		$track=$user->results->track;
		
		
		
		if($track->type=='track'){
				if(is_array($track->artists)){
				foreach($track->artists as $author)
					if($author->type=='artist')
					$trackauthorArr[]=$author->name;
				}
				if(is_array($track->genres)){
					foreach($track->genres as $genre)
						if($genre->type=='genre')
						$trackgenresArr[]=$genre->name;
				}
			
			$trackdata['title']=$track->name;
			$trackdata['author']=implode(' & ',$trackauthorArr);
			$trackdata['remix']=$track->mixName;
			$trackdata['musictype']=implode(',',$trackgenresArr);
			$trackdata['socialid']=198;
			$trackdata['stream']=$track->sampleUrl;
			
			$date=preg_match('/^(\d+)?\/(\d+)?\/(\d+)?/',$userdata->created_at, $match);
			$trackdata['date_create']=$match[3].".".$match[2].".".$match[1];
		}
		else {
			$trackdata['error']=true;
			$trackdata['status']='Данная ссылка не является треком';
		}
		return $trackdata;
		
		
	/*	
								$trackauthorArr=null;
								if(is_array($track->artists)){
									foreach($track->artists as $author)
										if($author->type=='artist')
										$trackauthorArr[]=$author->name;
								}
								$trackgenresArr=null;
								if(is_array($track->genres)){
									foreach($track->genres as $genre)
										if($genre->type=='genre')
										$trackgenresArr[]=$genre->name;
								}
								$trackdata=array();
								$trackdata['name']=$track->name;
								$trackdata['author']=implode(' & ',$trackauthorArr);
								$trackdata['remix']=$track->mixName;
								$trackdata['musictype']=implode(',',$trackgenresArr);								
								$trackdata['promocut']=1;
								$trackdata['typeid']=$releasedata['typeid'];
								$trackdata['download']=0;
								$trackdata['stream']=$track->sampleUrl;
								$trackdata['socialid']=$_POST['socialid'];
								$trackdata['sort']=$trcnt;
		
		return $trackdata;*/
	}	
}
?>