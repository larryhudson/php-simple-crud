<?php

// SQLite database connection
$db = new SQLite3('database.db');

function deleteItem($id) {
    // Assuming you have already established a database connection and assigned it to the $db variable

    // Prepare the SQL statement with placeholders
    $stmt = $db->prepare("DELETE FROM items WHERE id = :id");
    
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    
    // Execute the prepared statement
    $result = $stmt->execute();
}

function updateItem($id, $name, $description) {
    // Assuming you have already established a database connection and assigned it to the $db variable

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

function createItem($name, $description) {
    // Assuming you have already established a database connection and assigned it to the $db variable

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

        // Return the newly inserted record
        return $record;
    } else {
        // Handle the insertion failure
        // ...

    }
}

function executeQuery($tableName, $whereClause = array()) {
    global $db;

    // Prepare the SQL statement
    $stmt = $db->prepare("SELECT * FROM $tableName");


    // Build the WHERE clause
    $where = '';
    $params = array();

    if (!empty($whereClause)) {
        $where = ' WHERE ';
        $conditions = array();

        foreach ($whereClause as $column => $value) {
            $conditions[] = "$column = :$column";
            $params[":$column"] = $value;
        }

        $where .= implode(' AND ', $conditions);
    }

    // Append the WHERE clause to the SQL statement
    $sql = $stmt->expand($where);

    // Prepare the final SQL statement
    $finalStmt = $db->prepare($sql);

    // Bind the values to the prepared statement parameters
    foreach ($params as $param => $value) {
        $finalStmt->bindValue($param, $value);
    }

    // Execute the prepared statement
    $result = $finalStmt->execute();

    $items = array();

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $items[] = $row;
    }

    return $items;
}
