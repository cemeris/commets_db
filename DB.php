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
                echo "<li><span>" . $row['name'] . "</span>" . $row["comment"] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "0 results";
        }
    }

    public function add($name, $comment) {
        if (!$this->connection) {
            echo $this->$last_error;
            return;
        }

        $result = $this->connection->query("INSERT INTO comments (`name`, `comment`) VALUES ('$name', '$comment')");

        if ($result != true) {
            echo 'Insert failed: ' . $this->connection->error;
        }
    }
}