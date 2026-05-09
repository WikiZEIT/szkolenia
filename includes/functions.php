<?php
function is_spam() {
    return !empty($_POST['email_confirmation']);
}

function load_tokens() {
    if (!file_exists(ALLEGRO_TOKEN_FILE)) {
        return null;
    }
    return json_decode(file_get_contents(ALLEGRO_TOKEN_FILE), true);
}

function save_tokens($tokens) {
    file_put_contents(ALLEGRO_TOKEN_FILE, json_encode($tokens, JSON_PRETTY_PRINT));
}

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
        return null;
    }
    $new_tokens = json_decode($response, true);
    $new_tokens['expires_at'] = time() + $new_tokens['expires_in'];
    save_tokens($new_tokens);
    return $new_tokens['access_token'];
}

function get_valid_access_token() {
    $tokens = load_tokens();
    if (!$tokens) {
        return null;
    }
    if (time() >= $tokens['expires_at']) {
        return refresh_access_token();
    }
    return $tokens['access_token'];
}

function fetch_offer_data($query) {
    $access_token = get_valid_access_token();
    if (!$access_token) {
        return ['error' => 'No valid access token.'];
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
        return ['error' => 'Unauthorized – token expired and refresh failed.'];
    }
    if ($http_code !== 200) {
        return ['error' => 'HTTP ' . $http_code, 'response' => $response];
    }
    $data = json_decode($response, true);
    return $data['offers'][0]['saleInfo']['currentPrice']['amount'];
}
