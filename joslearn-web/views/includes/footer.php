<?php
/**
 * views/includes/footer.php
 * Menutup area konten, layout, dan dokumen HTML yang dibuka oleh header.php.
 * Footer tidak menampilkan teks agar tidak tertutup bar simpan di bagian bawah halaman.
 */
if (!function_exists('jl_url')) {
    function jl_url($route = '') {
        $base = defined('BASE_URL') ? rtrim(BASE_URL, '/') . '/' : '/';
        return $base . ltrim($route, '/');
    }
}
?>
        </main><!-- /.jl-content -->
    </div><!-- /.jl-main -->
</div><!-- /.jl-app -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= htmlspecialchars(jl_url('assets/js/main.js'), ENT_QUOTES, 'UTF-8') ?>"></script>
<script>
(function () {
    // Buka/tutup sidebar di layar kecil
    var sb = document.getElementById('jlSidebar');
    var bd = document.getElementById('jlBackdrop');
    var tg = document.getElementById('jlToggle');
    function toggle(open) {
        if (!sb) return;
        sb.classList.toggle('is-open', open);
        bd.classList.toggle('is-open', open);
    }
    if (tg) tg.addEventListener('click', function () { toggle(!sb.classList.contains('is-open')); });
    if (bd) bd.addEventListener('click', function () { toggle(false); });

    // Pintasan Ctrl/Cmd + K untuk fokus ke kolom pencarian topbar
    var search = document.getElementById('jlSearch');
    var kbd = document.getElementById('jlKbd');
    if (kbd && /Mac|iPhone|iPad/.test(navigator.platform)) kbd.textContent = '⌘K';
    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k' && search) {
            e.preventDefault();
            search.focus();
        }
    });
})();
</script>
</body>
</html>