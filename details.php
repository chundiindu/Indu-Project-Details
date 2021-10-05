<?php 

	include('config/db_connect.php');

	if(isset($_POST['delete'])){

		$id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

		$sql = "DELETE FROM projects WHERE id = $id_to_delete";

		if(mysqli_query($conn, $sql)){
			header('Location: index.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}

	// check GET request id param
	if(isset($_GET['id'])){
		
		// escape sql chars
		$id = mysqli_real_escape_string($conn, $_GET['id']);

		// make sql
		$sql = "SELECT * FROM projects WHERE id = $id";

		// get the query result
		$result = mysqli_query($conn, $sql);

		// fetch result in array format
		$project = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
		mysqli_close($conn);

	}

?>

<!DOCTYPE html>
<html>

	<?php include('templates/header.php'); ?>

	<div class="container center">
		<?php if($project): ?>
			<h4><?php echo $project['title']; ?></h4>
			<p>Created by <?php echo $project['email']; ?></p>
			<p><?php echo date($project['created_at']); ?></p>
			<h5>skills:</h5>
			<p><?php echo $project['skills']; ?></p>

			<!-- DELETE FORM -->
			<form action="details.php" method="POST">
				<input type="hidden" name="id_to_delete" value="<?php echo $project['id']; ?>">
				<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
			</form>

		<?php else: ?>
			<h5>No such projects exists.</h5>
		<?php endif ?>
	</div>

	<?php include('templates/footer.php'); ?>

</html>