/**
 * @author d.bozhok
 */


function moneySum(){
		$('#moneysum').change(function(){
			var randate = new Date().getTime();
			$.post("/admin/statistics/muzstat/", "period="+$(this).val(), function(data){
				$('#curmoneysum').text(data+" muz");
			});
		});
}



function admintest(){
		//alert(123);
		$('#usertype1').change(function(){
			$('#new_user').hide();
			$('#old_user').show();
		});	
		$('#usertype2').change(function(){
			$('#old_user').hide();
			$('#new_user').show();
		});	
}
  
//================== ЗАПУСК ===================
$(document).ready(function() {
	admintest();
});