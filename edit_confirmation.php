<?php
	// Check to see if any required fields are missing.
	if ( !isset($_POST['title']) || trim($_POST['title']) == '') {
		// One or more of the required fields is empty.
		$error = "Please fill out all required fields.";
	} else {
		// All required fields provided. Continue with the ADD workflow.

		$host = "303.itpwebdev.com";
		$user = "raperez_db_user";
		$pass = "Ihusiwep1!";
		$db = "raperez_dvd_db";

		// DB Connection.
		$mysqli = new mysqli($host, $user, $pass, $db);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$title = $_POST['title'];

		if ( isset($_POST['release_date']) && trim($_POST['release_date']) != '' ) {
			$release_date = $_POST['release_date'];
		} else {
			$release_date = "null";
		}
	
		if ( isset($_POST['label_id']) && trim($_POST['label_id']) != '' ) {
			$label_id = $_POST['label_id'];
		} else {
			$label_id = "null";
		}
	
		if ( isset($_POST['sound_id']) && trim($_POST['sound_id']) != '' ) {
			$sound_id = $_POST['sound_id'];
		} else {
			$sound_id = "null";
		}

		if ( isset($_POST['genre_id']) && trim($_POST['genre_id']) != '' ) {
			$genre_id = $_POST['genre_id'];
		} else {
			$genre_id = "null";
		}
		if ( isset($_POST['rating_id']) && trim($_POST['rating_id']) != '' ) {
			$rating_id = $_POST['rating_id'];
		} else {
			$rating_id = "null";
		}
		if ( isset($_POST['format_id']) && trim($_POST['format_id']) != '' ) {
			$format_id = $_POST['format_id'];
		} else {
			$format_id = "null";
		}
		if ( isset($_POST['award']) && trim($_POST['award']) != '' ) {
			$award = $_POST['award'];
		} else {
			$award = "null";
		}

		$sql = "UPDATE dvd_titles 
			SET
			title = '$title',
			release_date = $release_date,
			label_id = $label_id,
			sound_id = $sound_id,
			genre_id = $genre_id,
			rating_id = $rating_id,
			format_id = $format_id,
			award = '$award'
		WHERE dvd_title_id = " . $_POST['dvd_title_id'] . ";";
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
	<title>Edit Confirmation | Movie Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="main.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php?dvd_title_id=<?php echo $_POST['dvd_title_id']; ?>">Details</a></li>
		<li class="breadcrumb-item"><a href="edit_form.php?dvd_title_id=<?php echo $_POST['dvd_title_id']; ?>">Edit</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Edit Confirmation</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">	

			<?php if(isset($error) && trim($error) != '') : ?>
				<div class="text-danger font-italic"> <?php echo $error ?> </div>
			<?php else : ?>
				<div class="text-success"><span class="font-italic"> <?php echo $_POST['title'] ?> </span> was successfully edited.</div>
			<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="details.php" role="button" class="btn btn-primary">Back to Details</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>