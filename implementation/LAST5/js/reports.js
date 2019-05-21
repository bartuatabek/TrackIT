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
    
    
    
                $.post( "reports.php", { func_name: "create_pviewd"})
                .done(function( data ) {
            });
    
                $.post( "reports.php", { func_name: "fetch_pview"})
                .done(function( data ) {
                    let dataparsed = JSON.parse(data);
                    console.log(dataparsed);

                dataparsed.forEach(function(element) {
                    document.getElementById("pviewtb").innerHTML+='<tr>'+
                                                          '<th scope="row">'+element.project_id+'</th>'+
                                                          '<td>'+element.name+'</td>'+
                                                          '<td>'+element.start_date+'</td>'+
                                                          '<td>'+element.end_date+'</td>'+
                                                          '<td>'+element.day_passed+'</td>'+
                                                          '<td>'+element.day_remaning+'</td>'+
                                                          '</tr>';
                });
                    
            });
    
    
    
    
    
    
    
    
});