<?php
include_once('DatabaseModel.php');

class ArtistModel
{

    /*
        Artist page contains : 
            Artist Image , Artist Bio, Geners, Artist Name 
            GetAll Album Data for this artist ( Album Image, Album name, Artist Name)
    */

    private $_artistData = array();
    private $_artistId = null;

    public function loadArtist()
    {
        if (isset($_GET['id'])) {
            $_artistId = $_GET['id'];
        } else {
            // TODO: Show an alert that the artist details are not available or return back to the albums page 
            echo "Artist Not Found";
            return;
        }

        //establish the db connection
        $_db = new Database();
        $_conn = $_db->getConnection();

        try {
            //query to populate the artist page 
            $_query = "SELECT ar.id as arId, ar.name as arName, ar.bio as arBio, ar.genre as arGenres, ar.thumbnail as arThumbnail,
                al.id as alId, al.name as alName, al.cover as alCover FROM artist as ar \n"

                . "left join album as al on al.artist_id = ar.id\n"

                . "where ar.id = $_artistId;";

            $_stmt = $_conn->prepare($_query);
            $_stmt->execute();
            $_artistData = $_stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $_artistData = array();
            die("Error: " . $e->getMessage());

        }

        $_db ->closeConnection();
        return $_artistData;


    }

}

