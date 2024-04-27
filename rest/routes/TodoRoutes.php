<?php

require_once './services/TodoServices.php';
require_once './services/UserServices.php';

Flight::route('GET /todo/@id', function($id) {
    $todoService = new TodoService(new Todo());
    try {
        $todo = $todoService->getToDoById($id);
        Flight::json($todo);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});

Flight::route('GET /todos', function() {
    $todoService = new TodoService(new Todo());
    try {
        $todos = $todoService->getAllToDos();
        Flight::json($todos);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /add_todo', function() {
    $request = Flight::request();
    $data = $request->data->getData();

    $todoService = new TodoService(new Todo());
    try {
        $todo = $todoService->createToDo($data);
        Flight::json($todo);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /edit_todo/@id', function($id) {
    $data = Flight::request()->data->getData();

    $todoService = new TodoService(new Todo());
    try {
        $success = $todoService->updateToDo($id, $data);
        if ($success) {
            Flight::json(['message' => 'ToDo updated successfully'], 200);
        } else {
            Flight::json(['message' => 'Failed to update ToDo'], 500);
        }
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});

Flight::route('DELETE /delete_todo/@id', function($id) {
    $todoService = new TodoService(new Todo());
    try {
        $success = $todoService->deleteToDo($id);
        if ($success) {
            Flight::json(['message' => 'ToDo deleted successfully'], 200);
        } else {
            Flight::json(['message' => 'Failed to delete ToDo'], 500);
        }
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});

?>
