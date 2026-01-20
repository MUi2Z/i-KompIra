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