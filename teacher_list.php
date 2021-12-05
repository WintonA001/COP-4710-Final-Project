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
        <h3>Teacher List</h3><br>
        <table>
            <tr>
                <th>Teacher First Name</th>
                <th>Teacher Last Name</th>
                <th>Teacher Email</th>
                <th>Send Email</th>
            </tr>

            <?php
                include 'db_connector.php';

                $conn = OpenCon();

                $teacherQuery = "SELECT first_name, last_name, email FROM Teachers";
                $teacherStmt = $conn->prepare($teacherQuery);
                if ($teacherStmt->execute())
                {
                    $teacherRes = $teacherStmt->get_result();
                    while($row = $teacherRes->fetch_assoc())
                    {
                        echo "<tr>";
                        echo "<td>" .$row["first_name"]. "</td>";
                        echo "<td>" .$row["last_name"]. "</td>";
                        echo "<td>" .$row["email"]. "</td>";
                        echo "<td><form action='email_teacher.php' method='get' name='emailGetter'><input type='hidden' id='teachEmail' name='teachEmail' value=" .$row["email"]. "><input type='submit' name='emailSubmit' value='Send Email'></form></td>";
                        echo "</tr>";
                    }
                }
            ?>

        </table>
        <br>
        <a href="staff_dashboard.php">Back</a>

    </body>
</html>
