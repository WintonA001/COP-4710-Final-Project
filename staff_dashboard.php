<!DOCTYPE html>
<html>
    <body>
        <h1>Staff Dashboard</h1><br>
        <a href="s_reset_password.php">Change Password</a><br>
        <a href="logout_routine.php">Log Out</a><br>
        <?php
            session_start();
            if(!$_SESSION["userEmail"] || !$_SESSION["userPassword"])
            {
                echo "Log in session failed. Please log in again.";
                exit();
            }

            $email = $_SESSION["userEmail"];
            if(strcmp($email, "wintonartz012@gmail.com") == 0)
            {
                echo "<h3>Staff List<h3><br>";
                echo "<a href='staff_list.php'>View List</a><br>";
                echo "<br><h3>Register New Staff</h3><br>";
                echo "<a href='staff_signup.php'>Register Staff</a>";
            }
        ?>

        <h3>View Book Requests</h3><br>
        <form action="request_view.php" method="get" name="bookViewer">
            Semester:
            <select name="semester">
                <option value="fall">Fall</option>
                <option value="spring">Spring</option>
                <option value="summer">Summer</option>
            </select>
            <br>
            Year:
            <select name="year">
                <?php
                    
                    include 'db_connector.php';

                    $conn = OpenCon();

                    $yearQuery = "SELECT DISTINCT year FROM `book requests`";
                    $yearSt = $conn->prepare($yearQuery);
                    $yearSt->execute();
                    $yearResult = $yearSt->get_result();
                    while($row = $yearResult->fetch_assoc())
                    {
                        echo "<option value=" .$row["year"]. ">" .$row["year"]. "</option>";
                    }
                    CloseCon($conn);
                ?>
            </select>
            <br>
            <input type="submit" name="bookSubmit">
        </form>
        <br><h3>Send Email to Teachers</h3><br>
        <a href="teacher_list.php">Send Individual Email</a><br>
        <a href="global_email.php">Send Global Email</a>

        <br><h3>Set Dates for Automated Email</h3><br>
        <a href="set_date.php">Set Date</a>

    </body>
</html>