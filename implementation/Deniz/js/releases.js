window.onload = function () {
    var arr = document.getElementsByClassName("marker");
    for (let i = 0; i < arr.length; i++) {
        arr[i].onclick = function () {
            for (let j = 0; j < arr.length; j++) {
                arr[j].style.background = "#00000000";
            }
            arr[i].style.background = "red";

            showReleaseOnClick();

        };
    };
}

function showReleaseOnClick(){
  var releaseCard =
  '<div class="card release-card" style="width: 16rem;">'+
    '<div class="card-body">'+
      '<h5 class="card-title" name="release-name">Release Name <button type="button" class="close" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
        '</button></h5>'+
      '<p class="card-text" name="release-text">Lorem ipsum falan filan.</p>'+
      '<form>'+
        '<div class="form-group">'+
          '<label for="exampleFormControlTextarea1"></label>'+
          '<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>'+
        '</div>'+
      '</form>'+
      '<input class="btn btn-secondary" type="button" value="Edit">'+
      '<input class="btn btn-danger" type="submit" value="Delete">'+
      '<input class="btn btn-success" type="reset" value="Save">'+
    '</div>'+
  '</div>';

  $(document).ready(function () {
  $("#timeline").append(releaseCard);});
}
