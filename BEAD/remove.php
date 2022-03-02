<?php
include('storage.php');
$matches = new Storage(new JsonIO('matches.json'));
$id = $_GET['id'];
$team = $_GET['team'];
$matches->delete($id);
header('Location: allteams.php?id='.$team);
?>