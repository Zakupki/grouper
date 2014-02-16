<?
require_once 'modules/club/models/Event.php';
require_once 'modules/club/models/Reccount.php';
require_once 'modules/club/models/Gallery.php';
require_once 'modules/club/models/Video.php';
require_once 'modules/club/models/Track.php';

Class Widget {
	function __construct($registry,$menu,$teaser=1){
		$this->registry=$registry;
		$this->mainmenu=$menu;
		$this->showteaser=$teaser;
		$this->view = new View($this->registry);
	}
	public function events($name,$sort){
		$this->widgetname=$name;
		$this->Event=new Event;
		$this->eventsdata=$this->Event->getEvents(0,10);
		if(!$this->eventsdata){
		$this->eventsdata=$this->Event->getEvents(0,10,'eventpast');
		$this->registry->pastevents=true;
		}
		if($sort<2)
		$this->teaser=self::teaser(false,true);
		else $this->teaser=null;
		$this->events=$this->eventsdata['events'];
		$this->artists=$this->eventsdata['artists'];
		$this->comments=$this->eventsdata['comments'];
		$this->rate=$this->eventsdata['rate'];
		if(count($this->events)>0 || $_SESSION['User']['id']==$_SESSION['Site']['userid']>0)
		return $this->view->AddView('widgets/events', $this);
	}
	public function gallery($name,$sort){
		if($sort<2)
		$this->teaser=self::teaser();
		else $this->teaser=null;
		$this->widgetname=$name;
		$this->Gallery=new Gallery;
		$this->gallerydata=$this->Gallery->getGalleryType();
		$this->gallery=$this->gallerydata['gallery'];
		$this->comments=$this->gallerydata['comments'];
		$this->rate=$this->gallerydata['rate'];
		if(count($this->gallery)>0 || $_SESSION['User']['id']==$_SESSION['Site']['userid'])
		return $this->view->AddView('widgets/gallery', $this);
	}
	public function video($name,$sort){
		if($sort<2)
		$this->teaser=self::teaser();
		else $this->teaser=null;
		$this->widgetname=$name;
		$this->Video=new Video;
		$this->videodata=$this->Video->getVideoList();
		$this->video=$this->videodata['videos'];
		$this->comments=$this->videodata['comments'];
		$this->rate=$this->videodata['rate'];
		if(count($this->video)>0 || $_SESSION['User']['id']==$_SESSION['Site']['userid'])
		return $this->view->AddView('widgets/video', $this);
	}
	public function music($name,$sort){
		if($sort<2)
		$this->teaser=self::teaser();
		else $this->teaser=null;
		$this->Track=new Track;
		$this->tracks=$this->Track->getTracks();
		$this->widgetname=$name;
		if(count($this->tracks)>0 || $_SESSION['User']['id']==$_SESSION['Site']['userid'])
		return $this->view->AddView('widgets/music', $this);
	}
	public function place($name,$sort){
		if($sort<2)
		$this->teaser=self::teaser();
		else $this->teaser=null;
		$this->widgetname=$name;
		$this->Reccount=new Reccount;
		$this->place=$this->Reccount->getPlace();
		if($this->place['slogan'] || $this->place['about'] ||  $this->place['address'] || $_SESSION['User']['id']==$_SESSION['Site']['userid'])
		return $this->view->AddView('widgets/place', $this);
	}
	public function contacts($name,$sort){
		if($sort<2)
		$this->teaser=self::teaser();
		else $this->teaser=null;
		$this->widgetname=$name;
		$this->Reccount=new Reccount;
		$this->contacts=$this->Reccount->getСontacts();
		if(is_array($this->contacts) || $_SESSION['User']['id']==$_SESSION['Site']['userid'])
		return $this->view->AddView('widgets/contacts', $this);
	}
	public function blog($name,$sort){
		if($sort<2)
		$this->teaser=self::teaser();
		else $this->teaser=null;
		$this->widgetname=$name;
		//return $this->view->AddView('widgets/contacts', $this);
	}
	public function teaser($single=false, $event=false){
		if(!$this->showteaser && !$single || !$this->registry->showteaser)
		return;
		$this->Reccount=new Reccount;
		if($event)
		$this->inevent=true;
		$this->teaserlist=$this->Reccount->getSiteTeasers();
		if(!$this->teaserlist)
		$this->registry->noteaserlist=1;
		if(is_array($this->teaserlist) || $_SESSION['User']['id']==$_SESSION['Site']['userid'])
		return $this->view->AddView('widgets/teaser', $this);
	}
}
?>