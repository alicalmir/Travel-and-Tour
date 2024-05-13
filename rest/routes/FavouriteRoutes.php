<?php

require_once './dao/FavouriteDao.class.php';
require_once './services/FavouriteServices.php';

/**
 * @OA\Get(
 *      path="/favorite_place/{id}",
 *      summary="Get a specific favorite place by ID",
 *      tags={"favorite_places"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="Favorite place ID",
 *          @OA\Schema(type="integer", format="int64")
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="Favorite place data retrieved successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="id", type="integer", example=1),
 *          )
 *      ),
 *      @OA\Response(
 *          response="404",
 *          description="Favorite place not found",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="error", type="string", example="Favorite place not found")
 *          )
 *      )
 * )
 */
Flight::route('GET /favorite_place/@id', function($id) {
    $favoritePlaceService = new FavoritePlaceService(new FavoritePlaceDao());
    try {
        $favoritePlace = $favoritePlaceService->getFavoritePlace($id);
        Flight::json($favoritePlace);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});

/**
 * @OA\Get(
 *      path="/favorite_places",
 *      summary="Get all favorite places",
 *      tags={"favorite_places"},
 *      @OA\Response(
 *          response="200",
 *          description="List of favorite places",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *              )
 *          )
 *      )
 * )
 */
Flight::route('GET /favorite_places', function() {
    $favoritePlaceService = new FavoritePlaceService(new FavoritePlaceDao());
    try {
        $favoritePlaces = $favoritePlaceService->getAllFavoritePlaces();
        Flight::json($favoritePlaces);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Post(
 *      path="/add_favorite_place",
 *      summary="Create a new favorite place",
 *      tags={"favorite_places"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *  @OA\Property(property="place_name", type="string", example="demo@gmail.com",description="Place Name" ),
*             @OA\Property(property="description", type="string", example="12345",	description="Description" ),
*             @OA\Property(property="user_id", type="string", example="123",	description="Description" )
 *          )
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="Favorite place created successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="id", type="integer", example=1),
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
Flight::route('POST /add_favorite_place', function() {
    $request = Flight::request();
    $data = $request->data->getData();

    $favoritePlaceService = new FavoritePlaceService(new FavoritePlaceDao());
    try {
        $favoritePlace = $favoritePlaceService->createFavoritePlace($data);
        Flight::json($favoritePlace);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *      path="/edit_favorite_place/{id}",
 *      summary="Update a favorite place",
 *      tags={"favorite_places"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="Favorite place ID",
 *          @OA\Schema(type="integer", format="int64")
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 * @OA\Property(property="place_name", type="string", example="demo@gmail.com",description="Place Name" ),
*             @OA\Property(property="description", type="string", example="12345",	description="Description" ),
*             @OA\Property(property="user_id", type="string", example="123",	description="Description" )
 *          )
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="Favorite place updated successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Favorite place updated successfully")
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
Flight::route('PUT /edit_favorite_place/@id', function($id) {
    $data = Flight::request()->data->getData();

    $favoritePlaceService = new FavoritePlaceService(new FavoritePlaceDao());
    try {
        $success = $favoritePlaceService->updateFavoritePlace($id, $data);
        if ($success) {
            Flight::json(['message' => 'Favorite place updated successfully'], 200);
        } else {
            Flight::json(['message' => 'Failed to update favorite place'], 500);
        }
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});

/**
 * @OA\Delete(
 *      path="/delete_favorite_place/{id}",
 *      summary="Delete a favorite place",
 *      tags={"favorite_places"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="Favorite place ID",
 *          @OA\Schema(type="integer", format="int64")
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="Favorite place deleted successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Favorite place deleted successfully")
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
Flight::route('DELETE /delete_favorite_place/@id', function($id) {
    $favoritePlaceService = new FavoritePlaceService(new FavoritePlaceDao());
    try {
        $success = $favoritePlaceService->deleteFavoritePlace($id);
        if ($success) {
            Flight::json(['message' => 'Favorite place deleted successfully'], 200);
        } else {
            Flight::json(['message' => 'Failed to delete favorite place'], 500);
        }
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});
?>
