<?php
function db()
{
    global $link;
    $link = mysqli_connect("localhost", "root", "", "task manager", "3307") or die("couldn't connect to database");
    return $link;
}
/* this database is designed to run with default settings: it is stored locally, the user is root and pass is a null string, and the database title is todo */
