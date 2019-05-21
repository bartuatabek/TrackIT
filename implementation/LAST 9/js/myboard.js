//set body overflow hidden;
$(".Workflow-container").css("overflow-y", "hidden")

var username;
var Workflow_config = {};
Workflow_config.height = ($(document).height() - 30);

//fix the height of the workflow container
$('.Workflow-container').height(Workflow_config.height);

//init a basic workflow
var basic_workflow;

$(function() {
    $(".ul-parent").sortable({
        handle: '.handle',
        items: '> :not(.create_workspace)',
        placeholder: "highlight",
        start: function(event, ui) {
            ui.placeholder.height(ui.helper.outerHeight());
            ui.placeholder.width(ui.helper.outerWidth());
            console.log(ui, "ui")
        }
    }).disableSelection();
});

var binder = function() {
	//for drag and drop of the workspaces
	$(function() {
			$(".ul-parent").sortable({
					handle: '.handle',
	        items: '> :not(#archive)',
					placeholder: "highlight",
					start: function(event, ui) {
							ui.placeholder.height(ui.helper.outerHeight());
							ui.placeholder.width(ui.helper.outerWidth());
							console.log(ui, "ui")
					}
			}).disableSelection();
	});

	//for shuffling of the cards
	$(function() {
			$("li #cards").sortable({
					connectWith: "li #cards",
					placeholder: "highlight",
					cancel: ".cancel_drag",
//					items: '> :not(.cancel_drag)',
					start: function(event, ui) {
							ui.placeholder.height(ui.helper.outerHeight());
							ui.placeholder.width(ui.helper.outerWidth());
							console.log(ui, "ui")
					}
			}).disableSelection();
	});

	(function($) {
			//bind delete workspace
			$('.delete-workspace').off('click').on("click", function() {
					var list_id = $(this).attr('id');
					$(this).parent().parent().remove();
					$.post("mrequest.php", {func_name: "remove_lists", list_id: list_id})
					.done(function(data) {
					});
			});
	})($);
}

//basic initializing format
function init(workflowName) {
    if (workflowName != '') {
        //for adding a workflow
        basic_workflow = '<li class="li-parent no_padding_bottom"><div class = "handle"><div class="name-of-workflow">' + workflowName + '</div><div class="delete-workspace"><span class="glyphicon glyphicon-trash">x</span></div></div>';
        basic_workflow += '<ul id="cards">';
				basic_workflow += '<li onclick="addCard(' + 1 + ')" class="cancel_drag"><div class="add-a-card">Add a card</div></li>';
        basic_workflow += '</ul></li>';
				
        //set input value to null
        $('#add_workflow').val('');
        binder();
        workflowName = '';
    } else {
        binder();
    }
}

$('#add_workflow').bind('keydown', function(e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        if (this.value === '') {
            init();
        } else {
						var list_title = this.value;
            init(this.value);
            $(basic_workflow).insertBefore('#for_prepend_purpose');
            init();
						$.post("mrequest.php", {func_name: "add_lists", title: list_title})
						.done(function( data ) {
							location.reload(true);
						});
        }

        $('.Workflow-container').animate({
            scrollLeft: 100000
        });
    }
});

$(document).ready(function() {
	$.post("mrequest.php", {func_name: "user_cred"})
		.done(function(data) {
			let dataparsed = JSON.parse(data);
			username = dataparsed;
			document.getElementById("username").innerHTML = dataparsed;
			fetchBoard();
		});

	$('#comment-content').click(function () {
        $('#comment-content').attr('readonly', false);
    });
});

function addCard(list_id) {
    $('#createCardModal').modal();
    onClickStr = "add_card('" + list_id + "')";
    document.getElementById('cadd').setAttribute( "onClick", onClickStr);	
}

function add_card(list_id) {
    let name = document.getElementById("cname").value;
    let description = document.getElementById("cdescription").value;
			
    $.post( "mrequest.php", { func_name: "add_card", title: name, description: description, list_id : list_id})
        .done(function( data ) {
        $('#createCardModal').modal('hide');
        document.getElementById("cname").value = "";
        document.getElementById("cdescription").value = "";
				
				location.reload(true);
    });
}

function showCard(card_id) {
    $.post( "mrequest.php", { func_name: "show_card", card_id: card_id})
        .done(function( data ) {
        let dataparsed = JSON.parse(data);
        document.getElementById("cpastetitle").innerHTML = dataparsed[0].title;
        document.getElementById("cpastedescription").innerHTML = dataparsed[0].description;
        onClickStr = "assign_user('" + card_id + "')";
    		document.getElementById('assuserbut').setAttribute( "onClick", onClickStr );
        
				onClickStr = "archive_card('" + card_id + "')";
				document.getElementById('archivebut').setAttribute( "onClick", onClickStr );
        
        onClickStr = "delete_card('" + card_id + "')";
        document.getElementById('cdelete').setAttribute( "onClick", onClickStr );
        fetch_assignedusers(card_id);
        fetchComment(card_id);
        $('#showCardModal').modal();
					$('#comment-content').keypress(function (e) {
					if (e.which == 13) {
						var commandText = $('#comment-content').val();
						$('#comment-content').attr('readonly', true);
						addComment(username, commandText, card_id);
						$('#comment-content').val("");
						return false;
					}
				});
    });
}

function fetch_assignedusers(card_id) {
    $.post( "mrequest.php", { func_name: "fetch_assignedusers", card_id:card_id})
        .done(function( data ) {
        document.getElementById("pparticipants").innerHTML="";

        let dataparsed = JSON.parse(data);

        dataparsed.forEach(function(element) {
            document.getElementById("pparticipants").innerHTML+= 
                '<a style="font-size:13px;">'+ element.name +'<span style="color: darkgray"> #' + element.user_id +'</span> </a>'+
                '<a style="font-size:13px;">|</a>';
        });

    });
}

function assign_user(card_id) {
    var user_id = document.getElementById("assUserText").value;
    $.post( "mrequest.php", { func_name: "assign_user", card_id:card_id, user_id:user_id})
        .done(function( data ) {
        	showCard(card_id);
    });
}

// TODO
function archive_card(card_id) {
	$.post("mrequest.php", {func_name: "is_archived", card_id: card_id})
		.done(function(data) {
			location.reload(true);
		});
}

function delete_card(card_id) {
    $.post( "mrequest.php", { func_name: "delete_card", card_id:card_id})
        .done(function( data ) {
        document.getElementById("assUserText").value = "";
        $('#showCardModal').modal('hide');
				location.reload(true);
    });
}

function fetchBoard() {
	// check archive
	$.post("mrequest.php", {func_name: "create_archive"})
		.done(function(data) {
      // get lists
			$.post("mrequest.php", {func_name: "fetch_lists"})
				.done(function(lists) {
					let dataparsed = JSON.parse(lists);
					dataparsed.forEach(function(element) {
							var list_id = element.list_id;
							var list_name = element.title;
							var workflow;
							if (list_name == "Archive") {
								workflow = '<li class="li-parent no_padding_bottom" id="archive"><div class="handle"><div class="name-of-workflow">' + list_name + '</div></div><ul id="cards" class="ui-sortable"><li class="cancel_drag" id="hidden" value="' + list_id + '"></li>';
							} else {
								workflow = '<li class="li-parent no_padding_bottom"><div class="handle"><div class="name-of-workflow">' + list_name + '</div><div class="delete-workspace" id="' + list_id + '"><span class="glyphicon glyphicon-trash">x</span></div></div><ul id="cards" class="ui-sortable"><li class="cancel_drag" id="hidden" value="' + list_id + '"></li>';
							}

							// fetch cards
							$.post("mrequest.php", {func_name: "fetch_cards", list_id: list_id})
							.done(function(cards) {
									let dataparsed = JSON.parse(cards);
									dataparsed.forEach(function(element) {
										var card_id = element.card_id;
										var card_title = element.title;

										workflow += '<li onclick="showCard(' + card_id + ')"><i class="fas fa-align-left"></i>' + card_title + '</li>';
									});
									if (list_name != "Archive") {
										workflow += '<li onclick="addCard(' + list_id + ')" class="cancel_drag"><div class="add-a-card">Add a card</div></li>';
									}
									workflow +='</ul></li>';
									binder();
									$(workflow).insertBefore('#for_prepend_purpose');
									init();
							});
					});
				});
		});
}

// TODO
function addComment(userName, commentText, card_id) {
    if(commentText == "")
        return;
	var commentItem = '<li class="comment-container">' +
			'							<div class="comment-content">' +
			'								<img class="rounded-circle" style="float: left" width="40" height="40" src="http://style.anu.edu.au/_anu/4/images/placeholders/person.png"' +
			'									alt="User avatar.">' +
			'								<ul class="list-unstyled" style="margin-left: 50px;">' +
			'									<li>' +
			'										<a style="font-size:13px;">' + userName + '<span style="color: darkgray"></span></a>' +
			'									</li>' +
			'									<li>' +
			'										<h3 style="font-size:13px;">' + commentText +
			'										</h3>' +
			'									</li>';
	$(".comments-list").append(commentItem);

	$.post("mrequest.php", {func_name: "add_comment", card_id: card_id, comment: commentText})
	.done(function(data) {
		// refresh
	});
}

// TODO
function fetchComment(card_id) {
    
    
    
    $.post("mrequest.php", {func_name: "fetch_commentname", card_id: card_id})
	.done(function(datas) {
        
        let dataparseds = JSON.parse(datas);
        var counter = 0;
		$.post("mrequest.php", {func_name: "fetch_comments", card_id: card_id})
	.done(function(data) {
		let dataparsed = JSON.parse(data);
        console.log(dataparsed);
        $(".comments-list").html("");
		dataparsed.forEach(function(element) {
				var userName = dataparseds[counter].name;
                counter=counter+1;
				var commentText = element.comment;
				var commentItem = '<li class="comment-container">' +
				'							<div class="comment-content">' +
				'								<img class="rounded-circle" style="float: left" width="40" height="40" src="http://style.anu.edu.au/_anu/4/images/placeholders/person.png"' +
				'									alt="User avatar.">' +
				'								<ul class="list-unstyled" style="margin-left: 50px;">' +
				'									<li>' +
				'										<a style="font-size:13px;">' + userName + '<span style="color: darkgray"></span></a>' +
				'									</li>' +
				'									<li>' +
				'										<h3 style="font-size:13px;">' + commentText +
				'										</h3>' +
				'									</li>';
                
				$(".comments-list").append(commentItem);
		});
	});
	});
	
}