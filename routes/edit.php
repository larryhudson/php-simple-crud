<?php
$id = $_GET['id'] ?? '';

// Prepare the SQL statement with placeholders
$stmt = $db->prepare("SELECT * from items WHERE id= :id");

// Bind the values to the prepared statement parameters
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
// Execute the prepared statement
$result = $stmt->execute();
  
$row = $result->fetchArray();
$name = $row['name'];
$description = $row['description'];
?>

<form method="post" action="/items/update">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  <label for="name">Name:</label>
  <input type="text" name="name" id="name" required value="<?php echo $name; ?>"><br>
  <label for="description">Description:</label>
  <input type="text" name="description" id="description" required value="<?php echo $description; ?>"><br>
  <button type="submit">Update</button>
</form>
