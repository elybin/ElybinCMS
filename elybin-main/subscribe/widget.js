// Hide After Subscribe and Say Thanks
$(function() {
	//$("#subscribe .btn").click(function(){
	//	$("#subscribe").slideUp();
	//	$("#success").slideDown();
	//	return false;
	//});
	
	//$("#success .close").click(function(){
	//	$("#success").slideUp();
	//	$("#subscribe-hr").slideUp();
	//	return false;
	//});
	$('#subscribe-form #emailinput').focus(function(){
		$('#subscribe-form #codecp').slideDown();
	});
	$('#subscribe-form').submit(function(e){
		$("#subscribe .btn i").fadeIn();
		$("#subscribe .btn span#sub").hide();
		$("#subscribe .btn span#loading").fadeIn();
	    $.ajax({
	      url: $(this).attr('action'),
	      type: 'POST',
	      data: new FormData(this),
	      processData: false,
	      contentType: false,
	      success: function(data) {
				console.log(data);
			  	var data = $.parseJSON(data);
			  	// check first success nor
			  	if(data.status == "ok"){
					$("#subscribe-success p").html(data.isi);
					$("#subscribe-success").slideDown();
					$("#subscribe").slideUp();
					
					$("#subscribe #loading").fadeOut();	
			  	}
			  	else if(data.status == "error"){
					$("#subscribe-error p").html(data.isi);
			  		$("#subscribe-error").slideDown();
					$("#subscribe").slideUp();
					$("#subscribe #loading").fadeOut();
			  	}
		   },
		 error: function(data) {
			$("#subscribe-error").slideDown();
			$("#subscribe").slideUp();
			$("#subscribe #loading").fadeOut();
		 }
	    });
	    e.preventDefault();
	    return false;
  	});
	
	$("#subscribe-error .close").click(function(){
		$("#subscribe-error").slideUp();
		$("#subscribe, #subscribe-form").slideDown();
		
		$("#subscribe .btn i").hide();
		$("#subscribe .btn span#sub").fadeIn();
		$("#subscribe .btn span#loading").hide();
		return false;
	});
	
	$("#subscribe-success .close").click(function(){
		$("#subscribe-success, #subscribe, #subscribe-hr").slideUp();
		return false;
	});
});