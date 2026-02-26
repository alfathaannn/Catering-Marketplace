(function () {
    // ambil elemen penting
    const merchantBtn = document.getElementById("merchantBtn");
    const customerBtn = document.getElementById("customerBtn");

    // event listener merchant
    if (merchantBtn) {
        merchantBtn.addEventListener("click", function (e) {
            e.preventDefault(); // meski bukan link, untuk jaga

            // opsi: beri sedikit efek pada tombol (opsional, selain dari css)
            merchantBtn.style.transition = "all 0.1s";
            merchantBtn.style.transform = "scale(0.98)";
            setTimeout(() => {
                merchantBtn.style.transform = "scale(1)";
                window.location.href = merchantBtn.href;
            }, 150);

            // blur fokus agar tidak ada outline berlebih (opsional)
            merchantBtn.blur();
        });
    }

    // event listener customer
    if (customerBtn) {
        customerBtn.addEventListener("click", function (e) {
            e.preventDefault();

            customerBtn.style.transition = "all 0.1s";
            customerBtn.style.transform = "scale(0.98)";
            setTimeout(() => {
                customerBtn.style.transform = "scale(1)";
                window.location.href = customerBtn.href;
            }, 150);

            customerBtn.blur();
        });
    }

    // tambahan: sentuhan keyboard enter (aksesibilitas)
    [merchantBtn, customerBtn].forEach((btn) => {
        if (btn) {
            btn.addEventListener("keydown", function (e) {
                if (e.key === "Enter" || e.key === " ") {
                    e.preventDefault();
                    btn.click();
                }
            });
        }
    });

    // Biarkan pengguna juga mengklik di luar, tidak mengubah.
    // interaksi tetap mulus, dan hanya menggunakan warna putih, dark stone, biru.
    // Tidak ada gradien, tidak ada emoji.
})();
