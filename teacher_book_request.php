<!DOCTYPE html>
<html>
<body>
    <h1>View Book List</h1>
    <br>

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
    </form>

    <?php

        include 'db_connector.php';

        $Term=null;

        $conn = OpenCon();

        if(isset($_POST["Term"]))
        {
            $userPassword = $_POST["userPassword"];
            if($Term == "Term")
            {
                echo "<br>";
                echo "Please choose a semester";
                exit();
            }
        }

        $booklistQuery = "SELECT TERM = ? FROM booklist ORDER BY author";
		$booklist = $conn->prepare($booklistQuery);
        if($booklist->execute())
        {
			$booklistResult = $booklist->get_result();
			while($row = $booklistResult->fetch_assoc())
            {
				echo "<tr>";
                echo "<td>" .$row["Title"]. "</td>";
                echo "<td>" .$row["authour"]. "</td>";
                echo "<td>" .$row["ISBN"]. "</td>";
                echo "</tr>";
			}
		}
	
		CloseCon($conn);
    ?>

	<h1>Book Request Form Change </h1>
	<br>
	
	<h2>Add Book</h2>
	<form action="teacher_book_add.php" method="get">
		<input type="submit" value="Add">
	</form>
	
	
	<h2>Delete Book</h2>
	<form action="teacher_book_delete.php" method="get">
		<input type="submit" value="Delete">
	</form>
	
	
</body>
</html>