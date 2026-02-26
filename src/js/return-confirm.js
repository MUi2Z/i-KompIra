function confirmDelete(url, message = "Adakah anda pasti?") {
    Swal.fire({
        title: 'Pengesahan Padam',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444', 
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Padam!',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'rounded-xl px-4 py-2 font-bold',
            cancelButton: 'rounded-xl px-4 py-2 font-bold'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}