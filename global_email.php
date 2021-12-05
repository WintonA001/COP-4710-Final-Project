<!DOCTYPE html>
<html>
    <head>
    </head>
    
    <body>
        <h3>Email All Teachers</h3><br>
        <form method='post' name='emailForm'>
            <input type="hidden" name="submitCheck" value="yes">
            Subject: 
            <input type="text" name="subject"><br>
            Message:<br>
            <textarea id="content" name="content" rows="4" cols="50"></textarea><br>
            <input type="submit" name="send" value="Send">
        </form>

        <?php
            include 'db_connector.php';


            if( isset($_POST["submitCheck"]) && strcmp($_POST["submitCheck"], "") != 0 )
            {
                if( isset($_POST["subject"]) && strcmp($_POST["subject"], "") != 0 )
                {
                    if( isset($_POST["subject"]) && strcmp($_POST["content"], "") != 0 )
                    {
                        $subject = $_POST["subject"];
                        $message = $_POST["content"];

                        $conn = OpenCon();

                        $emailQuery = "SELECT email FROM Teachers";
                        $emailStmt = $conn->prepare($emailQuery);
                        if($emailStmt->execute())
                        {
                            $emailRes = $emailStmt->get_result();
                            while($row = $emailRes->fetch_assoc())
                            {
                                mail($row["email"], $subject, $message, "From: noreply@localhost");
                            }
                        }
                        $_POST = array();
                        echo "Email sent<br>";
                    }
                    else
                    {
                        echo "<br>Please enter a valid message.<br>";
                    }
                }
                else
                {
                    echo "<br>Please enter a valid subject.<br>";
                }
            }
            echo "<a href='staff_dashboard.php'>Back</a>"
        ?>
    </body>
</html>