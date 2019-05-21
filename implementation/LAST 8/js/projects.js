//Board page
var privileged = 0;
function fetch_board(){
    $.post( "projects.php", { func_name: "fetch_project"})
        .done(function( data ) {
        let dataparsed = JSON.parse(data);

        document.getElementById("board_cards").innerHTML="";
        dataparsed.forEach(function(element) {
            var fetchBoardPrivilegedStr = "";
            fetchBoardPrivilegedStr+= 
                '<div class="shadow-sm card ml-3" style="height: 10rem; width: 18rem;">'+
                '<div class="p-3">'+
                '<h6 onclick="setSessionRE(\'project_id\','+element.project_id+',\'/projectinfo.html\')">'+element.name+'</h6>'+///////////////////////////////////////CHANGE /BOARD.HTML TO NEXT PAGE SILININCE SESSION BOARDID 0LANMIYOR.
                '<hr class="mt-0 mb-0">'+
                '<p>'+element.description+'</p>';
            console.log(fetchBoardPrivilegedStr);
            
            if(privileged == 1){
                
                fetchBoardPrivilegedStr += '<i onclick="delete_board('+element.project_id+')" class="far fa-trash-alt m-2" style="position:absolute;bottom:0;right:0;"></i>';
            }
            fetchBoardPrivilegedStr += '</div></div>';
            console.log(fetchBoardPrivilegedStr);
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
                    '<input id="boardName" type="text" class="form-control" placeholder="Project Name" aria-label="BoardName">'+
                    '<hr class="mt-0 mb-0">'+
                    '<textarea id="boardDescription" type="text" class="form-control" placeholder="Project Description" aria-label="BoardDescription" rows="2"></textarea>'+
                    '<i onclick="add_board()" class="fas fa-check-square m-2" style="position:absolute;bottom:0;right:0;"></i>'+
                    '</div></form>'+
                    '</div>';
            });
        }

    });
}


function delete_board(project_id){
    $.post( "projects.php", { func_name: "delete_project", project_id: project_id})
        .done(function( data ) {
        fetch_board();
    });
}


function add_board(){

    let name = document.getElementById("boardName").value;
    let description = document.getElementById("boardDescription").value;
    $.post( "projects.php", { func_name: "add_project", name: name, description: description})
        .done(function( data ) {
        fetch_board();
    });
}



function setSessionRE(key,value,href){
    $.post( "projects.php", { func_name: "set_session", key:key, value:value})
        .done(function( data ) {
        window.location.href = href;
    });
}











$(document).ready(function(){

        $.post( "projects.php", { func_name: "fetch_privileged"})
            .done(function( data ) {
            privileged = data;
            console.log(privileged);
            fetch_board();
        });


    
});