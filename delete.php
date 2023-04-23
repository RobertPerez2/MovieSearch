<?php
	if ( !isset($_GET['dvd_title_id']) || trim($_GET['dvd_title_id']) == '' ) {
		// Missing track_id;
		$error = "Invalid URL.";
	} else {
		// Valid URL w/ track_id.
		$host = "303.itpwebdev.com";
		$user = "raperez_db_user";
		$pass = "Ihusiwep1!";
		$db = "raperez_dvd_db";

		// Establish MySQL Connection.
		$mysqli = new mysqli($host, $user, $pass, $db);

		// Check for any Connection Errors.
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$sql = "DELETE FROM dvd_titles WHERE dvd_title_id = " . $_GET['dvd_title_id']  . ";";

		// echo "<hr>$sql<hr>";

		$results = $mysqli->query($sql);

		if (!$results) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$mysqli->close();

	}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delete a Movie | Movie Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="main.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item active">Delete</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Delete Confirmation</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

			<?php if(isset($error) && trim($error) != '') : ?>
				<div class="text-danger">
					<!-- Display Error Messages Here. -->
					<?php echo $error; ?>
				</div>
			<?php else : ?>
				<div class="text-success"><span class="font-italic"> <?php echo $_GET['title']; ?></span> was successfully deleted.</div>

			<?php endif; ?>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_results.php" role="button" class="btn btn-primary">Back to Search Results</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>