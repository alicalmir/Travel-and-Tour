<?php

require_once './services/TodoServices.php';
require_once './services/UserServices.php';

/**
 * @OA\Get(
 *      path="/todo/{id}",
 *      summary="Get a specific ToDo by ID",
 *      tags={"todos"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ToDo ID",
 *          @OA\Schema(type="integer", format="int64")
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="ToDo data retrieved successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="id", type="integer", example=1),
 *              @OA\Property(property="title", type="string", example="Buy groceries"),
 *              @OA\Property(property="description", type="string", example="Buy milk, eggs, and bread"),
 *          )
 *      ),
 *      @OA\Response(
 *          response="404",
 *          description="ToDo not found",
 *          @OA\JsonContent(
 *              @OA\Property(property="error", type="string", example="ToDo not found")
 *          )
 *      )
 * )
 */
Flight::route('GET /todo/@id', function($id) {
    $todoService = new TodoService(new Todo());
    try {
        $todo = $todoService->getToDoById($id);
        Flight::json($todo);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});

/**
 * @OA\Get(
 *      path="/todos",
 *      summary="Get all ToDos",
 *      tags={"todos"},
 *      @OA\Response(
 *          response="200",
 *          description="List of ToDos",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="title", type="string", example="Buy groceries"),
 *                  @OA\Property(property="description", type="string", example="Buy milk, eggs, and bread"),
 *              )
 *          )
 *      )
 * )
 */

Flight::route('GET /todos', function() {
    $todoService = new TodoService(new Todo());
    try {
        $todos = $todoService->getAllToDos();
        Flight::json($todos);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});


/**
 * @OA\Post(
 *      path="/add_todo",
 *      summary="Create a new ToDo",
 *      tags={"todos"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="title", type="string", example="Buy groceries"),
 *              @OA\Property(property="description", type="string", example="Buy milk, eggs, and bread")
 *          )
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="ToDo created successfully",
 *          @OA\JsonContent(
 *              @OA\Property(property="id", type="integer", example=1),
 *              @OA\Property(property="title", type="string", example="Buy groceries"),
 *              @OA\Property(property="description", type="string", example="Buy milk, eggs, and bread")
 *          )
 *      ),
 *      @OA\Response(
 *          response="400",
 *          description="Bad request",
 *          @OA\JsonContent(
 *              @OA\Property(property="error", type="string", example="Bad request")
 *          )
 *      )
 * )
 */

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

/**
 * @OA\Put(
 *      path="/edit_todo/{id}",
 *      summary="Update a ToDo",
 *      tags={"todos"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ToDo ID",
 *          @OA\Schema(type="integer", format="int64")
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              @OA\Property(property="title", type="string", example="Buy groceries"),
 *              @OA\Property(property="description", type="string", example="Buy milk, eggs, and bread")
 *          )
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="ToDo updated successfully",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="ToDo updated successfully")
 *          )
 *      ),
 *      @OA\Response(
 *          response="500",
 *          description="Internal server error",
 *          @OA\JsonContent(
 *              @OA\Property(property="error", type="string", example="Internal server error")
 *          )
 *      )
 * )
 */

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

/**
 * @OA\Delete(
 *      path="/delete_todo/{id}",
 *      summary="Delete a ToDo",
 *      tags={"todos"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ToDo ID",
 *          @OA\Schema(type="integer", format="int64")
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="ToDo deleted successfully",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="ToDo deleted successfully")
 *          )
 *      ),
 *      @OA\Response(
 *          response="500",
 *          description="Internal server error",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="error", type="string", example="Internal server error")
 *          )
 *      )
 * )
 */
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
