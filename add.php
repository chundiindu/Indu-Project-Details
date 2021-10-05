<?php 

   // if(isset($_GET['submit'])){
	// 	echo $_GET['email'] . '<br />';
	// 	echo $_GET['title'] . '<br />';
	// 	echo $_GET['ingredients'] . '<br />';
	// }
	include('config/db_connect.php');

	$email = $title = $skills = '';
	$errors = array('email' => '', 'title' => '', 'skills' => '');

	if(isset($_POST['submit'])){
		//check email
		if(empty($_POST['email'])){
			$errors['email']= 'An email is required <br />';
		} else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email']= 'Email must be a valid email address';
			}
		}
         //check title
		if(empty($_POST['title']))
		if(empty($_POST['title'])){
			$errors['title']='A title is required <br />';
		} else{
			$title = $_POST['title'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
				$errors['title']='Title must be letters and spaces only';
			}
		}
        //check ingredients
		if(empty($_POST['skills'])){
			$errors['skills'] = 'At least one skill is required <br />';
		} else{
			$skills = $_POST['skills'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $skills)){
				$errors['skills'] = 'skills must be a comma separated list';
			}
		}

		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$skills = mysqli_real_escape_string($conn, $_POST['skills']);

			// create sql
			$sql = "INSERT INTO projects(title,email,skills) VALUES('$title','$email','$skills')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: index.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}

			
		}

	} // end POST check

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

    <section class="container grey-text">
		<h4 class="center">Add a Projects</h4>
		<form class="white" action="add.php" method="POST">
			<label>Your Email</label>
			<input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
			<div class="red-text"><?php echo $errors['email']; ?></div>
			<label>Project Title</label>
			<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
			<div class="red-text"><?php echo $errors['title']; ?></div>
			<label>Skills required (comma separated)</label>
			<input type="text" name="skills" value="<?php echo htmlspecialchars($skills) ?>">
			<div class="red-text"><?php echo $errors['skills']; ?></div>
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>