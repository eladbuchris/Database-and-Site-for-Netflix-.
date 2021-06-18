<html>
<?php
/*
 * Connect to the SQL server
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
<body style="background-color:#00ff7b;text-align: center"></body>
<h1 style= "text-align: center"> Show Distances from a Specific Actor</h1>
<h2 style= "text-align: center">Select Actor Name:</h2>
<form method="POST" action="show actor distance.php">
    <table style= margin-left:auto;margin-right:auto;>
        <tr><td>Actor name:</td><td><select name="Actor_Name">
            <option selected disabled hidden>Choose Actor Name</option>
            <?php
            $sql =  "SELECT DISTINCT Actor FROM Actors";
            $result = sqlsrv_query($conn, $sql);
            while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
                $actorName = $row['Actor'];
                echo "<option>$actorName</option>";
            }
            ?>
            </select></td></tr>
    </table>
    <button type="submit" value="Send" name="Send">Send</button>
    <br>
    <button type="reset" value="Clear">reset</button>
</form>
<table border="1" width =33% style= margin-left:auto;margin-right:auto;">
    <tr>
        <th>Distance = 1</th>
    </tr>
<?php
/*
* Shows all actors who played with a specific actor.
*/
if (isset($_POST["Send"])) {
    $actorName = $_POST['Actor_Name'];
    $sql = "SELECT DISTINCT A.Actor
            FROM ActedIn A, ActedIn A1
            WHERE (A1.Actor = '".addslashes($actorName)."' AND A.Title = A1.Title AND A1.Actor !=A.Actor)";
    $run = sqlsrv_query($conn, $sql);
    while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
        $Actor = $row['Actor'];
        echo "<tr style='text-align: center'><td>$Actor</td></tr>";
    }
} ?></table>
<br>
<table border="1" width =33% style= margin-left:auto;margin-right:auto;">
    <tr>
        <th>Distance = 2</th>
    </tr>
<?php
/*
 * Shows all actors (B) who didnt play with specific actor (A) in a movie, But, there is another actor (i.e C) who played with both A and B
 */
if (isset($_POST["Send"])) {
    $actorName = $_POST['Actor_Name'];
    $sql1 = "SELECT DISTINCT A2.Actor
            FROM ActedIn A1, ActedIn A2, ActedIn A3, ActedIn A4
            WHERE(A1.Actor = '$actorName' AND A1.Title = A3.Title AND A2.Actor != A1.Actor AND A3.Actor =A4.Actor AND
          A3.Actor != A1.Actor AND A1.Title != A2.Title AND A2.Title = A4.Title AND
          A2.Actor NOT IN(
              SELECT DISTINCT A3.Actor
              FROM ActedIn A2, ActedIn A3
              WHERE (A2.Actor = '$actorName' AND A2.Title = A3.Title AND A3.Actor !=A2.Actor)))";
    $run1 = sqlsrv_query($conn, $sql1);
    while($row = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)) {
        $Actor = $row['Actor'];
        echo "<tr style='text-align: center'><td>$Actor</td></tr>";
    }
} ?></>

</html>
