<?php 
//connect to database


	include('config/db_connect.php');

$sql = 'SELECT title, skills, id FROM projects ORDER BY created_at';
// get the result set (set of rows)
$result = mysqli_query($conn, $sql);
// fetch the resulting rows as an array
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
// free the $result from memory (good practise)
mysqli_free_result($result);

// close connection
mysqli_close($conn);
//print_r($projects);
?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>
	<h4 class="center grey-text">projects!</h4>

	<div class="container">
		<div class="row">

			<?php foreach($projects as $project): ?>

				<div class="col s6 md3">
					<div class="card z-depth-0">
					 <img src="Student.jpg" class="project">
						<div class="card-content center">
							<h6><?php echo htmlspecialchars($project['title']); ?></h6>
							<ul class="grey-text">
								<?php foreach(explode(',', $project['skills']) as $skill):?>
									<li><?php echo htmlspecialchars($skill); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<div class="card-action right-align">
						<a class="brand-text" href="details.php?id=<?php echo $project['id'] ?>">more info</a>
						</div>
					</div>
				</div>
				
			<?php endforeach; ?>
		</div>
	</div>

	<?php include('templates/footer.php'); ?>

</html>