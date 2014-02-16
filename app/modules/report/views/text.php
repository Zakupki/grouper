			<div class="centerwrap">
				<h1>
				   <?=$this->view->texttitle;?>
				</h1>
				<p><?=$this->view->text;?></p>
			</div>
			<?
			if($this->registry->action=="finishactive" && $_GET['status']==1){
			?>
			<script>
			function redirect(page) {
			   window.document.location.href = page;
			}
				setTimeout('redirect("/")',5000); 
			</script>	
			<?}?>