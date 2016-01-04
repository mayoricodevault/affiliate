$(function(){
	//acknowledgement message
    var message_status = $("#status");
    $("span[contenteditable=true]").blur(function(){
        var field_userid = $(this).attr("id") ;
        var value = $(this).text() ;
        $.post('../data/update-details.php' , field_userid + "=" + value, function(data){
            if(data != '')
			{
				message_status.show();
				message_status.html(data);
				//hide the message
				setTimeout(function(){message_status.hide()},3000);
			}
        });
    });
});

$(document).ready(function(){
  $('#delete-file').on('submit',function(e) {  //Don't foget to change the id form
	swal({   
		title: "Are you sure?",   
		text: "This will permenantly delete this file from your account and the server.",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Yes, delete it!",   
		cancelButtonText: "No, cancel please!",   
		closeOnConfirm: false,   
		closeOnCancel: false }, 
	function(isConfirm){   
		if (isConfirm){     
			$("#delete-file").submit();
			}
		else { swal("Action Canceled", "Your data has been unaffected.", "error");}});  
  
    e.preventDefault(); //This is to Avoid Page Refresh and Fire the Event "Click"
  });
});
	
$(".truncate").dotdotdot();	


(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));