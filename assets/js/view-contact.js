$(function(){
	//acknowledgement message
    var message_status = $("#status");
    $("span[contenteditable=true]").blur(function(){
        var field_userid = $(this).attr("id") ;
        var value = $(this).text() ;
        $.post('../data/update-contact.php' , field_userid + "=" + value, function(data){
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

$('.invite').click(function(event) {
   event.preventDefault();
	var c = $(this).attr("id");
   swal("Contact Invited!", "Your contact has been invited to create an account.", "success"); 
	// Ajax call .
	$.ajax({
		type: "GET",
		timeout: 10000,
		url: "../data/invite-contact?c="+c,
	});
});

$('.delete').click(function(event) {
    event.preventDefault();
	swal({   
		title: "Are you sure?",   
		text: "This will remove the contact from your account.",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Yes, delete them!",   
		cancelButtonText: "No, cancel please!",   
		closeOnConfirm: false,   
		closeOnCancel: false }, 
	function(isConfirm){   
		if (isConfirm){     
			swal("Contact Deleted!", "Your contact has been deleted successfully.", "success"); 
			setTimeout(
			  function() 
			  {
				$("#delete-contact").submit();
			  }, 2000);
			}
		else { swal("Canceled", "Your contact is safe!...for now :)", "error");}});
	});