<?php
define('TOKEN_FILE', __DIR__ . '/allegro_tokens.json');
define('CLIENT_ID', 'e4aa5beb230c4054bf0de66c58a5a832');
define('CLIENT_SECRET', 'd77uP787DGfoPsH9gxOG8lz9a0jRoGX5dpNPFRxY4q7pVCVu4hS3hnP7uJ6c5Tzw');

$message_sent = false;
$error_message = '';
$a = rand(1, 10);
$b = rand(1, 10);
$result = $a + $b;

session_start();
$prev_result = isset($_SESSION['result']) ? $_SESSION['result'] : null;
$_SESSION['result'] = $result;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $user_message = htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8');
    if (is_spam()) {
        $error_message = "Wygląda na to że nie jesteś człowiem!";
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($user_message)) {
        $to = 'jcubic@jcubic.pl';
        $subject = 'Interest in tracking.ninja domain';
        $body = "New inquiry about tracking.ninja domain:\n\n";
        $body .= "From: " . $email . "\n\n";
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
    if (!file_exists(TOKEN_FILE)) {
        return null;
    }
    $content = file_get_contents(TOKEN_FILE);
    return json_decode($content, true);
}

// Zapisuje tokeny do pliku
function save_tokens($tokens) {
    file_put_contents(TOKEN_FILE, json_encode($tokens, JSON_PRETTY_PRINT));
}

// Odświeża access_token przy użyciu refresh_token
function refresh_access_token() {
    $tokens = load_tokens();
    if (!$tokens || empty($tokens['refresh_token'])) {
        return null;
    }

    $url = 'https://allegro.pl/auth/oauth/token';
    $auth = base64_encode(CLIENT_ID . ':' . CLIENT_SECRET);

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

if (isset($_GET['auth'])) {
    session_start();

    $auth_header = base64_encode(CLIENT_ID . ':' . CLIENT_SECRET);

    if (empty($_SESSION['allegro_device_code'])) {

        // Krok 1: Pobierz device_code
        $ch = curl_init('https://allegro.pl/auth/oauth/device');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $auth_header,
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'client_id=' . CLIENT_ID);

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

        file_put_contents(TOKEN_FILE, json_encode($token_data, JSON_PRETTY_PRINT));

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
<html class="light" lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Wikipedia Konsultacje i Szkolenia</title>
    <link rel="canonical" href="https://support.jcubic.pl/wikipedia/" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
/* Reset and base styles */
* {
    box-sizing: border-box;
}

.material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
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

.dark body {
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
    margin-bottom: auto;
    font-size: 0.875rem;
    color: var(--color-gray-600);
}

.dark .pricing-description {
    color: var(--color-gray-400);
}

.pricing-amount {
    margin: 1.5rem 0;
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

.dark .footer-copyright {
    color: var(--color-gray-400);
}

.footer-links {
    display: flex;
    gap: 1rem;
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
    <link rel="canonical" href="https://jcubic.pl/wikipedia/" />
</head>
<body>
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
                        <!--
                        <button class="btn btn-primary">
                            <span>Umów konsultację</span>
                        </button>
                         -->
                    </header>

                    <main class="main-content">
                        <div class="hero-section">
                            <div class="hero-background" style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.5) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuCeB39A89xBeUKxVvFNPJ-SRAiF2t_CXSAv5Gyt4OOWeaAj3Z2vy1__6--udkBvo41QFdJTydTEKYPBm4YP2R6oWKWQI7bNrxnbfCY1t2X5dFulS_0AOD7ozv-UDdfAdCfhuQvBZxugPE_0sBTL8wgb0SSvxtQydS12yybbZgTiNA0LlGKJgRkaWMh2uBjSVO-tBv0K6E0y3GJvMkhqGtzaxZiH6EvINSd0At38vHzSD3uMI9ptcfs4e15NtNrnTNPGtFyiwFYjwcy3");'>
                                <div class="hero-content">
                                    <h1 class="hero-title">
                                      Płatna Edycja Wikipedii. Szkolenia oraz Konsultacje.
                                    </h1>
                                    <h2 class="hero-subtitle">
                                        Specjalistyczne doradztwo i szkolenia, aby wykorzystać największą encyklopedię świata do zwiększenia widoczności Twojej marki. Masz problem z edycją? Twoja strona została skasowana? Chcesz wiedzieć dlaczego trafiłeś w dobre miejsce.
                                    </h2>
                                </div>
                                <a href="#kontakt" class="btn btn-primary btn-hero">
                                    <span>Umów się na konsultację</span>
                                </a>
                            </div>
                        </div>

                        <section class="section">
                            <h2 class="section-title">Usługi</h2>
                            <div class="services-grid">
                                <div class="service-card">
                                    <span class="material-symbols-outlined service-icon">chat</span>
                                    <div class="service-content">
                                        <h3 class="service-title">Konsultacje</h3>
                                        <p class="service-description">Specjalistyczne porady dotyczące strategii Wikipedii, encyklopedyczności, SEO i tworzenia treści.</p>
                                    </div>
                                </div>
                                <div class="service-card">
                                    <span class="material-symbols-outlined service-icon">school</span>
                                    <div class="service-content">
                                        <h3 class="service-title">Szkolenia</h3>
                                        <p class="service-description">Zaawansowane kursy, które pozwolą Ci opanować Wikipedię dla sukcesu w marketingu i SEO.</p>
                                    </div>
                                </div>
                                <div class="service-card">
                                    <span class="material-symbols-outlined service-icon">edit_note</span>
                                    <div class="service-content">
                                        <h3 class="service-title">Profesjonalne Edycje</h3>
                                        <p class="service-description">Zgodne z zasadami tworzenie i edycja artykułów w Wikipedii, Wikidata i Wikimedia Commons.</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="section">
                            <h2 class="section-title">Program szkolenia 'Wikipedia+SEO i nie tylko'</h2>
                            <div class="accordion">
                                <details class="accordion-item" open>
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Historia i zasady Wikipedii</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Wprowadzenie do historii Wikipedii, jej zasad działania i struktury społeczności. Dowiesz się, jak poruszać się po projekcie, gdzie szukać pomocy i jak rozumieć reguły rządzące encyklopedią.</p>
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
                                    <p class="accordion-content">Jak zbudować poprawnie artykuł od podstaw — struktura, neutralny punkt widzenia (NPOV), formatowanie i wikitext. Wszystko wyjaśnione krok po kroku podczas szkolenia.</p>
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
                            </div>
                        </section>

                        <section class="section">
                            <h2 class="section-title">Cennik</h2>
                            <div class="pricing-grid">
                                <div class="pricing-card">
                                    <h3 class="pricing-title">Konsultacje Wikipedia SEO/Marketing</h3>
                                    <p class="pricing-description">Indywidualne sesje strategiczne, aby rozwiązać Twoje konkretne wyzwania związane z Wikipedią.</p>
                                    <div class="pricing-amount">
                                        <p class="pricing-name">Konsultacje</p>
                                        <p class="pricing-price">250zł/godz.</p>
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
                                            <span>Tworzenie Artykułu od zera (płatna edycja)</span>
                                        </li>
                                    </ul>
                                     <a href="#kontakt" class="btn btn-primary btn-full" data-title="Konsultacje z Wikipedii">
                                        <span>Umów konsultację</span>
                                    </a>
                                </div>
                                <div class="pricing-card pricing-card-featured">
                                    <div class="pricing-header">
                                        <h3 class="pricing-title">Szkolenie 'Wikipedia+SEO i nie tylko'</h3>
                                        <!--
                                        <span class="pricing-badge">Popularne</span>
                                         -->
                                    </div>
                                    <p class="pricing-description">Kompleksowy kurs dla zespołów i indywidualistów, aby samodzielnie zarządzać obecnością w Wikipedii.</p>
                                    <div class="pricing-amount">
                                        <p class="pricing-name">Szkolenie Grupowe</p>
                                        <p class="pricing-price">2999 zł (599zł/os.)</p>
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
                                    <a href="#kontakt" class="btn btn-primary btn-full" data-title="Szkolenie Grupowe 'Wikipedia+SEO'">
                                        <span>Rezerwój</span>
                                    </a>
                                </div>
                                <div class="pricing-card pricing-card-featured">
                                    <div class="pricing-header">
                                        <h3 class="pricing-title">Szkolenie 'Wikipedia+SEO i nie tylko'</h3>
                                    </div>
                                    <p class="pricing-description">Kompleksowy kurs dla jednej osoby, aby samodzielnie zarządzać obecnością w Wikipedii.</p>
                                    <div class="pricing-amount">
                                        <p class="pricing-name">Szkolenie</p>
                                        <p class="pricing-price">999 zł</p>
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
                                    <a href="#kontakt" class="btn btn-primary btn-full" data-title="Szkolenie 'Wikipedia+SEO'">
                                        <span>Rezerwój</span>
                                    </a>
                                </div>
                            </div>
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
                            <h2 class="section-title">O mnie</h2>
                            <div class="about-card">
                                <div class="about-avatar">
                                    <img src="./avatar-sm.jpg" alt="Jakub T. Jankiewicz portrait"/>
                                </div>
                                <p class="about-text">Nazywam się <a href="https://jakub.jankiewicz.org/">Jakub T. Jankiewicz</a>. Jestem Redaktorem w Polskiej Wikipedii, gdzie jestem także WikiTrenerem (prowadzę szkolenia na temat Wikipedii) oraz WikiPrzewodnikiem dla początkujących.</p>
                            </div>
                        </section>

                        <section class="section">
                            <h2 class="section-title">FAQ</h2>
                            <div class="accordion">
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Ile trwa edycja artykułu na Wikipedii?</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Edycja niewielkiego artykułu (100-150 wyrazów) w języku polskim trwa zazwyczaj 1-2 godzny. Krócej gdy mam już przygotowany tekst i źródła.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Czy edytujesz tylko w języku Polskim?</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Mogę pomóc także z edycją artykułów w jęzuku Angielskim.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Czy możesz pomóc w dodaniu wpisu w Wikidata?</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Tak, zawsze dodaje wpis w Wikidata, gdy dodaje artykuł do Wikipedii.</p>
                                </details>
                            </div>
                        </section>

                        <section class="section contact-section" id="kontakt">
                            <div class="contact-header">
                                <h2 class="contact-title">Kontakt</h2>
                                <p class="contact-subtitle">Masz pytanie lub chcesz omówić swój projekt? Wypełnij formularz, a skontaktuję się z Tobą jak najszybciej.</p>
                            </div>
                            <form class="contact-form">
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
                                <a class="footer-link" href="#"></a>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
    <script defer src="https://umami.jcubic.pl/script.js" data-website-id="74ae63b5-5715-4e73-89b8-3ecd1302c648"></script>
    <script>
        document.querySelectorAll('.btn[data-title]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var title = this.dataset.title;
                document.getElementById('subject').value = title;
            });
        });
    </script>
</body>
</html>
<?php } ?>
