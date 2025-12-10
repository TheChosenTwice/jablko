// Client-side helpers: password strength, toggle visibility, AJAX username/email availability, form validation
(function(){
    // Utility: debounce
    function debounce(fn, wait){
        let t;
        return function(...args){ clearTimeout(t); t = setTimeout(()=>fn.apply(this,args), wait); };
    }

    // Password strength meter (very simple)
    function strengthScore(pw){
        let score = 0;
        if (!pw) return score;
        if (pw.length >= 8) score += 1;
        if (/[A-Z]/.test(pw)) score += 1;
        if (/[0-9]/.test(pw)) score += 1;
        if (/[^A-Za-z0-9]/.test(pw)) score += 1;
        return score; // 0..4
    }

    function setupPasswordHelpers(){
        document.querySelectorAll('input[type=password]').forEach(input => {
            // add toggle button
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-sm btn-outline-secondary';
            btn.style.position = 'absolute';
            btn.style.right = '8px';
            btn.style.top = '50%';
            btn.style.transform = 'translateY(-50%)';
            btn.textContent = 'Show';
            wrapper.appendChild(btn);

            btn.addEventListener('click', function(){
                if (input.type === 'password') { input.type='text'; btn.textContent='Hide'; }
                else { input.type='password'; btn.textContent='Show'; }
            });

            // strength meter for fields with id 'password'
            if (input.id === 'password' || input.name === 'password'){
                const meter = document.createElement('div');
                meter.className = 'pw-meter mt-2';
                meter.style.height='6px';
                meter.style.background='#e9ecef';
                meter.innerHTML = '<div class="pw-fill" style="height:100%; width:0; background:#f00"></div>';
                wrapper.parentNode.insertBefore(meter, wrapper.nextSibling);

                input.addEventListener('input', function(){
                    const s = strengthScore(input.value);
                    const fill = meter.querySelector('.pw-fill');
                    fill.style.width = (s/4*100) + '%';
                    fill.style.background = s <= 1 ? '#f44336' : s === 2 ? '#ff9800' : s === 3 ? '#8bc34a' : '#4caf50';
                });
            }
        });
    }

    // AJAX availability check
    function setupAvailabilityChecks(){
        const checkUrl = '?c=auth&a=check';
        const usernameEl = document.getElementById('username');
        const emailEl = document.getElementById('email');
        if (usernameEl){
            const show = document.createElement('div'); show.className='form-text text-muted'; usernameEl.parentNode.appendChild(show);
            usernameEl.addEventListener('input', debounce(function(){
                const v = this.value.trim(); if (!v) { show.textContent=''; return; }
                fetch(checkUrl + '&field=username&value=' + encodeURIComponent(v))
                    .then(r=>r.json())
                    .then(j=>{ show.textContent = j.available ? 'Username available' : 'Username already taken'; show.style.color = j.available ? 'green' : 'red'; })
                    .catch(()=>{ show.textContent = ''; });
            }, 400));
        }
        if (emailEl){
            const showE = document.createElement('div'); showE.className='form-text text-muted'; emailEl.parentNode.appendChild(showE);
            emailEl.addEventListener('input', debounce(function(){
                const v = this.value.trim(); if (!v) { showE.textContent=''; return; }
                fetch(checkUrl + '&field=email&value=' + encodeURIComponent(v))
                    .then(r=>r.json())
                    .then(j=>{ showE.textContent = j.available ? 'Email available' : 'Email already in use'; showE.style.color = j.available ? 'green' : 'red'; })
                    .catch(()=>{ showE.textContent = ''; });
            }, 400));
        }
    }

    // Attach to forms to prevent submission if client-side validation fails
    function setupFormGuards(){
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e){
                // simple check: required fields
                const invalid = form.querySelectorAll(':invalid');
                if (invalid.length > 0){
                    invalid[0].focus();
                    e.preventDefault();
                    return false;
                }
                // password match check if password2 exists
                const pw = form.querySelector('input[name=password]');
                const p2 = form.querySelector('input[name=password2]');
                if (pw && p2 && pw.value !== p2.value){
                    e.preventDefault();
                    alert('Passwords do not match');
                    p2.focus();
                    return false;
                }
            });
        });
    }

    // Initialize when DOM ready
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
    function init(){
        setupPasswordHelpers();
        setupAvailabilityChecks();
        setupFormGuards();
        setupChipInteractions();
    }

    // Chip interactions: hover styling class and selected state toggle
    function setupChipInteractions(){
        document.querySelectorAll('.chips .chip').forEach(chip => {
            chip.setAttribute('tabindex', '0'); // make focusable
            chip.addEventListener('mouseenter', () => chip.classList.add('chip-hover'));
            chip.addEventListener('mouseleave', () => chip.classList.remove('chip-hover'));
            chip.addEventListener('click', () => {
                const selected = chip.classList.toggle('selected');
                // if unselected now, remove any selection data attribute
                if (!selected) chip.removeAttribute('data-selected'); else chip.setAttribute('data-selected','1');
            });
            // keyboard support (Space or Enter)
            chip.addEventListener('keydown', (e) => {
                if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); chip.click(); }
            });
        });
    }

})();
