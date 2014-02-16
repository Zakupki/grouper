/**
 * @author orange
 */
function test(){
	$('#test').click(function() {
	var frame = document.getElementById('authframe');
	frame.getToken();
	return false;
	});
}
//================== ЗАПУСК ===================
$(document).ready(function() {
	test();
});