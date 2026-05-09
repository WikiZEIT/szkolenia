<?php
/* Copyright (c) 2026 Jakub T. Jankiewicz
 * All Rights Reserved
 */
$assets_base = './';
$page_title = 'Wikipedia: Konsultacje, Edycje i Szkolenia';
$page_description = 'Szkolenia oraz konsultacje z zakresu edycji Wikipedii, Wikidata i projektów siostrzanych. Profesjonalne wsparcie dla osób oraz firm SEO, PR, i personal brand.';

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/faq.php';

$page_image = OFERTA_URL . 'social-card.png';

$page_url = OFERTA_URL;

require_once __DIR__ . '/includes/contact_handler.php';

$course_id = OFERTA_URL . 'szkolenia/#szkolenie';
$consultation_id = OFERTA_URL . 'konsultacje/#konsultacje';
$service_id = $wikizeit_id . '#service';
$breadcrumb_id = OFERTA_URL . '#breadcrumb';

$offer_catalog = [
    '@type' => 'OfferCatalog',
    'name' => 'Katalog usług Wikipedia + SEO',
    'itemListElement' => [
        ['@id' => $consultation_id],
        ['@id' => $course_id]
    ]
];

$person['hasOfferCatalog'] = $offer_catalog;

$faq = get_all_faq();

$graph = [
    '@context' => 'https://schema.org',
    '@graph' => [
        $person,
        [
            '@type' => 'WebPage',
            '@id' => OFERTA_URL . '#webpage',
            'url' => OFERTA_URL,
            'name' => $page_title,
            'description' => $page_description,
            'author' => ['@id' => $person_id],
            'mainEntity' => [
                ['@id' => $course_id],
                ['@id' => $service_id]
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
            '@type' => 'BreadcrumbList',
            '@id' => $breadcrumb_id,
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => $wikizeit_id . '#webpage',
                    'name' => 'WikiZeit'
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => OFERTA_URL . '#webpage',
                    'name' => 'Szkolenia i Konsultacje'
                ]
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

$show_form_prefill = false;
$show_translate = false;
$show_pricing_calculator = false;
$show_cal = true;

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
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
                                <a class="btn btn-primary btn-hero"
                                   data-cal-link="jcubic/darmowa-konsultacja"
                                   data-cal-namespace="darmowa-konsultacja"
                                   data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}'>
                                    <span>Zarezerwuj wstępną, darmową rozmowę</span>
                                </a>
                            </div>
                        </div>

                        <section class="section">
                            <h2 class="section-title">Usługi i doradztwo</h2>
                            <div class="services-grid">
                                <a href="/oferta/szkolenia/" class="service-card" style="text-decoration:none;color:inherit">
                                    <span class="material-symbols-outlined service-icon">auto_graph</span>
                                    <div class="service-content">
                                        <h3 class="service-title">Szkolenia Wikipedia &amp; SEO</h3>
                                        <p class="service-description">Profesjonalne i komercyjne Szkolenia dla agencji SEO oraz działów PR i marketingu. Nauczę Twój zespół, jak samodzielnie oceniać encyklopedyczność, poruszać się po strukturze technicznej Wikipedii i edytować zgodnie z zasadami społeczności.</p>
                                    </div>
                                    <span class="btn btn-primary"><span>Dowiedz się więcej</span></span>
                                </a>

                                <a href="/oferta/konsultacje/" class="service-card" style="text-decoration:none;color:inherit">
                                    <span class="material-symbols-outlined service-icon">fact_check</span>
                                    <div class="service-content">
                                        <h3 class="service-title">Audyt i Konsultacje</h3>
                                        <p class="service-description">Weryfikacja encyklopedyczności (notability) i analiza źródeł. Dowiesz się, czy Twój temat spełnia wymogi Wikipedii, zanim podejmiesz ryzyko publikacji.</p>
                                    </div>
                                    <span class="btn btn-primary"><span>Dowiedz się więcej</span></span>
                                </a>

                                <a href="/oferta/edycja/" class="service-card" style="text-decoration:none;color:inherit">
                                    <span class="material-symbols-outlined service-icon">verified_user</span>
                                    <div class="service-content">
                                        <h3 class="service-title">Płatna Edycja i Publikacja</h3>
                                        <p class="service-description">Profesjonalne opracowanie i techniczne wdrożenie treści do Wikipedii. Rzetelne zarządzanie wizerunkiem w oparciu o fakty, neutralny punkt widzenia (NPOV) oraz weryfikowalne źródła.</p>
                                    </div>
                                    <span class="btn btn-primary"><span>Dowiedz się więcej</span></span>
                                </a>
                            </div>
                        </section>

<?php
require __DIR__ . '/includes/about.php';
require __DIR__ . '/includes/contact_form.php';
require __DIR__ . '/includes/footer.php';
