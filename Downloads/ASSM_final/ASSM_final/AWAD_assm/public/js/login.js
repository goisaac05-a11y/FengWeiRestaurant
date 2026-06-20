const switchSignUpButton = document.getElementById('switchSignup');
const switchLoginButton  = document.getElementById('switchLogin');
const container          = document.getElementById('container');
const signupButton       = document.getElementById('signupButton');
const loginButton        = document.getElementById('loginButton');

const backHomeBtn = document.getElementById('backHomeBtn');
if (backHomeBtn) {
    backHomeBtn.addEventListener('click', () => {
        window.location.href = '/';
    });
}

if (switchSignUpButton) {
    switchSignUpButton.addEventListener('click', () => {
        container.classList.add('right-panel-active');
    });
}

if (switchLoginButton) {
    switchLoginButton.addEventListener('click', () => {
        container.classList.remove('right-panel-active');
    });
}

if (loginButton) {
    loginButton.addEventListener('click', function(e) {
        e.preventDefault();
        validateLoginForm();
    });
}

if (signupButton) {
    signupButton.addEventListener('click', function(e) {
        e.preventDefault();
        validateSignUpForm();
    });
}

// ==========================================
// Email regex pattern
// ==========================================
const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

// ==========================================
// Login Form Validation
// ==========================================
function validateLoginForm() {
    let isValid = true;
    const form = document.getElementById('LoginForm');

    document.getElementById('loginEmailError').textContent    = '';
    document.getElementById('loginPasswordError').textContent = '';

    if (form['email'].value.trim() === '') {
        document.getElementById('loginEmailError').textContent = 'Email is required.';
        isValid = false;
    } else if (!emailPattern.test(form['email'].value)) {
        document.getElementById('loginEmailError').textContent = 'Email is not valid.';
        isValid = false;
    }

    if (form['password'].value.trim() === '') {
        document.getElementById('loginPasswordError').textContent = 'Password is required.';
        isValid = false;
    } else if (form['password'].value.length < 8 || form['password'].value.length > 20) {
        document.getElementById('loginPasswordError').textContent = 'Password must be between 8 and 20 characters.';
        isValid = false;
    }

    if (isValid) {
        form.submit();
    }
}

// ==========================================
// Sign Up Form Validation
// ==========================================
function validateSignUpForm() {
    let isValid = true;
    const form = document.getElementById('SignUpForm');

    document.getElementById('usernameError').textContent        = '';
    document.getElementById('signupEmailError').textContent     = '';
    document.getElementById('phoneError').textContent           = '';
    document.getElementById('signUpPasswordError').textContent  = '';
    document.getElementById('confirmPasswordError').textContent = '';

    // Username
    if (form['username'].value.trim() === '') {
        document.getElementById('usernameError').textContent = 'Username is required.';
        isValid = false;
    } else if (form['username'].value.length > 10) {
        document.getElementById('usernameError').textContent = 'Username cannot exceed 10 characters.';
        isValid = false;
    }

    // Email
    if (form['email'].value.trim() === '') {
        document.getElementById('signupEmailError').textContent = 'Email is required.';
        isValid = false;
    } else if (!emailPattern.test(form['email'].value)) {
        document.getElementById('signupEmailError').textContent = 'Email is not valid.';
        isValid = false;
    }

    // Phone number (digits only, 8–12 characters)
    if (form['phoneNumber'].value.trim() === '') {
        document.getElementById('phoneError').textContent = 'Phone number is required.';
        isValid = false;
    } else if (!/^\d{8,12}$/.test(form['phoneNumber'].value)) {
        document.getElementById('phoneError').textContent = 'Enter a valid phone number (8-12 digits).';
        isValid = false;
    }

    // Password
    if (form['password'].value.trim() === '') {
        document.getElementById('signUpPasswordError').textContent = 'Password is required.';
        isValid = false;
    } else if (form['password'].value.length < 8 || form['password'].value.length > 20) {
        document.getElementById('signUpPasswordError').textContent = 'Password must be between 8 and 20 characters.';
        isValid = false;
    }

    const confirmField = form['password_confirmation'] || form['confirmPassword'];
    if (!confirmField || confirmField.value.trim() === '') {
        document.getElementById('confirmPasswordError').textContent = 'Confirm Password is required.';
        isValid = false;
    } else if (form['password'].value !== confirmField.value) {
        document.getElementById('confirmPasswordError').textContent = 'Passwords do not match. Please enter again.';
        isValid = false;
    }

    if (isValid) {
        form.submit();
    }
}