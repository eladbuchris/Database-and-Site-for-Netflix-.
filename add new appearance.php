<!-- This page allows us to insert a new row (data) for the table in
which the data for player plays in content is stored-->
<html>
<?php
/*
 * Connecting to the sql server
 */
$server = "tcp:techniondbcourse01.database.windows.net,1433";
$user = "eladbuchris";
$pass = "Qwerty12!";
$database = "eladbuchris";
$c = array("Database" => $database, "UID" => $user, "PWD" => $pass);
sqlsrv_configure('WarningsReturnAsErrors', 0);
$conn = sqlsrv_connect($server, $c);
if($conn === false)
{
    echo "error";
    die(print_r(sqlsrv_errors(), true));
}
?>
<?
/*
 * Creates a header to the page for adding new appearance to ActedIn table.
 */
?>
<body style="background-color:#00ff7b;text-align: center"></body>
<h1 style= "text-align: center"> Add new appearance </h1>
<h2 style= "text-align: center"> Fill appearance details: </h2>
<form method="POST" action="add new appearance.php">
    <table style= margin-left:auto;margin-right:auto;">
        <tr><td>Actor Name:</td><td><input type="text" name="Actor_Name" maxlength="50" required/></td></tr>
        <tr><td>Movie:</td><td><input type="text" name="Movie" maxlength="50" required /></td></tr>
    </table>
    <button type="submit" value="Send" name="Send">Send</button>
    <br>
    <button type="reset" value="Clear">reset</button>
</form>
<?php
if (isset($_POST["Send"])) {
    if (!empty($_POST['Actor_Name']) && !empty($_POST['Movie'])) {
        $actorName = $_POST['Actor_Name'];
        $movie = $_POST['Movie'];
        /*
         * Checking if the data can be inserted to the table (i.e fits the database limitations)
         */
        if (empty(sqlsrv_fetch_array(sqlsrv_query($conn, "SELECT Actor FROM Actors WHERE (Actor = '$actorName')"), SQLSRV_FETCH_ASSOC))) {
            echo "Name of actor does not exists in the db";
        } elseif (empty(sqlsrv_fetch_array(sqlsrv_query($conn, "SELECT Title FROM Content WHERE (Title = '$movie')"), SQLSRV_FETCH_ASSOC))) {
            echo "Name of content does not exists in the db";
        } elseif (!empty(sqlsrv_fetch_array(sqlsrv_query($conn, "SELECT Actor,Title FROM ActedIn WHERE (Actor = '$actorName' AND Title='$movie')"), SQLSRV_FETCH_ASSOC))) {
            echo "The information already exists in the db";
        } else {
            $sql1 = "SELECT A.Salary
                     FROM ActedIn A
                     WHERE (A.Actor = '" . addslashes($actorName) . "' AND  
                     A.Salary <= ALL(SELECT A1.Salary FROM ActedIn A1 WHERE (A1.Actor = '" . addslashes($actorName) . "')))";
            $result = sqlsrv_query($conn, $sql1);
            $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $sql = "INSERT INTO ActedIn(Actor, Title, Salary) VALUES
                                    ('" . addslashes($actorName) . "','" . addslashes($movie) . "','" . addslashes($row['Salary']) . "'); ";
            $run = sqlsrv_query($conn, $sql);
            if ($run) {
                echo "Good job, Your information was added to our database :)";}
        }
    }
}
?>

</html>
