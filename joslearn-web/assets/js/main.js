// JavaScript utama JosLearn.
/* ==========================================================
   assets/js/main.js
   TAMBAHKAN blok ini di AKHIR main.js Anda.
   Hanya aktif jika elemen #npForm ada (halaman new_password).
   ========================================================== */

(function initNewPasswordPage() {
    const form = document.getElementById('npForm');
    if (!form) return;

    const pw       = document.getElementById('npPassword');
    const confirm  = document.getElementById('npConfirm');
    const submit   = document.getElementById('npSubmit');
    const bar      = document.getElementById('npStrengthBar');
    const text     = document.getElementById('npStrengthText');
    const box      = bar.closest('.np-strength');
    const matchMsg = document.getElementById('npMatchMsg');
    const rules    = {
        length: form.querySelector('[data-rule="length"]'),
        mix:    form.querySelector('[data-rule="mix"]'),
        common: form.querySelector('[data-rule="common"]'),
    };

    const COMMON = [
        '12345678', '123456789', '1234567890', 'password', 'password1', 'password123',
        'qwerty123', 'qwertyuiop', 'abc12345', 'admin123', 'guru12345', 'iloveyou1',
        'sekolah123', 'joslearn123', 'rejoso123', '11111111', '00000000'
    ];

    /* ---------- Tombol mata ---------- */
    form.querySelectorAll('.np-eye').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = document.getElementById(btn.dataset.target);
            const show  = input.type === 'password';
            input.type  = show ? 'text' : 'password';
            btn.querySelector('.np-eye__open').hidden = show;
            btn.querySelector('.np-eye__off').hidden  = !show;
        });
    });

    /* ---------- Hitung kekuatan (maks 85%) ---------- */
    function calcStrength(v) {
        if (!v) return 0;
        let s = 0;
        if (v.length >= 8)  s += 25;
        if (v.length >= 12) s += 15;
        if (/[a-z]/.test(v) && /[A-Z]/.test(v)) s += 15;
        if (/\d/.test(v))        s += 15;
        if (/[^A-Za-z0-9]/.test(v)) s += 15;
        if (COMMON.indexOf(v.toLowerCase()) !== -1) s = Math.min(s, 15);
        return s;
    }

    function setRule(el, ok, label) {
        el.classList.toggle('is-met', ok);
        el.querySelector('em').textContent = ok ? '(terpenuhi)' : '(belum terpenuhi)';
        el.dataset.ok = ok ? '1' : '0';
    }

    function updateStrength() {
        const v = pw.value;
        const score = calcStrength(v);
        const level = score < 35 ? 'weak' : (score < 60 ? 'medium' : 'strong');
        const label = { weak: 'Lemah', medium: 'Sedang', strong: 'Kuat' }[level];

        bar.style.width = score + '%';
        box.dataset.level = level;
        text.textContent = v ? label + ' (' + score + '%)' : '-';

        setRule(rules.length, v.length >= 8);
        setRule(rules.mix, /[A-Za-z]/.test(v) && /\d/.test(v));
        setRule(rules.common, v.length > 0 && COMMON.indexOf(v.toLowerCase()) === -1);
    }

    /* ---------- Cek konfirmasi ---------- */
    function updateMatch() {
        const field = confirm.closest('.np-field');
        field.classList.remove('is-ok', 'is-error');
        matchMsg.hidden = true;
        if (!confirm.value) return;

        const same = confirm.value === pw.value;
        field.classList.add(same ? 'is-ok' : 'is-error');
        matchMsg.hidden = false;
        matchMsg.className = 'np-match ' + (same ? 'is-ok' : 'is-error');
        matchMsg.textContent = same ? 'Kata sandi cocok.' : 'Konfirmasi belum sama dengan kata sandi baru.';
    }

    function updateSubmit() {
        const allRules = Object.keys(rules).every(function (k) { return rules[k].dataset.ok === '1'; });
        submit.disabled = !(allRules && confirm.value === pw.value && confirm.value !== '');
    }

    function refresh() { updateStrength(); updateMatch(); updateSubmit(); }

    pw.addEventListener('input', refresh);
    confirm.addEventListener('input', refresh);

    /* ---------- Cegah kirim ganda ---------- */
    form.addEventListener('submit', function (e) {
        if (submit.disabled) { e.preventDefault(); return; }
        submit.disabled = true;
        submit.textContent = 'MENYIMPAN...';
    });

    refresh();
})();