/**
 * @author orange
 */
function askToken(){
/*     alert(window.frames.length); */
}
function logVisit(){
	if ($('.post').attr('rel')>0) {
		
		$.ajax({
                    type: 'POST',
                    url: '/ajax/visit/',
                    data: 'data='+$('.post').attr('rel')+'&type='+$('.post').attr('name'),
                 });
    }
}
//================== ЗАПУСК ===================
$(document).ready(function() {
    askToken();
	logVisit();
});