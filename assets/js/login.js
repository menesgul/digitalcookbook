document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const email = document.getElementById('email');
    const password = document.getElementById('password');

    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    let isValid = true;

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
        alert('Giriş başarılı!');
        window.location.href = 'home.html';
    }
});
