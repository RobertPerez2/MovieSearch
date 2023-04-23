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
		$mysqli->set_charset('utf8');

		$sql = "SELECT *
				FROM dvd_titles WHERE dvd_title_id = " . $_GET['dvd_title_id'] . ";";
		$results = $mysqli->query($sql);
		if (!$results) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		// Retrieve all genres from the DB.
		$sql_genre = "SELECT * FROM genres; ";
		$results_genre = $mysqli->query( $sql_genre );
		if ( !$results_genre ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		// Retrieve all rating types from the DB.
		$sql_rating = "SELECT * FROM ratings;";
		$results_rating = $mysqli->query( $sql_rating );
		if ( !$results_rating ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		// Retrieve all format types from the DB.
		$sql_format = "SELECT * FROM formats;";
		$results_format = $mysqli->query( $sql_format );
		if ( !$results_format ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		//label types
		$sql_label = "SELECT * FROM labels;";
		$results_label = $mysqli->query($sql_label);
		if(!$results_label) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$sql_sound = "SELECT * FROM sounds;";
		$results_sound = $mysqli->query($sql_sound);
		if(!$results_sound) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}


		$mysqli->close();
		$row = $results->fetch_assoc();

	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Form | Movie Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}
	</style>
</head>
<body>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="main.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php?dvd_title_id=<?php echo $_GET['dvd_title_id']; ?>">Details</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4 text-center">Edit a Movie</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

			<?php if(isset($error) && trim($error) != '') : ?>
				<div class="col-12 text-danger">
					<?php echo $error;?>
				</div>
			<?php else : ?>
				<form action=edit_confirmation.php method=POST>


					<input type="hidden" name="dvd_title_id" value="<?php echo $row['dvd_title_id']; ?>">

					<div class="form-group row">
						<label for="title-id" class="col-sm-3 col-form-label text-sm-right">Title: <span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="title-id" name="title" value="<?php echo $row['title']; ?>">
						</div>
					</div> <!-- .form-group -->

					<div class="form-group row">
						<label for="release-date-id" class="col-sm-3 col-form-label text-sm-right">Release Date:</label>
						<div class="col-sm-9">
							<input type="date" class="form-control" id="release-date-id" name="release_date" value="<?php echo $row['release_date']; ?>">
						</div>
					</div> <!-- .form-group -->

					<div class="form-group row">
						<label for="label-id" class="col-sm-3 col-form-label text-sm-right">Label:</label>
						<div class="col-sm-9">
							<select name="label_id" id="label-id" class="form-control">
								<option value="" selected>-- Select One --</option>

								<?php while( $row_label  = $results_label->fetch_assoc() ) : ?>
									<?php if($row['label_id'] == $row_label['label_id']) :?>
										<option value=" <?php echo $row_label['label_id']; ?> " selected> 
											<?php echo $row_label['label'];?>
										</option>
									<?php else : ?>
										<option value=" <?php echo $row_label['label_id']; ?> "> 
											<?php echo $row_label['label']; ?>
										</option>
									<?php endif; ?>
								<?php endwhile; ?>

							</select>
						</div>
					</div> <!-- .form-group -->

					<div class="form-group row">
						<label for="sound-id" class="col-sm-3 col-form-label text-sm-right">Sound:</label>
						<div class="col-sm-9">
							<select name="sound_id" id="sound-id" class="form-control">
								<option value="" selected>-- Select One --</option>

								<?php while( $row_sound  = $results_sound->fetch_assoc() ) : ?>
									<?php if($row['sound_id'] == $row_sound['sound_id']) :?>
										<option value=" <?php echo $row_sound['sound_id']; ?> " selected> 
											<?php echo $row_sound['sound']; ?>
										</option>
									<?php else : ?>
										<option value=" <?php echo $row_sound['sound_id']; ?> "> 
											<?php echo $row_sound['sound']; ?>
										</option>
									<?php endif; ?>
								<?php endwhile; ?>

							</select>
						</div>
					</div> <!-- .form-group -->

					<div class="form-group row">
						<label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
						<div class="col-sm-9">
							<select name="genre_id" id="genre-id" class="form-control">
								<option value="" selected>-- Select One --</option>

								<?php while( $row_genre  = $results_genre->fetch_assoc() ) : ?>
									<?php if($row['genre_id'] == $row_genre['genre_id']) :?>
										<option value=" <?php echo $row_genre['genre_id']; ?> " selected> 
											<?php echo $row_genre['genre']; ?>
										</option>
									<?php else : ?>
										<option value=" <?php echo $row_genre['genre_id']; ?> "> 
											<?php echo $row_genre['genre']; ?>
										</option>
									<?php endif; ?>
								<?php endwhile; ?>

							</select>
						</div>
					</div> <!-- .form-group -->

					<div class="form-group row">
						<label for="rating-id" class="col-sm-3 col-form-label text-sm-right">Rating:</label>
						<div class="col-sm-9">
							<select name="rating_id" id="rating-id" class="form-control">
								<option value="" selected>-- Select One --</option>
								
								<?php while( $row_rating  = $results_rating->fetch_assoc() ) : ?>
									<?php if($row_rating['rating_id'] == $row['rating_id']) :?>
										<option value=" <?php echo $row_rating['rating_id']; ?> " selected> 
											<?php echo $row_rating['rating']; ?>
										</option>
									<?php else : ?>
										<option value=" <?php echo $row_rating['rating_id']; ?> "> 
											<?php echo $row_rating['rating']; ?>
										</option>
									<?php endif; ?>
								<?php endwhile; ?>

							</select>
						</div>
					</div> <!-- .form-group -->

					<div class="form-group row">
						<label for="format-id" class="col-sm-3 col-form-label text-sm-right">Format:</label>
						<div class="col-sm-9">
							<select name="format_id" id="format-id" class="form-control">
								<option value="" selected>-- Select One --</option>

								<?php while( $row_format  = $results_format->fetch_assoc() ) : ?>
									<?php if($row_format['format_id'] == $row['format_id'] ) : ?>
										<option value=" <?php echo $row_format['format_id']; ?> " selected> 
											<?php echo $row_format['format']; ?>
										</option>
									<?php else : ?>
										<option value=" <?php echo $row_format['format_id']; ?> "> 
											<?php echo $row_format['format']; ?>
										</option>
									<?php endif; ?>
								<?php endwhile; ?>

							</select>
						</div>
					</div> <!-- .form-group -->

					<div class="form-group row">
						<label for="award-id" class="col-sm-3 col-form-label text-sm-right">Award:</label>
						<div class="col-sm-9">
							<textarea name="award" id="award-id" class="form-control"><?php echo trim($row['award']);?></textarea>
						</div>
					</div> <!-- .form-group -->

					<div class="form-group row">
						<div class="ml-auto col-sm-9">
							<span class="text-danger font-italic">* Required</span>
						</div>
					</div> <!-- .form-group -->

					<div class="form-group row">
						<div class="col-sm-3"></div>
						<div class="col-sm-9 mt-2">
							<button type="submit" class="btn btn-primary">Submit</button>
							<button type="reset" class="btn btn-light">Reset</button>
						</div>
					</div> <!-- .form-group -->

				</form>
			<?php endif; ?>
	</div> <!-- .container -->
</body>
</html>