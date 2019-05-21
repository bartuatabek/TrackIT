<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Track-It</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link rel="shortcut icon" type="image/png" href="./img/logo.png"/>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
		<link rel="stylesheet" href="css/users.css">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
								<a class="nav-item nav-link active" href="#">Projects</a>
								<a class="nav-item nav-link" href="#">Project Information</a>
								<a class="nav-item nav-link" href="#">Issue</a>
								<a class="nav-item nav-link" href="#">Releases</a>
								<a class="nav-item nav-link" href="#">Reports</a>
								<a class="nav-item nav-link" href="#">Users</a>
								<a class="nav-item nav-link order-3" href="#">Logout</a>
						</div>
				</div>
			</nav>
		</header>
		
		<div class="profile-container">
		</div>
		
		<div class="container">
			<h2>Users</h2>
			<!--team-->
			<div class="team">
				<?php
						include 'config.php';
						$sql = "SELECT user_id, name, username FROM PrivilegedUser NATURAL JOIN User";
						$result = mysqli_query($db, $sql);

						if($result-> num_rows > 0) {
								while($row = $result-> fetch_assoc()) {
				?>
									<div class="card">
										<figure>
											<img src="http://style.anu.edu.au/_anu/4/images/placeholders/person.png" />
											<figcaption>
												<h4><?php echo $row['name']?></h4>
												<h5>@<?php echo $row['username']?></h5>
												<span class="badge badge-pill badge-primary">Privilaged</span>
											</figcaption>
										</figure>
										<div class="links">
											<button class="remove-priv" value="<?php echo $row['user_id']?>"><i class="fas fa-star"></i></button>
										</div>
									</div>
				<?php
								}
						}
				
						$sql = "SELECT user_id, name, username FROM StandardUser NATURAL JOIN User";
						$result = mysqli_query($db, $sql);

						if($result-> num_rows > 0) {
								while($row = $result-> fetch_assoc()) {
				?>
									<div class="card">
										<figure>
											<img src="http://style.anu.edu.au/_anu/4/images/placeholders/person.png" />
											<figcaption>
												<h4><?php echo $row['name']?></h4>
												<h5>@<?php echo $row['username']?></h5>
											</figcaption>
										</figure>
										<div class="links">
											<button class="add-priv" value="<?php echo $row['user_id']?>"><i class="far fa-star"></i></button>
										</div>
									</div>
				<?php
								}
						}
						$db-> close();
				?>
			</div>
		</div>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
		<script src="js/users.js"></script>
	</body>
</html>