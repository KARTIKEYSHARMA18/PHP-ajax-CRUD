<?php
require_once __DIR__ . '/db/config.php';

$sql = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    exit("Query Failed");
}

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

       
        $id     = (int)$row['id'];
        $name   = htmlspecialchars($row['name']);
        $email  = htmlspecialchars($row['email']);
        $age    = (int)$row['age'];
        $gender = htmlspecialchars($row['gender']);
    
      
        echo "<tr>";
        echo "<td>{$name}</td>";
        echo "<td>{$email}</td>";
        echo "<td>{$age}</td>";
        echo "<td>{$gender}</td>";
        echo "<td>
                <button class='edit-btn'
                    onclick=\"editUser({$id}, '{$name}', '{$email}', {$age}, '{$gender}')\">
                    Edit
                </button>

                <button class='delete-btn'
                    onclick=\"deleteUser({$id})\">
                    Delete
                </button>
              </td>";
              
        echo "</tr>";
    }

} 
?>
