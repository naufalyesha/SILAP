document.querySelectorAll('.faq-question').forEach(item => {
    item.addEventListener('click', event => {
        const currentlyActive = document.querySelector('.faq-question.active');
        if (currentlyActive && currentlyActive !== item) {
            currentlyActive.classList.toggle('active');
            currentlyActive.nextElementSibling.style.display = 'none';
        }

        item.classList.toggle('active');
        const answer = item.nextElementSibling;
        if (item.classList.contains('active')) {
            answer.style.display = 'block';
        } else {
            answer.style.display = 'none';
        }
    });
});

function saveProfile() {
    const nama = document.getElementById('editNama').value;
    const alamat = document.getElementById('editAlamat').value;
    const nomorHandphone = document.getElementById('editNomorHandphone').value;
    const email = document.getElementById('editEmail').value;

    document.querySelector('.profile-info h4').innerText = `Nama: ${nama}`;
    document.querySelector('.profile-info p:nth-child(2)').innerText = `Alamat: ${alamat}`;
    document.querySelector('.profile-info p:nth-child(3)').innerText = `Nomor Handphone: ${nomorHandphone}`;
    document.querySelector('.profile-info p:nth-child(4)').innerText = `Email: ${email}`;

    // Tutup modal setelah menyimpan perubahan
    const modal = bootstrap.Modal.getInstance(document.getElementById('profileModal'));
    modal.hide();
}