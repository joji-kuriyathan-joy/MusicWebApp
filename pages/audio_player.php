<?php
include_once('../AudioPlayerModel.php');
$_playerObj = new AudioPlayerModel();
$_playerData = $_playerObj->loadAudioPlayer();
$curSongId = $_playerData['curSongId'];
unset($_playerData['curSongId']);
$breadcrumbObj = $_playerData['nav'];
unset($_playerData['nav']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
    <title>Audio Player</title>
    <link rel="stylesheet" href="../css/audio_player.css">
    <link rel="stylesheet" href="../css/global.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
        <section class="audio-conatiner">
            <section class="audio-info">
                <!-- 
                Card : Song Cover : Artist name : Song name 
                swipe/ (< : >) buttons to change the card
                 -->

                <div class="banner">
                    <div class="image-container">
                        <?php
                        echo '<span class="material-symbols-rounded prev-arrow" title="Prev track" onclick="play_prev(\'' . htmlspecialchars($curSongId) . '\')">
                            arrow_back_ios
                        </span>
                        
                        <img id="artistImg" src=" ' . htmlspecialchars($_playerData[$curSongId]['arThumbnail']) . ' " alt="../res/image_placeholder.jpg">
                       
                        <span class="material-symbols-rounded next-arrow" title="Next track" onclick="play_next(\'' . htmlspecialchars($curSongId) . '\')">
                            arrow_forward_ios
                        </span>';
                        ?>
                    </div>

                    <section class="artist-info">
                        <small class="artist-label">
                            <?php
                            echo ' <p class="artist-name" id="av_artist_name" onclick="show_artist(\'' . htmlspecialchars($_playerData[$curSongId]['arId']) . '\')"> '
                                . htmlspecialchars($_playerData[$curSongId]['arName']) . ' </p>
                            
                            <small>Now playing : <b style="color:white;">' . htmlspecialchars($_playerData[$curSongId]['sName']) . '</b></small>';
                            ?>
                        </small>
                    </section>
                </div>


            </section>
            <section class="audio-control">
                <!-- 
                | [>]/[||] : (--------track slider-----------) |
                -->
                <?php
                echo '<audio id="audioTagHidden" controls hidden>
                        <source src="../res/' . htmlspecialchars($_playerData[$curSongId]['songName']) . '" type="audio/mpeg">
                        Your browser does not support the audio element.
                        </audio>';
                ?>
                <span class="material-symbols-rounded play-btn" id="play_btn" onclick="playPauseControl('play');">
                    play_circle
                </span>

                <span class="material-symbols-rounded pause-btn" id="pause_btn" onclick="playPauseControl('pause');">
                    pause_circle
                </span>
                <span id="_audioCurTimeTag"></span>
                <input class="track-slider" type="range" min="0" value="0" step="1" id="progressBar">
                <span id="_durationTag"></span>


            </section>
            <section class="palylist">
                <!--
                 list of song which for the album.
                 highlight the currently playing album
                  -->
                <?php
                $_trackCount = 1;
                foreach ($_playerData as $_song) {
                    echo '<div class="track-container" tabindex="' . htmlspecialchars($_trackCount) . '" id="track_' . htmlspecialchars($_trackCount) . '" 
                                onclick="callAudioPlayer(\'' . htmlspecialchars($_song['sId']) . '\',\'' . htmlspecialchars($_song['alId']) . '\')">
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

        </section>
    </main>
</body>
<script>

    $(document).ready(function () {
        if (localStorage.getItem('playSong')) {
            localStorage.removeItem('playSong');
            playPauseControl('play');
        }
        //other stuff 
    });

    const audio = document.getElementById("audioTagHidden");
    const progressBarEl = document.getElementById("progressBar");
    seeking = false;


    /* 
    Function used to play/pause the audio. 
    Also used to swap btwn the play and pause icon
    */
    function playPauseControl(type) {
        play_ele = document.getElementById("play_btn");
        pause_ele = document.getElementById("pause_btn");

        if (type.toLowerCase() === "play") {
            play_ele.style = 'display:none !important';
            pause_ele.style = 'display:block !important';
            audio.play();

        }
        else if (type.toLowerCase() === "pause") {
            play_ele.style = 'display:block !important';
            pause_ele.style = 'display:none !important';
            audio.pause();
        }
        else {
            //by default show play button;
        }
    }

    /*
    event listener fun: update the time current time and total duration tag
    also show dynamic value in the progressbar input[range]
    */
    audio.addEventListener("timeupdate", () => {
        const currentTime = audio.currentTime;
        const duration = audio.duration;
        //    progressBarEl.setAttribute("max",duration);

        if (seeking) {
            console.log("SEEKINFG");
        }
        else {

            var _audioCurTimeTagEle = document.getElementById("_audioCurTimeTag");
            var _durationTagEle = document.getElementById("_durationTag");

            const currentMinutes = Math.floor(currentTime / 60);
            const currentSeconds = Math.floor(currentTime % 60);
            const totalMinutes = Math.floor(duration / 60);
            const totalSeconds = Math.floor(duration % 60);

            _audioCurTimeTagEle.innerHTML = `${currentMinutes}:${currentSeconds < 10 ? '0' : ''}${currentSeconds}`;
            _durationTagEle.innerHTML = `${totalMinutes}:${totalSeconds < 10 ? '0' : ''}${totalSeconds}`;
            progressBarEl.value = audio.currentTime / audio.duration * 100;
        }


    });


    progressBarEl.addEventListener("mousedown", (e) => {
        seeking = true;
        seek(e);
    });
    progressBarEl.addEventListener("mousemove", (e) => {
        seek(e);
    });
    progressBarEl.addEventListener("mouseup", () => {
        seeking = false;
    });

    //TODO: decide which method neeeds to be kept as best practice. 
    // functionalTesting -done. 
    // user testing --??
    progressBarEl.addEventListener("change", () => {
        const pct = progressBarEl.value / 100;
        audio.currentTime = (audio.duration || 0) * pct;
    });

    function seek(event) {
        if (seeking) {
            progressBarEl.value = event.clientX - progressBarEl.offsetLeft;
            audio.currentTime = audio.duration * (progressBarEl.value / 100);
        }
    }

    function callAudioPlayer(songId, albumId) {
        window.location.href = `./audio_player.php?sId=${songId}&alId=${albumId}`;
        localStorage.setItem('playSong', true);

    }

    function play_next(SongId) {
        if (parseInt(SongId) < parseInt(<?php echo count($_playerData)-1 ?>)) {
            callAudioPlayer(parseInt(<?php echo $_playerData[$curSongId]['sId']?>) + 1, <?php echo $_playerData[$curSongId]['alId'] ?>);
        }
        else {
            alert("End of the album");
        }
    }

    function play_prev(SongId) {
        console.log(SongId);
        if (parseInt(SongId) > 0) {
            callAudioPlayer(parseInt(<?php echo $_playerData[$curSongId]['sId']?>) - 1, <?php echo $_playerData[$curSongId]['alId'] ?>);
        }
        else {
            alert("Start of the album");
        }
    }


</script>

</html>