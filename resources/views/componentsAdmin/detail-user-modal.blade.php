<div id="detail-user-modal"
     class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4">
        <h3 class="text-xl font-bold text-cyan-600 mb-4">
            Detail Pengguna
        </h3>

        <div class="space-y-2 text-sm">
            <p><strong>Username:</strong> <span id="detail-username"></span></p>
            <p><strong>Email:</strong> <span id="detail-email"></span></p>
            <p><strong>Status:</strong> <span id="detail-status"></span></p>
            <p><strong>Role:</strong> <span id="detail-role"></span></p>
            <p><strong>Hobi:</strong> <span id="detail-hobi"></span></p>
            <p><strong>Bio:</strong></p>
            <p id="detail-bio" class="text-gray-600"></p>

            <div class="flex gap-4 mt-3">
                <p><strong>Followers:</strong> <span id="detail-followers"></span></p>
                <p><strong>Following:</strong> <span id="detail-following"></span></p>
            </div>
        </div>

        <div class="mt-5 text-right">
            <button id="close-detail-user"
                class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
const detailButtons = document.querySelectorAll('.detail-user-btn');
const detailModal = document.getElementById('detail-user-modal');
const closeDetailBtn = document.getElementById('close-detail-user');

// Elemen Text
const dUsername = document.getElementById('detail-username');
const dEmail = document.getElementById('detail-email');
const dStatus = document.getElementById('detail-status');
const dRole = document.getElementById('detail-role');
const dHobi = document.getElementById('detail-hobi');
const dBio = document.getElementById('detail-bio');
const dFollowers = document.getElementById('detail-followers');
const dFollowing = document.getElementById('detail-following');

function openDetailModal(data) {
    dUsername.textContent = data.username;
    dEmail.textContent = data.email;
    dStatus.textContent = data.status;
    dRole.textContent = data.role;
    dHobi.textContent = data.hobi;
    dBio.textContent = data.bio;
    dFollowers.textContent = data.followers;
    dFollowing.textContent = data.following;

    detailModal.classList.remove('hidden');
}

function closeDetailModal() {
    detailModal.classList.add('hidden');
}

// Event tombol detail
detailButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const data = {
            username: this.dataset.username,
            email: this.dataset.email,
            status: this.dataset.status,
            role: this.dataset.role,
            hobi: this.dataset.hobi,
            bio: this.dataset.bio,
            followers: this.dataset.followers,
            following: this.dataset.following
        };

        openDetailModal(data);
    });
});

// Tutup modal
closeDetailBtn.addEventListener('click', closeDetailModal);
detailModal.addEventListener('click', function(e) {
    if (e.target === detailModal) closeDetailModal();
});
</script>
