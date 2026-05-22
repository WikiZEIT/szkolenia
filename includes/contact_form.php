                        <section class="section contact-section" id="kontakt">
                            <div class="contact-header">
                                <h2 class="contact-title">Kontakt</h2>
                                <p class="contact-subtitle">Masz pytanie lub chcesz omówić swój projekt? Wypełnij formularz, a skontaktuję się z Tobą jak najszybciej.</p>
                            </div>
                            <form class="contact-form" method="POST">
                                <div class="form-group email-confirmation-field" aria-hidden="true">
                                    <label class="form-label" for="email_confirmation">Potwierdź email</label>
                                    <input class="form-input" type="text" id="email_confirmation" name="email_confirmation" placeholder="jan@example.com" tabindex="-1" autocomplete="off"/>
                                </div>
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
                                    <label class="form-label" for="website">Strona / marka (opcjonalnie)</label>
                                    <input class="form-input" id="website" name="website" placeholder="https://example.com lub nazwa firmy" type="text"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="subject">Temat</label>
                                    <input class="form-input" id="subject" name="subject" required placeholder="Pytanie dotyczące szkolenia" type="text"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="message">Wiadomość</label>
                                    <textarea class="form-textarea" id="message" name="message" required placeholder="Twoja wiadomość..." rows="4"></textarea>
                                </div>
                                <div class="form-group form-checkbox-group">
                                    <label class="form-checkbox-label">
                                        <input type="checkbox" name="send_copy" value="1" checked/>
                                        <span>Wyślij mi kopię wiadomości</span>
                                    </label>
                                </div>
                                <p class="privacy-notice">Wysyłając wiadomość, akceptujesz naszą <a href="/privacy/">politykę prywatności</a>.</p>
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
