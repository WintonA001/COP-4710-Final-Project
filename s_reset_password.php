<?php

session_start();

?>

<!DOCTYPE html>
<html>
	<h3>To reset your password, enter the desired password below and confirm it.</h3>
	<form method="post" name="passwordReset">
		Desired Password:
		<input type="text" name="password">
		<br>
		Confirm Password:
		<input type="text" name="confirmPass">
		<br>
		<input type="submit" name="submit">
	</form>
	
	<?php
		include 'db_connector.php';
		
        $conn = OpenCon();
		
		if(isset($_POST['submit']))
		{
			if(isset($_POST["password"]) && strcmp($_POST["password"], "") != 0 && mb_strlen($_POST["password"]) > 9 )
			{
				$email = $_SESSION["userEmail"];
				
				if(isset($_POST["confirmPass"]) && strcmp($_POST["password"], $_POST["confirmPass"]) == 0)
				{
						$inputPassword = $_POST["password"];
						
						$updateQuery = "UPDATE Staff SET password=? WHERE email= ?";
						$updateSt = $conn->prepare($updateQuery);
						$updateSt->bind_param("ss", $inputPassword, $email);
						$updateSt->execute();
						
						echo "<br>";
						echo "password changed";
				}
				else
				{
					echo "Please confirm your password by retyping it in the Confirm Password field.";
				}
			}
			else
			{
				echo "Invalid password - Needs at least 10 characters.";
			}
		}
		CloseCon($conn);
		echo "<br><a href='staff_dashboard.php'>Back</a>";
	?>
	
	
</html>