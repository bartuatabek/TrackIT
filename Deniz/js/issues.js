var cardGroup = document.getElementById("card-columns");

function createIssueCard() {
  var issueCard = '<div class="card issue-card">' +
    '<div class="card-header">' +
      '<i class="fa fa-circle"></i>' +
    '</div>' +
    '<div class="card-block">' +
      '<h4 class="card-title" id="issue-title">Drag & Drop Shift</h4>'+
      '<p class="card-text days-left-text" id="days-left-text"><small class="text-muted">5 Days Left</small></p>' +
      '<p class="card-text issue-description" id="issue-description"> Lorem ipsum falan filan.</p>'+
      '<div class="row">' +
        '<div class="col-1">' +
          '<img src="images/profile_pic.png" class="rounded float-left" width="25px" height="25px" data-toggle="tooltip" data-placement="top" title="(assigned_by)" id="assigner-profile">'+
        '</div>'+
        '<div class="col-1">'+
          '<img src="https://img.icons8.com/ios-glyphs/30/000000/arrow.png"></div>'+
        '<div class="col-1"> <img src="images/profile_pic.png" class="rounded float-left" width="25px" height="25px" data-toggle="tooltip" data-placement="top" title="(assigned_to)" id="assigned-to-profile"> </div>'+
        '<div class="col-4"><p class="card-text"><small class="text-muted">Created 3 mins ago</small></p></div>'+
        '<div class="col-1"><img src="images/add_user_button.png" width="30px" height="30px" data-toggle="tooltip" data-placement="top" title="Issue Another" id="new-issue-profile"></div>'+
        '<div class="col-4 align-self-right"><button type="button resolve-btn" class="btn btn-success">Resolve</button></div>'+
        '</div></div></div>';

        $(document).ready(function () {
        $("#card-columns").append(issueCard);});
  

  /*
  var cardNode = document.createElement("div");
  cardNode.className = "card issue-card";

  var cardHeader = document.createElement("div");
  cardHeader.className = "card-header";
  var cardI = document.createElement("i");
  cardI.className = "fa fa-circle";
  cardNode.appendChild(cardHeader);
  cardHeader.appendChild(cardI);

  var cardBlock = document.createElement("div");
  cardBlock.className = "card-block";
  var cardTitle = document.createElement("h4");
  cardTitle.className = "card-title";
  cardTitle.textContent = "something";

  var cardPar = document.createElement("p");
  cardPar.className = "card-text days-left-text";
  var daysLeft = document.createElement("small");
  daysLeft.className = "text-muted";

  cardBlock.appendChild(cardTitle);


  cardNode.appendChild(cardBlock);




  cardGroup.appendChild(cardNode);
  console.log(cardGroup);
  */
}

$(function() {
  $('[data-toggle="tooltip"]').tooltip()
})
