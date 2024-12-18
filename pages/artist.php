<?php

include_once('../ArtistModel.php');

$_artistObj = new ArtistModel();
$_artistData = $_artistObj->loadArtist();
$breadcrumbObj = $_artistData['nav'];
unset($_artistData['nav']);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
    <title>Artist</title>
    <link rel="stylesheet" href="../css/artist.css">
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
        <section class="artist-container">
            <!-- artist info section -->
            <section class="artist-header">
                <!-- Banner and Artist Name -->
                <?php

                /* 
                so an artist can have n number of albums, since the query uses a join on album table
                and return an array where the details from the Artist table would be same in all rows. 
                Hence use the first item in the array to display Bio, Genres , Thumbnail and Artist Name.

                */

                //check if the array is not empty 
                if (!empty(($_artistData))) {
                    $_arId = $_artistData[0]['arId'];
                    $_arName = $_artistData[0]['arName'];
                    $_arBio = $_artistData[0]['arBio'];
                    $_arGenres = $_artistData[0]['arGenres']; // will need to explod this later
                    $_arThumbnail = $_artistData[0]['arThumbnail'];

                    //_arGenres contains information seperated using '~' . So expload it, later loop it and use <li> 
                    // to display
                    $_arGenresList = explode('~', $_arGenres);

                    echo '<section class="banner">
                                <img src="' . htmlspecialchars($_arThumbnail) . '" alt="../res/image_placeholder.jpg">
                                <section class="artist-info">
                                    <h1>' . htmlspecialchars($_arName) . '</h1>
                                    <article>
                                        <small class="bio">' . htmlspecialchars($_arBio) . '</small>
                                        <aside>
                                            <h4>Geners</h4>
                                            <ul>';
                                            foreach ($_arGenresList as $_arGenre) {
                                                echo '<li>' . htmlspecialchars($_arGenre) . '</li>';
                                            }
                                            echo '</ul>
                                        </aside>
                                    </article>
                                </section>
                            </section>';

                } else {
                    echo '<p>Something went wrong!! </p>';
                }

                ?>
            </section>

            <!-- albums section -->
            <section class="album-container">
                <h1>Albums</h1>
                <section class="album-cards">

                    <?php
                     /* 
                     check array empty - loop the array get the album details and display
                     */

                     if(!empty($_artistData)){

                        foreach($_artistData as $_data) {
                            echo ' <div class="card" id="_album_card" onclick="show_album_view(\''. htmlspecialchars($_data['alId']).'\')">
                                        <div class="icon">
                                            <img id="album_cover" src="'. htmlspecialchars($_data['alCover']).'"
                                                alt="../res/image_placeholder.jpg">
                                        </div>
                                        <div class="card-content">
                                            <p class="album-title" id="album_name">'. htmlspecialchars($_data['alName']).'</p>
                                            <p class="artist-name" id="artist_name"><small>'. htmlspecialchars($_data['arName']).'</small></p>
                                        </div>
                                    </div>';
                     }
                     }
                    ?>
<!-- 
                    <div class="card" id="_album_card" onclick="show_album_view('album_id')">
                        <div class="icon">
                            <img id="album_cover" src="../res/image_placeholder_1.jpg"
                                alt="../res/image_placeholder.jpg">
                        </div>
                        <div class="card-content">
                            <p class="album-title" id="album_name">Album Name</p>
                            <p class="artist-name" id="artist_name"><small>Artist Name</small></p>
                        </div>
                    </div>
                     -->

                </section>
            </section>

        </section>
    </main>
</body>

</html>