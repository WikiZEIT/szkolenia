<?php
/* Copyright (c) 2026 Jakub T. Jankiewicz
 * All Rights Reserved
 */
$assets_base = '../';
$page_title = 'Płatna Edycja Wikipedii - WikiZEIT';
$page_description = 'Profesjonalne opracowanie i techniczne wdrożenie treści do Wikipedii. Rzetelne zarządzanie wizerunkiem w oparciu o fakty, neutralny punkt widzenia i weryfikowalne źródła.';

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/faq.php';

$page_image = OFERTA_URL . 'social-card-edycja.png';

$page_url = OFERTA_URL . 'edycja/';

require_once __DIR__ . '/../includes/contact_handler.php';

$breadcrumb_id = $page_url . '#breadcrumb';

$faq = get_faq_for_page('edycja');

$graph = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Płatna Edycja Wikipedii',
            'description' => 'Profesjonalne opracowanie i techniczne wdrożenie treści do Wikipedii zgodnie z wymogami społeczności.',
            'provider' => ['@id' => $wikizeit_id]
        ],
        [
            '@type' => 'BreadcrumbList',
            '@id' => $breadcrumb_id,
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'item' => $wikizeit_id . '#webpage', 'name' => 'WikiZeit'],
                ['@type' => 'ListItem', 'position' => 2, 'item' => OFERTA_URL . '#webpage', 'name' => 'Oferta'],
                ['@type' => 'ListItem', 'position' => 3, 'item' => $page_url . '#webpage', 'name' => 'Edycja']
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
$show_pricing_calculator = false;
$show_cal = true;

require __DIR__ . '/../includes/head.php';
require __DIR__ . '/../includes/header.php';
?>
                        <div class="hero-section">
                            <div class="hero-background" style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.5) 100%), url("../background.jpg");'>
                                <div class="hero-content">
                                    <h1 class="hero-title">
                                      Płatna Edycja i Publikacja w Wikipedii
                                    </h1>
                                    <h2 class="hero-subtitle">
                                        Profesjonalne opracowanie i techniczne wdrożenie treści do Wikipedii. Zapewniam rzetelne zarządzanie wizerunkiem w oparciu o fakty, neutralny punkt widzenia (<a href="https://pl.wikipedia.org/wiki/WP:NPOV">WP:NPOV</a>) oraz weryfikowalne źródła.
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
                            <h2 class="section-title">Dla kogo jest płatna edycja?</h2>
                            <ul class="audience-list">
                                <li class="audience-item">
                                    <h3 class="audience-title">Firmy i marki osobiste</h3>
                                    <p class="audience-desc">Potrzebujesz profesjonalnego artykułu w Wikipedii, ale nie masz czasu ani wiedzy, by samodzielnie przejść przez proces publikacji? Zajmę się wszystkim: od badania źródeł po wdrożenie.</p>
                                </li>
                                <li class="audience-item">
                                    <h3 class="audience-title">Agencje PR i SEO</h3>
                                    <p class="audience-desc">Twoi klienci oczekują obecności w Wikipedii jako elementu strategii wizerunkowej? Dostarczam gotowe artykuły zgodne z zasadami społeczności, z pełnym ujawnieniem konfliktu interesów.</p>
                                </li>
                                <li class="audience-item">
                                    <h3 class="audience-title">Startupy i firmy technologiczne</h3>
                                    <p class="audience-desc">Twoja firma osiągnęła rozpoznawalność medialną i chcesz to utrwalić w Wikipedii? Pomogę ocenić gotowość i przygotować artykuł, który przetrwa weryfikację.</p>
                                </li>
                                <li class="audience-item">
                                    <h3 class="audience-title">Osoby publiczne i eksperci</h3>
                                    <p class="audience-desc">Chcesz zadbać o rzetelny biogram w największej encyklopedii świata? Przygotuję treść opartą na faktach i niezależnych źródłach.</p>
                                </li>
                            </ul>
                        </section>

                        <section class="section">
                            <h2 class="section-title">Co obejmuje usługa edycji?</h2>
                            <div class="accordion">
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Badanie i weryfikacja źródeł</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Wyszukiwanie niezależnych, wiarygodnych publikacji potwierdzających encyklopedyczność tematu. Analiza prasy, publikacji naukowych i źródeł branżowych pod kątem wymagań Wikipedii.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Redakcja artykułu w języku Wikipedii</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Przygotowanie treści zgodnej z zasadami neutralnego punktu widzenia (<a href="https://pl.wikipedia.org/wiki/WP:NPOV">WP:NPOV</a>), wikitext i standardami formatowania. Artykuł jest gotowy do publikacji i odporny na cofnięcie przez społeczność.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Dodanie przypisów i kategorii</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Prawidłowe źródłowanie każdego stwierdzenia oraz przypisanie artykułu do odpowiednich kategorii, co zwiększa jego widoczność w Wikipedii i wyszukiwarkach.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Zdjęcia i logo w Wikimedia Commons</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Dodanie logo firmy, zdjęć produktów lub fotografii do Wikimedia Commons z odpowiednimi licencjami. Pliki multimedialne są następnie powiązane z artykułem w Wikipedii i elementem w Wikidata, wzmacniając spójność marki w ekosystemie Wikimedia.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Utworzenie i aktualizacja wpisu w Wikidata</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Dodanie lub aktualizacja elementu w Wikidata z pełnym zestawem właściwości. Poprawny wpis w Wikidata zwiększa szanse na pojawienie się w Grafie Wiedzy Google i jest wykorzystywany przez asystentów AI.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Powiązanie stron między projektami Wikimedia</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Połączenie artykułu w Wikipedii z elementem w Wikidata, plikami w Wikimedia Commons i wersjami językowymi. Taka sieć powiązań buduje kompletny profil marki widoczny dla wyszukiwarek i modeli AI.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Aktualizacja istniejących informacji</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Uaktualnienie nieaktualnych danych w istniejących artykułach Wikipedii i wpisach Wikidata. Uzupełnienie brakujących informacji, poprawienie błędów rzeczowych i dodanie nowych źródeł.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Publikacja i monitorowanie</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Wdrożenie artykułu do Wikipedii oraz obserwacja reakcji społeczności w pierwszych tygodniach. W razie potrzeby szybka reakcja na uwagi redaktorów.</p>
                                </details>
                            </div>
                        </section>

                        <section class="section">
                            <h2 class="section-title">Cennik</h2>
                            <div class="pricing-grid">
                                <div class="pricing-card">
                                    <h3 class="pricing-title">Płatna Edycja i Publikacja</h3>
                                    <p class="pricing-description">Profesjonalne opracowanie i techniczne wdrożenie treści do Wikipedii zgodnie z wymogami społeczności.</p>
                                    <div class="pricing-amount">
                                        <p class="pricing-name">Edycja</p>
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
                                    <a href="#kontakt" class="btn btn-primary btn-full" data-subject="Płatna Edycja Wikipedii" data-body="Jestem zainteresowany płatną edycją artykułu w Wikipedii.">
                                        <span>Zapytaj o szczegóły</span>
                                    </a>
                                </div>
                                <div class="pricing-card">
                                    <h3 class="pricing-title">Współpraca Merytoryczna</h3>
                                    <p class="pricing-description">Bezpłatna edycja Wikipedii i konsultacje w zamian za wzajemną promocję i link zwrotny na stronie partnera.</p>
                                    <div class="pricing-amount">
                                        <p class="pricing-name">Współpraca</p>
                                        <p class="pricing-price">do negocjacji</p>
                                    </div>
                                    <ul class="pricing-features">
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Edycja i publikacja artykułu w Wikipedii</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Konsultacja i audyt encyklopedyczności</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Wsparcie w zakresie Wikidata i Wikimedia Commons</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>W zamian za link zwrotny lub wzmiankę na stronie partnera</span>
                                        </li>
                                    </ul>
                                    <a href="#kontakt" class="btn btn-primary btn-full" data-subject="Współpraca merytoryczna" data-body="Jestem zainteresowany współpracą merytoryczną.">
                                        <span>Zapytaj o współpracę</span>
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
