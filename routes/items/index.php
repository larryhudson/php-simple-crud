<?php
$items = executeQuery('items');
?>

<!DOCTYPE html>
<html>
<head>
  <title>CRUD Example - Read</title>
<script src="https://unpkg.com/htmx.org@1.9.2" integrity="sha384-L6OqL9pRWyyFU3+/bjdSri+iIphTN/bvYyM37tICVyOJkWZLpP2vGn6VUEXgzg6h" crossorigin="anonymous"></script>
</head>
<body>
  <table>
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
</thead>
<tbody>
<?php
  foreach ($items as $item) {
?>
    <tr>
      <td><?= $item['id'] ?></td>
      <td><?= $item['name'] ?></td>
      <td><?= $item['description'] ?></td>
  </tr>
<?php
  }
?>
</tbody>
</table>

  <!-- Link to create a new item -->
  <button hx-get="/items/create" hx-swap="outerHTML">Create New Item</button>
</body>
</html>

