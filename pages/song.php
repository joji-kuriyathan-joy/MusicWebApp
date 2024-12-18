<?php
include_once('../SongModel.php');
$_songObj = new SongModel();
$_songData = $_songObj->loadSongForAlbum();
$breadcrumbObj = $_songData['nav'];
unset($_songData['nav']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
    <title>Album View</title>
    <link rel="stylesheet" href="../css/album_view.css">
    <link rel="stylesheet" href="../css/global.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <script type="application/javascript" src="../js/app.js"></script>

</head>

<body>
    <header>
    <div class="bd_container">
            <ul class="breadcrumb">
                <?php 
                foreach($breadcrumbObj as $key => $info){
                    echo'
                    <li class="breadcrumb__item breadcrumb__item-firstChild" onclick="pageNav('.htmlspecialchars($breadcrumbObj[$key]['navUrl']).')">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">'. htmlspecialchars($breadcrumbObj[$key]['breadcrumbName']).'</span>
                        </span>
                    </li>
                    ';
                }
                ?>
               
            </ul>
        </div>
    </header>
    <main>
        <section class="album-view-container">
            <?php
            if (!empty($_songData)) {
                $_albumName = $_songData[0]['alName'];
                $_albumCover = $_songData[0]['alCover'];
                $_albumId = $_songData[0]['alId'];
                $_artistId = $_songData[0]['arId'];
                $_artistName = $_songData[0]['arName'];
                $_artistImg = $_songData[0]['arThumbnail'];
                
                
                echo '<section class="album-info">
                <img id="av_alvum_cover" class="album-icon" src=" ' . htmlspecialchars($_albumCover) . ' " alt="../res/image_placeholder.jpg">
                <div class="artist-info">
                    <div>
                        <img id="av_artist_img" src=" ' . htmlspecialchars($_artistImg) . ' " alt="../res/image_placeholder.jpg">
                    </div>
                    
                    <small class="artist-label">Artist <br>
                        <p class="artist-name" id="av_artist_name" title="Click to view artist info." onclick="show_artist(\''.htmlspecialchars($_artistId). '\')"> ' . htmlspecialchars($_artistName) . ' </p>
                    </small>

                </div>
            </section>
            <section class="tracks-list">
                <h2 class="album-name">' . htmlspecialchars($_albumName) . '</h2>';
                $_trackCount = 1;
                foreach ($_songData as $_song) {
                    /*  each track-container onclick -> callAudioPlayer() : 
                        pass the song ID as param
                        $_song['sId'];
                    */ 
                    echo '<div class="track-container" id="track_'.htmlspecialchars($_trackCount).'" onclick="callAudioPlayer(\''.htmlspecialchars( $_song['sId']).'\',\''.htmlspecialchars($_albumId).'\')">
                            <div class="track-count-name">
                                <span class="track-count" id="t_count">' . htmlspecialchars($_trackCount) . '</span>
                                <span class="track-name" id="t_name">' . htmlspecialchars($_song['sName']) . '</span>
                            </div>
                            <div class="track-time-fav">
                                <span class="track-fav material-symbols-rounded" id="t_fav"> favorite </span>
                                <span class="track-time" id="t_time"> ' . htmlspecialchars($_song['sDuration']) . ' </span>
                            </div>
                        </div>';
                        $_trackCount++;
                }
                ?>
                </section>
            <?php } else{
                include '404.php';
            }

            ?>

        </section>
    </main>
</body>

<script>

            function callAudioPlayer(songId, albumId){
                window.location.href = `./audio_player.php?sId=${songId}&alId=${albumId}`;
            }
</script>

</html>