<div id="detail-post-modal"
     class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg mx-4 overflow-y-auto max-h-[90vh]">
        <h3 class="text-xl font-bold text-cyan-600 mb-4">
            Detail Post
        </h3>

        <!-- Author -->
        <div class="mb-3 text-sm text-gray-600">
            <strong>Author:</strong>
            <span id="detail-post-username"></span>
        </div>

        <!-- Image -->
        <div id="detail-post-image-wrapper" class="mb-4 hidden">
            <img id="detail-post-image"
                 src=""
                 alt="Post Image"
                 class="w-full rounded-lg object-cover max-h-64">
        </div>

        <!-- Content -->
        <div class="mb-4">
            <p class="text-sm font-medium text-gray-700 mb-1">Content</p>
            <p id="detail-post-content" class="text-gray-800 whitespace-pre-line"></p>
        </div>

        <!-- Meta -->
        <div class="grid grid-cols-2 gap-3 text-sm mb-4">
            <p><strong>Status:</strong> <span id="detail-post-status"></span></p>
            <p><strong>Views:</strong> <span id="detail-post-views"></span></p>
            <p><strong>Likes:</strong> <span id="detail-post-likes"></span></p>
            <p><strong>Bookmarks:</strong> <span id="detail-post-bookmarks"></span></p>
        </div>

        <div class="text-right">
            <button id="close-detail-post"
                class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
/**
 * DETAIL POST MODAL
 * Aman walau di-include di file partial
 */
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('detail-post-modal');
    const closeBtn = document.getElementById('close-detail-post');

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.detail-post-btn');
        if (!btn) return;

        e.preventDefault();

        document.getElementById('detail-post-username').textContent =
            btn.dataset.userName || '-';

        document.getElementById('detail-post-content').textContent =
            btn.dataset.content || '-';

        document.getElementById('detail-post-status').textContent =
            btn.dataset.status || '-';

        document.getElementById('detail-post-views').textContent =
            btn.dataset.view || '0';

        document.getElementById('detail-post-likes').textContent =
            btn.dataset.likes || '0';

        document.getElementById('detail-post-bookmarks').textContent =
            btn.dataset.bookmark || '0';

        // Image handling
        const imageWrapper = document.getElementById('detail-post-image-wrapper');
        const imageEl = document.getElementById('detail-post-image');

        if (btn.dataset.imageUrl) {
            imageEl.src = btn.dataset.imageUrl;
            imageWrapper.classList.remove('hidden');
        } else {
            imageEl.src = '';
            imageWrapper.classList.add('hidden');
        }

        modal.classList.remove('hidden');
    });

    closeBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) modal.classList.add('hidden');
    });
});
</script>
