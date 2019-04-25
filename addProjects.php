<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use app\Models\Project;


if(!empty($_POST)){
  $project = new Project();
  $project->title = $_POST["Title"];
  $project->description = $_POST["Description"];
  $project->save();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
    crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <title>Add Project</title>
</head>
<body>
  <h1>Add Project.</h1>
  <form action="addProjects.php" method="POST">
    <label for="">Title:</label>
    <input type="text" name="Title" id=""> <br>
    <label for="">Description:</label>
    <input type="text" name="Description" id=""> <br>
    <button type="submit">Save</button>
  </form>
</body>
</html>