<?php 

class ChatManager {
    private $pdo;

    public function __construct($dsn, $username, $password) {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function updateChatStatus($outgoingId, $chatId) {
        $query = "UPDATE friends SET status = 'Yes' WHERE incoming_id = :chatId AND outgoing_id = :outgoingId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':chatId', $chatId);
        $stmt->bindParam(':outgoingId', $outgoingId);

        if ($stmt->execute()) {
            header("Location: find.php");
        }
    }
}

// Usage
$dsn = 'mysql:host=localhost;dbname=my_database';
$username = 'root';
$password = 'password';

$chatManager = new ChatManager($dsn, $username, $password);
$chatManager->updateChatStatus($_SESSION['u_id'], $_GET['id']);