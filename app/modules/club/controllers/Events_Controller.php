<?php
require_once 'modules/base/controllers/BaseClub_Controller.php';
require_once 'modules/club/models/Event.php';
require_once 'modules/club/models/Reccount.php';
require_once 'modules/club/models/Track.php';
require_once 'modules/club/widgets/Widget.php';

Class Events_Controller Extends BaseClub_Controller {
		private $registry;
		public $start=0;
		public $take=10;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Event=new Event;
			$this->Reccount=new Reccount($this->registry);
			$this->sitedata=$this->Reccount->getSiteData();
			$this->socialblock=$this->Social->getSiteSocial();
			$this->banner=$this->Design->getBanner();
			
			}

        function indexAction() {
        		
        		$this->mainmenudata=$this->Menu->getMenuItems();
				$this->pagename=$this->Menu->pagetitle;
        		$this->mainmenu=$this->mainmenudata['html'];
        		$this->eventsdata=$this->Event->getEvents($this->start,$this->take+1,$this->registry->routername);
				if(!$this->eventsdata && $this->registry->routername!='eventpast'){
				$this->eventsdata=$this->Event->getEvents($this->start,$this->take,'eventpast');
				$this->registry->pastevents=true;
				}
				if($this->registry->routername=='eventpast' || $this->registry->pastevents)
				$this->past=true;
				$this->events=$this->eventsdata['events'];
				$this->artists=$this->eventsdata['artists'];
				$this->comments=$this->eventsdata['comments'];
				$this->rate=$this->eventsdata['rate'];
				$this->Widget=new Widget($this->registry,$this->mainmenu,0);
				$this->teaser=$this->Widget->teaser(true,true);
				$this->Track=new Track;
				$this->tracklist=$this->Track->getTracks(0,100);
				foreach($this->mainmenudata['data'] as $key=>$widget){
					if($widget['allwidget'] && $widget['active'] && $widget['code']!='events'){
						$method=$widget['code'];
						$this->widgets.=$this->Widget->$method($widget['name'],$key);
					}
				}
				$this->sitetitle=$this->pagename.'. '.$this->sitetitle;
				$this->sitedescription=$this->pagename.'. '.$this->sitedescription;
				$this->content =$this->view->AddView('events', $this);
				$this->view->renderLayout('layout', $this);
	    }
		function eventinnerAction() {
				$this->mainmenudata=$this->Menu->getMenuItems();
				$this->pagename=$this->Menu->pagetitle;
        		$this->mainmenu=$this->mainmenudata['html'];
				$this->eventsdata=$this->Event->getEventInner($this->registry->rewrites[1]);
				$this->eventinner=$this->eventsdata['data'];
				if($this->eventinner['oldevent'])
				$this->registry->oldevent=true;
				$this->artists=$this->eventsdata['artists'];
				$this->socials=$this->eventsdata['socials'];
				$this->Widget=new Widget($this->registry,$this->mainmenu,0);
				$this->teaser=$this->Widget->teaser(true,true);
				foreach($this->mainmenudata['data'] as $key=>$widget){
					if($widget['allwidget'] && $widget['active'] && $widget['code']!='events'){
						$method=$widget['code'];
						$this->widgets.=$this->Widget->$method($widget['name'],$key);
					}
				}
				
				foreach($this->artists as $artist){
					$artistList[]=$artist['name'];
				}
				
				//tools::print_r($this->eventinner['date_title']);
				$this->sitetitle=$this->eventinner['name'].', '.implode(', ',$artistList).', '.tools::GetDate($this->eventinner['date_title']).'. '.$this->pagename.' в '.$this->eventinner['city'].'е. '.$this->sitetitle;
				$this->sitedescription=$this->eventinner['name'].', '.implode(', ',$artistList).', '.tools::GetDate($this->eventinner['date_title']).'. '.$this->pagename.' в '.$this->eventinner['city'].'е. '.$this->sitedescription;
				$this->content =$this->view->AddView('event', $this);
				$this->view->renderLayout('layout', $this);
	    }
		function getmoreAction(){
			if($_POST['eventpast']=='true')
			$eventpast="eventpast";
			$this->eventsdata=$this->Event->getEvents(tools::int($_POST['count']),$this->take+1,$eventpast);
			$this->events=$this->eventsdata['events'];
			$this->artists=$this->eventsdata['artists'];
			$this->comments=$this->eventsdata['comments'];
			$this->rate=$this->eventsdata['rate'];
			$this->content =$this->view->AddView('blocks/events', $this);
			$this->view->renderLayout('blank', $this);
		}


}


?>