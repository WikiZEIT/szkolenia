<?php
/* Copyright (c) 2026 Jakub T. Jankiewicz
 * All Rights Reserved
 */
$assets_base = '../';
$page_title = 'Konsultacje i Audyt Wikipedia - WikiZEIT';
$page_description = 'Indywidualne konsultacje i audyt encyklopedyczności. Weryfikacja źródeł, analiza notability i strategia obecności w Wikipedii dla firm i marek osobistych.';

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/faq.php';

$page_image = OFERTA_URL . 'social-card-konsultacje.png';

$page_url = OFERTA_URL . 'konsultacje/';

require_once __DIR__ . '/../includes/contact_handler.php';

$service_id = $wikizeit_id . '#service';
$consultation_id = $page_url . '#konsultacje';
$breadcrumb_id = $page_url . '#breadcrumb';

$faq = get_faq_for_page('konsultacje');

$graph = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            '@id' => $service_id,
            'name' => 'Konsultacje Wikipedia SEO',
            'description' => 'Indywidualne konsultacje, audyt encyklopedyczności oraz płatne edycje Wikipedii dla firm i marek osobistych.',
            'provider' => ['@id' => $wikizeit_id]
        ],
        [
            '@type' => 'Offer',
            '@id' => $consultation_id,
            'price' => '250.00',
            'priceCurrency' => 'PLN',
            'itemOffered' => ['@id' => $service_id]
        ],
        [
            '@type' => 'BreadcrumbList',
            '@id' => $breadcrumb_id,
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'item' => $wikizeit_id . '#webpage', 'name' => 'WikiZeit'],
                ['@type' => 'ListItem', 'position' => 2, 'item' => OFERTA_URL . '#webpage', 'name' => 'Oferta'],
                ['@type' => 'ListItem', 'position' => 3, 'item' => $page_url . '#webpage', 'name' => 'Konsultacje']
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
                                      Konsultacje i Audyt Wikipedii
                                    </h1>
                                    <h2 class="hero-subtitle">
                                        Indywidualne sesje strategiczne, audyt encyklopedyczności i analiza źródeł. Dowiesz się, czy Twój temat spełnia wymogi Wikipedii, zanim podejmiesz ryzyko publikacji.
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
                            <h2 class="section-title">Dla kogo są konsultacje?</h2>
                            <ul class="audience-list">
                                <li class="audience-item">
                                    <h3 class="audience-title">Firmy planujące wejście do Wikipedii</h3>
                                    <p class="audience-desc">Chcesz wiedzieć, czy Twoja firma lub marka osobista spełnia kryteria encyklopedyczności? Audyt przed publikacją oszczędza czas i chroni przed usunięciem artykułu.</p>
                                </li>
                                <li class="audience-item">
                                    <h3 class="audience-title">Właściciele istniejących artykułów</h3>
                                    <p class="audience-desc">Twój artykuł został oznaczony do usunięcia lub edycja została cofnięta? Pomogę zrozumieć przyczyny i zaproponować strategię naprawy.</p>
                                </li>
                                <li class="audience-item">
                                    <h3 class="audience-title">Agencje SEO i PR</h3>
                                    <p class="audience-desc">Potrzebujesz eksperckiej opinii na temat strategii obecności klienta w Wikipedii i Wikidata? Konsultacja pozwoli uniknąć kosztownych błędów i blokad kont.</p>
                                </li>
                                <li class="audience-item">
                                    <h3 class="audience-title">Specjaliści budujący Graf Wiedzy</h3>
                                    <p class="audience-desc">Chcesz, aby Twoja marka pojawiła się w panelu Knowledge Graph Google? Wskażę najskuteczniejszą ścieżkę: Wikipedia, Wikidata, Schema.org.</p>
                                </li>
                            </ul>
                        </section>

                        <section class="section">
                            <h2 class="section-title">Zakres konsultacji</h2>
                            <div class="accordion">
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Audyt encyklopedyczności (notability)</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Ocena, czy dany temat spełnia kryteria Wikipedii na podstawie niezależnych, wiarygodnych źródeł. Otrzymasz jasną odpowiedź i listę brakujących elementów.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Analiza źródeł i referencji</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Przegląd dostępnych publikacji prasowych, naukowych i branżowych pod kątem wymagań Wikipedii. Wskażę, które źródła spełniają kryteria, a które wymagają uzupełnienia.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Strategia obecności w ekosystemie Wikimedia</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Plan działania obejmujący Wikipedię, Wikidata i Wikimedia Commons. Określenie priorytetów i kolejności kroków, aby zbudować spójną obecność marki w projektach Wikimedia.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Wsparcie w komunikacji ze społecznością</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Pomoc w rozmowach z administratorami i redaktorami Wikipedii. Przygotuję odpowiednie argumenty i terminologię, aby komunikacja była skuteczna i zgodna z uzusem społeczności.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Audyt istniejącego artykułu</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Przegląd treści, struktury, źródeł i zgodności z zasadami <a href="https://pl.wikipedia.org/wiki/WP:NPOV">WP:NPOV</a> i <a href="https://pl.wikipedia.org/wiki/WP:WER">WP:WER</a>. Raport z konkretnymi rekomendacjami poprawek i uzupełnień.</p>
                                </details>
                                <details class="accordion-item">
                                    <summary class="accordion-summary">
                                        <h3 class="accordion-title">Widoczność marki w AI dzięki projektom Wikimedia</h3>
                                        <span class="material-symbols-outlined accordion-icon">expand_more</span>
                                    </summary>
                                    <p class="accordion-content">Modele AI (ChatGPT, Gemini, Perplexity) czerpią wiedzę z Wikipedii i Wikidata. Pomogę zadbać o to, aby informacje o Twojej marce w tych źródłach były kompletne, aktualne i poprawne — co bezpośrednio wpływa na odpowiedzi generowane przez AI (GEO &ndash; Generative Engine Optimization).</p>
                                </details>
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
                                    <a href="#kontakt" class="btn btn-primary btn-full" data-subject="Konsultacje z Wikipedii" data-body="Jestem zainteresowany konsultacjami z Wikipedii.">
                                        <span>Zapytaj o szczegóły</span>
                                    </a>
                                </div>
                                <div class="pricing-card">
                                    <h3 class="pricing-title">Współpraca Merytoryczna</h3>
                                    <p class="pricing-description">Bezpłatna konsultacja i audyt w zamian za wzajemną promocję i link zwrotny na stronie partnera.</p>
                                    <div class="pricing-amount">
                                        <p class="pricing-name">Współpraca</p>
                                        <p class="pricing-price">do negocjacji</p>
                                    </div>
                                    <ul class="pricing-features">
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Konsultacja i audyt encyklopedyczności</span>
                                        </li>
                                        <li class="pricing-feature">
                                            <span class="material-symbols-outlined feature-icon">check_circle</span>
                                            <span>Analiza źródeł i strategia obecności w Wikipedii</span>
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
