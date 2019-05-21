<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/issues.css">

    <title>Issues</title>
</head>

<body>
    <header class="fixed-top">
			<nav class=" shadow-sm navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="#">Track-IT</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
						<div class="  navbar-nav">
								<a class="nav-item nav-link active" href="/projects.html">Projects</a>
								<a class="nav-item nav-link" href="/projectinfo.html">Project Information</a>
								<a class="nav-item nav-link" href="/issues.php">Issue</a>
								<a class="nav-item nav-link" href="/releases.php">Releases</a>
								<a class="nav-item nav-link" href="/reports.html">Reports</a>
								<a class="nav-item nav-link" href="/users.php">Users</a>
								<a class="nav-item nav-link order-3" href="/logout.php">Logout</a>
						</div>
				</div>
			</nav>
		</header>

    <div class="container mt-4"> SPACE HOLDER</div>

    <hr>

    <div class="container mt-3 profile-container">
        <div class="row justify-content-end align-items-center profile-row">
            <div class="col-1.2 profile-col">
                <div class="profile-name">
                    <p class="text-right"><strong>John Smith</strong></p>
                </div>
            </div>
            <div class="col-1 profile-col">
                <img src="images/profile_pic.png" class="rounded float-left" width="50px" height="50px" alt="">

            </div>
        </div>
    </div>

    <div class="container title-container">
        <h1 class="page-title">Issues</h1>
    </div>

    <button type="button" class="btn btn-success mx-auto d-block" id="issue-modal-button" data-toggle="modal" data-target="#issue-modal">Add Issue</button>

    <div class="container issue-container" id="issue-container">
        <div class="card-columns" id="card-columns">
            <?php
                include ("config.php");
                session_start();
                $pr = $_SESSION['project_id'];
                $sql = "SELECT * FROM Issue WHERE project_id='$pr'";
                $result = mysqli_query($db, $sql);
                if($result-> num_rows > 0) {
				    while($row = $result-> fetch_assoc()) {
            ?>
            <div class="card issue-card">

                <div class="card-header" data-toggle="modal" data-target="#issue-info-modal" onclick="inspectIssueCard(<?php echo $row['issue_id'] ?>)">
                    <div class="row">
                        <div class="col">
                            <h4 class="card-title"> <?php echo $row['name'] ?></h4>
                        </div>
                        <div class="col">
                            <p class="text-right" id="issue-status-info"> <?php echo $row['status'] ?> </p>
                        </div>
                    </div>
                    <i class="fa fa-circle"></i>
                </div>
                <div class="card-block">
                    <h6 class="card-title"><?php echo 'Priority:' . $row['priority'] ?> </h6>
                    <!--
                    <p class="card-text days-left-text"><small class="text-muted">5 Days Left</small></p>
                    -->
                    <p class="card-text issue-description"> <?php echo $row['note'] ?></p>

                    <div class="row issue-tags justify-content-center">
                        <span class="badge badge-secondary">Issue Tag</span>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <img src="images/profile_pic.png" class="rounded float-left" width="25px" height="25px" data-toggle="tooltip" data-placement="top" title="(assigned_by)" id="assigner-profile">
                        </div>
                        <div class="col-1">
                            <img src="https://img.icons8.com/ios-glyphs/30/000000/arrow.png">
                        </div>
                        <div class="col-1">
                            <img src="images/profile_pic.png" class="rounded float-left" width="25px" height="25px" data-toggle="tooltip" data-placement="top" title="(assigned_to)" id="assigned-to-profile">
                        </div>
                        <div class="col-6">
                            <p class="card-text"><small class="text-muted">Created 3 mins ago</small></p>
                        </div>
                        <div class="col-1 align-self-right">
                            <img src="images/add_user_button.png" width="30px" height="30px" data-toggle="tooltip" data-placement="top" title="Issue Another" id="new-issue-profile">
                        </div>


                    </div>
                </div>
            </div>
            <?php } } ?>
        </div>
    </div>

    <div class="row">
        <div class="col">


            <div class="modal fade" id="issue-modal" tabindex="-1" role="dialog" aria-labelledby="issue-modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="issue-modal-title">Add Issue</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="issue-name" class="col-form-label">Issue Name:</label>
                                    <input class="form-control" name="issue-name" id="issue-name">
                                </div>
                                <div class="form-group">
                                    <label for="issue-tag" class="col-form-label">Issue Tag:</label>
                                    <input class="form-control" name="issue-name" id="issue-tag">
                                </div>
                                <div class="form-group">
                                    <label for="issue-status" class="col-form-label">Issue Status:</label>
                                    <input class="form-control" name="issue-name" id="issue-status">
                                </div>
                                <div class="form-group">
                                    <label for="issue-priority" class="col-form-label">Issue Priority:</label>
                                    <input class="form-control" name="issue-name" id="issue-priority">
                                </div>

                                <!--
                                <div class="form-group">
                                    <label for="days-given" class="col-form-label">Days Left:</label>
                                    <input class="form-control" name="days-given" id="days-given">
                                </div>
                                -->
                                <div class="form-group">
                                    <label for="assigned-user" class="col-form-label">Assign to:</label>
                                    <input class="form-control" name="assigned-user" id="assigned-user">
                                </div>
                                <div class="form-group">
                                    <label for="issue-description" class="col-form-label">Issue description:</label>
                                    <textarea class="form-control" name="issue-description" id="issue-description"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="submitButton" onclick="createIssueCard()" data-dismiss="modal" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="issue-info-modal" tabindex="-1" role="dialog" aria-labelledby="issue-info-modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="issue-modal-title">Issue Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                              <h5 class="col-form-label">Issue Name:</h5>
                              <p name="issue-name-info" id="issue-name-info"></p>

                              <h5 class="col-form-label">Issue Tag:</h5>
                              <p name="issue-tag-info" id="issue-tag-info"></p>

                              <h5 class="col-form-label">Issue Status:</h5>
                              <p name="issue-status-info" id="issue-status-info"></p>

                              <h5 class="col-form-label">Issue Priority:</h5>
                              <p name="issue-priority-info" id="issue-priority-info"></p>

                              <h5 class="col-form-label">Assign to:</h5>
                              <p name="issue-assigned-user-info" id="issue-assigned-user-info"></p>

                              <h5 class="col-form-label">Issue description:</h5>
                              <p name="issue-description-info" id="issue-description-info"></p>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                          <button type="button" id="deleteButton" data-dismiss="modal" class="btn btn-danger">Delete</button>

                          <button type="button" id="resolveButton"
                            data-dismiss="modal" class="btn btn-success">Resolve</button>

                            <!-- delete'a onclick ekle-->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->



    <script src="https://code.jquery.com/jquery-3.4.1.min.js"integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/issues.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();
        });

        var goToAddIssue = function() {
            window.location.href = "add-issue.html";
        };

    </script>

</body>

</html>

<!--
GARBAGE
GREN PLUS IMAGE
<img src="images/plus_green.png"
class="rounded mx-auto d-block"
height="50px" width="50px"
data-toggle="tooltip modal"
data-toggle="modal"
data-target="#issue-modal">

-->
