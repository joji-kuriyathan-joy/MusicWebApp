<?php

include_once('../AlbumsModel.php');
// Initialize the AlbumsModel object

$_albumsObj = new AlbumsModel();
$_albumData = $_albumsObj->getAllAlbums();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
    <title>Albums</title>
    <link rel="stylesheet" href="../css/albums.css">
    <link rel="stylesheet" href="../css/global.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <script type="application/javascript" src="../js/app.js"></script>

</head>

<body>
    <!-- Header 
        This section contains navigation information currently Logo(left) search and user information on the right 
        -->
    <header>

    </header>
    <!-- main -->
    <main>
        <section class="album-container">
            <h1>My Albums</h1>
            <section class="album-cards">

                    <?php
                      if(!empty($_albumData)){
                            foreach($_albumData as $_album){
                                echo '<div class="card" id="_album_card" onclick="show_album_view(\''.htmlspecialchars($_album['albumId']). '\')">
                                        <div class="icon">
                                            <img id="album_cover" src="'.htmlspecialchars($_album['thumbnail']). '" alt="../res/image_placeholder.jpg">
                                        </div>
                                        <div class="card-content">
                                            <p class="album-title" id="album_name">'.htmlspecialchars($_album['albumName']). '</p>
                                            <p class="artist-name" id="artist_name"><small>'.htmlspecialchars($_album['artistName']). '</small></p>
                                        </div>
                                    </div>';  
                            }
                      }
                      else{
                        echo '<p>No albums found.</p>';
                      }

                    ?>  

            </section>
        </section>
    </main>
    <!-- footer -->
    <footer>

    </footer>
</body>

</html>