<?php

include_once('DatabaseModel.php');


class AlbumsModel {
    private $_albumsList = array();

    public function getAllAlbums(){
        $_db = new Database();
        $_conn = $_db->getConnection();
    
        try{
            // Get all albums join with artist table
            $_query = "SELECT al.id as albumId, al.name as albumName, al.thumbnail as thumbnail,
             ar.name as artistName from album as al\n". "left join artist as ar on al.artist_id = ar.id;";
            $_stmt = $_conn->prepare($_query);
            $_stmt->execute();
            $_albumsList = $_stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }catch (Exception $e) {
            $_albumsList = array();
            die("Error: " . $e->getMessage());

        }
        $_db->closeConnection();

        return $_albumsList;
    }
    
}

