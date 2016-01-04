$(".draggable" ).draggable({
     revert: true,
	 opacity: 0.5,
	 zIndex:10000,
     drag: function (event, ui) {   
     }
})
$(".droppable").droppable({
	hoverClass: "ui-drop-hover",
    drop: function(e, ui) {
        // This gets the ID of the item you are dragging
        var item_id = $(ui.draggable).attr('id');
		var location = $(this).attr("id");
		$( this )
            .addClass( "ui-state-highlight")
            .find( "p" )
            swal("Great Work!", "Your file has been sent to your contact successfully!", "success");
        // Ajax call .
        $.ajax({
            type: "GET",
            timeout: 10000,
            url: "../data/send-file?location="+location+"&item_id="+item_id,
        });
    }
});
$(".droppable-group").droppable({
	hoverClass: "ui-drop-hover",
    drop: function(e, ui) {
        // This gets the ID of the item you are dragging
        var item_id = $(ui.draggable).attr('id');
		var location = $(this).attr("id");
		$( this )
            .addClass( "ui-state-highlight")
            .find( "p" )
			swal("Awesome Job!", "Your file has been sent to your group successfully!", "success");
        // Ajax call .
        $.ajax({
            type: "GET",
            timeout: 10000,
            url: "../data/send-group-file?location="+location+"&item_id="+item_id,
        });
    }
});
$(".move-file").droppable({
    drop: function(e, ui) {
        // This gets the ID of the item you are dragging
        var item_id = $(ui.draggable).attr('id');
		var location = $(this).attr("id");
		$(ui.draggable).addClass("disappear");
		$( this )
            
            .find( "p" )
        
        // Ajax call .
        $.ajax({
            type: "GET",
            timeout: 10000,
            url: "../data/move-file?location="+location+"&item_id="+item_id,
        });
    }
});
	
$(".move-up").droppable({
    drop: function(e, ui) {
        // This gets the ID of the item you are dragging
        var item_id = $(ui.draggable).attr('id');
		$(ui.draggable).addClass("disappear");
		$( this )
            
            .find( "p" )
        
        // Ajax call .
        $.ajax({
            type: "GET",
            timeout: 10000,
            url: "../data/move-up?item_id="+item_id,
        });
    }
});	
	
$(".delete-it").droppable({
    drop: function(e, ui) {
        // This gets the ID of the item you are dragging
        var item_id = $(ui.draggable).attr('id');
		var location = $(this).attr("id");
		$( this )
            .addClass( "ui-state-highlight" )
            .find( "p" )
        swal({   
		title: "Are you sure?",   
		text: "This will permenantly delete this item and any associated files.",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Yes, delete them!",   
		cancelButtonText: "No, cancel please!",   
		closeOnConfirm: false,   
		closeOnCancel: false }, 
	function(isConfirm){   
		if (isConfirm){     
			swal("Good Job!", "Your item(s) has been deleted successfully.", "success"); 
			$(ui.draggable).addClass("disappear");
			// Ajax call .
			$.ajax({
				type: "GET",
				timeout: 10000,
				url: "../data/delete-item?item="+item_id,
			});
			}
		else { swal("Action Canceled", "Your data has been unaffected.", "error");}});   
        
    }
});	
	
$(function(){
	//acknowledgement message
    var message_status = $("#status");
    $("span[contenteditable=true]").blur(function(){
        var field_userid = $(this).attr("id") ;
        var value = $(this).text() ;
        $.post('../data/rename.php' , field_userid + "=" + value, function(data){
            if(data != '')
			{
				message_status.show();
				message_status.text(data);
				//hide the message
				setTimeout(function(){message_status.hide()},3000);
			}
        });
    });
});
	
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});	
	
$(".truncate").dotdotdot();	

document.getElementById("chooser-image").onclick = function () {
        Dropbox.choose({
            linkType: "direct",
            success: function (files) {
				swal("Dropbox Success!", "Your file has been uploaded successfully.", "success");
				// Ajax call .
				$.ajax({
					type: "GET",
					timeout: 10000,
					url: "../data/dropbox-uploader?item="+files[0].link+"&folder=<?php echo $_GET['p'];?>",
				});
				setTimeout(function(){// wait for 5 secs(2)
				   location.reload(); // then reload the page.(3)
			  	}, 3000); 
            }
        });
    };

$(document).ready(function() {
		$('#keyword').on('input', function() {
			var value = $(this).val();
			var search_results = $("#search-results");
			if (value.length >= 3) {
				$('.searching').show();
				$.post('../data/search.php?q=' + value, function(data){
					if(data != '')
					{
						search_results.show();
						search_results.html(data);
						$(".draggable" ).draggable({
							 revert: true,
							 opacity: 0.5,
							 zIndex:10000,
							 drag: function (event, ui) {   
							 }
						});	
					}
				});
			}
		});
	});
