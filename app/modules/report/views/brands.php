			<div class="centerwrap">
				<h1>
				   Ваши бренды
				</h1>
				<p>
				<?
				foreach($this->view->brandlist as $brand){?>
				<a href=""><img src="<?=$brand['logo'];?>"/></a>
				<?
				}
				?>
				</p>
			</div>
			