<?php
	$host = "303.itpwebdev.com";
	$user = "raperez_db_user";
	$pass = "Ihusiwep1!";
	$db = "raperez_dvd_db";

	$mysqli = new mysqli($host, $user, $pass, $db);

	// Check for any Connection Errors.
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');

	$sql = "SELECT dvd_title_id, title, release_date, genres.genre AS genre, ratings.rating AS rating FROM dvd_titles
				LEFT JOIN genres
					ON dvd_titles.genre_id = genres.genre_id
				LEFT JOIN ratings
					ON dvd_titles.rating_id = ratings.rating_id 
					WHERE 1 = 1";

	if ( isset($_GET['title']) && trim($_GET['title']) != '' ) {
		$title = $_GET['title'];
		$sql = $sql . " AND title LIKE '%$title%' ";
	}

	if ( isset( $_GET['release_date_from'] ) && trim( $_GET['release_date_from'] ) != '' &&  isset( $_GET['release_date_to'] ) && trim( $_GET['release_date_to'] ) != '') {
		$release_date_from = $_GET['release_date_from'];
		$release_date_to = $_GET['release_date_to'];
		$sql = $sql . " AND release_date BETWEEN $release_date_from AND $release_date_to";
	}

	if ( isset( $_GET['genre_id'] ) && trim( $_GET['genre_id'] ) != '' ) {
		$genre_id = $_GET['genre_id'];
		$sql = $sql . " AND genres.genre_id = $genre_id";
	}

	if ( isset( $_GET['rating_id'] ) && trim( $_GET['rating_id'] ) != '' ) {
		$rating_id = $_GET['rating_id'];
		$sql = $sql . " AND ratings.rating_id = $rating_id";
	}

	if(isset( $_GET['award'] ) && trim( $_GET['award'] ) != '') {
		if ( $_GET['award'] == 'yes' ) {
			$sql = $sql . " AND award IS NOT NULL;";
		} else if( $_GET['award'] == 'no' ) {
			$sql = $sql . " AND award IS NULL;";
		}
	}

	$sql = $sql . ";";
	$results = $mysqli->query($sql);

	if ( !$results ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	// Close MySQL Connection.
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Movie Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="main.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item active">Results</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Movie Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mb-4">
			<div class="col-12 mt-4">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Search Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col-12">

				Showing <?php echo $results->num_rows; ?> result(s).

			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th> </th>
							<th>Movie Title</th>
							<th>Release Date</th>
							<th>Genre</th>
							<th>Rating</th>
						</tr>
					</thead>
					<tbody>
						<?php while ( $row = $results->fetch_assoc() ) : ?>
							<tr>
							<td>
									<a href="delete.php?dvd_title_id=<?php echo $row['dvd_title_id']; ?>&title=<?php echo $row['title']; ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this movie?');">
										Delete
									</a>
								</td>
							<td>
								<a href="details.php?dvd_title_id=<?php echo $row['dvd_title_id']; ?>"> 
									<?php echo $row['title']; ?> 
								</a> 
							</td>
							<td> <?php echo $row['release_date']; ?> </td>
							<td> <?php echo $row['genre']; ?> </td>
							<td> <?php echo $row['rating']; ?> </td>
							<tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Search Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>