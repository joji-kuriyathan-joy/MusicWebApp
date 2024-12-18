<?php

include_once('DatabaseModel.php');

class AudioPlayerModel
{
    private $_songId = null;
    private $_albumId = null;
    private $_songList = array();


    public function loadAudioPlayer()
    {

        //Get the song and album id from the url
        if (isset($_GET['sId'])) {
            $_songId = $_GET['sId'];
        } else {
            echo "Song not found";
            return;
        }
        if (isset($_GET['alId'])) {
            $_albumId = $_GET['alId'];
        } else {
            echo "Album not found";
            return;
        }

        //initialize the connection 
        $_db = new Database();
        $_conn = $_db->getConnection();

        // get the current song that need to play and also other tracks related to this album. 
        try {
            $_query = "SELECT s.id as sId, s.name as sName, SUBSTRING_INDEX(s.duration, ':', -2) as sDuration, s.song_name as songName, ar.id as arId, ar.name as arName,
            ar.thumbnail as arThumbnail, al.cover as alCover, al.name as alName, al.id as alId from song as s\n"

                . "left join album as al on s.album_id = al.id\n"

                . "left join artist as ar on s.artist_id = ar.id\n"

                . "where al.id = $_albumId;";

            $_stmt = $_conn->prepare($_query);
            $_stmt->execute();
            $_songList = $_stmt->fetchAll(PDO::FETCH_ASSOC);

            // serving the current song to play from the front end/
            foreach ($_songList as $idx => $eachSongArray) {
                if (intval($eachSongArray['sId']) == intval($_songId)) {
                    $_songList["curSongId"] = $idx;
                }

            }

            //bred crumb data
            $_songList["nav"] = array(['breadcrumbName' =>'Albums', 'navUrl'=>'`./albums.php`'],
                                ['breadcrumbName' =>$_songList[0]['alName'], 'navUrl'=>'`./song.php?id= '.$_albumId.'`']);

        } catch (Exception $e) {
            $_songList = array();
            die("Error: " . $e->getMessage());

        }


        $_db->closeConnection();
        return $_songList;

    }

}

