<?php

$defaultThumb = (isset($link) && is_object($link)) ? $link->asset('images/vaiicko_logo.png') : '/images/vaiicko_logo.png';

?>

<!-- Styles for this view were moved to public/css/styl.css -->

<div class="home-hero d-flex align-items-center justify-content-between">
    <div>
        <h2 class="mb-1">SuperCook</h2>
        <div>Máte 1 ingrediencii</div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <div class="search-box me-3" style="min-width:360px;">
            <input id="home-search" type="search" class="form-control form-control-lg" placeholder="Nájdite recept alebo prísadu..." aria-label="Nájdite recept alebo prísadu">
        </div>

        <div class="auth-links">
            <a href="<?= $link->url('auth.login') ?>" class="btn btn-link">Login</a>
            <a href="<?= $link->url('auth.register') ?>" class="btn btn-primary">Register</a>
        </div>
    </div>
</div>

<div class="home-layout">
    <aside class="sidebar card p-3">
        <h5>Zelenina <small class="text-muted">1/98 Prísady</small></h5>
        <div class="chips mt-3">
            <span class="chip">cibuľa</span>
            <span class="chip highlight">cesnak</span>
            <span class="chip">zemiaky</span>
            <span class="chip">mrkva</span>
            <span class="chip">paradajky</span>
            <span class="chip">paprika</span>
            <span class="chip">cuketa</span>
            <span class="chip">zeler</span>
            <span class="chip">pór</span>
            <span class="chip">pažítka</span>
            <span class="chip">špenát</span>
            <span class="chip">rukola</span>
            <span class="chip">brokolica</span>
            <span class="chip">kel</span>
            <span class="chip">šalát</span>
        </div>

        <hr />
        <div class="mt-3">
            <h6>Huby <small class="text-muted">0/17 Prísady</small></h6>
            <div class="chips mt-2">
                <span class="chip">šampiňóny</span>
                <span class="chip">kováč</span>
                <span class="chip">lievikovec</span>
                <span class="chip">bedľa</span>
            </div>
        </div>

        <hr />
        <div class="mt-3">
            <h6>Mäso & Ryby <small class="text-muted">5/120 Prísady</small></h6>
            <div class="chips mt-2">
                <span class="chip">kuracie</span>
                <span class="chip">hovädzie</span>
                <span class="chip">bravčové</span>
                <span class="chip">losos</span>
                <span class="chip">tuniak</span>
            </div>
        </div>

        <hr />
        <div class="mt-3">
            <h6>Obilniny & Strukoviny <small class="text-muted">0/40 Prísady</small></h6>
            <div class="chips mt-2">
                <span class="chip">ryža</span>
                <span class="chip">pšeničná múka</span>
                <span class="chip">quinoa</span>
                <span class="chip">cestoviny</span>
                <span class="chip">šošovica</span>
            </div>
        </div>
    </aside>

    <main class="flex-fill main-scroll">
        <div class="card p-3 mb-3">
            <div class="tags">
                <span class="tag">Kľúčové Prísady</span>
                <span class="tag">Vylúčiť</span>
                <span class="tag">Typ Jedla</span>
                <span class="tag">Chýba jedna ingrediencia</span>
                <span class="tag">Iba Video</span>
                <span class="tag">Kuchyňa</span>
            </div>

            <h3 class="mt-3">Môžete vytvoriť 2 receptov</h3>
            <div class="mb-2 text-muted">Máte?</div>
            <div class="chips mb-3">
                <span class="chip">olivový olej</span>
                <span class="chip">rastlinný olej</span>
                <span class="chip">maslo</span>
                <span class="chip">cibuľa</span>
                <span class="chip">citron</span>
                <span class="chip">zemiaky</span>
                <span class="chip">parmezán</span>
            </div>

            <div class="recipes">
                <!-- Added more recipes to show scrolling behavior -->
                <?php for($i=0;$i<12;$i++): ?>
                <div class="recipe-card" data-img="<?= $defaultThumb ?>" data-ingredients="sample">
                    <div class="recipe-thumb bg-light"></div>
                    <div class="recipe-meta" style="flex:1;">
                        <div class="recipe-title">Sample recipe #<?= $i+1 ?></div>
                        <div class="recipe-source">source.example</div>
                        <div class="text-muted">Máte 0 prísad</div>
                    </div>
                    <div class="text-end" style="width:90px;">
                        <button class="btn btn-sm btn-outline-secondary">❤</button>
                    </div>
                </div>
                <?php endfor; ?>

             </div>
        </div>

        <div class="card p-3">
            <h5>Ďalšie recepty</h5>
            <p class="text-muted">Zobrazené položky sú ilustračné — v reálnom projekte by tu boli dynamicky vygenerované recepty.</p>
        </div>
    </main>
</div>

<!-- Slide-over panel + overlay -->
<div id="slide-overlay" class="slide-overlay" aria-hidden="true"></div>
<aside id="slide-panel" class="slide-panel" aria-hidden="true">
    <div id="panel-hero" class="panel-hero" style="background-image: none;">
        <button id="panel-close" class="panel-close" aria-label="Zavrieť">✕</button>
    </div>
    <div class="panel-content">
        <div class="panel-title" id="panel-title">Titulok receptu</div>
        <div class="panel-source" id="panel-source">zdroj.sk</div>
        <div class="panel-small" id="panel-have">Máte všetky ingrediencie</div>

        <div class="panel-ingredients" id="panel-ingredients">
            <h6>Prísady</h6>
            <p id="panel-ingredients-list">cesnak, soľ, olej</p>
        </div>

        <div class="panel-cta">
            <a id="panel-full-link" href="#" class="btn btn-danger btn-block">Pozrieť sa na Celý Recept</a>
        </div>

        <div class="mt-4">
            <h6>Tiež s vám môže páčiť</h6>
            <div class="mt-2">
                <div class="card p-2">
                    <div class="d-flex align-items-center">
                        <div style="width:56px; height:42px; background:#eee; border-radius:5px; margin-right:10px;"></div>
                        <div>
                            <div class="small">Cesnaková pasta (fotorecept)</div>
                            <div class="text-muted small">pravda.sk</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</aside>

<script>
// Panel open/close logic
(function(){
    const overlay = document.getElementById('slide-overlay');
    const panel = document.getElementById('slide-panel');
    const hero = document.getElementById('panel-hero');
    const titleEl = document.getElementById('panel-title');
    const sourceEl = document.getElementById('panel-source');
    const ingredientsEl = document.getElementById('panel-ingredients-list');
    const haveEl = document.getElementById('panel-have');
    const fullLink = document.getElementById('panel-full-link');
    const closeBtn = document.getElementById('panel-close');

    function openPanel(data){
        if(data.img) hero.style.backgroundImage = `url('${data.img}')`;
        else hero.style.backgroundImage = '';
        titleEl.textContent = data.title || '';
        sourceEl.textContent = data.source || '';
        ingredientsEl.textContent = data.ingredients || '';
        haveEl.textContent = data.have || '';
        fullLink.href = data.link || '#';

        overlay.classList.add('open');
        panel.classList.add('open');
        overlay.setAttribute('aria-hidden', 'false');
        panel.setAttribute('aria-hidden', 'false');
    }

    function closePanel(){
        overlay.classList.remove('open');
        panel.classList.remove('open');
        overlay.setAttribute('aria-hidden', 'true');
        panel.setAttribute('aria-hidden', 'true');
    }

    // Attach click to recipe cards
    document.querySelectorAll('.recipe-card').forEach(card => {
        card.addEventListener('click', function(e){
            // ignore clicks on controls like favorite button
            if (e.target.closest('button')) return;

            const title = this.querySelector('.recipe-title')?.innerText || '';
            const source = this.querySelector('.recipe-source')?.innerText || '';
            const note = this.querySelector('.recipe-note')?.innerText || '';
            const img = this.dataset.img || '';
            const ingredients = this.dataset.ingredients || '';

            openPanel({ title: title, source: source, ingredients: ingredients, img: img, have: note || 'Máte všetky ingrediencie', link: '#' });
        });
    });

    // Close handlers
    overlay.addEventListener('click', closePanel);
    closeBtn.addEventListener('click', closePanel);

    // Escape key
    document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closePanel(); });
})();
</script>
