<?php
include('storage.php');
session_start();
$id = $_GET['id'];
$comment=[];
$error=[];
$comments = new Storage(new JsonIO('comments.json'));

function validate($in, &$comment, &$error){
    if(!isset($in['comment']) || $in['comment']==""){
        $error['comment']="Comment can't be empty";
    }
    else{
        $comment['text']=$in['comment'];
    }
    return count($error);
}

if(count($_POST) > 0){
    if(validate($_POST, $comment, $error) == 0){
        $today = date("Y-m-d");
        $commentID=$comments->add([
            'date'=> $today,
            'author' => $_SESSION['user']['username'],
            'text'=> $comment['text'],
            'team' => $id,
        ]);
        header('Location: allteams.php?id='.$id);
        exit();
    }
    else{
        header('Location: allteams.php?id='.$id.'&error='.$error['comment']);
        print_r($error['comment']);
        exit();
    }
}

?>