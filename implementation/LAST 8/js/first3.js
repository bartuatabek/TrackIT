function fetch_userlog(){
    var username = document.getElementById("userText").value;
    var password = document.getElementById("passtext").value;
    
    $.post( "login.php", { func_name: "fetch_user", username:username, password:password})
        .done(function( data ) {
        console.log("asd");
        let dataparsed = JSON.parse(data);

        if(dataparsed.length == 0){
            document.getElementById("errorField").innerHTML="LOGIN FAILED";/////////CHANGE LATER
            document.getElementById("userText").value="";
            document.getElementById("passtext").value="";
            console.log("asd");
        }
        else{
            console.log(dataparsed[0].user_id);
            setSessionRE("user_id",dataparsed[0].user_id,"/projects.html");//////CHANGE LATER
        }

    });
}


function setSessionRE(key,value,href){
    $.post( "login.php", { func_name: "set_session", key:key, value:value})
        .done(function( data ) {
        window.location.href = href;
    });
}

function add_usersin(){
    var username = document.getElementById("usernameField").value;
    var name = document.getElementById("nameField").value;
    var email = document.getElementById("emailField").value;
    var password = document.getElementById("passwordField").value;
    var user_type;
    console.log(document.getElementById('stdradio').checked);
    if(document.getElementById('stdradio').checked){
        user_type = 0;
    }else{
        user_type = 1;
    }
    $.post( "signup.php", { func_name: "new_user", username:username, password:password, name:name, email:email, user_type:user_type})
        .done(function( data ) {
        window.location.href = "/index.html";
    });
}