<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Feng Wei</title>
    <link rel="stylesheet" href="{{ asset('css/passwordStyle.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .error-text {
            color: #dc3545;
            font-size: 13px;
            min-height: 18px;
            margin: 6px 0 4px 0;
            display: block;
            font-family: 'Montserrat', sans-serif;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="backButton">
            <a href="{{ route('login') }}">
                <img src="{{ asset('icon/back.png') }}" alt="Back" class="backButtonIcon"
                     onerror="this.outerHTML='&#8592;'">
            </a>
        </div>

        <div class="mainContent">

            {{-- Step 1: Email Verification --}}
            <div id="step1">
                <div class="textContent">
                    <h2>Forgot Password?</h2>
                    <p class="subtitle">Enter your registered email address to verify your account.</p>
                </div>
                <div class="emailSearchInput">
                    <input type="email" id="emailInput" placeholder="Enter your email address">
                    {{-- FIX: was .error-text (undefined), now has inline style as fallback --}}
                    <div id="emailError" class="error-text"></div>
                    <button type="button" onclick="checkEmail()">Verify Email</button>
                </div>
            </div>

            {{-- Step 2: Reset Password --}}
            <div id="step2" style="display:none;">
                <div class="textContent">
                    <h2>Reset Password</h2>
                    <p class="subtitle">Please enter your new password below.</p>
                </div>
                <div class="passwordResetInput active">
                    <input type="password" id="newPassword" placeholder="New Password (8-20 characters)">
                    <div id="newPasswordError" class="error-text"></div>

                    <input type="password" id="confirmNewPassword" placeholder="Confirm New Password">
                    <div id="confirmNewPasswordError" class="error-text"></div>

                    <button type="button" onclick="resetPassword()">Reset Password</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        let verifiedEmail = '';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showError(elementId, message) {
            const el = document.getElementById(elementId);
            if (el) el.innerText = message;
        }

        function clearError(elementId) {
            const el = document.getElementById(elementId);
            if (el) el.innerText = '';
        }

        // ==========================================
        // Step 1: Verify Email
        // ==========================================
        function checkEmail() {
            const email = document.getElementById('emailInput').value.trim();
            clearError('emailError');

            if (email === '') {
                showError('emailError', 'Please enter your email address.');
                return;
            }

            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                showError('emailError', 'Please enter a valid email address.');
                return;
            }

            const btn = document.querySelector('#step1 button');
            btn.disabled = true;
            btn.innerText = 'Checking...';

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('password.check_email') }}', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState !== 4) return;

                btn.disabled = false;
                btn.innerText = 'Verify Email';

                if (xhr.status === 200) {
                    try {
                        const res = JSON.parse(xhr.responseText);
                        if (res.status === 'success') {
                            verifiedEmail = email;
                            document.getElementById('step1').style.display = 'none';
                            document.getElementById('step2').style.display = 'block';
                        } else {
                            showError('emailError', res.message || 'Email not found.');
                        }
                    } catch (e) {
                        showError('emailError', 'Unexpected server response. Please try again.');
                    }
                } else if (xhr.status === 422) {
                    // Laravel validation error
                    try {
                        const res = JSON.parse(xhr.responseText);
                        const firstError = Object.values(res.errors)[0][0];
                        showError('emailError', firstError);
                    } catch (e) {
                        showError('emailError', 'Invalid request. Please try again.');
                    }
                } else {
                    showError('emailError', 'Server error (' + xhr.status + '). Please try again.');
                }
            };

            xhr.onerror = function() {
                btn.disabled = false;
                btn.innerText = 'Verify Email';
                showError('emailError', 'Network error. Please check your connection.');
            };

            xhr.send('_token=' + encodeURIComponent(csrfToken) + '&email=' + encodeURIComponent(email));
        }

        // ==========================================
        // Step 2: Reset Password
        // ==========================================
        function resetPassword() {
            clearError('newPasswordError');
            clearError('confirmNewPasswordError');

            const newPassword     = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmNewPassword').value;

            let isValid = true;

            if (newPassword.trim() === '') {
                showError('newPasswordError', 'Password is required.');
                isValid = false;
            } else if (newPassword.length < 8 || newPassword.length > 20) {
                showError('newPasswordError', 'Password must be between 8 and 20 characters.');
                isValid = false;
            }

            if (confirmPassword.trim() === '') {
                showError('confirmNewPasswordError', 'Please confirm your password.');
                isValid = false;
            } else if (newPassword !== confirmPassword) {
                showError('confirmNewPasswordError', 'Passwords do not match.');
                isValid = false;
            }

            if (!isValid) return;

            const btn = document.querySelector('#step2 button');
            btn.disabled = true;
            btn.innerText = 'Resetting...';

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('password.reset_submit') }}', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState !== 4) return;

                btn.disabled = false;
                btn.innerText = 'Reset Password';

                if (xhr.status === 200) {
                    try {
                        const res = JSON.parse(xhr.responseText);
                        if (res.status === 'success') {
                            alert('Password successfully updated! You can now login.');
                            window.location.href = '{{ route('login') }}';
                        } else {
                            showError('newPasswordError', res.message || 'Failed to reset password.');
                        }
                    } catch (e) {
                        showError('newPasswordError', 'Unexpected server response. Please try again.');
                    }
                } else if (xhr.status === 422) {
                    try {
                        const res = JSON.parse(xhr.responseText);
                        const firstError = Object.values(res.errors)[0][0];
                        showError('newPasswordError', firstError);
                    } catch (e) {
                        showError('newPasswordError', 'Invalid request. Please try again.');
                    }
                } else {
                    showError('newPasswordError', 'Server error (' + xhr.status + '). Please try again.');
                }
            };

            xhr.onerror = function() {
                btn.disabled = false;
                btn.innerText = 'Reset Password';
                showError('newPasswordError', 'Network error. Please check your connection.');
            };

            xhr.send(
                '_token='      + encodeURIComponent(csrfToken) +
                '&email='      + encodeURIComponent(verifiedEmail) +
                '&newPassword='+ encodeURIComponent(newPassword)
            );
        }

        document.getElementById('emailInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') checkEmail();
        });
    </script>
</body>
</html>