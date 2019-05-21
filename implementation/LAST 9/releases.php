<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/releases.css">

  <title>Releases</title>
</head>

<body>
  <header class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Track-IT</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link active" href="#">Home</a>
          <a class="nav-item nav-link" href="#">Features</a>
          <a class="nav-item nav-link" href="#">Pricing</a>
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
    <h1 class="page-title">Releases</h1>
  </div>

  <div class="container btn-container">
    <button type="button" class="btn btn-success mx-auto d-block"
    id="release-modal-button" data-toggle="modal"
    data-target="#release-add-modal">Add Release</button>
  </div>

  <div class="container release-container" id="release-container">
    <div class="card-columns" id="card-columns">
      <?php


          include ("config.php");
          session_start();
          $pr = $_SESSION['project_id'];
          $sql = "SELECT * FROM Releases WHERE project_id='$pr'";
          $result = mysqli_query($db, $sql);
          if($result-> num_rows > 0) {
      while($row = $result-> fetch_assoc()) {
      ?>
      <div class="card release-card">
        <div class="card-header" id="clickableHeader" data-toggle="modal"
        data-target="#release-info-modal"
        onclick="inspectReleaseCard(<?php echo $row['release_id'] ?>)">
          <div class="row">
            <div class="col">
              <h5 class="card-title" id="release-title"><?php echo $row['name'] ?></h5>
              <p class="card-text" class="text-muted"><?php echo $row['start_date'] ?></p>
            </div>
            <div class="float-right">
              <p class="card-text version-text"><?php echo $row['version'] ?></p>
            </div>
          </div>
          <i class="fa fa-circle"></i>
        </div>
        <div class="card-block">
          <p><?php echo $row['URL'] ?></p>
          <p class="card-text release-description"> <?php echo $row['note'] ?></p>

          <div class="d-flex justify-content-around">
            <button type="button resolve-btn" class="btn btn-danger">Delete</button>
            <button type="button resolve-btn" class="btn btn-success">Save</button>
          </div>

        </div>
      </div>
    <?php } } ?>
    </div>
  </div>

  <div class="modal fade" id="release-info-modal" tabindex="-1" role="dialog" aria-labelledby="release-info-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <label for="release-name" class="col-form-label" id="release-modal-title"><h5> Release Information</h5></label>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <h5 class="col-form-label">Release Name:</h5>
          <p name="release-name-info" id="release-name-info"></p>

          <h5 class="col-form-label">Version Number:</h5>
          <p name="release-version-info" id="release-version-info"></p>

          <h5 class="col-form-label">Release URL:</h5>
          <p name="release-url-info" id="release-url-info"></p>

          <h5 class="col-form-label">Release description:</h5>
          <p name="release-description-info" id="release-description-info"></p>

        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="release-add-modal" tabindex="-1" role="dialog" aria-labelledby="release-add-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="release-add-modal-title">Add Release</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="release-name" class="col-form-label">Release Name:</label>
            <input class="form-control" id="release-name">
          </div>
          <div class="form-group">
            <label for="version-number" class="col-form-label">Version Number:</label>
            <input class="form-control" id="version-number">
          </div>
          <div class="form-group">
            <label for="release-url" class="col-form-label">Release URL:</label>
            <input class="form-control" id="release-url">
          </div>
          <div class="form-group">
            <label for="release-description" class="col-form-label">Release description:</label>
            <textarea class="form-control" id="release-description"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" id="submitButton" onclick="createReleaseCard()"
          data-dismiss="modal" class="btn btn-success">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="js/releases.js"></script>

</html>
