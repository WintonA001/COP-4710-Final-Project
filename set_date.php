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
        <h3>Set Dates for Automatic Emails</h3>
        <h2>Current Dates</h2>
        <br>
        <table>
            <tr>
                <th>Email Date</th>
                <th>Due Date</th>
                <th>Remove Date</th>
            </tr>

            <?php
                include 'db_connector.php';
                $conn = OpenCon();

                $dateQuery = "SELECT * FROM `reminder dates` ORDER BY date";
                $dateStmt = $conn->prepare($dateQuery);
                if($dateStmt->execute())
                {
                    $dateRes = $dateStmt->get_result();
                    while($row = $dateRes->fetch_assoc())
                    {
                        echo "<tr>";
                        echo "<td>" .$row["date"]. "</td>";
                        echo "<td>" .$row["due_date"]. "</td>";
                        echo "<td><form method='post' name='dateDeleter'><input type='hidden' name='deleteVal' value=" .$row["date"]. "><input type='submit' name='deleteSubmit' value='Delete'></form></td>";
                        echo "</tr>";
                    }
                }

            ?>

        </table>
        <br><br>
        <h3>Create Date Entry</h3>
        <form method="post" name="dateSetter">
            Email date:
            <br>
            <input type="date" id="dateSet" name="emailDate" min=
            <?php
                date_default_timezone_set("EST");
                $today = date_create(date("Y-m-d"));
                $todayString = $today->format('Y-m-d');
                echo "'" .$todayString. "'";
            ?>
            >
            <br>
            Due Date:
            <br>
            <input type="date" id="dueDate" name="dueDate" min=
            <?php
                date_default_timezone_set("EST");
                $today = date_create(date("Y-m-d"));
                $todayString = $today->format('Y-m-d');
                echo "'" .$todayString. "'";
            ?>
            >
            <br>
            <input type="submit" name="dateSubmit">
        </form>

        <?php

            if(isset($_POST["deleteVal"]) && strcmp($_POST["deleteVal"], "") != 0)
            {
                $dateForDeletion = $_POST["deleteVal"];
                $deleteQuery = "DELETE FROM `reminder dates` WHERE date=?";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bind_param("s",$dateForDeletion);
                if($deleteStmt->execute())
                {
                    $_POST = array();
                    header("Location: http://localhost/set_date.php");
                }
            }

            if(isset($_POST["dateSubmit"]) && strcmp($_POST["emailDate"], "") != 0 && strcmp($_POST["dueDate"], "") != 0)
            {
                $date = $_POST["emailDate"];
                $dueDate = $_POST["dueDate"];

                $dateQuery = "INSERT INTO `reminder dates`(date, due_date) VALUES (?,?)";
                $dateStmt = $conn->prepare($dateQuery);
                $dateStmt->bind_param("ss", $date, $dueDate);
                if($dateStmt->execute())
                {
                    header("Location: http://localhost/set_date.php");
                }
            }
            else
            {
                echo "<br>Submit a valid date: YYYY-MM-DD";
            }

            echo "<br><a href='staff_dashboard.php'>Back</a>";
            CloseCon($conn);
        ?>
    </body>
</html>