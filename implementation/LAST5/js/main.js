
var privileged=0;
function fetchTeam(){
    $.post( "request.php", { func_name: "fetch_team"})
        .done(function( data ) {
        console.log(data);
        let dataparsed = JSON.parse(data);

        document.getElementById("teams").innerHTML = ""; 
        dataparsed.forEach(function(team_element) {
            var participantStr ="";
            $.post( "request.php", { func_name: "fetch_tparticipants", team_id: team_element.team_id})
                .done(function( data ) {
                console.log(data);
                let dataparsed = JSON.parse(data);

                dataparsed.forEach(function(element) {
                    participantStr +=
                        '<a ondblclick="delete_userFromTeam('+element.user_id+','+team_element.team_id+')" style="font-size:13px;">'+element.name +'<span style="color: darkgray"> #'+element.user_id+ '</span> </a>'+
                        '<a style="font-size:13px;">|</a>';
                });



                addTeamsStr= 
                    '<p  class="font-weight-bold" style="font-size:20px; display: inline;" data-toggle="collapse" data-target="#teamcol'+team_element.team_id+'">'+team_element.name+ '<i class="fas fa-caret-down"></i></p> <i  onclick= "setSessionRE(\'team_id\','+team_element.team_id+',\'/board.html\')" class="far fa-arrow-alt-circle-right"></i><span style="display: block;"></span>'+
                    '<div id="teamcol'+team_element.team_id+'" class="collapse">'+
                    '<p ><span class="font-weight-bold" style="font-size:16px;">Team description:</span> '+ team_element.description+'</p>'+
                    '<p class="font-weight-bold" style="font-size:16px;">Participants</p>'+
                    '<div id="tparticipants'+team_element.team_id+'" class="overflow-auto" style="height: auto;max-height: 100px;overflow-x: hidden;">'+
                    participantStr;

                if(privileged == 1){
                    addTeamsStr+=
                        '</div><form onsubmit="addUser(this,'+team_element.team_id+'); return false;" id="add_user_form'+team_element.team_id+'">'+
                        '<div class="form-group mb-2 mt-2">'+
                        '<label for="addUser'+team_element.team_id+'">User ID </label>'+
                        '<input type="text" name="userIdField" class="form-control form-control-sm" id="participantId'+team_element.team_id+'"  placeholder="Enter ID">'+
                        '</div>'+
                        '<button id="add_user'+team_element.team_id+'" class="btn btn-primary btn-sm">Add User</button>'+
                        '</form>'+    
                        '<button  id ="delete_team'+team_element.team_id+'" onclick="deleteTeam('+team_element.team_id+')" type="button" class="btn btn-danger btn-sm mt-2">Delete Team</button>';
                }
                addTeamsStr+='</div>';
                document.getElementById("teams").innerHTML += addTeamsStr;
            });

        });
    });
}
function setSessionRE(key,value,href){
    $.post( "request.php", { func_name: "set_session", key:key, value:value})
        .done(function( data ) {
        window.location.href = href;
    });
}

function delete_userFromProject(user_id){
    $.post( "request.php", { func_name: "delete_userFromProject", user_id:user_id})
        .done(function( data ) {
        fetch_pparticipants();
        fetchTeam();
    });
}




function delete_userFromProject(user_id){
    $.post( "request.php", { func_name: "delete_userFromProject", user_id:user_id})
        .done(function( data ) {
        fetch_pparticipants();
        fetchTeam();
    });
}


function delete_userFromTeam(user_id,team_id){
    $.post( "request.php", { func_name: "delete_userFromTeam", user_id:user_id, team_id:team_id})
        .done(function( data ) {
        fetchTeam();
    });
}


function fetch_pparticipants(){
    $.post( "request.php", { func_name: "fetch_pparticipants"})
        .done(function( data ) {
        document.getElementById("pparticipants").innerHTML="";

        let dataparsed = JSON.parse(data);

        dataparsed.forEach(function(element) {
            document.getElementById("pparticipants").innerHTML+= 
                '<a ondblclick="delete_userFromProject('+element.user_id+')" style="font-size:13px;">'+ element.name +'<span style="color: darkgray"> #' + element.user_id +'</span> </a>'+
                '<a style="font-size:13px;">|</a>';
        });

    });
}
function inviteUserToProject(user_id,element){
    $.post( "request.php", { func_name: "add_userToProject", user_id: user_id})
        .done(function( data ) {
        fetch_pparticipants();
        $(element).toggleClass('btn-primary btn-success');
        setTimeout(function(){
            $(element).toggleClass('btn-success btn-primary');
        }, 2000);
    });


}
function deleteTeam(team_id){
    $.post( "request.php", { func_name: "delete_team", team_id: team_id})
        .done(function( data ) {
        fetchTeam();
    });
}

function addUser(element,team_id){
    let user_id = element.querySelectorAll('[name=userIdField]')[0].value;
    $.post( "request.php", { func_name: "add_userToTeam", team_id: team_id, user_id: user_id})
        .done(function( data ) {
        fetchTeam();
    });
}


//Board page
function fetch_board(){
    $.post( "request.php", { func_name: "fetch_board"})
        .done(function( data ) {
        let dataparsed = JSON.parse(data);

        document.getElementById("board_cards").innerHTML="";
        dataparsed.forEach(function(element) {
            var fetchBoardPrivilegedStr = "";
            fetchBoardPrivilegedStr+= 
                '<div class="shadow-sm card ml-3" style="height: 10rem; width: 18rem;">'+
                '<div class="p-3">'+
                '<h6 onclick="setSessionRE(\'board_id\','+element.board_id+',\'/myboard.html\')">'+element.name+'</h6>'+///////////////////////////////////////CHANGE /BOARD.HTML TO NEXT PAGE SILININCE SESSION BOARDID 0LANMIYOR.
                '<hr class="mt-0 mb-0">'+
                '<p>'+element.description+'</p>';
            if(privileged == 1){
                fetchBoardPrivilegedStr += '<i onclick="delete_board('+element.board_id+')" class="far fa-trash-alt m-2" style="position:absolute;bottom:0;right:0;"></i>';
            }
            fetchBoardPrivilegedStr += '</div></div>';
            document.getElementById("board_cards").innerHTML += fetchBoardPrivilegedStr;
        });
        if(privileged == 1){
            document.getElementById("board_cards").innerHTML+= '<div id="add_boardField">'+
                '<div  class="shadow-sm card ml-3" style="height: 10rem; width: 18rem; display: flex;justify-content: center;align-items: center;">'+
                '<div class="p-3 text-center" >'+

                '<i id="add_boardel" class="fas fa-plus-circle" style="font-size: 60px; color: darkgray"></i>'+
                '</div>'+

                '</div>'+
                '</div>';
            $( "#add_boardel" ).click(function() {
                document.getElementById("add_boardField").innerHTML= 
                    '<div class="shadow-sm card ml-3" style="height: 10rem; width: 18rem;">'+
                    '<form id="boardForm"><div class="p-3">'+
                    '<input id="boardName" type="text" class="form-control" placeholder="BoardName" aria-label="BoardName">'+
                    '<hr class="mt-0 mb-0">'+
                    '<textarea id="boardDescription" type="text" class="form-control" placeholder="BoardDescription" aria-label="BoardDescription" rows="2"></textarea>'+
                    '<i onclick="add_board()" class="fas fa-check-square m-2" style="position:absolute;bottom:0;right:0;"></i>'+
                    '</div></form>'+
                    '</div>';
            });
        }

    });
}


function delete_board(board_id){
    $.post( "request.php", { func_name: "delete_board", board_id: board_id})
        .done(function( data ) {
        fetch_board();
    });
}


function add_board(){

    let name = document.getElementById("boardName").value;
    let description = document.getElementById("boardDescription").value;
    $.post( "request.php", { func_name: "add_board", name: name, description: description})
        .done(function( data ) {
        fetch_board();
    });
}





function updateProject(){
    $( "#pname" ).replaceWith('<input id="projectname" type="text" class="form-control mt-1 mb-1" placeholder="Project Name" aria-label="ProjectName">');
    $( "#pstat" ).replaceWith('<input id="projectstatus" type="text" class="form-control mt-1 mb-1" placeholder="Project Status" aria-label="ProjectStat">');
    $( "#pdesc" ).replaceWith('<input id="projectdescription" type="text" class="form-control mt-1 mb-1" placeholder="Project Description" aria-label="ProjectDesc">');
    $( "#pstartdate" ).replaceWith('<input id="projectsdate" type="text" class="form-control mt-1 mb-1" placeholder="Project StartDate" aria-label="ProjectSDate">');
    $( "#penddate" ).replaceWith('<input id="projectedate" type="text" class="form-control mt-1 mb-1" placeholder="Project EndDate" aria-label="ProjectEDate">');
    $( "#pupdatesubmit" ).replaceWith('<button id="pupbut" onclick="update_project()" type="submit" class="btn btn-primary mt-1 mb-1">Update Project</button>');
}


function update_project(){
    let name = document.getElementById("projectname").value;
    let status = document.getElementById("projectstatus").value;
    let description = document.getElementById("projectdescription").value;
    let start_date = document.getElementById("projectsdate").value;
    let end_date = document.getElementById("projectedate").value;
    console.log(status);
    console.log(start_date);
    $.post( "request.php", { func_name: "update_project", name: name, description: description,status:status,start_date:start_date,end_date:end_date})
        .done(function( data ) {
        $( "#projectname" ).replaceWith('<h6 id="pname">Project name:</h6>');
        $( "#projectstatus" ).replaceWith('<h6 id="pstat">Status:</h6>');
        $( "#projectdescription" ).replaceWith('<h6 id="pdesc">Description:</h6>');
        $( "#projectsdate" ).replaceWith('<h6 id="pstartdate">Start Date:</h6>');
        $( "#projectedate" ).replaceWith('<h6 id="penddate">End Date:</h6>');
        $( "#pupbut" ).replaceWith('<div id="pupdatesubmit"></div>');
        fetch_project();
    });
}

function fetch_project(){
$.post( "request.php", { func_name: "fetch_project"})
                .done(function( data ) {
                let dataparsed = JSON.parse(data);
                document.getElementById("pname").innerHTML+= " " + dataparsed[0].name;
                document.getElementById("pstat").innerHTML+= " " + dataparsed[0].status;
                document.getElementById("pdesc").innerHTML+= " " + dataparsed[0].description;
                document.getElementById("pstartdate").innerHTML+= " " + dataparsed[0].start_date;
                document.getElementById("penddate").innerHTML+= " " + dataparsed[0].end_date;

            });
}


$(document).ready(function(){











    if(window.location.pathname == "/projectinfo.html"){  ////////////////////CHANGE
        $.post( "request.php", { func_name: "fetch_privileged"})
            .done(function( data ) {
            privileged = data;
            if(data == 0){
                $('#teamAddCircle').remove();
                $('#user_showcase').remove();
            }

            fetch_project();

            fetch_pparticipants();

            $.post( "request.php", { func_name: "fetch_users"})
                .done(function( data ) {

                let dataparsed = JSON.parse(data);
                var maxCard = 6;
                dataparsed.forEach(function(element) {
                    if(document.getElementById("user_cards") == null){
                        return;
                    }
                    document.getElementById("user_cards").innerHTML+= 
                        '<div class ="col-6 mt-3">'+
                        '<div class="shadow-sm card">'+
                        '<div class="text-center">'+
                        '<img class="rounded-circle align-center mt-2" width="40" height="40" src="./images/default.jpg" alt="Card image cap">'+
                        '<p class= "mt-1 mb-0" style="font-size:11px;"> #'+element.user_id+'</p>'+
                        '<div class="pt-1 pr-2 pl-2 pb-1">'+
                        '<p class="mb-0" style="font-size:14px;">'+element.name+'</p>'+
                        '</div>'+
                        '<button onclick="inviteUserToProject('+element.user_id+',this)" type="button" class="btn btn-primary pb-0 pt-0 mb-1">Invite</button>'+
                        '</div>'+
                        '</div>'+
                        '</div>';
                    maxCard = maxCard - 1;
                    if(maxCard == 0){
                        return;
                    }
                });

            });
            fetchTeam();
            $('#teamform').on('submit', function(e) { //use on if jQuery 1.7+
                e.preventDefault();  //prevent form from submitting
                var data = $("#teamform").serializeArray();
                data.push({"name": "func_name","value" : "add_team"});
                var dataJson = {};
                $.each(data, function() {
                    if (dataJson[this.name]) {
                        if (!dataJson[this.name].push) {
                            dataJson[this.name] = [dataJson[this.name]];
                        }
                        dataJson[this.name].push(this.value || '');
                    } else {
                        dataJson[this.name] = this.value || '';
                    }
                });

                $.post( "request.php", dataJson)
                    .done(function( rdata ) {
                    fetchTeam();
                    $('#tname').val('');
                    $('#tdescription').val('');
                });

            });


        });

    }else if(window.location.pathname == "/board.html"){
        $.post( "request.php", { func_name: "fetch_privileged"})
            .done(function( data ) {
            privileged = data;
            fetch_board();
        });


    }
});