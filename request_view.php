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
        <h3>Book Requests for 
            <?php
                $semester = $_GET["semester"];
                $displaySem;
                if(strcmp($semester, "fall") == 0) $displaySem = "Fall";
                else if(strcmp($semester, "spring") == 0) $displaySem = "Spring";
                else $displaySem = "Summer";
                $year = $_GET["year"];
                echo "" .$displaySem. " " .$year. "";
            ?>
        </h3>
        <br>
        <table>
            <tr>
                <th>Teacher First Name</th>
                <th>Teacher Last Name</th>
                <th>Teacher Email</th>
                <th>ISBN</th>
                <th>Title</th>
                <th>Authors</th>
                <th>Edition</th>
                <th>Publisher</th>
            </tr>

            <?php

                include 'db_connector.php';
                $semester = $_GET["semester"];
                $year = $_GET["year"];

                $conn = OpenCon();

                $brtQuery = "SELECT T.first_name, T.last_name, T.email, B.isbn, B.title, B.authors, B.edition, B.publisher
                FROM teachers t, `book requests` r, books b
                WHERE t.email = r.teacher_email AND r.isbn = b.isbn AND r.year=? AND r.semester=?";
                $brtStmt = $conn->prepare($brtQuery);
                $brtStmt->bind_param("ss",$year,$semester);
                if($brtStmt->execute())
                {
                    $brtResult = $brtStmt->get_result();
                    while($row = $brtResult->fetch_assoc())
                    {
                        echo "<tr>";
                        echo "<td>" .$row["first_name"]. "</td>";
                        echo "<td>" .$row["last_name"]. "</td>";
                        echo "<td>" .$row["email"]. "</td>";
                        echo "<td>" .$row["isbn"]. "</td>";
                        echo "<td>" .$row["title"]. "</td>";
                        echo "<td>" .$row["authors"]. "</td>";
                        echo "<td>" .$row["edition"]. "</td>";
                        echo "<td>" .$row["publisher"]. "</td>";
                        echo "</tr>";
                    }
                }

            ?>

        </table>
    </body>
</html>