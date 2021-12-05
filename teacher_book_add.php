<!DOCTYPE html>
<html>
<body>
    <h1>Add New Book</h1>
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
			<label for="Title">Title:    </label>
			<input type="text" id="title" name="title" size="50" required><br><br>
			<label for="Author">Author: </label>
			<input type="text" id="author" name="author" size="30" required><br><br>
			<label for="ISBN">ISBN:     </label>
			<input type="numeric" id="isbn" name="isbn" size="13" required><br><br>
	</form>
	
	<?php

        include 'db_connector.php';

        $title=null;
        $author=null;
        $isbn=null;

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
	
        if(isset($_POST["title"]))
        {
			
            $title = $_POST["title"];
            if(strcmp($title, "") == 0)
            {
                echo "<br>";
                echo "Please enter title";
                $_POST = array();
                exit();
            }
        }
        
        if(isset($_POST["lName"]))
        {
            $author = $_POST["author"];
            if(strcmp($author, "") == 0)
            {
                echo "<br>";
                echo "Please enter author's name";
                $_POST = array();
                exit();
            }
        }

		if(isset($_POST["isbn"]))
        {
            $isbn = $_POST["isbn"];
            if(mb_strlen($isbn) != 13)
            {
                echo "<br>";
                echo "Invalid ISBN - Needs 13 characters";
                $_POST = array();
                exit();
            }
        }

        $conn = OpenCon();


        if ($term && $title && $author && $isbn)
        {
            $addbookQuery = "INSERT INTO Teachers(term, title, author, isbn) VALUES (?,?,?,?)";
            $addbook = $conn->prepare($addbookQuery);
            $addbook->bind_param("ssss", $term,$title,$author,$isbn);
            if($addbook->execute())
            {
                CloseCon($conn);
            }
            else
            {
                echo "Failed to add new book";
                CloseCon($conn);
                return;
            }
        }
        $_POST = array();

    ?>

</body>
</html>