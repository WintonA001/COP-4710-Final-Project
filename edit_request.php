<?php

    session_start();
    if($_GET["year"] && strcmp($_GET["year"], "") != 0 ) $_SESSION["year"] = $_GET["year"];
    if($_GET["semester"] && strcmp($_GET["semester"], "") != 0 ) $_SESSION["semester"] = $_GET["semester"];

    $semester = $_SESSION["semester"];
    $year = $_SESSION["year"];
?>

<!DOCTYPE html>
<html>
    <head>
        <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
        }
        </style>
    </head>
    <body>
        <h3>Edit Book Requests for
            <?php
                $displaySem;
                if(strcmp($semester, "fall") == 0) $displaySem = "Fall";
                else if(strcmp($semester, "spring") == 0) $displaySem = "Spring";
                else $displaySem = "Summer";
                echo "" .$displaySem. " " .$year. "";

                
            ?>
        </h3>
        <br>
          <table>
              <tr>
                  <th>ISBN</th>
                  <th>Title</th>
                  <th>Authors</th>
                  <th>Edition</th>
                  <th>Publisher</th>
                  <th></th>
                  <th></th>
              </tr>

              <?php

                  include 'db_connector.php';
                  $semester = $_SESSION["semester"];
                  $year = $_SESSION["year"];
                  $email = $_SESSION["userEmail"];

                  $conn = OpenCon();

                  $brtQuery = "SELECT B.isbn, B.title, B.authors, B.edition, B.publisher
                  FROM `book requests` r, books b
                  WHERE r.teacher_email =? AND r.isbn = b.isbn AND r.year=? AND r.semester=?";
                  $brtStmt = $conn->prepare($brtQuery);
                  $brtStmt->bind_param("sss",$email,$year,$semester);
                  if($brtStmt->execute())
                  {
                      $brtResult = $brtStmt->get_result();
                      while($row = $brtResult->fetch_assoc())
                      {
                          echo '<tr>';
                          echo '<form method="POST">
                          <td>' .$row['isbn']. '</td>
                          <input type = "hidden" value="' .$row['isbn'].'" name="isbn">
                          <td><input type = "text" value ="'  .$row['title']. '" name="title" size="30" required></td>
                          <td><input type = "text" value ="'  .$row['authors']. '" name="authors" size="20" required></td>
                          <td><input type = "text" value ="'  .$row['edition']. '" name="edition" size="15" required></td>
                          <td><input type = "text" value ="'  .$row['publisher']. '" name="publisher" size="20" required></td>
                          <td><input type="submit" name="updateItem" value="Update"></td>
                          </input></form>';
                          echo '<td><form method="POST">
                            <input type="hidden" value="'.$row['isbn'].'" name="request">
                            <input type="hidden" value="'.$semester.'" name="semester">
                            <input type="hidden" value"'.$year.'" name="year">
                            <input type="submit" name="deleteItem" value="Delete">
                            </td></input></form>';
                          echo '</tr>';
                      }
                  }

              ?>

            <tr>
                <form method='post' name='newBookForm'>
                    <td><input type="text" name="isbn" size="20"></td>
                    <td><input type="text" name="title" size="30"></td>
                    <td><input type="text" name="authors" size="20"></td>
                    <td><input type="text" name="edition" size="15"></td>
                    <td><input type="text" name="publisher" size="20"></td>
                    <td><input type="submit" name="createBook" value="Add"></td>
                    <td></td>
                </form>
            </tr>
          </table>
          <br>

          <?php

           if (isset($_POST['deleteItem']))
           {
             $delIsbn = $_POST['request'];
             $delQuery = "DELETE FROM `book requests` WHERE teacher_email=? AND isbn=? AND year=? AND semester=?";
             $delStmt =$conn->prepare($delQuery);
             $delStmt->bind_param('ssss', $email, $delIsbn, $year, $semester);
             if ($delStmt->execute()) echo "Deletion successful.";
             else echo "Error occurred.";
             $_POST = array();
             header("location: edit_request.php?semester=" .$semester. "&year=" .$year. "&bookSubmit=Submit+Query");
           }

           if (isset($_POST['updateItem']))
           {
             $isbn = $_POST['isbn'];
             $upTitle = $_POST['title'];
             $upAuthors = $_POST['authors'];
             $upEdition = $_POST['edition'];
             $upPublisher = $_POST['publisher'];
             $upQuery = "UPDATE Books SET title=?, authors=?, edition=?, publisher=?
              WHERE isbn =?";
             $upStmt = $conn->prepare($upQuery);
             $upStmt->bind_param("sssss", $upTitle, $upAuthors, $upEdition, $upPublisher, $isbn);
             if ($upStmt->execute()) echo "<br><br>Updates made.";
             else echo "Error occurred.";
             $_POST = array();
             header("location: edit_request.php?semester=" .$semester. "&year=" .$year. "&bookSubmit=Submit+Query");
           }

           if (isset($_POST["createBook"]))
           {
                $isbn = $_POST["isbn"];
                $title = $_POST["title"];
                $authors = $_POST["authors"];
                $edition = $_POST["edition"];
                $publisher = $_POST["publisher"];

                $bookCheckQuery = "SELECT * FROM `books` WHERE isbn=?";
                $checkStmt = $conn->prepare($bookCheckQuery);
                $checkStmt->bind_param("s", $isbn);
                if($checkStmt->execute())
                {
                    $result = $checkStmt->get_result();
                    if($result->num_rows <= 0)
                    {
                        $newBookQuery = "INSERT INTO `books`(isbn, title, authors, edition, publisher) VALUES (?,?,?,?,?)";
                        $newBookSt = $conn->prepare($newBookQuery);
                        $newBookSt->bind_param("sssss", $isbn, $title, $authors, $edition, $publisher);
                        $newBookSt->execute();
                    }
                }
                $createReqQuery = "INSERT INTO `book requests`(teacher_email, isbn, year, semester) VALUES (?,?,?,?)";
                $reqStmt = $conn->prepare($createReqQuery);
                $reqStmt->bind_param("ssss", $email, $isbn, $year, $semester);
                if(!$reqStmt->execute())
                {
                    echo "<br><br>Request already exists.<br>";
                }
                $_POST = array();
                header("location: edit_request.php?semester=" .$semester. "&year=" .$year. "&bookSubmit=Submit+Query");
           }

           CloseCon($conn);
           ?>

        <br><a href="teacher_dashboard.php">Back to Dashboard</a>
    </body>
</html>
