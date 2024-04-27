<?php

require_once 'BaseDao.class.php';

class FavoritePlaceDao extends BaseDao {
    public function __construct() {
        parent::__construct('favorite_places');
    }

    public function getFavoritePlaceById($id) {
        return $this->get_by_id($id);
    }

    public function createFavoritePlace($favoritePlace) {
        return $this->add($favoritePlace);
    }

    public function getAllFavoritePlaces() {
        return $this->get_all();
    }

    public function getFavoritePlacesByUserId($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateFavoritePlace($id, $data) {
        $place_name = $data['place_name'];
        $description = $data['description'];

        $stmt = $this->conn->prepare("UPDATE favorite_places SET place_name = ?, description = ? WHERE id = ?");
        $stmt->execute([$place_name, $description, $id]);

        return $stmt->rowCount() > 0;
    }

    public function deleteFavoritePlace($id) {
        $stmt = $this->conn->prepare("DELETE FROM favorite_places WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>
