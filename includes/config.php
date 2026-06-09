<?php
define('SITE_URL', 'https://wikizeit.edu.pl/');
define('OFERTA_URL', 'https://wikizeit.edu.pl/oferta/');
define('ALLEGRO_TOKEN_FILE', __DIR__ . '/../allegro_tokens.json');
define('ALLEGRO_CLIENT_ID', '...');
define('ALLEGRO_CLIENT_SECRET', '...');
define('ALLEGRO_ENABLED', false);
define('PRICE', 350);

$person = json_decode(file_get_contents(__DIR__ . '/../person.json'), true);
$person_id = 'https://jakub.jankiewicz.org';
$wikizeit_id = SITE_URL;
