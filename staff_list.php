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
            </tr>

            <?php

                include 'db_connector.php';

                $conn = OpenCon();

                $staffQuery = "SELECT S.first_name, S.last_name, S.email FROM Staff S ORDER BY S.last_name";
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
                        echo "</tr>";
                    }
                }

                CloseCon($conn);
            ?>

        </table>
        <br>

        <h2>Reset Staff Password</h2><br>
        <form action="staff_reset.php" method="post" name="staffReset">
            Staff Email:
            <input type="text" name="staffEmail">
            <input type="submit" name="editSubmit value="Reset">
        </form>

        <br><br>

        <h2>Delete Staff Account</h2><br>
        <form action="staff_delete.php" method="post" name="staffReset">
            Staff Email:
            <input type="text" name="staffEmail">
            <input type="submit" name="editSubmit" value="Delete">
        </form>
        <br>
        <a href="staff_dashboard.php">Back to Dashboard</a>

    </body>
</html>