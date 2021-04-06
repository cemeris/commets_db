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
            echo $this->last_error;
            return;
        }

        $result = $this->connection->query("SELECT * FROM comments");

        if ($result->num_rows > 0) {
            echo "<ul class='entry-list'>";
            while($row = $result->fetch_assoc()) {
                $id = $this->text($row['id']);
                echo sprintf(
                    '<li>
                        <span>%s</span>
                        %s
                        <a href="update.php?update=%s">Update</a>
                        <a href="request.php?delete=%s" class="delete" onclick="postFromLink.bind(this)(event)">x</a>
                    </li>',
                    $this->text($row['name']),
                    $this->text($row['comment']),
                    $id,
                    $id
                );
            }
            echo "</ul>";
        } else {
            echo "0 results";
        }
    }

    public function get($id) {
        if (!$this->connection) {
            echo $this->last_error;
            return;
        }

        $result = $this->connection->query(
            sprintf(
                "SELECT name, comment FROM comments WHERE id='%s'",
                $this->connection->escape_string($id)
            )
        );

        return ($result) ? $result->fetch_assoc() : [];
    }

    public function text($value) {
        return htmlentities($value, ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, 'utf-8');
    }

    public function add($name, $comment) {
        if (!$this->connection) {
            return $this->last_error;
        }

        $name = $this->connection->escape_string($name);
        $comment = $this->connection->escape_string($comment);
        $sql = sprintf(
            "INSERT INTO comments (`name`, `comment`) VALUES ('%s', '%s')",
            $name,
            $comment
        );
        
        $result = $this->connection->query($sql);
        if ($result != true) {
            return json_encode(['error' => $this->connection->error]);
        }
        
        return json_encode([
            'name' => $this->text($name),
            'comment' => $this->text($comment),
            'id' => $this->text($this->connection->insert_id)
        ]);
    }

    public function update($id, $name, $comment) {
        if (!$this->connection) {
            return $this->last_error;
        }

        $sql = sprintf(
            "UPDATE comments SET `name`='%s', `comment`='%s' WHERE id='%s'",
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

    public function delete($id) {
        if (!$this->connection) {
            return $this->last_error;
        }

        $sql = sprintf(
            "DELETE FROM comments WHERE id=%s",
            $this->connection->escape_string($id)
        );
        
        $result = $this->connection->query($sql);
        if ($result != true) {
            return 'Delete failed: ' . $this->connection->error;
        }
        
        return 'Deleted';
    }
}