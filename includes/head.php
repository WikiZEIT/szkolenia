<?php
$want_markdown = (
    str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'text/markdown') ||
    ($_GET['format'] ?? '') === 'md'
);
if ($want_markdown) ob_start();
?><!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
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
    <meta property="og:url" content="<?= $page_url ?>" />
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>" />
    <meta property="og:description" content="<?= htmlspecialchars($page_description) ?>" />
    <meta property="og:image" content="<?= $page_image ?>" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="<?= $page_url ?>" />
    <meta name="twitter:title" content="<?= htmlspecialchars($page_title) ?>" />
    <meta name="twitter:description" content="<?= htmlspecialchars($page_description) ?>" />
    <meta name="twitter:image" content="<?= $page_image ?>" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=block" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= $assets_base ?>css/style.css" />
    <link rel="canonical" href="<?= $page_url ?>" />
    <?php if (!empty($page_schema)): ?>
    <script type="application/ld+json">
    <?= $page_schema ?>
    </script>
    <?php endif; ?>
</head>
