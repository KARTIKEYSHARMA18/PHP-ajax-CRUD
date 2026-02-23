<?php

require_once __DIR__ . "/../db/config.php";

header("Content-Type: application/json");



$errors = [];

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request"
    ]);
    exit;
}

$id = $_POST['id'] ?? '';
if(!filter_var($id, FILTER_VALIDATE_INT)){
    echo json_encode([
        "status" => "error", 
        "message" => "invalid_id"
    ]);
    exit;
}
$id = (int)$id;

$name   = trim($_POST['name'] ?? '');
$email  = trim($_POST['email'] ?? '');
$age    = trim($_POST['age'] ?? '');
$gender = trim($_POST['gender'] ?? '');

// Validation
if ($id <= 0) {
    $errors[] = "Invalid user ID";
}

if ($name === '' || $email === '' || $age === '' || $gender === '') {
    $errors[] = "All fields are required";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

if (!is_numeric($age) || $age <= 0) {
    $errors[] = "Invalid age";
}
$genders = ["Male", "Female"];
if(!in_array($gender, $genders, true)){
    $errors[] = " not valid gender";
}
if (!empty($errors)) {
    echo json_encode([
        "status" => "error",
        "message" => implode(", ", $errors)
    ]);
    exit;
}

// Update
$sql = "UPDATE users SET name=?, email=?, age=?, gender=? WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssisi", $name, $email, $age, $gender, $id);

if(mysqli_stmt_execute($stmt)){
    echo json_encode([
        "status" => "success",
        "message" => "User updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Error updating user"
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?> 