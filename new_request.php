<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <?php
            include 'db_connector.php';
            $conn = OpenCon();
            session_start();

            $_SESSION["year"] = $_GET["year"];
            $year = $_SESSION["year"];

            $_SESSION["semester"] = $_GET["semester"];
            $semester = $_SESSION["semester"];

            $email = $_SESSION["userEmail"];

            $newFormQuery = "INSERT INTO `request forms`(teacher_email, year, semester) VALUES(?,?,?)";
            $newFormSt = $conn->prepare($newFormQuery);
            $newFormSt->bind_param("sss", $email, $year, $semester);
            if($newFormSt->execute())
            {
                header("location: edit_request.php?semester=" .$semester. "&year=" .$year. "&bookSubmit=Submit+Query");
            }
            else
            {
                header("location: edit_request.php?semester=" .$semester. "&year=" .$year. "&bookSubmit=Submit+Query");
            }
            CloseCon($conn);
        ?>
    </body>
</html>