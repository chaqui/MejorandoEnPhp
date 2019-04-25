<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;
use app\Models\Project;
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'curso_php',
    'username'  => 'root',
    'password'  => 'root',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$project = new Project();
if(!empty($_POST)){
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