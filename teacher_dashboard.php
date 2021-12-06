<?php

    session_start();
    $_SESSION["year"] = "";
    $_SESSION["semester"] = "";

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
        <h1>Teacher Dashboard</h1>
        <a href="t_reset_password.php">Change Password</a><br>
        <a href="logout_routine.php">Log Out</a><br>

        <h3>Book Requests</h3>
        <h4>Create a new book request form</h4>
        <form method="get" name="newSubmitter" action="new_request.php">
            Semester:
            <select name="semester">
                <option value="fall">Fall</option>
                <option value="spring">Spring</option>
                <option value="summer">Summer</option>
            </select>
            <br><br>
            Year:
            <input type="number" id="year" name="year" min="2021" max="9999">
            <br><br>
            <input type="submit" name="newSubmit">
        </form>
        <h4>Edit/View a book request form</h4>
        <table>
            <tr>
                <th>Year</th>
                <th>Semester</th>
                <th>View Request</th>
            </tr>
            
            <?php
                include 'db_connector.php';
                $conn = OpenCon();

                $yearQuery = "SELECT DISTINCT year, semester FROM `request forms` WHERE teacher_email=? ORDER BY year";
                $yearStmt = $conn->prepare($yearQuery);
                $yearStmt->bind_param("s", $_SESSION["userEmail"]);
                if($yearStmt->execute())
                {
                    $yearResult = $yearStmt->get_result();
                    while($row = $yearResult->fetch_assoc())
                    {
                        echo "<tr>";
                        $displaySem;
                        if(strcmp($row["semester"], "fall") == 0) $displaySem = "Fall";
                        else if(strcmp($row["semester"], "spring") == 0) $displaySem = "Spring";
                        else $displaySem = "Summer";

                        echo "<td>" .$row["year"]. "</td>";
                        echo "<td>" .$displaySem. "</td>";
                        echo "<td>
                                <form method='get' action='edit_request.php'>
                                    <input type='hidden' name='year' value=" .$row["year"]. ">
                                    <input type='hidden' name='semester' value=" .$row["semester"]. ">
                                    <input type='submit' name='editSubmit' value='View'>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                }


            ?>
        </table>

    </body>
</html>