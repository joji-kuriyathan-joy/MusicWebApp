# MusicWebApp
Bootcamp with Layers Studio. Full Stack Development with PHP

# Database Design
* ## Artist
  * id - int - PK
  * name - varchar(100)
  * bio - varchar(200)
  * genre - varchar(100)
  * play_counter - int // show top 10 Artist 
  * thumbnail varchar(100)
  * cover varchar(100)
* ## Album
  * id - int - PK
  * name - varchar(100)
  * artist_id - int - FK
  * play_counter - int // show top 10 Albums
  * thumbnail varchar(100)
  * cover varchar(100)
* ## Song
  * id - int - PK
  * name - varchar(100)
  * artist_id - int - FK
  * album_id - int - FK
  * likes - int
  * language - varchar(100)
  * play_counter - int // show top 10 Songs
  * thumbnail varchar(100)
  * cover varchar(100)
* ## User
