document.getElementById('signupForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const username = document.getElementById('username');
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    const usernameError = document.getElementById('usernameError');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    let isValid = true;

    // Kullanıcı adı validasyonu
    if (!username.value.trim()) {
        usernameError.textContent = 'Kullanıcı adı alanı boş bırakılamaz.';
        isValid = false;
    } else if (username.value.length < 3) {
        usernameError.textContent = 'Kullanıcı adı en az 3 karakter olmalıdır.';
        isValid = false;
    } else {
        usernameError.textContent = '';
    }

    // E-posta validasyonu
    if (!email.value.trim()) {
        emailError.textContent = 'E-posta alanı boş bırakılamaz.';
        isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(email.value)) {
        emailError.textContent = 'Geçerli bir e-posta adresi girin.';
        isValid = false;
    } else {
        emailError.textContent = '';
    }

    // Şifre validasyonu
    if (!password.value.trim()) {
        passwordError.textContent = 'Şifre alanı boş bırakılamaz.';
        isValid = false;
    } else if (password.value.length < 6) {
        passwordError.textContent = 'Şifre en az 6 karakter olmalıdır.';
        isValid = false;
    } else {
        passwordError.textContent = '';
    }

   if (isValid) {
        // Form verilerini oluştur
        const formData = new FormData();
        formData.append('username', username.value);
        formData.append('email', email.value);
        formData.append('password', password.value);

        // AJAX ile PHP'ye gönder
        fetch('../server/register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if(data.includes('Kayıt başarılı')) {
                alert('Kayıt başarılı! Lütfen giriş yapın.');
                window.location.href = '../templates/login.html';
            } else {
                alert('Kayıt sırasında bir hata oluştu: ' + data);
            }
        })
        .catch(error => { console.error('Hata:', error);
            alert('Bir hata oluştu!');
        });
    }
});