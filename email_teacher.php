<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <h3>Email Teacher</h3><br>
        <form method='post' name='emailForm'>
            <?php
                $email = $_GET["teachEmail"];
                echo "To: " .$email. "<br>";
                echo "<input type='hidden' name='email' value=" .$email. ">";
            ?>
            Subject: 
            <input type="text" name="subject"><br>
            Message:<br>
            <textarea id="content" name="content" rows="4" cols="50"></textarea><br>
            <input type="submit" name="send" value="Send">
        </form>

        <?php

            if( isset($_POST["email"]) && strcmp($_POST["email"], "") != 0 )
            {
                if( isset($_POST["subject"]) && strcmp($_POST["subject"], "") != 0 )
                {
                    if( isset($_POST["subject"]) && strcmp($_POST["content"], "") != 0 )
                    {
                        
                        $email = $_POST["email"];
                        $subject = $_POST["subject"];
                        $message = $_POST["content"];

                        mail($email, $subject, $message, "From: noreply@localhost");
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