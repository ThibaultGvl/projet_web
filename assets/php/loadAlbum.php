<?php
require_once 'models/Database.php';

$db = new Database('db/');
$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
$page = $data->page;
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