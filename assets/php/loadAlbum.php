<?php
require_once 'Database.php';

$db = new Database();

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage = 9;
$offset = ($page - 1) * $perPage;

$albums = $db->getAlbumsPaginated($perPage, $offset);

$jsonAlbums = [];

foreach ($albums as $album) {
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

echo json_encode($jsonAlbums);