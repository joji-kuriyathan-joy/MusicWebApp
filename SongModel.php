<?php
include_once('DatabaseModel.php');


class SongModel{
    private $_songList = array();
    private $_albumId = null;

    public function loadSongForAlbum(){
        
       
        //Check the url has 'id' parm using GET requests
        if (isset($_GET['id'])) {
            $_albumId = intval($_GET['id']);
        } else {
            // Fallback behaviour goes here
            echo "Album / Song not found";
            return;
        }

        //initialize the connection 
        $_db = new Database();
        $_conn = $_db->getConnection();
        try{
            $_query = "SELECT s.id as sId, s.name as sName, SUBSTRING_INDEX(s.duration, ':', -2) as sDuration, ar.id as arId, ar.name as arName,
            ar.thumbnail as arThumbnail, al.cover as alCover, al.name as alName, al.id as alId from song as s\n"

            . "left join album as al on s.album_id = al.id\n"

            . "left join artist as ar on s.artist_id = ar.id\n"

            . "where al.id = $_albumId;";

            $_stmt = $_conn->prepare($_query);
            $_stmt->execute();
            $_songList = $_stmt->fetchAll(PDO::FETCH_ASSOC);
            //bred crumb data
            if(!empty($_songList)){
                $_songList["nav"] = array(['breadcrumbName' =>'Albums', 'navUrl'=>'`./albums.php`'],
                ['breadcrumbName' =>$_songList[0]['alName'], 'navUrl'=>'`./song.php?id='.$_albumId.'`']);
            }
            else{
                $_songList["nav"] = array(['breadcrumbName' =>'Albums', 'navUrl'=>'`./albums.php`']);
            }
            
        }catch (Exception $e) {
            $_songList = array();
            die("Error: " . $e->getMessage());

        }

        $_db->closeConnection();
        return $_songList;
    }
}

