<?php
$id = $_GET['id'] ?? '';

// Prepare the SQL statement with placeholders
$stmt = $db->prepare("DELETE FROM items WHERE id= :id");

$stmt->bindValue(':id', $id, SQLITE3_INTEGER);

// Execute the prepared statement
$result = $stmt->execute();

// Redirect back to the read page after deleting the item
header('Location: /');
exit();
?>

