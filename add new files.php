<!-- This page allows us to add new files to the database. -->
<?php
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
}?>
<html>
<body style="background-color:#00ff7b;"></body>
<h1 style= "text-align: center"> Add Files </h1>
<h2 style= "text-align: center"> Choose Content File: </h2>
<form style="text-align: center" action="add new files.php" method="post" enctype="multipart/form-data">
    <input name="csv" type="file" id="csv" />
    <input type="submit" name="submit_content" value="submit" />
</form>
<?php
if (isset($_POST["submit_content"])){
    $file = $_FILES[csv][tmp_name];
    $numOfGood = 0;
    $numOfBad = -1; // init to -1 because we want to discard the header.
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 3000, ",")) !== FALSE) {
            $sql="INSERT INTO Content(title, language, release_date) VALUES 
     		('".addslashes($data[0])."','".addslashes($data[1])."',
     		'".addslashes($data[2])."'); ";
            $run = sqlsrv_query($conn, $sql);
            if($run){ // Counts the number of good rows insterted to the data.
                $numOfGood += 1;
            }
            else{ // Counts the number of bad rows inserted.
                $numOfBad += 1;
            }
        }
        fclose($handle); }
    echo "<p style='text-align: center'>Number of failed tuples upload :".$numOfBad."\n</p>";
    echo "<p style='text-align: center'>Number of successful uploads :".$numOfGood."</p>";}
?>

<h2 style= "text-align: center"> Choose Series File: </h2>
<form style="text-align: center" action="add new files.php" method="post" enctype="multipart/form-data">
    <input name="csv" type="file" id="csv" />
    <input type="submit" name="submit_series" value="submit" />
</form>
<?php
if(isset($_POST["submit_series"])){
    $numOfGood = 0;
    $numOfBad = -1;
    $file = $_FILES[csv][tmp_name];
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 3000, ",")) !== FALSE) {
            $sql="INSERT INTO Series(title, genre) VALUES
     		('".addslashes($data[0])."','".addslashes($data[1])."'); ";
            $run = sqlsrv_query($conn, $sql);
            if($run){
                $numOfGood += 1;
            }
            else{
                $numOfBad += 1;
            }
        }
        fclose($handle); }
    echo "<p style='text-align: center'>Number of failed tuples upload :".$numOfBad."\n</p>";
    echo "<p style='text-align: center'>Number of successful uploads :".$numOfGood."</p>";}
?>
<h2 style= "text-align: center"> Choose Directors File: </h2>
<form style="text-align: center" action="add new files.php" method="post" enctype="multipart/form-data">
    <input name="csv" type="file" id="csv" />
    <input type="submit" name="submit_directors" value="submit" />
</form>
<?php
if(isset($_POST["submit_directors"])){
    $file = $_FILES[csv][tmp_name];
    $numOfGood = 0;
    $numOfBad = -1;
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 3000, ",")) !== FALSE) {
            $sql="INSERT INTO Directors(Director, FavoriteSeries) VALUES
     		('".addslashes($data[0])."','".addslashes($data[1])."'); ";
            $run = sqlsrv_query($conn, $sql);
            if($run){
                $numOfGood += 1;
            }
            else{
                $numOfBad += 1;
            }
        }
        fclose($handle); }
    echo "<p style='text-align: center'>Number of failed tuples upload :".$numOfBad."\n</p>";
    echo "<p style='text-align: center'>Number of successful uploads :".$numOfGood."</p>";}
?>
<h2 style= "text-align: center"> Choose Countries File: </h2>
<form style="text-align: center" action="add new files.php" method="post" enctype="multipart/form-data">
    <input name="csv" type="file" id="csv" />
    <input type="submit" name="submit_countries" value="submit" />
</form>
<?php
if(isset($_POST["submit_countries"])){
    $file = $_FILES[csv][tmp_name];
    $numOfGood = 0;
    $numOfBad = -1;
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 3000, ",")) !== FALSE) {
            $sql="INSERT INTO Countries(Country, Region, Population, Area) VALUES
     		('".addslashes($data[0])."','".addslashes($data[1])."','".addslashes($data[2])."','".addslashes($data[3])."'); ";
            $run = sqlsrv_query($conn, $sql);
            if($run){
                $numOfGood += 1;
            }
            else{
                $numOfBad += 1;
            }
        }
        fclose($handle); }
    echo "<p style='text-align: center'>Number of failed tuples upload :".$numOfBad."\n</p>";
    echo "<p style='text-align: center'>Number of successful uploads :".$numOfGood."</p>";}
?>
<h2 style= "text-align: center"> Choose Actors File: </h2>
<form style="text-align: center" action="add new files.php" method="post" enctype="multipart/form-data">
    <input name="csv" type="file" id="csv" />
    <input type="submit" name="submit_actors" value="submit" />
</form>
<?php
if(isset($_POST["submit_actors"])){
    $file = $_FILES[csv][tmp_name];
    $numOfGood = 0;
    $numOfBad = -1;
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 3000, ",")) !== FALSE) {
            $sql="INSERT INTO Actors(actor, favoritecountry) VALUES
     		('".addslashes($data[0])."','".addslashes($data[1])."'); ";
            $run = sqlsrv_query($conn, $sql);
            if($run){
                $numOfGood += 1;
            }
            else{
                $numOfBad += 1;
            }
        }
        fclose($handle); }
    echo "<p style='text-align: center'>Number of failed tuples upload :".$numOfBad."\n</p>";
    echo "<p style='text-align: center'>Number of successful uploads :".$numOfGood."</p>";}
?>
<h2 style= "text-align: center"> Choose Movies File: </h2>
<form style="text-align: center" action="add new files.php" method="post" enctype="multipart/form-data">
    <input name="csv" type="file" id="csv" />
    <input type="submit" name="submit_movies" value="submit" />
</form>
<?php
if(isset($_POST["submit_movies"])){
    $file = $_FILES[csv][tmp_name];
    $numOfGood = 0;
    $numOfBad = -1;
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 3000, ",")) !== FALSE) {
            $sql="INSERT INTO Movies(Title, Revenues, Director) VALUES
     		('".addslashes($data[0])."','".addslashes($data[1])."','".addslashes($data[2])."'); ";
            $run = sqlsrv_query($conn, $sql);
            if($run){
                $numOfGood += 1;
            }
            else{
                $numOfBad += 1;
            }
        }
        fclose($handle); }
    echo "<p style='text-align: center'>Number of failed tuples upload :".$numOfBad."\n</p>";
    echo "<p style='text-align: center'>Number of successful uploads :".$numOfGood."</p>"; }
?>
<h2 style= "text-align: center"> Choose ActedIn File: </h2>
<form style="text-align: center" action="add new files.php" method="post" enctype="multipart/form-data">
    <input name="csv" type="file" id="csv" />
    <input type="submit" name="submit_actedin" value="submit" />
</form>
<?php
if(isset($_POST["submit_actedin"])){
    $file = $_FILES[csv][tmp_name];
    $numOfGood = 0;
    $numOfBad = -1;
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 3000, ",")) !== FALSE) {
            $sql="INSERT INTO ActedIn(actor, title, salary) VALUES
     		('".addslashes($data[0])."','".addslashes($data[1])."','".addslashes($data[2])."'); ";
            $run = sqlsrv_query($conn, $sql);
            if($run){
                $numOfGood += 1;
            }
            else{
                $numOfBad += 1;
            }
        }
        fclose($handle); }
    echo "<p style='text-align: center'>Number of failed tuples upload :".$numOfBad."\n</p>";
    echo "<p style='text-align: center'>Number of successful uploads :".$numOfGood."</p>";}
?>
 </body>
</html>
