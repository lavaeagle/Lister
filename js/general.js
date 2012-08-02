$(function(){
	$('.tt').tooltip();
	$('iframe#load').attr('src', 'index.php?phpinfo');
	
	$(".previewIt").click(function(){
		var url = $(this).data("url");
		$('iframe#load').attr('src', url);
	});
});