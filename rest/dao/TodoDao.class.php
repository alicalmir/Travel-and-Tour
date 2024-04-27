<?php

require_once 'BaseDao.class.php';

class Todo extends BaseDao {
    public function __construct() {
        parent::__construct('todos');
    }

    public function getToDoById($id) {
        return $this->get_by_id($id);
    }

    public function createToDo($todo) {
        return $this->add($todo);
    }

    public function getAllToDos() {
        return $this->get_all();
    }

    public function getToDosByUserId($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateToDo($id, $data) {
        $title = $data['title'];
        $description = $data['description'];
        $completed = $data['completed'];

        $stmt = $this->conn->prepare("UPDATE todos SET title = ?, description = ?, completed = ? WHERE id = ?");
        $stmt->execute([$title, $description, $completed, $id]);

        return $stmt->rowCount() > 0;
    }

    public function deleteToDo($id) {
        $stmt = $this->conn->prepare("DELETE FROM todos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}

?>