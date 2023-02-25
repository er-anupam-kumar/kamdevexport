function showError(message,delay=2000){
	alertify.set('notifier','position', 'bottom-center');
	alertify.error(message);
}

function showSuccess(message,delay=2000){
	alertify.set('notifier','position', 'bottom-center');
	alertify.success(message);
}

if($(".select2").length>0){
	$(".select2").select2({
		placeholder: $(this).data('placeholder'),
	});
}

if($(".tinymce").length > 0){
	tinymce.init({
		selector: "textarea.tinymce",
		theme: "modern",
		height:250,
		style_formats: [
		{title: 'Bold text', inline: 'b'},
		{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
		{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}}
		]
	});
}

$('.query-link').on('click',function(){
	var key = $(this).data('param');
	var value = $(this).data('val');
	window.location.href = updateURL(window.location.href,key,value);
});

$('.query-select').on('change',function(){
	var key = $(this).data('param');
	var value = $(this).val();
	window.location.href = updateURL(window.location.href,key,value);
});

function updateURL(uri, key, value) {
	var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
	var separator = uri.indexOf('?') !== -1 ? "&" : "?";
	if (uri.match(re)) {
		return uri.replace(re, '$1' + key + "=" + value + '$2');
	}
	else {
		return uri + separator + key + "=" + value;
	}
}
