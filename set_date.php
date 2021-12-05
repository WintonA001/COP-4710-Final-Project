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
                <th>Dates</th>
                <th>Remove Date</th>
            </tr>

            <?php
                include 'db_connector.php';
                $conn = OpenCon();

                $dateQuery = "SELECT * FROM `reminder dates`";
                $dateStmt = $conn->prepare($dateQuery);
                if($dateStmt->execute())
                {
                    $dateRes = $dateStmt->get_result();
                    while($row = $dateRes->fetch_assoc())
                    {
                        echo "<tr>";
                        echo "<td>" .$row["date"]. "</td>";
                        echo "<td><form method='post' name='dateDeleter'><input type='hidden' name='deleteVal' value=" .$row["date"]. "><input type='submit' name='deleteSubmit' value='Delete'></form></td>";
                        echo "</tr>";
                    }
                }

            ?>

        </table>
        <br><br>

        <form method="post" name="dateSetter">
            <input type="date" id="dateSet" name="dateSet" min=
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

            if(isset($_POST["dateSet"]) && strcmp($_POST["dateSet"], "") != 0)
            {
                $date = $_POST["dateSet"];

                $dateQuery = "INSERT INTO `reminder dates`(date) VALUES (?)";
                $dateStmt = $conn->prepare($dateQuery);
                $dateStmt->bind_param("s", $date);
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