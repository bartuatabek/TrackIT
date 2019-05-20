$(document).ready(function() {
	
  $('.remove-priv').click(function(){
		var user_id = $(this).val();
		$.post("mrequest.php", { func_name: "remove_privilage", user_id: user_id})
        .done(function(data) {
				location.reload(true);
    });
	});
	
	$('.add-priv').click(function(){
		var user_id = $(this).val();
		$.post("mrequest.php", { func_name: "add_privilage", user_id: user_id})
        .done(function(data) {
				location.reload(true);
    });
	});
	
});