<?php

require_once __DIR__ . '/../db/config.php';
header('Content-Type: application/json');

$name   = trim($_POST['name'] ?? '');
$email  = trim($_POST['email'] ?? '');
$age    = trim($_POST['age'] ?? '');
$gender = trim($_POST['gender'] ?? '');

$errors = [];


if ($name === '' || $email === '' || $age === '' || $gender === '') {
    $errors[] = "All fields are required";
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors[] = "Invalid email format";
}

if(!is_numeric($age) || $age <= 0){
    $errors[] = "Invalid age";
}

$genders = ["Male", "Female"];
if(!in_array($gender, $genders, true)){
    $errors[] = " not valid gender";
}

if(!empty($errors)){
    echo json_encode([
        "status" => "error",
        "message" => implode(", ", $errors)
    ]);
    exit;
}

$check = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
mysqli_stmt_bind_param($check, "s", $email);
mysqli_stmt_execute($check);

mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Email already exists"
    ]);
    exit;
}

mysqli_stmt_close($check);


$stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, age, gender) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssis", $name, $email, $age, $gender);

if(mysqli_stmt_execute($stmt)){
    echo json_encode([
        "status" => "success",
        "message" => "User added successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Insert failed"
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
