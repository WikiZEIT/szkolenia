# Wikipedia Landing Page — Project Notes

## Overview

Landing page for Wikipedia SEO/Consulting/Training services. The entire site lives in a **single file**.

## Key File

- **`index.php`** — the only file to edit; contains all PHP, HTML, CSS, and JS in one place
- `avatar-sm.jpg` — author photo used in the "O mnie" section
- `original/` — original reference files (index.html, styles.css); do not edit

## Rules

- All changes go into `index.php` only — never split into separate files
- JavaScript must be **inline at the bottom** of the file, before `</body>`
- `localStorage` keys must use the **`wikipedia:` prefix** (e.g. `wikipedia:colorScheme`) to avoid conflicts with other apps on the same server
- The site is served at `https://wikizeit.jcubic.pl/oferta/`
- The PHP/Allegro code at the top of the file is **unused** — do not remove it

## Architecture Notes

- The `$faq` PHP array at the top of the file drives both the HTML rendering (via `foreach`) and the JSON-LD `FAQPage` schema in `<head>`
- Dark mode class `dark` is set on `<html>`, not `<body>` — use `html.dark` selectors, not `.dark body`
- A small inline `<script>` in `<head>` reads `localStorage` and applies the `dark` class before render to prevent FOUC
- LSP/linter errors in the file are false positives — the linter misidentifies mixed PHP/HTML/CSS as JavaScript

## Features Implemented

1. **FAQ section** — between "O mnie" and the contact form; uses `<details>`+`<summary>` with `.accordion` classes; defined as `$faq` PHP array
2. **JSON-LD FAQPage** — auto-generated in `<head>` from the `$faq` array
3. **Pricing buttons JS** — clicking a pricing button fills the "Temat" field in the contact form using the button's `data-title` attribute
4. **Pricing class names** — `.pricing-name` (title, 2.25rem, grey), `.pricing-price` (price, 1.25rem, `--color-primary`)
5. **Training program** — 6 points: Historia i zasady, Encyklopedyczność, Tworzenie artykułu, Źródła i przypisy, Linki/SEO, Prawo autorskie
6. **Form messages** — success (green, ✅) and error (red, ❌) displayed above the submit button
7. **Dark mode toggle** — Material Icons icon in the header; default follows `prefers-color-scheme`; saved to `localStorage`
8. **Footer link color** — fixed for dark mode (inherits grey instead of browser default blue)

## Manual Tasks (owner)

- Add new FAQ entries to the `$faq` array in `index.php`
- Update `data-title` attribute values on pricing buttons to match desired form prefill text
