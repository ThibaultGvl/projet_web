<?php

require_once 'Album.php';
require_once 'Comment.php';

class Database {

	private $pdo;

	function __construct($path) {
		$this->pdo = $this->connect($path);
	}

	function connect($path) {
		if($this->pdo==null) {
				$this->pdo = new PDO('sqlite:'. $path .'database.db');
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->query('CREATE TABLE IF NOT EXISTS albums (
					id INTEGER PRIMARY KEY AUTOINCREMENT,
					title VARCHAR(255) NOT NULL,
					descript VARCHAR NOT NULL,
					artist VARCHAR NOT NULL,
					ranking INTEGER NOT NULL,
					uri VARCHAR
				)');
				$this->pdo->query('CREATE TABLE IF NOT EXISTS comments (
					id INTEGER PRIMARY KEY AUTOINCREMENT,
					email VARCHAR,
					user VARCHAR(255) NOT NULL,
					comment VARCHAR NOT NULL
				)');
				$this->initDatabase();
		}
		return $this->pdo;
	}

	public function insertAlbum($album) {
		$sql = 'INSERT INTO albums(id, title, descript, artist, ranking, uri) '
		. 'VALUES(:id, :title, :descript, :artist, :ranking, :uri)';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':id', $album->getId(), PDO::PARAM_INT);
		$stmt->bindValue(':title', htmlspecialchars($album->getTitle()), PDO::PARAM_STR);
		$stmt->bindValue(':descript', htmlspecialchars($album->getDescription()), PDO::PARAM_STR);
		$stmt->bindValue(':artist', htmlspecialchars($album->getArtist()), PDO::PARAM_STR);
		$stmt->bindValue(':ranking', $album->getRank(), PDO::PARAM_INT);
		$stmt->bindValue(':uri', htmlspecialchars($album->getUri()), PDO::PARAM_STR);
		$stmt->execute();
		$album->setId($this->pdo->lastInsertId());
	}

	public function insertComment($comment) {
		try {
			$sql = 'INSERT INTO comments(email, user, comment) '
			. 'VALUES(:email, :user, :comment)';
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':email', htmlspecialchars($comment->getEmail()), PDO::PARAM_STR);
			$stmt->bindValue(':user', htmlspecialchars($comment->getUser()), PDO::PARAM_STR);
			$stmt->bindValue(':comment', htmlspecialchars($comment->getComment()), PDO::PARAM_STR);
			$stmt->execute();
			$comment->setId($this->pdo->lastInsertId());
		} catch(PDOException $e) {
			echo "Error inserting comment: " . $e->getMessage();
		}
	}
	
	

	public function getAlbums() {
		$stmt = $this->pdo->query('SELECT * FROM albums');
		$albums = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$album = new Album($row['title'], $row['artist'], $row['descript'], $row['ranking'], $row['uri']);
			$album->setId($row['id']);
			$albums[] = $album;
		}
		return $albums;
	}

	public function getComments() {
		$stmt = $this->pdo->query('SELECT * FROM comments');
		$comments = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$comment = new Comment($row['email'], $row['user'], $row['comment']);
			$comment->setId($row['id']);
			$comments[] = $comment;
		}
		return $comments;
	}

	public function getAlbumById($id) {
		$albums = $this->getAlbums();
		$return = null;
		foreach ($albums as $album) {
			if ($album->getId() == $id) {
				$return = $album;
			}
		}
		if (!$return) {
			shuffle($albums);
			$return = $albums[0];
		}
		return $return;
	}

	public function getAlbumsByName($name) {
		$albums = $this->getAlbums();
		$albumsToReturn = [];
		foreach ($albums as $album) {
			if (strpos(strtolower($album->getTitle()), strtolower($name)) !== false || strpos(strtolower($album->getArtist()), strtolower($name)) !== false) {
				$albumsToReturn[] = $album;
			}
		}
		return $albumsToReturn;
	}

	public function getAlbumsPaginated($perPage, $page) {
		$albums = $this->getAlbums();
		$albumsToReturn = [];
		for($i = 0; $i<$perPage; $i++) {
			$index = 9 + ($perPage)*($page-1) + $i;
			if (isset($albums[$index])) {
				$albumsToReturn[] = $albums[$index];
			}
		}
		return $albumsToReturn;
	} 		

	private function initDatabase() {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM albums');
        $count = $stmt->fetchColumn();
		$com_default = "Dumque ibi diu moratur commeatus opperiens, quorum translationem ex Aquitania verni imbres solito crebriores prohibebant auctique torrentes, Herculanus advenit protector domesticus, Hermogenis ex magistro equitum filius, apud Constantinopolim, ut supra rettulimus, populari quondam turbela discerpti. quo verissime referente quae Gallus egerat, damnis super praeteritis maerens et futurorum timore suspensus angorem animi quam diu potuit emendabat. Et quoniam inedia gravi adflictabantur, locum petivere Paleas nomine, vergentem in mare, valido muro firmatum, ubi conduntur nunc usque commeatus distribui militibus omne latus Isauriae defendentibus adsueti. circumstetere igitur hoc munimentum per triduum et trinoctium et cum neque adclivitas ipsa sine discrimine adiri letali, nec cuniculis quicquam geri posset, nec procederet ullum obsidionale commentum, maesti excedunt postrema vi subigente maiora viribus adgressuri.
		Raptim igitur properantes ut motus sui rumores celeritate nimia praevenirent, vigore corporum ac levitate confisi per flexuosas semitas ad summitates collium tardius evadebant. et cum superatis difficultatibus arduis ad supercilia venissent fluvii Melanis alti et verticosi, qui pro muro tuetur accolas circumfusus, augente nocte adulta terrorem quievere paulisper lucem opperientes. arbitrabantur enim nullo inpediente transgressi inopino adcursu adposita quaeque vastare, sed in cassum labores pertulere gravissimos.
		Cognitis enim pilatorum caesorumque funeribus nemo deinde ad has stationes appulit navem, sed ut Scironis praerupta letalia declinantes litoribus Cypriis contigui navigabant, quae Isauriae scopulis sunt controversa.
		Omitto iuris dictionem in libera civitate contra leges senatusque consulta; caedes relinquo; libidines praetereo, quarum acerbissimum extat indicium et ad insignem memoriam turpitudinis et paene ad iustum odium imperii nostri, quod constat nobilissimas virgines se in puteos abiecisse et morte voluntaria necessariam turpitudinem depulisse. Nec haec idcirco omitto, quod non gravissima sint, sed quia nunc sine teste dico.
		Cum autem commodis intervallata temporibus convivia longa et noxia coeperint apparari vel distributio sollemnium sportularum, anxia deliberatione tractatur an exceptis his quibus vicissitudo debetur, peregrinum invitari conveniet, et si digesto plene consilio id placuerit fieri, is adhibetur qui pro domibus excubat aurigarum aut artem tesserariam profitetur aut secretiora quaedam se nosse confingit.
		Vide, quantum, inquam, fallare, Torquate. oratio me istius philosophi non offendit; nam et complectitur verbis, quod vult, et dicit plane, quod intellegam; et tamen ego a philosopho, si afferat eloquentiam, non asperner, si non habeat, non admodum flagitem. re mihi non aeque satisfacit, et quidem locis pluribus. sed quot homines, tot sententiae; falli igitur possumus.
		Primi igitur omnium statuuntur Epigonus et Eusebius ob nominum gentilitatem oppressi. praediximus enim Montium sub ipso vivendi termino his vocabulis appellatos fabricarum culpasse tribunos ut adminicula futurae molitioni pollicitos.
		Quam quidem partem accusationis admiratus sum et moleste tuli potissimum esse Atratino datam. Neque enim decebat neque aetas illa postulabat neque, id quod animadvertere poteratis, pudor patiebatur optimi adulescentis in tali illum oratione versari. Vellem aliquis ex vobis robustioribus hunc male dicendi locum suscepisset; aliquanto liberius et fortius et magis more nostro refutaremus istam male dicendi licentiam. Tecum, Atratine, agam lenius, quod et pudor tuus moderatur orationi meae et meum erga te parentemque tuum beneficium tueri debeo.
		Quaestione igitur per multiplices dilatata fortunas cum ambigerentur quaedam, non nulla levius actitata constaret, post multorum clades Apollinares ambo pater et filius in exilium acti cum ad locum Crateras nomine pervenissent, villam scilicet suam quae ab Antiochia vicensimo et quarto disiungitur lapide, ut mandatum est, fractis cruribus occiduntur.
		Quod si rectum statuerimus vel concedere amicis, quidquid velint, vel impetrare ab iis, quidquid velimus, perfecta quidem sapientia si simus, nihil habeat res vitii; sed loquimur de iis amicis qui ante oculos sunt, quos vidimus aut de quibus memoriam accepimus, quos novit vita communis. Ex hoc numero nobis exempla sumenda sunt, et eorum quidem maxime qui ad sapientiam proxime accedunt.
		Per hoc minui studium suum existimans Paulus, ut erat in conplicandis negotiis artifex dirus, unde ei Catenae inditum est cognomentum, vicarium ipsum eos quibus praeerat adhuc defensantem ad sortem periculorum communium traxit. et instabat ut eum quoque cum tribunis et aliis pluribus ad comitatum imperatoris vinctum perduceret: quo percitus ille exitio urgente abrupto ferro eundem adoritur Paulum. et quia languente dextera, letaliter ferire non potuit, iam districtum mucronem in proprium latus inpegit. hocque deformi genere mortis excessit e vita iustissimus rector ausus miserabiles casus levare multorum.
		Erat autem diritatis eius hoc quoque indicium nec obscurum nec latens, quod ludicris cruentis delectabatur et in circo sex vel septem aliquotiens vetitis certaminibus pugilum vicissim se concidentium perfusorumque sanguine specie ut lucratus ingentia laetabatur.
		Fieri, inquam, Triari, nullo pacto potest, ut non dicas, quid non probes eius, a quo dissentias. quid enim me prohiberet Epicureum esse, si probarem, quae ille diceret? cum praesertim illa perdiscere ludus esset. Quam ob rem dissentientium inter se reprehensiones non sunt vituperandae, maledicta, contumeliae, tum iracundiae, contentiones concertationesque in disputando pertinaces indignae philosophia mihi videri solent.
		Fieri, inquam, Triari, nullo pacto potest, ut non dicas, quid non probes eius, a quo dissentias. quid enim me prohiberet Epicureum esse, si probarem, quae ille diceret? cum praesertim illa perdiscere ludus esset. Quam ob rem dissentientium inter se reprehensiones non sunt vituperandae, maledicta, contumeliae, tum iracundiae, contentiones concertationesque in disputando pertinaces indignae philosophia mihi videri solent.
		Ciliciam vero, quae Cydno amni exultat, Tarsus nobilitat, urbs perspicabilis hanc condidisse Perseus memoratur, Iovis filius et Danaes, vel certe ex Aethiopia profectus Sandan quidam nomine vir opulentus et nobilis et Anazarbus auctoris vocabulum referens, et Mopsuestia vatis illius domicilium Mopsi, quem a conmilitio Argonautarum cum aureo vellere direpto redirent, errore abstractum delatumque ad Africae litus mors repentina consumpsit, et ex eo cespite punico tecti manes eius heroici dolorum varietati medentur plerumque sospitales.
		Post emensos insuperabilis expeditionis eventus languentibus partium animis, quas periculorum varietas fregerat et laborum, nondum tubarum cessante clangore vel milite locato per stationes hibernas, fortunae saevientis procellae tempestates alias rebus infudere communibus per multa illa et dira facinora Caesaris Galli, qui ex squalore imo miseriarum in aetatis adultae primitiis ad principale culmen insperato saltu provectus ultra terminos potestatis delatae procurrens asperitate nimia cuncta foedabat. propinquitate enim regiae stirpis gentilitateque etiam tum Constantini nominis efferebatur in fastus, si plus valuisset, ausurus hostilia in auctorem suae felicitatis, ut videbatur.
		Nec sane haec sola pernicies orientem diversis cladibus adfligebat. Namque et Isauri, quibus est usitatum saepe pacari saepeque inopinis excursibus cuncta miscere, ex latrociniis occultis et raris, alente inpunitate adulescentem in peius audaciam ad bella gravia proruperunt, diu quidem perduelles spiritus inrequietis motibus erigentes, hac tamen indignitate perciti vehementer, ut iactitabant, quod eorum capiti quidam consortes apud Iconium Pisidiae oppidum in amphitheatrali spectaculo feris praedatricibus obiecti sunt praeter morem.
		Hae duae provinciae bello quondam piratico catervis mixtae praedonum a Servilio pro consule missae sub iugum factae sunt vectigales. et hae quidem regiones velut in prominenti terrarum lingua positae ob orbe eoo monte Amano disparantur.
		Cum saepe multa, tum memini domi in hemicyclio sedentem, ut solebat, cum et ego essem una et pauci admodum familiares, in eum sermonem illum incidere qui tum forte multis erat in ore. Meministi enim profecto, Attice, et eo magis, quod P. Sulpicio utebare multum, cum is tribunus plebis capitali odio a Q. Pompeio, qui tum erat consul, dissideret, quocum coniunctissime et amantissime vixerat, quanta esset hominum vel admiratio vel querella.";
        if ($count == 0) {
            $album = new Album('Lark\'s tongue in aspic', 'King Crimson', $com_default, 5, 'https://p4.storage.canalblog.com/44/60/636073/69813048.jpg');
            $album2 = new Album('2112', 'Rush', $com_default, 5, 'https://www.rush.com/wp-content/uploads/2012/12/Rush_2112_Square_REV-800x800.jpg');
            $album3 = new Album('Vector', 'Haken', $com_default, 5, 'https://upload.wikimedia.org/wikipedia/en/9/91/Vector_%28Haken_album%29.jpg');
            $album4 = new Album('Wish you were here', 'Pink Floyd', $com_default, 5, 'https://monshoppingcestcalais.fr/media/catalog/product/cache/1/image/480x480/85e4522595efc69f496374d01ef2bf13/2/c/2c06896918_.jpg');
            $album5 = new Album('Red Queen to Gryphon Three', 'Gryphon', $com_default, 5, 'https://m.media-amazon.com/images/I/61WKQAUxwVL.jpg');
            $album6 = new Album('Alba les ombres errantes', 'Hypno5e', $com_default, 5, 'https://i.scdn.co/image/ab67616d0000b273673db762f2672847ea5c0c6f');
            $album7 = new Album('Erotic Cakes', 'Guthrie Govan', $com_default, 5, 'https://m.media-amazon.com/images/W/IMAGERENDERING_521856-T1/images/I/51lfSTeKkfL.jpg');
            $album8 = new Album('Les 5 saisons', 'Harmonium', $com_default, 5, 'https://i.scdn.co/image/ab67616d0000b27302c1e441b4e84a11ad5b2f3a');
            $album9 = new Album('Apostrophe \'', 'Frank Zappa', $com_default, 5, 'https://static.fnac-static.com/multimedia/FR/Images_Produits/FR/fnac.com/Visual_Principal_340/8/2/1/0824302385128.jpg');
            $album10 = new Album('Breakfast in america', 'Supertramp', $com_default, 5, 'https://upload.wikimedia.org/wikipedia/en/c/c4/Supertramp_-_Breakfast_in_America.jpg');
            $album11 = new Album('Morningrise', 'Opeth', $com_default, 5, 'https://m.media-amazon.com/images/I/81+o5rqRrDL.jpg');
			$album12 = new Album('Grow', 'Chon', $com_default, 5, 'https://upload.wikimedia.org/wikipedia/en/2/24/Chon_Grow_artwork.jpg');
			$album13 = new Album('Terria', 'Devin Townsend', $com_default, 5, 'https://static.fnac-static.com/multimedia/FR/Images_Produits/FR/fnac.com/Visual_Principal_340/1/8/8/5052205011881/tsp20120920160039/Terria.jpg');
			$album14 = new Album('Gloire Eternelle', 'First Fragment', $com_default, 5, 'https://www.metal-archives.com/images/9/5/7/8/957831.jpg?0726');
			$album15 = new Album('The Madness Of Many', 'Animals as Leaders', $com_default, 5, 'https://upload.wikimedia.org/wikipedia/en/3/3d/TheMadnessOfMany.jpg');
			$album16 = new Album('Currents', 'Covet', $com_default, 5, 'https://m.media-amazon.com/images/I/61QvL7tpZ+L._UXNaN_FMjpg_QL85_.jpg');
			$album17 = new Album('This Godless Endeavor', 'Nevermore', $com_default, 5, 'https://upload.wikimedia.org/wikipedia/en/3/34/ThisGodlessEndeavor2.jpg');
			$album18 = new Album('Jailbreak', 'Thin Lizzy', $com_default, 5, 'https://m.media-amazon.com/images/W/IMAGERENDERING_521856-T1/images/I/61qaVKlXadL._SY450_.jpg');
			$album19 = new Album('Onset Of Putrefaction', 'Necrophagist', $com_default, 5, 'https://m.media-amazon.com/images/I/61V7AjQpmgL.jpg');
			$album20 = new Album('Cosmogenesis', 'Obscure', $com_default, 5, 'https://m.media-amazon.com/images/I/91TlBRgzrfL._SY450_.jpg');
			$album21 = new Album('Savage Sinusoid', 'Igorrr', $com_default, 5, 'https://m.media-amazon.com/images/I/51wAaHnT4YL._SX425_.jpg');
			$album22 = new Album('Rust in Peace', 'Megadeth', $com_default, 5, 'https://upload.wikimedia.org/wikipedia/en/d/dc/Megadeth-RustInPeace.jpg');
			$album23 = new Album('The Aristocrats', 'The Aristocrats', $com_default, 5, 'https://i.discogs.com/zBpoqzf4TNb6U72qqIMj6hk_L4uG4GyjoYJ-wbRHknc/rs:fit/g:sm/q:90/h:600/w:597/czM6Ly9kaXNjb2dz/LWRhdGFiYXNlLWlt/YWdlcy9SLTYyNTA1/NzEtMTYyMzE3NjY0/MS03MzkzLmpwZWc.jpeg');
			$this->insertAlbum($album);
            $this->insertAlbum($album2);
            $this->insertAlbum($album3);
            $this->insertAlbum($album4);
            $this->insertAlbum($album5);
            $this->insertAlbum($album6);
            $this->insertAlbum($album7);
            $this->insertAlbum($album8);
            $this->insertAlbum($album9);
            $this->insertAlbum($album10);
			$this->insertAlbum($album11);
			$this->insertAlbum($album12);
			$this->insertAlbum($album13);
			$this->insertAlbum($album14);
			$this->insertAlbum($album15);
			$this->insertAlbum($album16);
			$this->insertAlbum($album17);
			$this->insertAlbum($album18);
			$this->insertAlbum($album19);
			$this->insertAlbum($album20);
			$this->insertAlbum($album21);
			$this->insertAlbum($album22);
			$this->insertAlbum($album23);
		}
    }
}
