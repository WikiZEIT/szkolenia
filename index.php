<?php
/* Copyright (c) 2026 Jakub T. Jankiewicz
 * All Rights Reserved
 */
define('ALLEGRO_TOKEN_FILE', __DIR__ . '/allegro_tokens.json');
define('ALLEGRO_CLIENT_ID', '...');
define('ALLEGRO_CLIENT_SECRET', '...');
define('ALLEGRO_ENABLED', false);
define('BASE_URL', 'https://jcubic.pl/wikizeit/oferta/');

$message_sent = false;
$error_message = '';
$a = rand(1, 10);
$b = rand(1, 10);
$result = $a + $b;

$faq = [
    [
        'question' => 'Jak opublikować artykuł na Wikipedii?',
        'answer'   => "<p>Aby dodać artykuł, który na pewno zostanie w Wikipedii, dobrze jest założyć najpierw konto (chociaż nie jest to technicznie wymagane) oraz zacząć w swoim brudnopisie. Gdy artykuł jest gotowy należy poprosić twojego przewodnika o sprawdzenie i ewentualną publikacje (czyli przeniesnie do przestrzni główej).<p>\n<p>Dodając artykuł należy pamiętać o naważniejszych zasadach: <a href=\"https://pl.wikipedia.org/wiki/WP:NPOV\">neutralnym punkcie widzenia</a> , <a href=\"https://pl.wikipedia.org/wiki/WP:ENCY\">encyklopedyczności tematu</a>, <a href=\"https://pl.wikipedia.org/wiki/WP:WER\">wiarygodnych źródłach</a> oraz <a href=\"https://pl.wikipedia.org/wiki/WP:PA\">poszanowaniu praw autorskich</a>.</p>"
    ],
    [
        'question' => 'Czy płatne edytowanie Wikipedii jest dozwolone?',
        'answer'   => "<p>Tak, pod warunkiem pełnego ujawnienia takich edycji na stronie użytkownika lub w opisie zmian. Jednak różne wersje językowe moga mieć różne wytyczne, ponieważ Wikipedia jest to projekt społeczny i zasady są wypracowywane przez społeczność. Jeśli chodzi o płatne edycje, Angielska Wikipedia jest bardziej restrykcyjna na temat ujawniania płatnych edycji.</p>\n<p>W polskiej Wikipedii, nie ma wypracowanej zasady dotyczącej płatnych edycji, ale mimo to warto dodać taką informację na swojej stronie profilowej. <a href=\"https://foundation.wikimedia.org/wiki/Policy:Terms_of_Use/pl#paid-contrib-disclosure\">Ogólne wytyczne na temat Płatnych edycji</a> można znaleźć na stronie Wikimedia Foundation.</p>"
    ],
    [
        'question' => 'Ile trwa edycja artykułu na Wikipedii?',
        'answer'   => '<p>Edycja niewielkiego artykułu (100-150 wyrazów) w języku polskim trwa zazwyczaj 1-2 godziny. Krócej, gdy mam już przygotowany tekst i źródła. Wyszkuwanie i czytanie źródeł, może wydłużyć cały proces.</p>',
    ],
    [
        'question' => 'Jaki jest maksymalny koszt przygotowania jednego artykułu?',
        'answer'   => '<p>W przypadku <strong>standardowych zleceń</strong> (edycja artykułu do ok. 200 słów), stosuję <strong>górny limit 1000 zł netto</strong> za pojedynczą stronę. W trudnych przypadkach dostaniesz indywidualną wycenę.</p>'
    ],
    [
        'question' => 'Czy edytujesz tylko w języku Polskim?',
        'answer'   => '<p>Mogę pomóc także z edycją artykułów w języku Angielskim. Chociaż czas edycji może sie wydłużyć, w zależności od tematyki artykułu.</p>',
    ],
    [
        'question' => 'Czy wystawiasz fakturę VAT?',
        'answer'   => '<p>Jeśli potrzebujesz faktury możemy podpisać umowę przez <a href="https://useme.com/pl/roles/contractor/jakub-t-jankiewicz,187663/">UseMe</a>.</p>'
    ],
    [
        'question' => 'Czy uferujesz linki z Wikipedii?',
        'answer'   => '<p>Nie mam tego w ofercie. Natomiast jeśli jesteś ekspertem SEO i szukasz linków z Wikipedii, możesz wziąć udział w moim szkoleniu, gdzie dowiesz się jak je dodawać samemu. Jest to jednorazowa inwestycja.</p>'
    ],
    [
        'question' => 'Czy możesz pomóc w dodaniu wpisu w Wikidanych (Wikidata)?',
        'answer'   => '<p>Tak, zawsze dodaję wpis w Wikidata, gdy dodaję artykuł do Wikipedii. Mogę go także dodać, gdy twój temat nie nadaje się do Wikipedii lub gdy twój artykuł jeszcze go nie ma.</p>',
    ],
    [
        'question' => 'Jak uzyskać wpis w Google Knowledge Graph?',
        'answer'   => "<p>Główne czynniki wpływające na pojawienie się w Grafie Wiedzy Google to:</p>\n<ul><li>Wpis w Wikipedii</li>\n<li>Wpis w Wikidata</li>\n<li>Duży kanał na YouTube</li>\n<li>Optymalizacja techniczna oraz <a href=\"https://schema.org/\">Schema.org</a></li>\n<li>Publikacje w mediach</li>\n<li>Obecność w tematycznych bazach danych</li></ul>"
    ],
    [
        'question' => 'Czy są jakieś darmowe szkolenia z Wikipedii?',
        'answer'   => "<p>Tak, stowarszyenie <a href=\"https://wikimedia.pl/\">Wikimedia Polska</a> organizuje darmowe szkolenia z edycji Wikipedii, w ramach <a href=\"https://wikiszkola.pl/szkolenia/\">Wikiszkoły</a>.</p>\n<p>Jedym z projektów jest <a href=\"https://wikiszkola.pl/wikiteka/\">Wikiteka</a>, jest to projekt przenaczony głównie dla bibliotekarzy (bibliotekarek) oraz nauczycielek (nauczycieli). Wikimedia Polska organizuje szkolenia także dla studentów i uczniów. Szkolenia prowadzą wolontariusze nazwani Wikitrnerami.</p>"
    ],
    [
        'question' => 'Kto w polsce organizuje szkolenia z Wikipedii?',
        'answer' => "<p>Główną instytucją organizującą szkolenia z Wikipedii w Polsce jest stowarzyszenie Wikmedia Polska (tzw. Chapter na Polskę). Szkolenia odbywaja się głównie dla nauczycieli (nauczycielek), bibliotekarzy (bibliotekarek), pracowników kultury (GLAM), studentów (studentek) oraz uczniowiów. Szkolenia prowadzą wolontarusze nazywani Wikitrenerami.</p>\n<p>Prowadzone są także komercyjne szkolenia np. przez NobleProg czy WikiZEIT.</p>"
    ]
];

$person = json_decode(file_get_contents('person.json'), true);
$person_id = 'https://jakub.jankiewicz.org';
$course_id = BASE_URL . '#szkolenie';
$consultation_id = BASE_URL . '#konsultacje';

$offer_catalog = [
    '@type' => 'OfferCatalog',
    'name' => 'Katalog usług Wikipedia + SEO',
    'itemListElement' => [
        ['@id' => $consultation_id],
        ['@id' => $course_id]
    ]
];

$person['hasOfferCatalog'] = $offer_catalog;

$page_id = BASE_URL . "#webpage";
$wikizeit_id = 'https://jcubic.pl/wikizeit/';
$service_id = $wikizeit_id . '#service';
$breadcrumb_id = BASE_URL . '#breadcrumb';

$graph = [
    '@context' => 'https://schema.org',
    '@graph' => [
        $person,
        [
            '@type' => 'WebPage',
            '@id' => $page_id,
            'url' => BASE_URL,
            'name' => 'Komercyjne szkolenia z Wikipedii i SEO - WikiZEIT',
            'description' => 'Profesjonalne szkolenia z edycji Wikipedii i danych strukturalnych prowadzone przez Jakuba T. Janiewicza.',
            'author' => ['@id' => $person_id],
            'mainEntity' => [
                [ '@id' => $course_id ],
                [ '@id' => $service_id ]
            ]
        ],

        [
            '@type' => 'EducationalOrganization',
            '@id' => $wikizeit_id,
            'name' => 'WikiZEIT',
            'alternateName' => 'Projekt WikiZEIT',
            'url' => $wikizeit_id,
            'logo' => $wikizeit_id . 'img/logo.svg',
            'description' => 'Projekt edukacyjny poświęcony etycznemu SEO, danym strukturalnym i profesjonalnej edycji Wikipedii.',
            'founder' => ['@id' => $person_id],
            'sameAs' => [
                'https://www.wikidata.org/wiki/Q138621958',
                'https://www.linkedin.com/company/wikizeit/',
                'https://commons.wikimedia.org/wiki/Category:WikiZEIT',
                'https://www.youtube.com/@WikiZEIT',
                'https://github.com/WikiZEIT'
            ]
        ],

        [
            '@type' => 'Offer',
            '@id' => $consultation_id,
            'price' => '250.00',
            'priceCurrency' => 'PLN',
            'itemOffered' => [
                '@id' => $service_id
            ]
        ],

        [
            '@type' => 'Offer',
            'name' => 'Szkolenie Wikipedia+SEO - Solo',
            'price' => '999.00',
            'priceCurrency' => 'PLN',
            'itemOffered' => ['@id' => $course_id]
        ],

        [
            '@type' => 'Offer',
            'name' => 'Szkolenie Wikipedia+SEO - Team',
            'priceSpecification' => [
                '@type' => 'UnitPriceSpecification',
                'priceCurrency' => 'PLN',
                'minPrice' => '499.00',
                'maxPrice' => '599.00',
                'unitText' => 'osoba'
            ],
            'description' => 'Cena przy zakupie pakietu grupowego (od 3 do 10 osób).',
            'itemOffered' => ['@id' => $course_id]
        ],

        [
            '@type' => 'Course',
            '@id' => $course_id,
            'name' => 'Szkolenie Wikipedia+SEO i nie tylko',
            'description' => 'Kompleksowe szkolenie z edycji Wikipedii i danych strukturalnych. Pakiet obejmuje:\n' .
                           '- Imienny certyfikat ukończenia szkolenia\n' .
                           '- Stały dostęp do konsultacji w cenie 190 zł netto/h\n' .
                           '- Opiekę oficjalnego Wiki-Przewodnika wewnątrz Wikipedii\n' .
                           '- Konfigurację strony z odnośnikami do narzędzi.',
            'author' => [ '@id' => $person_id ],
            'provider' => [ '@id' => $wikizeit_id ]
        ],

        [
            '@type' => 'Service',
            '@id' => $service_id,
            'name' => 'Konsultacje Wikipedia SEO',
            'description' => 'Indywidualne konsultacje, audyt encyklopedyczności oraz płatne edycje Wikipedii dla firm i marek osobistych.',
            'provider' => [ '@id' => $wikizeit_id ]
        ],

        [
            '@type' => 'BreadcrumbList',
            '@id' => $breadcrumb_id,
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => 'https://jcubic.pl',
                    'name' => 'Głównie JavaScript'
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => $wikizeit_id . '#webpage',
                    'name' => 'WikiZeit'
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'item' => $page_id,
                    'name' => 'Szkolenia i Konsultacje'
                ]
            ]
        ],

        [
            '@type' => 'Review',
            'author' => [
                '@type' => 'Person',
                'name' => 'Tymon Wysocki'
            ],
            'reviewBody' => 'Jakub posiada głęboką wiedzę o mechanizmach działania Wikipedii i potrafi ją przekazać oraz zamienić w rzeczywiste rezultaty.',
            'itemReviewed' => [
                '@id' => $service_id
            ]
        ],

        [
            '@type' => 'Review',
            'author' => [
                '@type' => 'Person',
                'name' => 'Iga Jagiełło'
            ],
            'reviewBody' => 'Współpraca z Jakubem była absolutnie świetna. Pomógł mi napisać i poprawić artykuł na Wikipedii - tam, gdzie wiele osób się wahało lub unikało tematu, on od razu zaproponował swoją pomoc. Był konkretny, szybki i niezwykle profesjonalny. Wszystko odbywało się sprawnie, a kontakt z nim był naprawdę przyjemny. Jestem bardzo zadowolona i ogromnie wdzięczna za jego zaangażowanie. Zdecydowanie polecam współpracę z Jakubem!',
            'itemReviewed' => [
                '@id' => $service_id
            ]
        ],

        [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(function($item) {
                return [
                    '@type' => 'Question',
                    'name' => $item['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => strip_tags($item['answer'])
                    ]
                ];
            }, $faq)
        ]
    ]
];

session_start();
$prev_result = isset($_SESSION['result']) ? $_SESSION['result'] : null;
$_SESSION['result'] = $result;

$is_request = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($is_request) {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $user_message = htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8');
    if (is_spam()) {
        $error_message = "Wygląda na to że nie jesteś człowiem!";
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($user_message)) {
        $to = 'jcubic@jcubic.pl';
        $subject = $_POST['subject'];
        $body = "Wiadomość ze strony " . BASE_URL . ":\n\n";
        $body .= "From: " . $email . "\n";
        $body .= "Message:\n" . $user_message;

        $headers = "From: jcubic@jcubic.pl\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject, $body, $headers)) {
            $message_sent = true;
        } else {
            $error_message = 'Przepraszam, ale wystąpił błąd wysłania wiadomosci. Spróbuj jeszcze raz.';
        }
    } else {
        $error_message = 'Podaj prawidłowy adres email i wiadomość.';
    }
}

function is_spam() {
  global $result, $prev_result;
  if (!isset($_POST['email_confirmation'])) {
     return true;
  }
  return intval($_POST['email_confirmation']) != $prev_result;
}


function dump($data) {
    return json_encode($data, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);
}

// Sprawdza, czy plik z tokenami istnieje i ładuje dane
function load_tokens() {
    if (!file_exists(ALLEGRO_TOKEN_FILE)) {
        return null;
    }
    $content = file_get_contents(ALLEGRO_TOKEN_FILE);
    return json_decode($content, true);
}

// Zapisuje tokeny do pliku
function save_tokens($tokens) {
    file_put_contents(ALLEGRO_TOKEN_FILE, json_encode($tokens, JSON_PRETTY_PRINT));
}

// Odświeża access_token przy użyciu refresh_token
function refresh_access_token() {
    $tokens = load_tokens();
    if (!$tokens || empty($tokens['refresh_token'])) {
        return null;
    }

    $url = 'https://allegro.pl/auth/oauth/token';
    $auth = base64_encode(ALLEGRO_CLIENT_ID . ':' . ALLEGRO_CLIENT_SECRET);

    $post_fields = http_build_query([
        'grant_type'    => 'refresh_token',
        'refresh_token' => $tokens['refresh_token']
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . $auth,
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        return null; // nie udało się odświeżyć – trzeba będzie ręcznie zrobić device flow ponownie
    }

    $new_tokens = json_decode($response, true);
    $new_tokens['expires_at'] = time() + $new_tokens['expires_in']; // zwykle 43200 sekund

    save_tokens($new_tokens);

    return $new_tokens['access_token'];
}

// Pobiera aktualny (ważny) access_token
function get_valid_access_token() {
    $tokens = load_tokens();

    // Jeśli nie ma tokenów wcale
    if (!$tokens) {
        return null;
    }

    // Jeśli token wygasł – spróbuj odświeżyć
    if (time() >= $tokens['expires_at']) {
        return refresh_access_token();
    }

    // Token jest jeszcze ważny
    return $tokens['access_token'];
}

// Pobiera dane oferty z Allegro API
function fetch_offer_data($query) {
    $access_token = get_valid_access_token();

    if (!$access_token) {
        return ['error' => 'No valid access token. Run device flow manually once to initialize.'];
    }

    $url = "https://api.allegro.pl/sale/offers?sellingMode.format=AUCTION&name=" . urlencode($query);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $access_token,
        'Accept: application/vnd.allegro.public.v1+json',
        'Content-Type: application/vnd.allegro.public.v1+json'
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 401) {
        // Token prawdopodobnie wygasł i nie dało się odświeżyć
        return ['error' => 'Unauthorized – token expired and refresh failed.'];
    }

    if ($http_code !== 200) {
        return ['error' => 'HTTP ' . $http_code, 'response' => $response];
    }

    $data = json_decode($response, true);

    return $data['offers'][0]['saleInfo']['currentPrice']['amount'];
}

if (isset($_GET['auth']) && ALLEGRO_ENABLED) {
    session_start();

    $auth_header = base64_encode(ALLEGRO_CLIENT_ID . ':' . ALLEGRO_CLIENT_SECRET);

    if (empty($_SESSION['allegro_device_code'])) {

        // Krok 1: Pobierz device_code
        $ch = curl_init('https://allegro.pl/auth/oauth/device');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $auth_header,
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'client_id=' . ALLEGRO_CLIENT_ID);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200) {
            die("<h2>Błąd inicjacji Device Flow</h2><pre>$response</pre>");
        }

        $data = json_decode($response, true);

        // Zapisz w sesji na czas autoryzacji
        $_SESSION['allegro_device_code'] = $data['device_code'];
        $_SESSION['allegro_interval']    = $data['interval'] ?? 5;

        // Dane do wyświetlenia
        $user_code = $data['user_code'];
        $verification_uri_complete = $data['verification_uri_complete'];
        $interval = $_SESSION['allegro_interval'];
    } else {
        // Mamy już aktywny flow – użyj danych z sesji
        $device_code = $_SESSION['allegro_device_code'];
        $interval    = $_SESSION['allegro_interval'];

        // Nie mamy zapisanych danych do wyświetlenia – możemy je pominąć lub zapisać też w sesji (opcjonalnie)
        // Na potrzeby prostoty – po prostu sprawdzamy status
    }
    $ch = curl_init('https://allegro.pl/auth/oauth/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . $auth_header,
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type'  => 'urn:ietf:params:oauth:grant-type:device_code',
        'device_code' => $_SESSION['allegro_device_code']
    ]));

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 200) {
        // SUKCES!
        $token_data = json_decode($response, true);
        $token_data['expires_at'] = time() + $token_data['expires_in'];

        file_put_contents(ALLEGRO_TOKEN_FILE, json_encode($token_data, JSON_PRETTY_PRINT));

        // Wyczyść sesję
        unset($_SESSION['allegro_device_code'], $_SESSION['allegro_interval']);

        echo "<!DOCTYPE html>
    <html><head><title>Sukces!</title><meta charset='utf-8'></head>
    <body style='text-align:center; margin-top:100px; font-family:Arial;'>
        <h1 style='color:green;'>Autoryzacja zakończona sukcesem!</h1>
        <p>Tokeny zapisane do <strong>allegro_tokens.json</strong></p>
        <p>Możesz zamknąć tę kartę.</p>
    </body></html>";
        exit;
    }

    echo "<!DOCTYPE html>
<html>
<head>
    <title>Autoryzacja Allegro</title>
    <meta charset='utf-8'>
    <style>
        body { font-family: Arial; text-align: center; margin-top: 80px; }
        .code { font-size: 48px; font-weight: bold; background: #f8f8f8; padding: 20px; display: inline-block; margin: 30px; border: 2px dashed #ccc; }
        a { font-size: 24px; color: #0066cc; }
    </style>
</head>
<body>
    <h1>Potwierdź dostęp w Allegro</h1>";

    // Jeśli to pierwsze wejście – pokaż kod i link
    if (!empty($user_code) && !empty($verification_uri_complete)) {
        echo "<p>Otwórz link (na telefonie lub komputerze):</p>
          <p><a href='$verification_uri_complete' target='_blank'>$verification_uri_complete</a></p>
          <p>Lub wejdź na <strong>https://allegro.pl/auth/oauth/device</strong> i wpisz:</p>
          <div class='code'>$user_code</div>";
    } else {
        echo "<p>Kod został już wyświetlony wcześniej. Jeśli go nie masz – uruchom skrypt ponownie.</p>";
    }

    echo "    <p><em>Czekam na potwierdzenie... (strona odświeży się automatycznie)</em></p>
    <script>
        setTimeout(function(){ location.reload(); }, " . ($interval * 1000) . ");
    </script>
</body>
</html>";

    // Obsługa błędów końcowych
    $error_data = json_decode($response, true);
    $error = $error_data['error'] ?? 'unknown';

    if ($error === 'access_denied') {
        unset($_SESSION['allegro_device_code']);
        die("<h2 style='color:red;'>Dostęp odrzucony. Uruchom autoryzację ponownie.</h2>");
    }
    if ($error === 'expired_token') {
        unset($_SESSION['allegro_device_code']);
        die("<h2 style='color:red;'>Kod wygasł. Uruchom autoryzację ponownie.</h2>");
    }
} else {
?><!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <title>Wikipedia: Konsultacje, Edycje i Szkolenia</title>
    <meta name="description" content="Szkolenia oraz konsultacje z zakresu edycji Wikipedii, Wikidata i projektów siostrzanych. Profesjonalne wsparcie dla osób oraz firm SEO, PR, i personal brand.">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <script>
        (function() {
            var stored = localStorage.getItem('wikipedia:colorScheme');
            var dark = stored === 'dark' || (!stored && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.add(dark ? 'dark' : 'light');
            document.documentElement.classList.add('icons-hidden');

            function icons_ready() {
                document.documentElement.classList.remove('icons-hidden');
            }
            if (document.fonts && document.fonts.ready) {
                const font = '24px "Material Symbols Outlined"';
                document.fonts.load(font).then(icons_ready);
            } else {
                icons_ready();
            }
        })();
    </script>
    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="<?= BASE_URL ?>" />
    <meta property="og:type" content="website">
    <meta property="og:title" content="Wikipedia Konsultacje i Szkolenia" />
    <meta property="og:description" content="Szkolenia i konsultacje z zakresu Wikipedii. Naucz się tworzyć trwałe artykuły, dbać o SEO i poruszać w świecie Wikimedia Commons. Profesjonalne wsparcie dla firm." />
    <meta property="og:image" content="<?= BASE_URL ?>social-card.png" />

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="<?= BASE_URL ?>" />
    <meta name="twitter:title" content="Wikipedia Konsultacje i Szkolenia" />
    <meta name="twitter:description" content="Szkolenia i konsultacje z zakresu Wikipedii. Naucz się tworzyć trwałe artykuły, dbać o SEO i poruszać w świecie Wikimedia Commons. Profesjonalne wsparcie dla firm." />
    <meta name="twitter:image" content="<?= BASE_URL ?>social-card.png" />

    <!-- Meta Tags Generated via https://www.opengraph.io -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=block" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <style>
/* Reset and base styles */
* {
    box-sizing: border-box;
}

.material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    display: inline-block;
    white-space: nowrap;
    word-wrap: normal;
    direction: ltr;
    -webkit-font-feature-settings: 'liga';
    -webkit-font-smoothing: antialiased;
    overflow: hidden;
    width: 1em;
}

.icons-hidden .material-symbols-outlined {
    visibility: hidden;
}

/* CSS Variables */
:root {
    --color-primary: #137fec;
    --color-background-light: #f6f7f8;
    --color-background-dark: #101922;
    --color-gray-50: #f9fafb;
    --color-gray-100: #f3f4f6;
    --color-gray-200: #e5e7eb;
    --color-gray-300: #d1d5db;
    --color-gray-400: #9ca3af;
    --color-gray-500: #6b7280;
    --color-gray-600: #4b5563;
    --color-gray-700: #374151;
    --color-gray-800: #1f2937;
    --color-gray-900: #111827;
    --color-white: #ffffff;
    --color-green-500: #10b981;
    --font-display: 'Inter', sans-serif;
    --border-radius: 0.25rem;
    --border-radius-lg: 0.5rem;
    --border-radius-xl: 0.75rem;
    --border-radius-full: 9999px;
}

/* Body and root layout */
body {
    margin: 0;
    padding: 0;
    font-family: var(--font-display);
    background-color: var(--color-background-light);
    color: var(--color-gray-900);
    line-height: 1.5;
}

html.dark body {
    background-color: var(--color-background-dark);
    color: var(--color-gray-100);
}

.design-root {
    position: relative;
    display: flex;
    min-height: 100vh;
    width: 100%;
    flex-direction: column;
    overflow-x: hidden;
}

.layout-container {
    display: flex;
    height: 100%;
    flex-direction: column;
    flex-grow: 1;
}

.layout-wrapper {
    display: flex;
    flex: 1;
    justify-content: center;
}

.layout-content-container {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 90rem;
    flex: 1;
}

/* Theme toggle button */
.btn-theme-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: var(--border-radius-full);
    border: 1px solid var(--color-gray-200);
    background-color: transparent;
    color: var(--color-gray-600);
    cursor: pointer;
    transition: background-color 0.2s, color 0.2s, border-color 0.2s;
    flex-shrink: 0;
}

.btn-theme-toggle:hover {
    background-color: var(--color-gray-100);
    color: var(--color-gray-900);
}

html.dark .btn-theme-toggle {
    border-color: var(--color-gray-700);
    color: var(--color-gray-400);
}

html.dark .btn-theme-toggle:hover {
    background-color: var(--color-gray-800);
    color: var(--color-gray-100);
}

/* Header */
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    white-space: nowrap;
    border-bottom: 1px solid var(--color-gray-200);
    padding: 1rem 2.5rem;
    position: sticky;
    top: 0;
    background-color: rgba(246, 247, 248, 0.8);
    backdrop-filter: blur(8px);
    z-index: 50;
}

.dark .header {
    border-color: var(--color-gray-800);
    background-color: rgba(16, 25, 34, 0.8);
}

.header-logo {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.logo-icon {
    color: var(--color-primary);
}

.logo-svg {
    width: 2rem;
    height: 2rem;
}

.header-title {
    color: var(--color-gray-900);
    font-size: 1.125rem;
    font-weight: 700;
    line-height: 1.25;
    letter-spacing: -0.015em;
    margin: 0;
}

.dark .header-title {
    color: var(--color-gray-100);
}

/* Buttons */
.btn {
    display: flex;
    min-width: 84px;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border-radius: var(--border-radius-lg);
    height: 2.5rem;
    padding: 0 1rem;
    border: none;
    font-family: var(--font-display);
    font-size: 0.875rem;
    font-weight: 700;
    line-height: 1.5;
    letter-spacing: 0.015em;
    transition: background-color 0.2s;
}

.btn-primary {
    background-color: var(--color-primary);
    color: var(--color-white);
}

.btn-primary:hover {
    background-color: rgba(19, 127, 236, 0.9);
}

.btn span {
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}

/* Main content */
.main-content {
    flex: 1;
    padding: 2.5rem;
}

/* Hero section */
.hero-section {
    margin-bottom: 3rem;
}

.hero-background {
    display: flex;
    min-height: 480px;
    flex-direction: column;
    gap: 1.5rem;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: var(--border-radius-xl);
    align-items: flex-start;
    justify-content: flex-end;
    padding: 2.5rem;
}

.hero-content {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    text-align: left;
    max-width: 42rem;
}

.hero-title {
    color: var(--color-white);
    font-size: 2.25rem;
    font-weight: 900;
    line-height: 1.25;
    letter-spacing: -0.033em;
    margin: 0;
}

.hero-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0;
}

.btn-hero {
    height: 2.5rem;
    padding: 0 1rem;
}

/* Sections */
.section {
    margin-bottom: 3rem;
}

.section-title {
    color: var(--color-gray-900);
    font-size: 1.375rem;
    font-weight: 700;
    line-height: 1.25;
    letter-spacing: -0.015em;
    padding: 1.25rem 1rem 1rem;
    margin: 0;
}

.dark .section-title {
    color: var(--color-gray-100);
}

.section-source {
    color: var(--color-gray-500);
    font-size: 0.875rem;
    margin: -0.5rem 0 0.5rem 1rem;
}

.dark .section-source {
    color: var(--color-gray-400);
}

.section-source a {
    color: var(--color-primary);
    text-decoration: none;
}

.section-source a:hover {
    text-decoration: underline;
}

/* Services grid */
.services-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
}

@media (min-width: 640px) {
    .services-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .services-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.service-card {
    display: flex;
    flex: 1;
    gap: 1rem;
    border-radius: var(--border-radius-xl);
    border: 1px solid var(--color-gray-200);
    background-color: var(--color-white);
    padding: 1.5rem;
    flex-direction: column;
}

.dark .service-card {
    border-color: var(--color-gray-800);
    background-color: var(--color-background-dark);
}

.service-icon {
    color: var(--color-primary);
    font-size: 32px;
}

.service-content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.service-title {
    color: var(--color-gray-900);
    font-size: 1rem;
    font-weight: 700;
    line-height: 1.25;
    margin: 0;
}

.dark .service-title {
    color: var(--color-gray-100);
}

.service-description {
    color: var(--color-gray-600);
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0;
}

.dark .service-description {
    color: var(--color-gray-400);
}

/* Accordion */
.accordion {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.accordion-item {
    padding: 1.5rem;
    border-radius: var(--border-radius-xl);
    background-color: var(--color-white);
    border: 1px solid var(--color-gray-200);
}

.dark .accordion-item {
    background-color: var(--color-background-dark);
    border-color: var(--color-gray-800);
}

.accordion-summary {
    display: flex;
    cursor: pointer;
    align-items: center;
    justify-content: space-between;
    list-style: none;
}

.accordion-summary::-webkit-details-marker {
    display: none;
}

.accordion-title {
    color: var(--color-gray-900);
    font-weight: 700;
    margin: 0;
}

.dark .accordion-title {
    color: var(--color-gray-100);
}

.accordion-icon {
    transition: transform 0.3s;
}

details[open] .accordion-icon {
    transform: rotate(180deg);
}

.accordion-content {
    margin-top: 1rem;
    color: var(--color-gray-600);
    font-size: 0.875rem;
}

.dark .accordion-content {
    color: var(--color-gray-400);
}

/* Audience list */
.audience-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.audience-item {
    padding: 1.5rem 1.5rem 1.5rem 1.75rem;
    border-left: 4px solid var(--color-primary);
    border-radius: 0 var(--border-radius-xl) var(--border-radius-xl) 0;
    background-color: var(--color-white);
    border-top: 1px solid var(--color-gray-200);
    border-right: 1px solid var(--color-gray-200);
    border-bottom: 1px solid var(--color-gray-200);
}

.dark .audience-item {
    background-color: var(--color-background-dark);
    border-top-color: var(--color-gray-800);
    border-right-color: var(--color-gray-800);
    border-bottom-color: var(--color-gray-800);
}

.audience-title {
    color: var(--color-gray-900);
    font-weight: 700;
    font-size: 1.125rem;
    margin: 0 0 0.5rem;
}

.dark .audience-title {
    color: var(--color-gray-100);
}

.audience-desc {
    color: var(--color-gray-600);
    font-size: 0.9375rem;
    margin: 0;
    line-height: 1.6;
}

.dark .audience-desc {
    color: var(--color-gray-400);
}

/* Bonuses */
.bonuses {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.bonus-item {
    display: flex;
    align-items: flex-start;
    gap: 1.25rem;
    padding: 1.5rem;
    border-radius: var(--border-radius-xl);
    background-color: var(--color-white);
    border: 1px solid var(--color-gray-200);
}

.dark .bonus-item {
    background-color: var(--color-background-dark);
    border-color: var(--color-gray-800);
}

.bonus-icon {
    font-size: 2rem;
    color: var(--color-primary);
    flex-shrink: 0;
    margin-top: 0.125rem;
}

.bonus-title {
    color: var(--color-gray-900);
    font-weight: 700;
    font-size: 1.125rem;
    margin: 0 0 0.5rem;
}

.dark .bonus-title {
    color: var(--color-gray-100);
}

.bonus-desc {
    color: var(--color-gray-600);
    font-size: 0.9375rem;
    margin: 0;
}

.dark .bonus-desc {
    color: var(--color-gray-400);
}

/* Pricing grid */
.pricing-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .pricing-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .pricing-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.pricing-card {
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    border-radius: var(--border-radius-xl);
    background-color: var(--color-white);
    border: 1px solid var(--color-gray-200);
}

.dark .pricing-card {
    background-color: var(--color-background-dark);
    border-color: var(--color-gray-800);
}

.pricing-card-featured {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 2px rgba(19, 127, 236, 0.2);
}

.pricing-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pricing-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--color-gray-900);
    margin: 0;
}

.dark .pricing-title {
    color: var(--color-gray-100);
}

.pricing-badge {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background-color: rgba(19, 127, 236, 0.1);
    color: var(--color-primary);
    padding: 0.25rem 0.5rem;
    border-radius: var(--border-radius-full);
}

.pricing-description {
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: var(--color-gray-600);
}

.dark .pricing-description {
    color: var(--color-gray-400);
}

.pricing-amount {
    margin-top: 1.5rem;
    margin-bottom: auto;
}

.pricing-name {
    font-size: 2.25rem;
    font-weight: 900;
    color: var(--color-gray-900);
    margin: 0;
}

.dark .pricing-name {
    color: var(--color-gray-100);
}

.participants-select {
    margin-top: 0.75rem;
    padding: 0.5rem 0.75rem;
    border: 1px solid var(--color-gray-300);
    border-radius: var(--border-radius-lg);
    background-color: var(--color-white);
    font-size: 0.9375rem;
    cursor: pointer;
    width: 100%;
}

.dark .participants-select {
    background-color: var(--color-gray-700);
    border-color: var(--color-gray-600);
    color: var(--color-gray-100);
}

.pricing-price {
    font-size: 1.25rem;
    font-weight: 900;
    color: var(--color-primary);
    margin: 0.25rem 0 0;
}

.dark .pricing-price {
    color: var(--color-primary);
}

.pricing-features {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-top: 2em;
}

.pricing-feature {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--color-gray-700);
}

.dark .pricing-feature {
    color: var(--color-gray-300);
}

.feature-icon {
    color: var(--color-green-500);
    font-size: 1.125rem;
}

.btn-full {
    margin-top: 2rem;
    width: 100%;
}

/* Testimonials */
.testimonials-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

@media (min-width: 1024px) {
    .testimonials-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

.testimonial-card {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    border-radius: var(--border-radius-xl);
    border: 1px solid var(--color-gray-200);
    background-color: var(--color-white);
    padding: 1.5rem;
}

.dark .testimonial-card {
    border-color: var(--color-gray-800);
    background-color: var(--color-background-dark);
}

.testimonial-quote {
    color: rgba(19, 127, 236, 0.5);
    font-size: 2.25rem;
}

.testimonial-text {
    color: var(--color-gray-700);
    margin: 0;
}

.dark .testimonial-text {
    color: var(--color-gray-300);
}

.testimonial-body {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    flex: 1;
}

.translate-toggle {
    align-self: flex-start;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    font-size: 1rem;
    color: var(--color-primary);
    text-decoration: underline;
    text-underline-offset: 2px;
}

.translate-toggle:hover {
    opacity: 0.8;
}

.testimonial-footer {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid var(--color-gray-200);
}

.dark .testimonial-footer {
    border-color: var(--color-gray-800);
}

.testimonial-name {
    font-weight: 700;
    color: var(--color-gray-900);
    margin: 0;
}

.dark .testimonial-name {
    color: var(--color-gray-100);
}

.testimonial-position {
    font-size: 0.875rem;
    color: var(--color-gray-600);
    margin: 0.25rem 0 0;
}

.dark .testimonial-position {
    color: var(--color-gray-400);
}

.linkedin-link {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    color: #0a66c2;
    text-decoration: none;
}

.linkedin-link:hover {
    text-decoration: underline;
}

.linkedin-icon {
    width: 0.9em;
    height: 0.9em;
    fill: #0a66c2;
    flex-shrink: 0;
    vertical-align: middle;
}

/* logos */
.logos {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.logos li {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.25rem 1.75rem;
    border-radius: var(--border-radius-xl);
    background-color: var(--color-white);
    border: 1px solid var(--color-gray-200);
    flex: 1 1 140px;
    min-width: 120px;
}

.dark .logos li {
    background-color: var(--color-background-dark);
    border-color: var(--color-gray-800);
}

.logos img {
    max-width: 120px;
    width: auto;
    height: auto;
    object-fit: contain;
    filter: grayscale(100%);
    opacity: 0.7;
    transition: filter 0.2s, opacity 0.2s;
}

.logos li:hover img {
    filter: grayscale(0%);
    opacity: 1;
}

.dark .logos img {
    filter: grayscale(100%) invert(1) brightness(1.5);
    opacity: 0.6;
}

.dark .logos li:hover img {
    filter: grayscale(0%) invert(0) brightness(1);
    opacity: 1;
}

.logos-desc {
    margin: 1.5rem 0 0.5rem;
    color: var(--color-gray-600);
    font-size: 0.9375rem;
}

.dark .logos-desc {
    color: var(--color-gray-400);
}

.logos-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.logos-list li {
    padding: 1rem 1rem 1rem 1.25rem;
    border-left: 4px solid var(--color-primary);
    border-radius: 0 var(--border-radius-xl) var(--border-radius-xl) 0;
    background-color: var(--color-white);
    border-top: 1px solid var(--color-gray-200);
    border-right: 1px solid var(--color-gray-200);
    border-bottom: 1px solid var(--color-gray-200);
    color: var(--color-gray-600);
    font-size: 0.9375rem;
    line-height: 1.6;
}

.dark .logos-list li {
    background-color: var(--color-background-dark);
    border-top-color: var(--color-gray-800);
    border-right-color: var(--color-gray-800);
    border-bottom-color: var(--color-gray-800);
    color: var(--color-gray-400);
}

/* About section */
.about-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
    padding: 1.5rem;
    border-radius: var(--border-radius-xl);
    background-color: var(--color-white);
    border: 1px solid var(--color-gray-200);
}

@media (min-width: 768px) {
    .about-card {
        flex-direction: row;
    }
}

.dark .about-card {
    background-color: var(--color-background-dark);
    border-color: var(--color-gray-800);
}

.about-avatar {
    width: 10rem;
    height: 10rem;
    border-radius: var(--border-radius-full);
    background-color: var(--color-gray-200);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.dark .about-avatar {
    background-color: var(--color-gray-700);
}

.about-avatar-icon {
    font-size: 3rem;
    color: var(--color-gray-500);
}

.dark .about-avatar-icon {
    color: var(--color-gray-400);
}

.about-text {
    color: var(--color-gray-700);
    line-height: 1.6;
    margin: 0;
}

@media (min-width: 768px) {
    .about-text {
        font-size: 1.125rem;
    }
}

.dark .about-text {
    color: var(--color-gray-300);
}

.about-body {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.about-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.875rem;
}

.about-list-item {
    padding-left: 1.25rem;
    border-left: 3px solid var(--color-primary);
    color: var(--color-gray-700);
    line-height: 1.6;
    font-size: 0.9375rem;
}

.dark .about-list-item {
    color: var(--color-gray-300);
}

/* Contact section */
.contact-section {
    padding: 2rem;
    background-color: var(--color-white);
    border-radius: var(--border-radius-xl);
    border: 1px solid var(--color-gray-200);
}

.dark .contact-section {
    background-color: var(--color-background-dark);
    border-color: var(--color-gray-800);
}

@media (min-width: 640px) {
    .contact-section {
        padding: 2rem;
    }
}

.contact-header {
    max-width: 36rem;
    margin: 0 auto;
    text-align: center;
}

.contact-title {
    color: var(--color-gray-900);
    font-size: 1.375rem;
    font-weight: 700;
    line-height: 1.25;
    letter-spacing: -0.015em;
    margin: 0;
}

.dark .contact-title {
    color: var(--color-gray-100);
}

@media (min-width: 640px) {
    .contact-title {
        font-size: 1.875rem;
    }
}

.contact-subtitle {
    margin-top: 0.5rem;
    color: var(--color-gray-600);
}

.dark .contact-subtitle {
    color: var(--color-gray-400);
}

.contact-form {
    margin-top: 2rem;
    max-width: 36rem;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

@media (min-width: 640px) {
    .form-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--color-gray-700);
}

.dark .form-label {
    color: var(--color-gray-300);
}

.form-input,
.form-textarea {
    margin-top: 0.25rem;
    display: block;
    width: 100%;
    border-radius: var(--border-radius-lg);
    border: 1px solid var(--color-gray-300);
    background-color: var(--color-gray-50);
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    padding: 0.5rem 0.75rem;
    font-family: var(--font-display);
    font-size: 0.875rem;
}

.dark .form-input,
.dark .form-textarea {
    border-color: var(--color-gray-700);
    background-color: var(--color-gray-800);
    color: var(--color-gray-200);
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(19, 127, 236, 0.1);
}

.form-textarea {
    resize: vertical;
}

.form-submit {
    text-align: center;
}

.btn-submit {
    height: 3rem;
    padding: 0 1.5rem;
    font-size: 1rem;
    width: 100%;
}

@media (min-width: 640px) {
    .btn-submit {
        width: auto;
    }
}

.form-message {
    padding: 0.75rem 1rem;
    border-radius: var(--border-radius-lg);
    font-size: 0.875rem;
    font-weight: 500;
}

.form-message-success {
    background-color: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.form-message-error {
    background-color: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.dark .form-message-success {
    background-color: #052e16;
    color: #86efac;
    border-color: #166534;
}

.dark .form-message-error {
    background-color: #450a0a;
    color: #fca5a5;
    border-color: #991b1b;
}

/* Footer */
.footer {
    width: 100%;
    margin-top: 3rem;
    padding: 2rem 0;
    border-top: 1px solid var(--color-gray-200);
}

.dark .footer {
    border-color: var(--color-gray-800);
}

.footer-content {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    text-align: center;
    gap: 1rem;
    padding: 0 2.5rem;
}

@media (min-width: 640px) {
    .footer-content {
        flex-direction: row;
        text-align: left;
    }
}

.footer-copyright {
    font-size: 0.875rem;
    color: var(--color-gray-600);
    margin: 0;
}

a:not(.btn) {
    color: var(--color-gray-600);
}

a:not(.btn):hover {
    color: var(--color-primary);
}

.dark {
    color: var(--color-gray-400);
}

.dark a:not(.btn) {
    color: var(--color-gray-400);
}

.dark a:not(.btn):hover {
    color: var(--color-primary);
}

.footer-links {
    display: flex;
    gap: 1rem;
}
.footer-links ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.footer-link {
    font-size: 0.875rem;
    color: var(--color-gray-600);
    text-decoration: none;
    transition: color 0.2s;
}

.dark .footer-link {
    color: var(--color-gray-400);
}

.footer-link:hover {
    color: var(--color-primary);
}

/* Responsive adjustments */
@media (max-width: 639px) {
    .header {
        padding: 1rem;
    }

    .main-content {
        padding: 1rem;
    }

    .hero-background {
        padding: 1.5rem;
        gap: 2rem;
    }

    .hero-title {
        font-size: 2.25rem;
    }

    .hero-subtitle {
        font-size: 1rem;
    }

    .btn-hero {
        height: 3rem;
        padding: 0 1.25rem;
        font-size: 1rem;
    }
}

@media (min-width: 480px) {
    .hero-background {
        gap: 2rem;
    }

    .hero-title {
        font-size: 3rem;
    }

    .hero-subtitle {
        font-size: 1rem;
    }

    .btn-hero {
        height: 3rem;
        padding: 0 1.25rem;
        font-size: 1rem;
    }
}
    </style>
    <link rel="canonical" href="<?= BASE_URL ?>" />
    <script type="application/ld+json">
    <?php
    echo json_encode($graph, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    ?>
    </script>
</head>
<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display:none">
        <symbol id="icon-linkedin" viewBox="0 0 24 24">
            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
        </symbol>
    </svg>
    <div class="design-root">
        <div class="layout-container">
            <div class="layout-wrapper">
                <div class="layout-content-container">
                    <header class="header">
                        <div class="header-logo">
                            <div class="logo-icon">
                                <svg class="logo-svg" fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.263 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z"></path>
                                    <path clip-rule="evenodd" d="M10.4485 13.8519C10.4749 13.9271 10.6203 14.246 11.379 14.7361C12.298 15.3298 13.7492 15.9145 15.6717 16.3735C18.0007 16.9296 20.8712 17.2655 24 17.2655C27.1288 17.2655 29.9993 16.9296 32.3283 16.3735C34.2508 15.9145 35.702 15.3298 36.621 14.7361C37.3796 14.246 37.5251 13.9271 37.5515 13.8519C37.5287 13.7876 37.4333 13.5973 37.0635 13.2931C36.5266 12.8516 35.6288 12.3647 34.343 11.9175C31.79 11.0295 28.1333 10.4437 24 10.4437C19.8667 10.4437 16.2099 11.0295 13.657 11.9175C12.3712 12.3647 11.4734 12.8516 10.9365 13.2931C10.5667 13.5973 10.4713 13.7876 10.4485 13.8519ZM37.5563 18.7877C36.3176 19.3925 34.8502 19.8839 33.2571 20.2642C30.5836 20.9025 27.3973 21.2655 24 21.2655C20.6027 21.2655 17.4164 20.9025 14.7429 20.2642C13.1498 19.8839 11.6824 19.3925 10.4436 18.7877V34.1275C10.4515 34.1545 10.5427 34.4867 11.379 35.027C12.298 35.6207 13.7492 36.2054 15.6717 36.6644C18.0007 37.2205 20.8712 37.5564 24 37.5564C27.1288 37.5564 29.9993 37.2205 32.3283 36.6644C34.2508 36.2054 35.702 35.6207 36.621 35.027C37.4573 34.4867 37.5485 34.1546 37.5563 34.1275V18.7877ZM41.5563 13.8546V34.1455C41.5563 36.1078 40.158 37.5042 38.7915 38.3869C37.3498 39.3182 35.4192 40.0389 33.2571 40.5551C30.5836 41.1934 27.3973 41.5564 24 41.5564C20.6027 41.5564 17.4164 41.1934 14.7429 40.5551C12.5808 40.0389 10.6502 39.3182 9.20848 38.3869C7.84205 37.5042 6.44365 36.1078 6.44365 34.1455L6.44365 13.8546C6.44365 12.2684 7.37223 11.0454 8.39581 10.2036C9.43325 9.3505 10.8137 8.67141 12.343 8.13948C15.4203 7.06909 19.5418 6.44366 24 6.44366C28.4582 6.44366 32.5797 7.06909 35.657 8.13948C37.1863 8.67141 38.5667 9.3505 39.6042 10.2036C40.6278 11.0454 41.5563 12.2684 41.5563 13.8546Z" fill="currentColor" fill-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h2 class="header-title">Wikipedia SEO</h2>
                        </div>
                        <button class="btn-theme-toggle" id="theme-toggle" aria-label="Przełącz tryb ciemny/jasny">
                            <span class="material-symbols-outlined" id="theme-icon">dark_mode</span>
                        </button>
                        <!--
                        <a class="btn btn-primary">
                            <span>Umów konsultację</span>
                        </a>
                        -->
                    </header>

                    <main class="main-content">
                        <div class="hero-section">
                            <div class="hero-background" style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.5) 100%), url("./background.jpg");'>
                                <div class="hero-content">
                                    <h1 class="hero-title">
                                      Płatna Edycja Wikipedii. Szkolenia oraz Konsultacje.
                                    </h1>
                                    <h2 class="hero-subtitle">
                                        Pomagam firmom zrozumieć standardy Wikipedii, aby ich obecność tam była trwała i zgodna z zasadami społeczności. Masz problem z edycją? Twoja strona została skasowana? Chcesz wiedzieć dlaczego, trafiłeś w dobre miejsce.
                                    </h2>
                                </div>
                                <a href="#kontakt" class="btn btn-primary btn-hero" data-subject="Konsultacje z Wikipedii" data-body="Jestem zainteresowany darmowym adytem z Wikipedii.">
                                    <span>Umów wstępny, darmowy audyt</span>
                                </a>
                            </div>
                        </div>

                        <section class="section">
                            <h2 class="section-title">Usługi i doradztwo</h2>
                            <div class="services-grid">
                                <div class="service-card">
                                    <span class="material-symbols-outlined service-icon">fact_check</span>
                                    <div class="service-content">
                                        <h3 class="service-title">Audyt i Konsultacje</h3>
                                        <p class="service-description">Weryfikacja encyklopedyczności (notability) i analiza źródeł. Dowiesz się, czy Twój temat spełnia wymogi Wikipedii, zanim podejmiesz ryzyko publikacji.</p>
                                    </div>
                                </div>

                                <div class="service-card">
                                    <span class="material-symbols-outlined service-icon">verified_user</span>
                                    <div class="service-content">
                                        <h3 class="service-title">Płatna Edycja i Publikacja</h3>
                                        <p class="service-description">Profesjonalne opracowanie i techniczne wdrożenie treści do Wikipedii. Jako redaktor oferuję pełną implementację treści zgodnie z wymogami Wikipedii. Zapewniam rzetelne zarządzanie wizerunkiem w oparciu o fakty, neutralny punkt widzenia (NPOV) oraz weryfikowalne źródła (WER).</p>
                                    </div>
                                </div>

                                <div class="service-card">
                                    <span class="material-symbols-outlined service-icon">auto_graph</span>
                                    <div class="service-content">
                                        <h3 class="service-title">Szkolenia Wikipedia &amp; SEO</h3>
                                        <p class="service-description">Profesjonalne i komercyjne Szkolenia dla agencji SEO oraz działów PR i marketingu. Nauczę Twój zespół, jak samodzielnie oceniać encyklopedyczność, poruszać się po strukturze technicznej Wikipedii i edytować zgodnie z rygorystycznymi zasadami społeczności, by budować trwałą obecność marki bez ryzyka blokady i wykorzystywać powiązane projekty do budowania grafu wiedzy marki w Google.</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="section">
                            <h2 class="section-title">Dla kogo jest to szkolenie i doradztwo?</h2>
                            <ul class="audience-list">
                                <li class="audience-item">
                                    <h3 class="audience-title">Agencje SEO i Content Marketingowe</h3>
                                    <p class="audience-desc">Chcesz bezpiecznie budować Graf Wiedzy (Knowledge Graph) dla swoich klientów? Nauczę Twój zespół, jak edytować Wikidata i Wikipedię bez ryzyka blokady kont firmowych oraz jak wykorzystać projekty siostrzane do wzmocnienia autorytetu domeny (E-E-A-T).</p>
                                </li>
                                <li class="audience-item">
                                    <h3 class="audience-title">Działy PR i Komunikacji (In-house)</h3>
                                    <p class="audience-desc">Twoja firma potrzebuje profesjonalnej obecności w encyklopedii, ale boisz się oskarżeń o kryptoreklamę? Dowiesz się, jak transparentnie zarządzać Konfliktem Interesów (COI) i jak rozmawiać z administratorami, używając ich własnego języka i argumentów.</p>
                                </li>
                                <li class="audience-item">
                                    <h3 class="audience-title">Specjaliści Personal Brandingu</h3>
                                    <p class="audience-desc">Budujesz wizerunek eksperta lub osoby publicznej? Pomogę Ci zrozumieć kryteria encyklopedyczności (WP:BIO), aby Twój biogram był trwały, rzetelny i odporny na próby usunięcia przez społeczność.</p>
                                </li>
                                <li class="audience-item">
                                    <h3 class="audience-title">Właściciele e-commerce i Innowatorzy</h3>
                                    <p class="audience-desc">Twoja marka tworzy unikalne technologie lub produkty? Dowiesz się, czy Twoje działania kwalifikują się do uwiecznienia w największej encyklopedii świata i jak przygotować źródła, których nikt nie podważy.</p>
                                </li>
                            </ul>
                        </section>

                        <section class="section">
                            <h2 class="section-title">Program szkolenia 'Wikipedia+SEO i nie tylko'</h2>
                            <div class="accordion">
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Historia i zasady Wikipedii</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Wprowadzenie do historii Wikipedii, jej zasad działania i struktury społeczności. Dowiesz się, jak poruszać się po projekcie, gdzie szukać pomocy i jak rozumieć reguły rządzące encyklopedią.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Żargon i komunikacja w Wikipedii</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">
                                        Nauczysz się języka, którym posługują się edytorzy i administratorzy. Dowiesz się, co oznaczają kluczowe skróty: <strong>DNU</strong>, <strong>EK</strong>, <strong>WP:WER</strong> czy <strong>WP:NPOV</strong>. Poznasz <strong>Uzus</strong> panujący w projektach Wikimedia, dzięki czemu Twoja komunikacja na stronach dyskusji będzie profesjonalna i skuteczna.
                                    </p>
                                    <p class="accordion-content">
                                        Dowiesz się gdzie szukać pomocy, jak poruszać się po Wikipedii oraz jak wygląda komunikacja między Wikipedystami.
                                    </p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Encyklopedyczność, czy temat nadaje się do Wikipedii</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Nauczysz się oceniać, czy dany temat nadaje się do Wikipedii. Dzięki temu nie będziesz tracić czasu na tworzenie treści, które zostaną usunięte lub cofnięte przez społeczność.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Tworzenie poprawnego artykułu</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Jak zbudować poprawnie artykuł od podstaw, struktura, neutralny punkt widzenia (NPOV), formatowanie i wikitext. Wszystko wyjaśnione krok po kroku podczas szkolenia.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Źródła i przypisy</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Jak prawidłowo podawać źródła, dobierać wiarygodne referencje i dodawać przypisy. Poprawne źródłowanie to podstawa artykułu, który przetrwa kontrolę społeczności.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Linki, budowanie i strategia SEO</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Jakie linki można dodawać i gdzie. Dowiesz się też, jak budować wartościowe linki nawet wtedy, gdy Twój temat nie nadaje się bezpośrednio do Wikipedii.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Prawo autorskie i Wikimedia Commons</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Prawa autorskie w kontekście Wikipedii, licencje wolne oraz Wikimedia Commons — miejsce, gdzie przechowuje się zdjęcia i multimedia. Nauczysz się poprawnie dodawać obrazy zgodnie z zasadami projektu.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Wikidane a Google Knowledge Graph</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Nauczysz się edytować Wikidata. Serce danych strukturalnych ekosystemu Wikimedia. Dowiesz się, jak poprawnie definiować podmioty (entity), aby zwiększyć szansę na pojawienie się marki w Grafie Wiedzy Google (panel boczny w wyszukiwarce) oraz jak łączyć dane między różnymi projektami.</p>
                                </details>
                            </div>
                        </section>

                        <section class="section">
                            <h2 class="section-title">Bonusy dla uczestników szkolenia</h2>
                            <div class="bonuses">
                                <div class="bonus-item">
                                    <span class="material-symbols-outlined bonus-icon">workspace_premium</span>
                                    <div class="bonus-content">
                                        <h3 class="bonus-title">Certyfikat ukończenia szkolenia</h3>
                                        <p class="bonus-desc">Po ukończeniu szkolenia otrzymasz imienny certyfikat potwierdzający zdobyte umiejętności edycji Wikipedii.</p>
                                    </div>
                                </div>
                                <div class="bonus-item">
                                    <span class="material-symbols-outlined bonus-icon">support_agent</span>
                                    <div class="bonus-content">
                                        <h3 class="bonus-title">Stały dostęp do konsultacji w preferencyjnej cenie</h3>
                                        <p class="bonus-desc">Absolwenci szkoleń otrzymują stały dostęp do konsultacji w cenie <strong>190 zł netto / godz</strong>.</p>
                                    </div>
                                </div>
                                <div class="bonus-item">
                                    <span class="material-symbols-outlined bonus-icon">contact_support</span>
                                    <div class="bonus-content">
                                        <h3 class="bonus-title">Gwarancja wsparcia</h3>
                                        <p class="bonus-desc">Zostanę Twoim Wiki-Przewodnikiem, abyś mógł bezpiecznie zadawać pytania wewnątrz Wikipedii.</p>
                                    </div>
                                </div>
                                <div class="bonus-item">
                                  <span class="material-symbols-outlined bonus-icon">dashboard</span>
                                  <div class="bonus-content">
                                    <h3 class="bonus-title">Dodatkowe materiały</h3>
                                    <p class="bonus-desc">Skonfiguruję dla Ciebie na Wikipedii stronę z odnośnikami do kluczowych procedur i narzędzi. Dzięki temu błyskawicznie dotrzesz do najważniejszych miejsc w Wikipedii bez błądzenia po systemie.</p>
                                  </div>
                                </div>
                            </div>
                        </section>

                        <section class="section">
                            <h2 class="section-title">Cennik</h2>
                            <div class="pricing-grid">
                                <div class="pricing-card">
                                    <h3 class="pricing-title">Konsultacje i Audyt Encyklopedyczności</h3>
                                    <p class="pricing-description">Indywidualne sesje strategiczne, aby rozwiązać Twoje konkretne wyzwania związane z Wikipedią.</p>
                                    <div class="pricing-amount">
                                        <p class="pricing-name">Konsultacje</p>
                                        <p class="pricing-price">250zł netto / godz.</p>
                                    </div>
                                    <ul class="pricing-features">
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Analiza Encyklopedyczności</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Pomoc w Edycji</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Redakcja i Dodawnie Przypisów</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Tworzenie Artykułu od zera</span>
                                        </li>
                                    </ul>
                                     <a href="#kontakt" class="btn btn-primary btn-full" data-subject="Konsultacje z Wikipedii" data-body="Jestem zainteresowany darmowym audytem z Wikipedii.">
                                        <span>Umów wstępny, darmowy audyt</span>
                                    </a>
                                </div>
                                <div class="pricing-card pricing-card-featured">
                                    <div class="pricing-header">
                                        <h3 class="pricing-title">Szkolenie 'Wikipedia+SEO i nie tylko'</h3>
                                        <!--
                                        <span class="pricing-badge">Popularne</span>
                                         -->
                                    </div>
                                    <p class="pricing-description">Kompleksowy kurs dla zespołów, aby samodzielnie zarządzać obecnością w Wikipedii.</p>
                                    <div class="pricing-amount">
                                        <p class="pricing-name">Szkolenie - Team</p>
                                        <p class="pricing-price" id="group-price">2999 zł netto (<span id="price-per-person">~599</span>zł/os.)</p>
                                    </div>
                                    <ul class="pricing-features">
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>2 dni szkoleniowe</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Grupa do 5 osób</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Teoria i Praktyka</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Certyfikat ukończenia</span>
                                        </li>
                                    </ul>
                                    <a href="#kontakt" class="btn btn-primary btn-full grupowe" data-subject="Szkolenie dla zespołu 'Wikipedia+SEO'">
                                        <span>Zapytaj o termin szkolenia</span>
                                    </a>
                                </div>
                                <div class="pricing-card pricing-card-featured">
                                    <div class="pricing-header">
                                        <h3 class="pricing-title">Szkolenie 'Wikipedia+SEO i nie tylko'</h3>
                                    </div>
                                    <p class="pricing-description">Kompleksowy kurs dla jednej osoby, aby samodzielnie zarządzać obecnością w Wikipedii.</p>
                                    <div class="pricing-amount">
                                        <p class="pricing-name">Szkolenie - Solo</p>
                                        <p class="pricing-price">999 zł netto</p>
                                    </div>
                                    <ul class="pricing-features">
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>2 dni szkoleniowe</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Jedna miejscówka</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Teoria i Praktyka</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Certyfikat ukończenia</span>
                                        </li>
                                    </ul>
                                    <a href="#kontakt" class="btn btn-primary btn-full" data-subject="Szkolenie dla Ciebie 'Wikipedia+SEO'" data-body="Jestem zainteresowany szkoleniem dla jednej osoby.">
                                        <span>Zapytaj o termin szkolenia</span>
                                    </a>
                                </div>
                            </div>
                        </section>

                        <section class="section">
                          <h2 class="section-title">Mój kod był wykorzystywany przez</h2>
                          <ul class="logos">
                            <li><img src="./google.png" alt="Google" /></li>
                            <li><img src="./docker.png" alt="Docker" /></li>
                            <li><img src="./duckduckgo.png" alt="DuckDuckGo" /></li>
                            <li><img src="./sqlite.png" alt="SQLite" /></li>
                            <li><img src="./codalab.png" alt="CodaLab" /></li>
                          </ul>
                          <p class="logos-desc">Mój projekt Open Source <a href="https://terminal.jcubic.pl/">jQuery Terminal</a> był wykorzystywany przez:</p>
                          <ul class="logos-list">
                            <li>Google wykorzystał go w narzędzu do rekrutacji <a href="https://govanify.com/post/foobar/">FooBar</a>.</li>
                            <li>DockDuckGo użyło go jako <a href="https://web.archive.org/web/20220608043747/https://duckduckgo.com/tty/">intefejs wyszukiwarki w stylu terminalowym</a>.</li>
                            <li>Docker używał go jako <a href="https://web.archive.org/web/20130822144120/https://www.docker.io/gettingstarted/">interaktywny samouczek</a>.</li>
                            <li>Codalab nadal używa go w swoich <a href="https://worksheets.codalab.org/worksheets">worksheets</a>.</li>
                            <li>SQLite używa biblioteki na <a href="https://sqlite.org/fiddle/index.html">swojej piaskownicy</a>.</li>
                          </ul>
                        </section>

                        <section class="section">
                            <h2 class="section-title">Co mówią klienci</h2>
                            <div class="testimonials-grid">
                                <div class="testimonial-card">
                                    <span class="material-symbols-outlined testimonial-quote">format_quote</span>
                                    <blockquote class="testimonial-text">
                                        "Jakub posiada głęboką wiedzę o mechanizmach działania Wikipedii i potrafi ją przekazać oraz zamienić w rzeczywiste rezultaty."
                                    </blockquote>
                                    <footer class="testimonial-footer">
                                        <p class="testimonial-name">Tymon Wysocki</p>
                                        <p class="testimonial-position">specjalista ds. marketingu</p>
                                    </footer>
                                </div>
                                <div class="testimonial-card">
                                    <span class="material-symbols-outlined testimonial-quote">format_quote</span>
                                    <blockquote class="testimonial-text">
                                        "Współpraca z Jakubem była absolutnie świetna. Pomógł mi napisać i poprawić artykuł na Wikipedii -tam, gdzie wiele osób się wahało lub unikało tematu, on od razu zaproponował swoją pomoc. Był konkretny, szybki i niezwykle profesjonalny. Wszystko odbywało się sprawnie, a kontakt z nim był naprawdę przyjemny. Jestem bardzo zadowolona i ogromnie wdzięczna za jego zaangażowanie. Zdecydowanie polecam współpracę z Jakubem!"
                                    </blockquote>
                                    <footer class="testimonial-footer">
                                        <p class="testimonial-name">Iga Jagiełło</p>
                                        <p class="testimonial-position">właścicielka salonu medycyny estetycznej</p>
                                    </footer>
                                </div>
                            </div>
                        </section>

                        <section class="section">
                            <h2 class="section-title">Opinie o wsparciu Open Source</h2>
                            <p class="section-source">Źródło: <a href="https://support.jcubic.pl/" target="_blank" rel="noopener">support.jcubic.pl</a></p>
                            <div class="testimonials-grid">
                                <div class="testimonial-card">
                                    <span class="material-symbols-outlined testimonial-quote">format_quote</span>
                                    <div class="testimonial-body">
                                        <blockquote class="testimonial-text testimonial-original">"I came across Jakub's website when we were trying to solve a problem with rendering of terminal outputs. I&nbsp;contacted him for help. He immediately responded and started helping us. He knows Javascript very well and has in-depth knowledge of implementing terminals in JavaScript. He went above and beyond and quickly put together a&nbsp;code that we could use for our purpose. Wherever he could not help, he pointed us in the right direction. This was a small project but a&nbsp;great experience dealing with Jakub from Poland! Thank you Jakub."</blockquote>
                                        <blockquote class="testimonial-text testimonial-translation" hidden>„Trafiłem na stronę Jakuba, gdy próbowaliśmy rozwiązać problem z renderowaniem danych wyjściowych terminala. Skontaktowałem się z nim po pomoc. Odpowiedział natychmiast i zaczął nam pomagać. Bardzo dobrze zna JavaScript i posiada dogłębną wiedzę na temat implementacji terminali w JavaScript. Wyszedł ponad oczekiwania i szybko przygotował kod, którego mogliśmy użyć. Tam, gdzie nie mógł pomóc, wskazał nam właściwy kierunek. Był to mały projekt, ale świetne doświadczenie we współpracy z Jakubem z Polski! Dziękuję, Jakub."</blockquote>
                                        <button class="translate-toggle" type="button">Przetłumacz</button>
                                    </div>
                                    <footer class="testimonial-footer">
                                        <p class="testimonial-name">Sarang Dharmapurikar</p>
                                        <p class="testimonial-position">CEO, <a href="https://www.dagknows.com/" target="_blank" rel="noopener">DagKnows Inc</a></p>
                                    </footer>
                                </div>
                                <div class="testimonial-card">
                                    <span class="material-symbols-outlined testimonial-quote">format_quote</span>
                                    <div class="testimonial-body">
                                        <blockquote class="testimonial-text testimonial-original">"Jakub is an expert in his field. I hired him to help with my project and he made a solution. He is pleasant to deal with and his time is well worth the price. Thanks Jakub."</blockquote>
                                        <blockquote class="testimonial-text testimonial-translation" hidden>„Jakub jest ekspertem w swojej dziedzinie. Zatrudniłem go do pomocy przy moim projekcie i opracował rozwiązanie. Miło się z nim pracuje, a jego czas jest wart swojej ceny. Dzięki, Jakub."</blockquote>
                                        <button class="translate-toggle" type="button">Przetłumacz</button>
                                    </div>
                                    <footer class="testimonial-footer">
                                        <p class="testimonial-name">Ordo</p>
                                        <p class="testimonial-position">Klient, <a href="https://support.jcubic.pl/" target="_blank" rel="noopener">support.jcubic.pl</a></p>
                                    </footer>
                                </div>
                                <div class="testimonial-card">
                                    <span class="material-symbols-outlined testimonial-quote">format_quote</span>
                                    <div class="testimonial-body">
                                        <blockquote class="testimonial-text testimonial-original">"Jakub T. Jankiewicz shared his open source story for the book maintaine.rs, showcasing a diverse portfolio of projects driven by creativity and technical skill. From jQuery Terminal to isomorphic-git—a pure JavaScript Git client—Jakub's dedication as a maintainer continues to empower developers worldwide. Grateful for his contribution to the book and for his ongoing impact in open source."</blockquote>
                                        <blockquote class="testimonial-text testimonial-translation" hidden>„Jakub T. Jankiewicz podzielił się swoją historią open source na potrzeby książki maintaine.rs, prezentując różnorodne portfolio projektów napędzanych kreatywnością i umiejętnościami technicznymi. Od jQuery Terminal po isomorphic-git — czysty klient Git w JavaScript — zaangażowanie Jakuba jako maintainera nadal wspiera deweloperów na całym świecie. Wdzięczny za jego wkład w książkę i ciągły wpływ na świat open source."</blockquote>
                                        <button class="translate-toggle" type="button">Przetłumacz</button>
                                    </div>
                                    <footer class="testimonial-footer">
                                        <p class="testimonial-name">Nick Vidal</p>
                                        <p class="testimonial-position">Open Source enthusiast, <a href="https://www.linkedin.com/in/nickvidal/" target="_blank" rel="noopener" class="linkedin-link"><svg class="linkedin-icon" aria-hidden="true"><use href="#icon-linkedin"/></svg>LinkedIn</a></p>
                                    </footer>
                                </div>
                            </div>
                        </section>

                        <section class="section">
                            <h2 class="section-title">Opinie współpracowników</h2>
                            <p class="section-source">Źródło: <a href="https://www.linkedin.com/in/jcubic/" target="_blank" rel="noopener">LinkedIn</a></p>
                            <div class="testimonials-grid">
                                <div class="testimonial-card">
                                    <span class="material-symbols-outlined testimonial-quote">format_quote</span>
                                    <div class="testimonial-body">
                                        <blockquote class="testimonial-text testimonial-original">"I have worked with Kuba on a large scientific software project. Not only did he become known as an absolute expert in JavaScript and its frameworks, but he also quickly learned enough R and Shiny to be able to actively participate in the development of the server-side parts of the app. Kuba is passionate in what he's doing, hungry for knowledge and always eager to share what he has already learned."</blockquote>
                                        <blockquote class="testimonial-text testimonial-translation" hidden>„Pracowałem z Kubą przy dużym naukowym projekcie informatycznym. Nie dość, że stał się znany jako absolutny ekspert w JavaScript i jego frameworkach, to jeszcze szybko nauczył się na tyle R i Shiny, żeby aktywnie uczestniczyć w rozwoju części serwerowej aplikacji. Kuba jest pasjonatem tego, co robi, spragniony wiedzy i zawsze chętny do dzielenia się tym, czego się nauczył."</blockquote>
                                        <button class="translate-toggle" type="button">Przetłumacz</button>
                                    </div>
                                    <footer class="testimonial-footer">
                                        <p class="testimonial-name">Paweł Piątkowski</p>
                                        <p class="testimonial-position">Born-again bioinformatician, <a href="https://www.linkedin.com/in/pawel-piatkowski/" target="_blank" rel="noopener" class="linkedin-link"><svg class="linkedin-icon" aria-hidden="true"><use href="#icon-linkedin"/></svg>LinkedIn</a></p>
                                    </footer>
                                </div>
                                <div class="testimonial-card">
                                    <span class="material-symbols-outlined testimonial-quote">format_quote</span>
                                    <div class="testimonial-body">
                                        <blockquote class="testimonial-text testimonial-original">"I can highly recommend Jakub as a programmer and frontend expert. He has been an invaluable asset to our team, creating an open source project for terminal emulation in browser. Jakub is an excellent communicator who is always willing to offer advice and assistance. He provides long term support and is great at troubleshooting. His skills are top-notch and I highly recommend him."</blockquote>
                                        <blockquote class="testimonial-text testimonial-translation" hidden>„Mogę gorąco polecić Jakuba jako programistę i eksperta frontend. Był nieocenionym członkiem naszego zespołu, tworząc projekt open source do emulacji terminala w przeglądarce. Jakub świetnie się komunikuje i zawsze chętnie udziela porad i pomocy. Zapewnia długoterminowe wsparcie i doskonale radzi sobie z rozwiązywaniem problemów. Jego umiejętności są najwyższej klasy i gorąco go polecam."</blockquote>
                                        <button class="translate-toggle" type="button">Przetłumacz</button>
                                    </div>
                                    <footer class="testimonial-footer">
                                        <p class="testimonial-name">Tom Sapletta</p>
                                        <p class="testimonial-position">prototyping.pl, <a href="https://www.linkedin.com/in/tom-sapletta-com/en/" target="_blank" rel="noopener" class="linkedin-link"><svg class="linkedin-icon" aria-hidden="true"><use href="#icon-linkedin"/></svg>LinkedIn</a></p>
                                    </footer>
                                </div>
                                <div class="testimonial-card">
                                    <span class="material-symbols-outlined testimonial-quote">format_quote</span>
                                    <div class="testimonial-body">
                                        <blockquote class="testimonial-text testimonial-original">"Jakub is a JavaScript expert. His knowledge is really stunning. Jakub has always a thousand ideas how to solve problems and he doesn't refrain to communicate them openly. Beside the impressive technical skills Jakub is a very helpful person. One may learn a lot from Jakub."</blockquote>
                                        <blockquote class="testimonial-text testimonial-translation" hidden>„Jakub jest ekspertem JavaScript. Jego wiedza jest naprawdę imponująca. Jakub ma zawsze tysiąc pomysłów na rozwiązanie problemów i nie waha się otwarcie je komunikować. Oprócz imponujących umiejętności technicznych Jakub jest bardzo pomocną osobą. Można się od niego dużo nauczyć."</blockquote>
                                        <button class="translate-toggle" type="button">Przetłumacz</button>
                                    </div>
                                    <footer class="testimonial-footer">
                                        <p class="testimonial-name">Jakub Małecki</p>
                                        <p class="testimonial-position">Senior Data Scientist, <a href="https://www.linkedin.com/in/malecki-jakub/en/" target="_blank" rel="noopener" class="linkedin-link"><svg class="linkedin-icon" aria-hidden="true"><use href="#icon-linkedin"/></svg>LinkedIn</a></p>
                                    </footer>
                                </div>
                            </div>
                        </section>

                        <section class="section">
                            <h2 class="section-title">FAQ</h2>
                            <div class="accordion">
                                <?php foreach ($faq as $item): ?>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title"><?= $item['question'] ?></h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content"><?= $item['answer'] ?></p>
                                </details>
                                <?php endforeach; ?>
                            </div>
                        </section>

                        <section class="section">
                            <div class="about-card">
                                <div class="about-avatar">
                                    <img src="./avatar-sm.jpg" width="160" height="160" alt="Jakub T. Jankiewicz portrait"/>
                                </div>
                                <div class="about-body">
                                    <p class="about-text">Nazywam się <a href="https://jakub.jankiewicz.org/"><strong>Jakub T. Jankiewicz</strong></a>. Łączę świat technologii z rzetelną informacją, działając na styku programowania i wolnej wiedzy.</p>
                                    <ul class="about-list">
                                        <li class="about-list-item">
                                            <strong>W Wikipedii:</strong> Posiadam ponad <strong>15 lat doświadczenia</strong> i uprawnienia <a href="https://pl.wikipedia.org/wiki/Wikipedysta:Jcubic"><strong>Redaktora</strong></a> w polskiej Wikipedii. Jako certyfikowany <a href="https://pl.wikipedia.org/wiki/Wikipedia:WikiTrenerzy"><strong>WikiTrener</strong></a> prowadzę oficjalne szkolenia dla stowarzyszenia <a href="https://wikimedia.pl/">Wikimedia Polska</a>, a jako <a href="https://pl.wikipedia.org/wiki/Pomoc:Przewodnicy"><strong>WikiPrzewodnik</strong></a> pomagam nowicjuszom stawiać pierwsze kroki. Jestem także wielokrotnym <a href="https://www.youtube.com/watch?v=3bdQZ67mpn8">prelegentem</a> na konferencji poświęconej Wikipedii oraz projektów siostrznych <a href="https://pl.wikimedia.org/wiki/Wzlot">WZLOT</a>.
                                        </li>
                                        <li class="about-list-item">
                                          <strong>W Technologii:</strong> Jestem doświadczonym programistą i twórcą projektów Open Source (m.in. <a href="https://terminal.jcubic.pl">jQuery Terminal</a>, <a href="https://github.com/jcubic/sysend">Sysend</a>, <a href="https://github.com/jcubic/wayne">Wayne</a>, czy <a href="https://lips.js.org">LIPS Scheme</a>). Moje techniczne podejście pozwala mi rozumieć Wikipedię nie tylko jako tekst, ale jako system danych strukturalnych (Wikidata), który bezpośrednio wpływa na nowoczesne SEO i Graf Wiedzy Google.
                                        </li>
                                        <li class="about-list-item">
                                            <strong>W Edukacji:</strong> Od lat tłumaczę zawiłe aspekty techniczne w przystępny sposób. Moim celem jest edukowanie profesjonalistów z branży PR i SEO, aby ich obecność w największej encyklopedii świata była etyczna, trwała i technicznie poprawna.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </section>

                        <section class="section contact-section" id="kontakt">
                            <div class="contact-header">
                                <h2 class="contact-title">Kontakt</h2>
                                <p class="contact-subtitle">Masz pytanie lub chcesz omówić swój projekt? Wypełnij formularz, a skontaktuję się z Tobą jak najszybciej.</p>
                            </div>
                            <form class="contact-form" method="POST">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Imię i nazwisko</label>
                                        <input class="form-input" id="name" name="name" required placeholder="Jan Kowalski" type="text"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="email">Email</label>
                                        <input class="form-input" id="email" name="email" required placeholder="jan.kowalski@example.com" type="email"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="subject">Temat</label>
                                    <input class="form-input" id="subject" name="subject" required laceholder="Pytanie dotyczące szkolenia" type="text"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="message">Wiadomość</label>
                                    <textarea class="form-textarea" id="message" name="message" required  placeholder="Twoja wiadomość..." rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label lass="form-label" for="email_confirmation">Podaj Wynik: <?= $a ?> + <?= $b ?></label>
                                    <input class="form-input" type="text" id="email_confirmation" name="email_confirmation" required placeholder="="/>
                                </div>
                                <div class="form-submit">
                                    <?php if ($message_sent): ?>
                                        <p class="form-message form-message-success">✅ Wiadomość została wysłana. Odezwę się wkrótce!</p>
                                    <?php elseif (!empty($error_message)): ?>
                                        <p class="form-message form-message-error">❌ <?= htmlspecialchars($error_message) ?></p>
                                    <?php endif; ?>
                                    <button class="btn btn-primary btn-submit" type="submit">
                                        <span>Wyślij wiadomość</span>
                                    </button>
                                </div>
                            </form>
                        </section>
                    </main>

                    <footer class="footer">
                        <div class="footer-content">
                          <p class="footer-copyright">© 2025 <a href="https://jakub.jankiewicz.org">Jakub T. Jankiewicz</a>.</p>
                          <div class="footer-links">
                              <ul>
                                  <li><a class="footer-link" href="/">Głównie JavaScript</a></li>
                                  <li><a class="footer-link" href="/wikizeit">WikiZEIT</a></li>
                                  <li><a class="footer-link" href="https://github.com/WikiZEIT/szkolenia">kod źródłowy</a></li>
                              </ul>
                          </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            var STORAGE_KEY = 'wikipedia:colorScheme';
            var html = document.documentElement;
            var icon = document.getElementById('theme-icon');

            function isDark() {
                return html.classList.contains('dark');
            }

            function applyTheme(dark) {
                if (dark) {
                    html.classList.add('dark');
                    html.classList.remove('light');
                    icon.textContent = 'light_mode';
                } else {
                    html.classList.remove('dark');
                    html.classList.add('light');
                    icon.textContent = 'dark_mode';
                }
            }

            function initTheme() {
                var stored = localStorage.getItem(STORAGE_KEY);
                if (stored === 'dark') {
                    applyTheme(true);
                } else if (stored === 'light') {
                    applyTheme(false);
                } else {
                    var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    applyTheme(prefersDark);
                }
            }

            document.getElementById('theme-toggle').addEventListener('click', function() {
                var dark = !isDark();
                applyTheme(dark);
                localStorage.setItem(STORAGE_KEY, dark ? 'dark' : 'light');
            });

            initTheme();
        })();

        document.querySelectorAll('.btn[data-subject]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var title = this.dataset.subject;
                var body = this.dataset.body ?? '';
                document.getElementById('subject').value = title;
                document.getElementById('message').value = body;
            });
        });

        document.querySelectorAll('.translate-toggle').forEach(function(btn) {
            var body = btn.closest('.testimonial-body');
            var original = body.querySelector('.testimonial-original');
            var translation = body.querySelector('.testimonial-translation');
            var translated = false;

            btn.addEventListener('click', function() {
                translated = !translated;
                original.hidden = translated;
                translation.hidden = !translated;
                btn.textContent = translated ? 'Zobacz oryginał' : 'Przetłumacz';
            });
        });

        function interpolate(pts) {
            return (n) => {
                if (n <= pts[0][0]) return pts[0][1];
                if (n >= pts.at(-1)[0]) return pts.at(-1)[1];

                const i = pts.findIndex((p, idx) => idx < pts.length-1 && n <= pts[idx+1][0]);
                if (i < 0) return pts.at(-1)[1];

                const [x0,y0] = pts[i];
                const [x1,y1] = pts[i+1];

                return Math.round(y0 + (n - x0) * (y1 - y0) / (x1 - x0));
            };
        }

        (function() {
            const strings = { many: 'osób', one: 'osoba', few: 'osoby' };
            const pr = new Intl.PluralRules('pl-PL');

            const price = interpolate([[2, 1700], [5, 2999], [10, 4999]]);

            const groupPriceEl = document.getElementById('group-price');
            const pricingAmount = groupPriceEl.closest('.pricing-amount');

            const select = document.createElement('select');
            select.className = 'participants-select';
            select.id = 'participants';

            for (let i = 2; i <= 10; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i + ' ' + strings[pr.select(i)];
                if (i === 5) option.selected = true;
                select.appendChild(option);
            }

            pricingAmount.appendChild(select);

            function updatePrice() {
                const n = parseInt(select.value, 10);
                const totalPrice = price(n);
                const pricePerPerson = Math.trunc(totalPrice / n);
                groupPriceEl.innerHTML = totalPrice + ' zł netto (<span id="price-per-person">~' + pricePerPerson + '</span>zł/os.)';
            }

            select.addEventListener('change', updatePrice);

            const reserveBtn = document.querySelector('.grupowe');
            if (reserveBtn) {
                reserveBtn.setAttribute('data-body', 'Jestem zainteresowany szkoleniem grupowym dla 5 osób.');
                select.addEventListener('change', function() {
                    const n = parseInt(select.value, 10);
                    const person = strings[pr.select(n)];
                    reserveBtn.setAttribute('data-body', `Jestem zainteresowany szkoleniem grupowym dla ${n} ${person}.`);
                });
            }
        })();
    </script>
    <script defer src="https://umami.jcubic.pl/script.js" data-website-id="c716ef1c-b60b-455c-8279-58996a09a8a6"></script>
</body>
</html>
<?php } ?>
