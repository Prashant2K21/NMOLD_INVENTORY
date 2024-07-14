
<?php
include_once __DIR__."/connection.php";
if ($_POST) {
    $user_id=$_POST['user_id'];
    $query="DELETE FROM users Where id='$user_id'";
    $result=$conn->exec($query);
    if($result){
        echo json_encode(["success"=>true,
        "message" => "deleted successfully"
    ]);
    }else{
        echo json_encode(["success"=>false]);
    }
} else {
    echo json_encode(["success"=>false,
    "message" => "unable to delete"
    ]);
}