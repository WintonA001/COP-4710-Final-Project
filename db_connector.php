<?php

function OpenCon()
    {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $db = "project_development";

        $conn = new mysqli($dbhost, $dbuser, null, $db) or die("Connect failed: %s\n". $conn -> error);

        return $conn;
    }

    function CloseCon($conn)
        {
            $conn -> close();
        }


?>