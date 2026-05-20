document.addEventListener('DOMContentLoaded', () => {

    const password = document.getElementById('password');
    const togglePass = document.getElementById('toggle-pass');
    const icon = document.getElementById('toggle-icon');

    togglePass.addEventListener('click', () => {

        const isHidden = password.type === 'password';

        password.type = isHidden ? 'text' : 'password';

        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');

    });

});