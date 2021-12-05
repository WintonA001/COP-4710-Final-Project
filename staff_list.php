<!DOCTYPE html>
<html>
    <header>
        <style>
            table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            }
            th, td {
                padding: 15px;
            }
        </style>
    </header>
    <body>
        <h3>Staff List</h3>
        <br>

        <table>
            <tr>
                <th>Staff First Name</th>
                <th>Staff Last Name</th>
                <th>Staff Email</th>
                <th>Reset Password</th>
                <th>Delete</th>
            </tr>

            <?php

                include 'db_connector.php';
                $conn = OpenCon();

                $staffQuery = "SELECT S.first_name, S.last_name, S.email FROM Staff S WHERE S.email != 'wintonartz012@gmail.com' ORDER BY S.last_name";
                $staffStmt = $conn->prepare($staffQuery);
                if($staffStmt->execute())
                {
                    $staffResult = $staffStmt->get_result();
                    while($row = $staffResult->fetch_assoc())
                    {
                        echo "<tr>";
                        echo "<td>" .$row["first_name"]. "</td>";
                        echo "<td>" .$row["last_name"]. "</td>";
                        echo "<td>" .$row["email"]. "</td>";
                        echo "<td> <form method='post' name='resetForm' action='staff_reset.php'><input type='hidden' id='staffEmail' name='staffEmail' value=" .$row["email"]. "><input type='submit' name='resetSubmit' value='Reset'></form></td>";
                        echo "<td> <form method='post' name='deleteForm' action='staff_delete.php'><input type='hidden' id='staffEmail' name='staffEmail' value=" .$row["email"]. "><input type='submit' name='deleteSubmit' value='Delete'></form></td>";
                        echo "</tr>";
                    }
                }
                CloseCon($conn);
            ?>

        </table>
        <br>
        <?php
            session_start();
            if(isset($_SESSION["opSuccess"]) && strcmp($_SESSION["opSuccess"], "") != 0)
            {
                echo "<br>" .$_SESSION["opSuccess"]. "<br>";
                $_SESSION["opSuccess"] = "";
            }
        ?>
        <br>

        <a href="staff_dashboard.php">Back to Dashboard</a>

    </body>
</html>