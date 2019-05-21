$(document).ready(function() {
	$.post( "reports.php", { func_name: "fetch_projectCount"})
        .done(function( data ) {
        
        document.getElementById("projectcount").innerHTML +=data;
    });
    
    $.post( "reports.php", { func_name: "fetch_teamCount"})
        .done(function( data ) {
        
        document.getElementById("teamcount").innerHTML +=data;
    });
    
    
    $.post( "reports.php", { func_name: "fetch_greatestProject"})
        .done(function( data ) {
        
        document.getElementById("greatestProject").innerHTML +=data;
    });
    
    
    
});