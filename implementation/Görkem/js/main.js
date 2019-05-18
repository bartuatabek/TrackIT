

$(document).ready(function(){
    $.post( "request.php", { func_name: "fetch_project"})
        .done(function( data ) {

        let dataparsed = JSON.parse(data);

        document.getElementById("pname").innerHTML+= " " + dataparsed[0].name;
        document.getElementById("pstat").innerHTML+= " " + dataparsed[0].status;
        document.getElementById("pdesc").innerHTML+= " " + dataparsed[0].description;
        document.getElementById("pstartdate").innerHTML+= " " + dataparsed[0].start_date;
        document.getElementById("penddate").innerHTML+= " " + dataparsed[0].end_date;

    });

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
        console.log(data);
        $.post( "request.php", dataJson)
            .done(function( rdata ) {
                console.log(rdata)
        

        });

    });
});