<?php
if ($_POST) {
    $user_id = $_POST['userId'];
    $first_name = $_POST['f_name'];
    $last_name = $_POST['l_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    //adding the record.
    require_once __DIR__ . "/connection.php";
    try {
        $sql = "UPDATE users SET email=?,first_name=?, last_name=?,role=?, updated_at=?  WHERE id=?";
        $conn->prepare($sql)->execute([$email, $first_name, $last_name, $role, date('Y-m-d h:i:s'), $user_id]);
        echo json_encode([
            'success' => true,
            'message' => $first_name . ' ' . $last_name . ' successfully updated.'
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error processing your request!'
        ]);
    }
}
