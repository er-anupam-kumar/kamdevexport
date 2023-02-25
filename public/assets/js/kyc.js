$('#doing_business_as').on('change',function(){
	var value = $(this).val();
	if(value=='1'){
		$('.business_type').show('slow');
	}else{
		$('.business_type').hide('slow');
		$('#business_type').val('');
		$('.company').hide('slow');
	}
});

$('#business_type').on('change',function(){
	var value = $(this).val();
	if(value=='0' || value=='3'){
		$('.company').hide('slow');
	}else{
		$('.company').show('slow');
	}

	if(value=='2' || value=='5'){
		$('.not-for-limited').hide('slow');
	}else{
		$('.not-for-limited').show('slow');
	}

});