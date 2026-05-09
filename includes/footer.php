                    </main>

                    <footer class="footer">
                        <div class="footer-content">
                          <p class="footer-copyright">© 2025-<?= date('Y') ?> <a href="https://jakub.jankiewicz.org">Jakub T. Jankiewicz</a>.</p>
                          <div class="footer-links">
                              <ul>
                                  <li><a class="footer-link" href="/">WikiZEIT</a></li>
                                  <li><a class="footer-link" href="/oferta/">Oferta</a></li>
                                  <li><a class="footer-link" href="/privacy/">Prywatność</a></li>
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
    </script>
    <?php if (!empty($show_form_prefill)): ?>
    <script>
        document.querySelectorAll('.btn[data-subject]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var title = this.dataset.subject;
                var body = this.dataset.body ?? '';
                document.getElementById('subject').value = title;
                document.getElementById('message').value = body;
            });
        });
    </script>
    <?php endif; ?>
    <?php if (!empty($show_translate)): ?>
    <script>
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
    </script>
    <?php endif; ?>
    <?php if (!empty($show_pricing_calculator)): ?>
    <script>
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
            if (!groupPriceEl) return;
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
    <?php endif; ?>
    <?php if (!empty($show_cal)): ?>
    <!-- Cal.com element-click embed -->
    <script type="text/javascript">
      (function (C, A, L) { let p = function (a, ar) { a.q.push(ar); }; let d = C.document; C.Cal = C.Cal || function () { let cal = C.Cal; let ar = arguments; if (!cal.loaded) { cal.ns = {}; cal.q = cal.q || []; d.head.appendChild(d.createElement("script")).src = A; cal.loaded = true; } if (ar[0] === L) { const api = function () { p(api, arguments); }; const namespace = ar[1]; api.q = api.q || []; if(typeof namespace === "string"){cal.ns[namespace] = cal.ns[namespace] || api;p(cal.ns[namespace], ar);p(cal, ["initNamespace", namespace]);} else p(cal, ar); return;} p(cal, ar); }; })(window, "https://app.cal.eu/embed/embed.js", "init");
      Cal("init", "darmowa-konsultacja", {origin:"https://app.cal.eu"});
      Cal.ns["darmowa-konsultacja"]("ui", {"hideEventTypeDetails":false,"layout":"month_view"});
    </script>
    <?php endif; ?>
    <script defer src="https://umami.jcubic.pl/script.js" data-website-id="c716ef1c-b60b-455c-8279-58996a09a8a6"></script>
    <script>
      function track(event, data) {
        var umami = globalThis.umami;
        if (umami) {
          umami.track(event, data);
        }
      }
      var calLink = document.querySelector('[data-cal-link]');
      if (calLink) {
          calLink.addEventListener('click', function() {
              track('CTA', { action: 'darmowa-rozmowa' });
          });
      }
    </script>
</body>
</html>
<?php
if ($want_markdown) {
    $html = ob_get_clean();
    preg_match('/<main[^>]*>(.*?)<\/main>/s', $html, $m);
    $main_html = $m[1] ?? '';
    $main_html = preg_replace('/<script[\s\S]*?<\/script>/i', '', $main_html);
    $main_html = preg_replace('/<form[\s\S]*?<\/form>/i', '', $main_html);
    $main_html = preg_replace('/<style[\s\S]*?<\/style>/i', '', $main_html);

    require_once __DIR__ . '/../vendor/autoload.php';
    $converter = new \League\HTMLToMarkdown\HtmlConverter([
        'strip_tags' => true,
        'hard_break' => true,
    ]);
    $markdown = $converter->convert($main_html);

    header('Content-Type: text/markdown; charset=utf-8');
    echo $markdown;
}
