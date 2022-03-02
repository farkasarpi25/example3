<?php
include('storage.php');
$comments = new Storage(new JsonIO('comments.json'));
$id = $_GET['id'];
$comment = $comments->findById($id);
$team = $comment['team'];
$comments->delete($id);
header('Location: allteams.php?id='.$team['id']);
exit();
?>
