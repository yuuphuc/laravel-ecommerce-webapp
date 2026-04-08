(function () {
    const IS_ADMIN = window.location.pathname.startsWith('/admin');

    // ── Fade in khi trang load xong ──
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.2s ease';
    requestAnimationFrame(() => {
        document.body.style.opacity = '1';
    });

    // ── Intercept click ──
    document.addEventListener('click', function (e) {
        const link = e.target.closest('a[href]');
        if (!link) return;
        if (link.hostname !== location.hostname) return; // link ngoài
        if (link.target === '_blank') return;            // tab mới
        if (link.getAttribute('href')?.startsWith('#')) return; // anchor
        if (link.getAttribute('href')?.startsWith('javascript')) return;

        const targetIsAdmin = link.pathname.startsWith('/admin');

        // Nếu chuyển giữa 2 khu vực khác nhau → reload có animation
        if (IS_ADMIN !== targetIsAdmin) {
            e.preventDefault();
            document.body.style.transition = 'opacity 0.15s ease';
            document.body.style.opacity = '0';
            setTimeout(() => { location.href = link.href; }, 150);
            return;
        }

        // Nếu cùng khu vực → AJAX swap
        e.preventDefault();
        navigateTo(link.href);
    });

    // ── Back / Forward ──
    window.addEventListener('popstate', function (e) {
        navigateTo(e.state?.url || location.href, false);
    });

    // ── Hàm navigate AJAX ──
    async function navigateTo(url, pushState = true) {
        // Fade out
        document.body.style.transition = 'opacity 0.15s ease';
        document.body.style.opacity = '0';

        try {
            const res = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!res.ok) throw new Error('Response not ok');

            const html = await res.text();
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');

            // Update title
            document.title = newDoc.title;

            // Swap nội dung main (không swap toàn body để giữ CSS/JS)
            const newMain = newDoc.querySelector('div.container.mt-4') // client
                         || newDoc.querySelector('main.container-fluid'); // admin

            const currentMain = document.querySelector('div.container.mt-4')
                             || document.querySelector('main.container-fluid');

            if (newMain && currentMain) {
                currentMain.innerHTML = newMain.innerHTML;
            } else {
                // Fallback: swap toàn body
                document.body.innerHTML = newDoc.body.innerHTML;
            }

            // Update URL
            if (pushState) {
                history.pushState({ url }, '', url);
            }

            // Re-init scripts nếu cần
            reinitScripts();

        } catch (err) {
            // Fallback an toàn
            location.href = url;
            return;
        }

        // Fade in
        requestAnimationFrame(() => {
            document.body.style.transition = 'opacity 0.2s ease';
            document.body.style.opacity = '1';
        });
    }

    // ── Re-init các script cần thiết sau khi swap DOM ──
    function reinitScripts() {
        // Re-bind cart buttons (client)
        document.querySelectorAll('.btn-increase, .btn-decrease').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                // Logic cart update giữ nguyên
            });
        });

        // Scroll về đầu trang
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

})();