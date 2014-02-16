<?php
class Pageing{

	private $total;
	private $start;
	private $list;
	private $Conter;
	private $Get;
	private $last;
	private $top_count;
	private $page;
	private $get_url;
	public $out_url;
	
	public function __construct($get_url, $take=10, $total, $page=null){
		$this->total=$total;
		$this->get_url=$get_url;
		$this->out_url='/'.$get_url.'/';
		if (isset($page))
		$this->page=$page;
		else
		$this->page=1;
		$this->start=($this->page-1)*$take;		
		
		$this->take=$take;
		$this->blocks=10;
		$this->url='/';
		
		$this->total_pages=ceil($this->total/$this->take);
		
		$this->last_page=$this->total_pages;
		
		$this->half_block=floor($this->blocks/2);
		$this->half_block2=floor($this->blocks/2);
		
		$this->list=array("first_page"=>1, "last_page"=>$this->last_page);
		
		$cnt=1;
		for ($i=$this->page; $i > 0; $i--)
			{
				if ($this->page==$i)
				$this->list['current']=$i;
				else
				$this->list[$i]=$i;
				if ($this->half_block==$cnt)
				break;
				$cnt++;
			}
		$cnt=1;
		for ($i=$this->page; $i <= $this->total_pages; $i++)
			{
				
				if ($this->page!==$i)
				$this->list[$i]=$i;
				if ($this->half_block==$cnt)
				break;
				$cnt++;
			}
	}
	
	public function getStart(){
	return $this->start;	
	}
	
	public function GetHTML(){
	
	/*$this->Get=new Get();
	$this->url=$this->Get->GetURL();
	$this->url=$this->Get->GetRewriteMatch();*/
	/*unset($this->url[0]);
			$cnt=1;
			foreach($this->url as $v){
				if(count($this->url)==$cnt && $v>0 && is_numeric($v)){
				//$this->out_url.=$v.'/';
				}
				else
				$this->out_url.=$v.'/';
			$cnt++;
			}*/
	
		
	
	$next=$this->list['current']+1;
	$prev=$this->list['current']-1;
	$limit=($this->page-1)*$this->take+1;
	$limit2=$limit+$this->take-1;
	
	if ($this->page==$this->total_pages)
	$limit2=$this->total;
	$str='';
	$str .="";
	

	$str .=<<<OUT
			<div class="pager">
		  	<div class="hr"><i></i></div>
		    <ul>
OUT;
	if($prev>0){
	$str .=<<<OUT
			<li class="prev"><a href="{$this->out_url}{$prev}/"><i class="i"></i></a></li>
OUT;
	}
 
	for ($i=1; $i < $this->page ; $i++)
		{
			if ($i>((int)$this->page-(int)$this->half_block)){
				if($i==1){
				$str .=<<<OUT
				<li><a href="{$this->out_url}{$this->list[$i]}/">{$this->list[$i]}</a></li>
OUT;
				}
				else {
				$str .=<<<OUT
				<li><a href="{$this->out_url}{$this->list[$i]}/">{$this->list[$i]}</a></li>
OUT;
				}
			}
		}
	if($this->total_pages==$this->list['current'])
	$str .="<li class='last'>".$this->list['current']."</li>";
	else
	$str .="<li>".$this->list['current']."</li>";
	
	$cnt=1;
	for ($i=$this->page+1; $i <= $this->total_pages ; $i++)
		{
			if($this->total_pages==$i || ($this->half_block-1)==$cnt)
			$classlast=' class="last"';
			else
			$classlast='';
			
			if ($this->half_block==$cnt)
			break;
			$str .=<<<OUT
			<li{$classlast}><a href="{$this->out_url}{$this->list[$i]}/">{$this->list[$i]}</a></li>
OUT;
			$cnt++;
		}

	if($this->list['current']<$this->total_pages){
	$str .=<<<OUT
			<li class="next"><a href="{$this->out_url}{$next}/"><i class="i"></i></a></li>
OUT;
	}
	
	$str .=<<<OUT
  		  </div>
OUT;
	if ($this->total_pages>1)
	return $str;
	
	}
	public function GetAdminHTML(){
	
	/*$this->Get=new Get();
	$this->url=$this->Get->GetURL();
	$this->url=$this->Get->GetRewriteMatch();*/
	/*unset($this->url[0]);
			$cnt=1;
			foreach($this->url as $v){
				if(count($this->url)==$cnt && $v>0 && is_numeric($v)){
				//$this->out_url.=$v.'/';
				}
				else
				$this->out_url.=$v.'/';
			$cnt++;
			}*/
	
		
	
	$next=$this->list['current']+1;
	$prev=$this->list['current']-1;
	$limit=($this->page-1)*$this->take+1;
	$limit2=$limit+$this->take-1;
	
	if ($this->page==$this->total_pages)
	$limit2=$this->total;
	$str='';
	$str .="";
	

	$str .=<<<OUT
			<div class="pagination">
		  	<ul class="pag_list">
OUT;
	if($prev>0){
	$str .=<<<OUT
			<li class="prev"><a href="{$this->out_url}{$prev}/"><i class="i"></i></a></li>
OUT;
	}
 
	for ($i=1; $i < $this->page ; $i++)
		{
			if ($i>((int)$this->page-(int)$this->half_block)){
				if($i==1){
				$str .=<<<OUT
				<li><a href="{$this->out_url}{$this->list[$i]}/">{$this->list[$i]}</a></li>
OUT;
				}
				else {
				$str .=<<<OUT
				<li><a href="{$this->out_url}{$this->list[$i]}/">{$this->list[$i]}</a></li>
OUT;
				}
			}
		}
	if($this->total_pages==$this->list['current'])
	$str .="<li class='last'>".$this->list['current']."</li>";
	else
	$str .="<li>".$this->list['current']."</li>";
	
	$cnt=1;
	for ($i=$this->page+1; $i <= $this->total_pages ; $i++)
		{
			if($this->total_pages==$i || ($this->half_block-1)==$cnt)
			$classlast=' class="last"';
			else
			$classlast='';
			
			if ($this->half_block==$cnt)
			break;
			$str .=<<<OUT
			<li{$classlast}><a href="{$this->out_url}{$this->list[$i]}/">{$this->list[$i]}</a></li>
OUT;
			$cnt++;
		}

	if($this->list['current']<$this->total_pages){
	$str .=<<<OUT
			<li class="next"><a href="{$this->out_url}{$next}/"><i class="i"></i></a></li>
OUT;
	}
	
	$str .=<<<OUT
  		  </div>
OUT;
	if ($this->total_pages>1)
	return $str;
	
	}
}


?>