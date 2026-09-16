document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const loginInput = document.getElementById('login');
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const loginButton = document.getElementById('loginButton');

    /* Toggle Password */
    togglePassword.addEventListener('click', function () {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        const icon = togglePassword.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    /* Bootstrap Validation */
    loginForm.addEventListener('submit', function (event) {
        let valid = true;

        // Login validation
        if (loginInput.value.trim() === '') {
            loginInput.classList.add('is-invalid');
            valid = false;
        } else {
            loginInput.classList.remove('is-invalid');
        }

        // Password validation
        if (passwordInput.value.trim() === '') {
            passwordInput.classList.add('is-invalid');
            valid = false;
        } else {
            passwordInput.classList.remove('is-invalid');
        }

        if (!valid) {
            event.preventDefault();
            return;
        }

        /* Loading State */
        loginButton.disabled = true;
        loginButton.innerHTML = `
            <span
                class="spinner-border spinner-border-sm me-1"
                role="status"
            ></span>

            Signing in...
        `;
    });


    /* Remove Validation Error While Typing */
    loginInput.addEventListener('input', function () {
        if (loginInput.value.trim() !== '') {
            loginInput.classList.remove('is-invalid');
        }
    });

    passwordInput.addEventListener('input', function () {
        if (passwordInput.value.trim() !== '') {
            passwordInput.classList.remove('is-invalid');
        }
    });
});