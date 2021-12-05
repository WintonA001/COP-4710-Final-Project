<!DOCTYPE html>
<html>
    <body>
	
		<form method="post" name="userSignup">
			<label> Term: </label>
			<select required>
				<option value="Term">Term</option>
				<option value="Fall 2021">Fall2021</option>
				<option value="Spring 2022">Spring2021</option>
				<option value="Summer 2022">Summer2021</option>
				<option value="Fall 2022">Fall2022</option>
			</select>
			<br>
			<label for="Title">Title:    </label>
			<input type="text" id="title" name="title" size="50" required><br><br>
			<label for="Author">Author: </label>
			<input type="text" id="author" name="author" size="30" required><br><br>
			<label for="ISBN">ISBN:     </label>
			<input type="numeric" id="isbn" name="isbn" size="13" required><br><br>
		</form>

		<?php
            include 'db_connector.php';

            $conn = OpenCon();

            $deleteQuery = "DELETE FROM Staff WHERE isbn=? && term = ?";
            $deleteSt = $conn->prepare($deleteQuery);
            $deleteSt->bind_param("s",$isbn);
            if($deleteSt->execute())
            {
                echo "<h3>" .$title. " by " .$author. " has been deleted.";
            }
            else
            {
                echo "Account with this ISBN was not found.";
            }
        ?>
    </body>
</html>