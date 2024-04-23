<?php

require_once './dao/TodoDao.class.php';

class TodoService {
    protected $todoDao;

    public function __construct(Todo $todoDao) {
        $this->todoDao = $todoDao;
    }

    public function getToDoById($id) {
        $todo = $this->todoDao->getToDoById($id);

        if (!$todo) {
            throw new Exception("ToDo not found.");
        }

        return $todo;
    }

    public function createToDo($data) {
        // Create a new ToDo in the database
        $todo = $this->todoDao->createToDo($data);

        return $todo;
    }

    public function getUserToDos($userId) {
        $todos = $this->todoDao->getToDosByUserId($userId);
        return $todos;
    }

    public function getAllToDos() {
        $todos = $this->todoDao->getAllToDos();

        return $todos;
    }

    public function updateToDo($id, $data) {
        $todo = $this->todoDao->getToDoById($id);

        if (!$todo) {
            throw new Exception("ToDo not found.");
        }

        // Update the ToDo data
        if (isset($data['title'])) {
            $todo['title'] = $data['title'];
        }
        if (isset($data['description'])) {
            $todo['description'] = $data['description'];
        }
        if (isset($data['completed'])) {
            $todo['completed'] = $data['completed'];
        }

        // Save the updated ToDo in the database
        $updatedToDo = $this->todoDao->updateToDo($id, $todo);

        return $updatedToDo;
    }

    public function deleteToDo($id) {
        $todo = $this->todoDao->getToDoById($id);

        if (!$todo) {
            throw new Exception("ToDo not found.");
        }

        // Delete the ToDo from the database
        $deleted = $this->todoDao->deleteToDo($id);

        if ($deleted) {
            return true;
        } else {
            throw new Exception("Failed to delete ToDo.");
        }
    }
}

?>