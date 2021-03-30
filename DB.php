<?php
class DB
{
    private $connection;
    public $last_error = '';

    public function __construct() {
        $this->connection = new mysqli("localhost", "root", "root", "FD7_comments");
        if ($this->connection->connect_error) {
            $this->last_error = "Failed to connect to MySQL: " . $this->connection->connect_error;
            $this->connection = false;
        }
    }

    public function __deconstruct() {
        $this->connection->close();
    }

    public function displayAll() {
        if (!$this->connection) {
            echo $this->$last_error;
            return;
        }

        $result = $this->connection->query("SELECT * FROM comments");

        if ($result->num_rows > 0) {
            echo "<ul class='entry-list'>";
            while($row = $result->fetch_assoc()) {
                echo '<li><span>' . $this->text($row['name']) . '</span>' . $this->text($row['comment']) . ' <a href="update.php?update=' . $this->text($row['id']) . '" >Update</a></li>';
            }
            echo "</ul>";
        } else {
            echo "0 results";
        }
    }

    private function text($value) {
        return htmlentities($value, ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, 'utf-8');
    }

    public function add($name, $comment) {
        if (!$this->connection) {
            return $this->$last_error;
        }

        $sql = sprintf(
            "INSERT INTO comments (`name`, `comment`) VALUES ('%s', '%s')",
            $this->connection->escape_string($name),
            $this->connection->escape_string($comment)
        );
        
        $result = $this->connection->query($sql);
        if ($result != true) {
            return 'Insert failed: ' . $this->connection->error;
        }
        
        return 'Inserted';
    }

    public function update($id, $name, $comment) {
        if (!$this->connection) {
            return $this->$last_error;
        }

        $sql = sprintf(
            "UPDATE comments SET `name`='%s', `comment`='%s' WHERE id=%s",
            $this->connection->escape_string($name),
            $this->connection->escape_string($comment),
            $this->connection->escape_string($id)
        );
        
        $result = $this->connection->query($sql);
        if ($result != true) {
            return 'Update failed: ' . $this->connection->error;
        }
        
        return 'Updated';
    }
}