<?

final class get
{
	public $http_host;
	protected $registry;
	
	function __construct($registry){
		$this->http_host=$_SERVER['HTTP_HOST'];
		$this->registry = $registry;
	}
	public function handleDomain($checkhost=null){
		if($checkhost)
		$this->http_host=$checkhost;
		$this->http_host=str_replace('www.','',$this->http_host);
		
		foreach($this->registry->sitedomains as $dk=>$dom){
			if(preg_match("'r([\d]+?).".$dom[0]."$'",$this->http_host,$domain) || preg_match("'w([\d]+?).".$dom[0]."$'",$this->http_host,$domain)){
				define('MAIN_NAME', 'Reactor-PRO');	
				return $domain['1'];
			}
			if($this->http_host==$dom[0]){
				if($dom[2]>0){
				$_SESSION['langid']=$dom[2];
				$this->registry->langid=$dom[2];
				}
				switch ($dk) {
				    case 1:
					case 2:
					case 3:
					   define('MAIN_NAME', 'Clubsreport');
				       $translate_array = parse_ini_file("config/report/".$dom[2].".ini");
					   $this->registry->trans=$translate_array;
					break;
					  
				    default:
					   define('MAIN_NAME', 'Reactor-PRO');	
					   $translate_array = parse_ini_file("config/lang/".$dom[2].".ini");
					   $this->registry->trans=$translate_array;
					   break;
				}
				return $dom[1];
			}
		}
		if(preg_match("'([\w\d]+?).clubsreport.com$'",$this->http_host,$domain)){
			define('MAIN_NAME', 'Clubsreport');	
			$translate_array = parse_ini_file("config/report/1.ini");
			$this->registry->trans=$translate_array;
			$this->registry->brandcode=$domain['1'];
			return 'report';
		}
		
		return 'client';
	}
	public function redirect($url){
		header("Location: ".$url."");
	return;
	}
}

?>