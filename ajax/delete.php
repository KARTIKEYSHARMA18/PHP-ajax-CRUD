<?php
require_once __DIR__ . '/../db/config.php';

header('Content-Type: application/json');

if($_SERVER["REQUEST_METHOD"] !== 'POST'){
    echo json_encode([
        "status" => "error",
        "message" => "Invalid Request"
    ]);
    exit;
}

$id = intval(trim($_POST['id'] ?? 0));

if($id <= 0){
    echo json_encode([
        "status" => "error",
        "message" => "Invalid user id"
    ]);
    exit;
}

$sql = "DELETE FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if(!$stmt){
    echo json_encode([
        "status" => "error",
        "message" => "Query preparation failed"
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

if(mysqli_stmt_affected_rows($stmt) > 0){
    echo json_encode([
        "status" => "success",
        "message" => "User deleted successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "User not found"
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
