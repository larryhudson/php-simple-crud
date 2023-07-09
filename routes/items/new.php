<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $description = $_POST['description'];

  // Prepare the SQL statement with placeholders
  $stmt = $db->prepare("INSERT INTO items (name, description) VALUES (:name, :description)");
  
  // Bind the values to the prepared statement parameters
  $stmt->bindValue(':name', $name, SQLITE3_TEXT);
  $stmt->bindValue(':description', $description, SQLITE3_TEXT);
  
  // Execute the prepared statement
  $result = $stmt->execute();
  
  if ($result) {
    // Insertion successful
    // Get the ID of the last inserted record
    $lastInsertId = $db->lastInsertRowID();

    // Fetch the newly inserted record
    $query = $db->prepare("SELECT * FROM items WHERE id = :id");
    $query->bindValue(':id', $lastInsertId, SQLITE3_INTEGER);
    $record = $query->execute()->fetchArray(SQLITE3_ASSOC);

    // Access the ID and other fields of the newly inserted record
    $newId = $record['id'];
    $newName = $record['name'];
    $newDescription = $record['description'];
    // ...
  } else {
    // Handle the insertion failure
    // ...
  }

?>
  <tr><td><?= $newId ?></td><td><?= $newName ?></td><td><?= $newDescription ?></td><td><a href='/items/delete?id=<?= $newId ?>'>Delete</a> | <a href='/items/edit?id=<?= $newId ?>'>Edit</a></td></tr>
<?php
exit();
}
?>
<form hx-target="#list" hx-swap="beforeend" hx-post="/items/create" >
  <label for="name">Name:</label>
  <input type="text" name="name" id="name" required><br>
  <label for="description">Description:</label>
  <input type="text" name="description" id="description" required><br>
  <button type="submit">Create</button>
</form>
