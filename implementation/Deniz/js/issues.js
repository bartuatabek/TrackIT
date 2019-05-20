function createIssueCard() {
  //element.preventDefault();
  console.log("WORKING");
  var submitBtn = document.getElementById("submitButton");

  var issueName = document.getElementById("issue-name").value;
  var assignedUser = document.getElementById("assigned-user").value;
  var issueDescription = $('textarea#issue-description').val();
  var issueTag = document.getElementById("issue-tag").value;
  var issuePriority = document.getElementById("issue-priority").value;
  var issueStatus = document.getElementById("issue-status").value;

  console.log(issuePriority);


  var issueCard = '<div class="card issue-card">' +
    '<div class="card-header">' +
    '<div class="row">' +
    '<div class="col">' +
    '<h4 class="card-title">' + issueName + '</h4>' +
    '</div>' +
    '<div class="col">' +
    '<p class="text-right">' + issueStatus + '</p>' +
    '</div>' +
    '</div>' +
    '<i class="fa fa-circle"></i>' +
    '</div>' +
    '<div class="card-block">' +
    '<h6 class="card-title"> Issue Priority:' + issuePriority + '</h6>' +
    '<p class="card-text issue-description" id="issue-description">' + issueDescription + '</p>' +
    '<div class="row issue-tags justify-content-center">' +
    '<span class="badge badge-secondary">' + issueTag + '</span>' +
    '</div>' +
    '<div class="row">' +
    '<div class="col-1">' +
    '<img src="images/profile_pic.png" class="rounded float-left" width="25px" height="25px" data-toggle="tooltip" data-placement="top" title="(assigned_by)" id="assigner-profile">' +
    '</div>' +
    '<div class="col-1">' +
    '<img src="https://img.icons8.com/ios-glyphs/30/000000/arrow.png"></div>' +
    '<div class="col-1"> <img src="images/profile_pic.png" class="rounded float-left" width="25px" height="25px" data-toggle="tooltip" data-placement="top" title="(assigned_to)" id="assigned-to-profile"> </div>' +
    '<div class="col-4"><p class="card-text"><small class="text-muted">Created 3 mins ago</small></p></div>' +
    '<div class="col-1"><img src="images/add_user_button.png" width="30px" height="30px" data-toggle="tooltip" data-placement="top" title="Issue Another" id="new-issue-profile"></div>' +
    '<div class="col-4 align-self-right"><button type="button resolve-btn" class="btn btn-success">Resolve</button></div>' +
    '</div></div></div>';

  $("#card-columns").append(issueCard);




  $.post("phphandler.php", {
      func_name: "add_issue",
      name: issueName,
      status: issueStatus,
      priority: issuePriority,
      note: issueDescription,
      issue_tag: issueTag
    })
    /*
    .done(function(data) {
      //location.reload(true);
    });
    */
}


$(document).ready(function() {
    console.log("ready!");
});
