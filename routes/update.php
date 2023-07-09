<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $description = $_POST['description'];

  // Prepare the SQL statement with placeholders
  $stmt = $db->prepare("UPDATE items SET name = :name, description = :description WHERE id = :id");
  
  // Bind the values to the prepared statement parameters
  $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
  $stmt->bindValue(':name', $name, SQLITE3_TEXT);
  $stmt->bindValue(':description', $description, SQLITE3_TEXT);
  
  // Execute the prepared statement
  $result = $stmt->execute();
  
  // Check if the update was successful
  if ($result) {
    // Redirect back to the read page after updating the item
    header('Location: router.php');
    exit();
  } else {
    // Handle the update failure
    // ...
  }
}
?>
