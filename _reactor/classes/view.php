<?

 
class View {
	private $Session;
	private $registry;
	function __construct($registry){
		$this->registry=$registry;
		
	}
    
	function fetchPartialLayout($template, $obj){
        ob_start();
		$this->view=$obj;
		include 'modules/'.$this->registry->module.'/layout/'.$template.'.php';
        return ob_get_clean();
    }
	
	
	function AddView($template, $obj){
        ob_start();
		$this->view=$obj;
		include 'modules/'.$this->registry->module.'/views/'.$template.'.php';
        return ob_get_clean();
    }
	
	function renderLayout($template='index', $obj){
        echo $this->fetchPartialLayout($template, $obj);
    }
	
	
	
	
	
}
?>