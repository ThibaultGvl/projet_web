<?php
require_once 'Database.php';

$db = new Database('db/');
static $page = 1;
//isset($_POST['page']) est toujours false ici
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$perPage = 3;

$albums = $db->getAlbumsPaginated($perPage, $page);

$jsonAlbums = [];

foreach ($albums as $album) {
    if ($album != null) {
        $jsonAlbum = json_encode([
            'id' => $album->getId(),
            'title' => $album->getTitle(),
            'descript' => $album->getDescription(),
            'artist' => $album->getArtist(),
            'ranking' => $album->getRank(),
            'uri' => $album->getUri()
        ]);
        
        array_push($jsonAlbums, $jsonAlbum);
    }
}

echo json_encode($jsonAlbums);