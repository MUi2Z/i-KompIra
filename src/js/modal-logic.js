function toggleModal(modalId, cardId) {
    const modal = document.getElementById(modalId);
    const card = document.getElementById(cardId);

    if (modal.classList.contains('hidden')) {
        // 1. Tunjukkan modal
        modal.classList.remove('hidden');
        
        // 2. Benarkan tetikus berinteraksi dengan modal (PENTING)
        modal.classList.remove('pointer-events-none');
        modal.classList.add('pointer-events-auto');

        // 3. Jalankan animasi
        setTimeout(() => {
            card.classList.remove('scale-95', 'opacity-0', 'translate-y-4');
            card.classList.add('scale-100', 'opacity-100', 'translate-y-0');
        }, 10);
    } else {
        // 1. Jalankan animasi keluar
        card.classList.add('scale-95', 'opacity-0', 'translate-y-4');
        card.classList.remove('scale-100', 'opacity-100', 'translate-y-0');

        // 2. Sekat interaksi tetikus semula
        modal.classList.add('pointer-events-none');
        modal.classList.remove('pointer-events-auto');

        // 3. Sembunyikan selepas animasi tamat
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
}

function openEditModal(modalId, cardId, data) {
    const modal = document.getElementById(modalId);
    if (!modal) return; // Guard clause jika modal tak wujud

    // 1. Reset sebarang preview gambar sedia ada dahulu
    const previewImg = modal.querySelector('#preview_img');
    const previewContainer = modal.querySelector('#preview_container');
    if (previewContainer) previewContainer.classList.add('hidden');

    // 2. Loop setiap data yang dihantar
    for (const key in data) {
        const input = modal.querySelector(`#edit_${key}`);
        
        if (input) {
            // Jika elemen adalah checkbox
            if (input.type === 'checkbox') {
                input.checked = data[key] == 1 || data[key] == true;
            } 
            // Untuk input biasa, select, dan textarea
            else {
                input.value = data[key];
            }
        }
    }

    // 3. Logik Preview Gambar yang lebih mantap
    // Kita anggap data.imagePath mengandungi URL penuh atau path gambar
    if (previewImg && data.imagePath && data.imagePath.trim() !== "") {
        previewImg.src = data.imagePath;
        if (previewContainer) previewContainer.classList.remove('hidden');
    }

    // 4. Panggil fungsi toggle asal
    toggleModal(modalId, cardId);
}