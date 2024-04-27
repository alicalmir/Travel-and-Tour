<?php

require_once './dao/FavouriteDao.class.php';
require_once './services/FavouriteServices.php';


Flight::route('GET /favorite_place/@id', function($id) {
    $favoritePlaceService = new FavoritePlaceService(new FavoritePlaceDao());
    try {
        $favoritePlace = $favoritePlaceService->getFavoritePlace($id);
        Flight::json($favoritePlace);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});

Flight::route('GET /favorite_places', function() {
    $favoritePlaceService = new FavoritePlaceService(new FavoritePlaceDao());
    try {
        $favoritePlaces = $favoritePlaceService->getAllFavoritePlaces();
        Flight::json($favoritePlaces);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

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
