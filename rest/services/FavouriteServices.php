<?php

require_once './dao/FavouriteDao.class.php';

class FavoritePlaceService {
    protected $favoritePlaceDao;

    public function __construct(FavoritePlaceDao $favoritePlaceDao) {
        $this->favoritePlaceDao = $favoritePlaceDao;
    }

    public function getFavoritePlace($id) {
        $favoritePlace = $this->favoritePlaceDao->getFavoritePlaceById($id);

        if (!$favoritePlace) {
            throw new Exception("Favorite place not found.");
        }

        return $favoritePlace;
    }

    public function createFavoritePlace($data) {
        // Create a new favorite place in the database
        $favoritePlace = $this->favoritePlaceDao->createFavoritePlace($data);
        return $favoritePlace;
    }

    public function getUserFavoritePlaces($userId) {
        $favoritePlaces = $this->favoritePlaceDao->getFavoritePlacesByUserId($userId);
        return $favoritePlaces;
    }

    public function getAllFavoritePlaces() {
        $favoritePlaces = $this->favoritePlaceDao->getAllFavoritePlaces();

        return $favoritePlaces;
    }

    public function updateFavoritePlace($id, $data) {
        $favoritePlace = $this->favoritePlaceDao->getFavoritePlaceById($id);

        if (!$favoritePlace) {
            throw new Exception("Favorite place not found.");
        }

        // Update the favorite place data
        if (isset($data['place_name'])) {
            $favoritePlace['place_name'] = $data['place_name'];
        }
        if (isset($data['description'])) {
            $favoritePlace['description'] = $data['description'];
        }

        // Save the updated favorite place in the database
        $updatedFavoritePlace = $this->favoritePlaceDao->updateFavoritePlace($id, $favoritePlace);

        return $updatedFavoritePlace;
    }

    public function deleteFavoritePlace($id) {
        $favoritePlace = $this->favoritePlaceDao->getFavoritePlaceById($id);

        if (!$favoritePlace) {
            throw new Exception("Favorite place not found.");
        }

        // Delete the favorite place from the database
        $deleted = $this->favoritePlaceDao->deleteFavoritePlace($id);

        if ($deleted) {
            return true;
        } else {
            throw new Exception("Failed to delete favorite place.");
        }
    }
}
?>
