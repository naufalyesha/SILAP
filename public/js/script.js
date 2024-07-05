const sidebarToggle = document.querySelector("#sidebar-toggle");
sidebarToggle.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("collapsed");
});

document.querySelector(".theme-toggle").addEventListener("click", () => {
    toggleLocalStorage();
    toggleRootClass();
});

function toggleRootClass() {
    const current = document.documentElement.getAttribute('data-bs-theme');
    const inverted = current == 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-bs-theme', inverted);
}

function toggleLocalStorage() {
    if (isLight()) {
        localStorage.removeItem("light");
    } else {
        localStorage.setItem("light", "set");
    }
}

function isLight() {
    return localStorage.getItem("light");
}

if (isLight()) {
    toggleRootClass();
}

//tambahan profile
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

// Tambahan Reset Password
function resetPassword() {
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (newPassword !== confirmPassword) {
        alert('New passwords do not match!');
        return;
    }

    // Add logic here to handle password reset, e.g., sending the data to the server

    // Tutup modal setelah menyimpan perubahan
    const modal = bootstrap.Modal.getInstance(document.getElementById('resetPasswordModal'));
    modal.hide();
}

// metode pembayaran start
var paymentMethods = [];
var paymentMethodsList = document.getElementById('paymentMethodsList');
var addPaymentMethodForm = document.getElementById('addPaymentMethodForm');

document.getElementById('paymentType').addEventListener('change', function () {
    var paymentType = this.value;
    if (paymentType === 'bank') {
        document.getElementById('bankDetails').style.display = 'block';
        document.getElementById('qrisDetails').style.display = 'none';
    } else if (paymentType === 'qris') {
        document.getElementById('bankDetails').style.display = 'none';
        document.getElementById('qrisDetails').style.display = 'block';
    } else {
        document.getElementById('bankDetails').style.display = 'none';
        document.getElementById('qrisDetails').style.display = 'none';
    }
});

addPaymentMethodForm.addEventListener('submit', function (e) {
    e.preventDefault();
    var paymentType = document.getElementById('paymentType').value;
    var paymentMethod = {
        id: paymentMethods.length + 1,
        type: paymentType
    };

    if (paymentType === 'bank') {
        paymentMethod.bankName = document.getElementById('bankName').value;
        paymentMethod.accountNumber = document.getElementById('accountNumber').value;
    } else if (paymentType === 'qris') {
        var qrisImage = document.getElementById('qrisImage').files[0];
        if (qrisImage) {
            var reader = new FileReader();
            reader.onload = function (e) {
                paymentMethod.qrisImage = e.target.result;
                paymentMethods.push(paymentMethod);
                updatePaymentMethodsList();
            };
            reader.readAsDataURL(qrisImage);
        } else {
            alert('Please upload a QRIS image');
            return;
        }
    }

    if (paymentType === 'bank') {
        paymentMethods.push(paymentMethod);
    }

    updatePaymentMethodsList();
    addPaymentMethodForm.reset();
    document.getElementById('bankDetails').style.display = 'none';
    document.getElementById('qrisDetails').style.display = 'none';
    $('#addPaymentMethodModal').modal('hide'); // Hide the modal after form submission
});

function updatePaymentMethodsList() {
    paymentMethodsList.innerHTML = '';
    paymentMethods.forEach(function (paymentMethod) {
        var row = document.createElement('tr');
        row.innerHTML = `
                    <th scope="row">${paymentMethod.id}</th>
                    <td>${paymentMethod.type === 'bank' ? paymentMethod.bankName : 'QRIS'}</td>
                    <td>${paymentMethod.type === 'bank' ? paymentMethod.accountNumber : '<img src="' + paymentMethod.qrisImage + '" alt="QRIS" width="100">'}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editPaymentMethod(${paymentMethod.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deletePaymentMethod(${paymentMethod.id})">Delete</button>
                    </td>
                `;
        paymentMethodsList.appendChild(row);
    });
}

function editPaymentMethod(id) {
    var paymentMethod = paymentMethods.find(function (method) {
        return method.id === id;
    });

    if (paymentMethod) {
        document.getElementById('paymentType').value = paymentMethod.type;
        if (paymentMethod.type === 'bank') {
            document.getElementById('bankDetails').style.display = 'block';
            document.getElementById('qrisDetails').style.display = 'none';
            document.getElementById('bankName').value = paymentMethod.bankName;
            document.getElementById('accountNumber').value = paymentMethod.accountNumber;
        } else if (paymentMethod.type === 'qris') {
            document.getElementById('bankDetails').style.display = 'none';
            document.getElementById('qrisDetails').style.display = 'block';
        }
        deletePaymentMethod(id);
    }
}

function deletePaymentMethod(id) {
    paymentMethods = paymentMethods.filter(function (method) {
        return method.id !== id;
    });
    updatePaymentMethodsList();
}

// metode pembayaran end