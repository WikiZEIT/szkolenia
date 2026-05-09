<?php
/* Copyright (c) 2026 Jakub T. Jankiewicz
 * All Rights Reserved
 */
$assets_base = '../';
$page_title = "Szkolenia 'Wikipedia+SEO i nie tylko' - WikiZEIT";
$page_description = 'Profesjonalne szkolenia z edycji Wikipedii i danych strukturalnych dla agencji SEO, działów PR i marketingu. Certyfikowany WikiTrener prowadzi kurs z teorią i praktyką.';

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/faq.php';

$page_image = OFERTA_URL . 'social-card-szkolenia.png';

$page_url = OFERTA_URL . 'szkolenia/';

require_once __DIR__ . '/../includes/contact_handler.php';

$course_id = $page_url . '#szkolenie';
$breadcrumb_id = $page_url . '#breadcrumb';

$faq = get_faq_for_page('szkolenia');

$graph = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Course',
            '@id' => $course_id,
            'name' => 'Szkolenie Wikipedia+SEO i nie tylko',
            'description' => 'Kompleksowe szkolenie z edycji Wikipedii i danych strukturalnych. Pakiet obejmuje: imienny certyfikat ukończenia, stały dostęp do konsultacji z 20% zniżką, opiekę oficjalnego Wiki-Przewodnika, konfigurację strony z odnośnikami do narzędzi.',
            'author' => ['@id' => $person_id],
            'provider' => ['@id' => $wikizeit_id]
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
            '@type' => 'BreadcrumbList',
            '@id' => $breadcrumb_id,
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'item' => $wikizeit_id . '#webpage', 'name' => 'WikiZeit'],
                ['@type' => 'ListItem', 'position' => 2, 'item' => OFERTA_URL . '#webpage', 'name' => 'Oferta'],
                ['@type' => 'ListItem', 'position' => 3, 'item' => $page_url . '#webpage', 'name' => 'Szkolenia']
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

$page_schema = json_encode($graph, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

$show_form_prefill = true;
$show_translate = true;
$show_pricing_calculator = true;
$show_cal = true;

require __DIR__ . '/../includes/head.php';
require __DIR__ . '/../includes/header.php';
?>
                        <div class="hero-section">
                            <div class="hero-background" style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.5) 100%), url("../background.jpg");'>
                                <div class="hero-content">
                                    <h1 class="hero-title">
                                      Szkolenia Wikipedia+SEO i nie tylko
                                    </h1>
                                    <h2 class="hero-subtitle">
                                        Profesjonalne i komercyjne szkolenia dla agencji SEO oraz działów PR i marketingu. Naucz swój zespół samodzielnie zarządzać obecnością w Wikipedii i budować Graf Wiedzy.
                                    </h2>
                                </div>
                                <a class="btn btn-primary btn-hero"
                                   data-cal-link="jcubic/darmowa-konsultacja"
                                   data-cal-namespace="darmowa-konsultacja"
                                   data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}'>
                                    <span>Zarezerwuj wstępną, darmową rozmowę</span>
                                </a>
                            </div>
                        </div>

                        <section class="section">
                            <h2 class="section-title">Dla kogo jest to szkolenie?</h2>
                            <ul class="audience-list">
                                <li class="audience-item">
                                    <h3 class="audience-title">Agencje SEO i Content Marketingowe</h3>
                                    <p class="audience-desc">Chcesz bezpiecznie budować Graf Wiedzy (Knowledge Graph) dla swoich klientów? Nauczę Twój zespół, jak edytować Wikidata i Wikipedię bez ryzyka blokady kont firmowych oraz jak wykorzystać projekty siostrzane do wzmocnienia autorytetu domeny (E-E-A-T).</p>
                                </li>
                                <li class="audience-item">
                                    <h3 class="audience-title">Działy PR i Komunikacji (In-house)</h3>
                                    <p class="audience-desc">Twoja firma potrzebuje profesjonalnej obecności w encyklopedii, ale boisz się oskarżeń o kryptoreklamę? Dowiesz się, jak transparentnie zarządzać Konfliktem Interesów (<a href="https://pl.wikipedia.org/wiki/WP:KI">WP:KI</a>) i jak rozmawiać z administratorami, używając ich własnego języka i argumentów.</p>
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
                                        <p class="bonus-desc">Absolwenci szkoleń otrzymują stały dostęp do konsultacji <strong>z 20% zniżką</strong>.</p>
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
                                <div class="pricing-card pricing-card-featured">
                                    <div class="pricing-header">
                                        <h3 class="pricing-title">Szkolenie 'Wikipedia+SEO i nie tylko'</h3>
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

<?php require __DIR__ . '/../includes/testimonials_clients.php'; ?>
<?php require __DIR__ . '/../includes/testimonials_colleagues.php'; ?>

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

<?php
require __DIR__ . '/../includes/about.php';
require __DIR__ . '/../includes/contact_form.php';
require __DIR__ . '/../includes/footer.php';
