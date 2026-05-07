<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoBus | Admin Login</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="container">
        <div class="leftSide">
            <h2>Welcome Admin!</h2>

            <p>Need an admin account?</p>

            <a href="{{ route('admin.signup') }}" class="btn">
                SIGN UP
            </a>

            <br><br>

            <a href="{{ route('home') }}" class="btn">
                BACK HOME
            </a>
        </div>

        <div class="rightSide">
            <h2>ADMIN LOG IN</h2>

            @if ($errors->any())
                <div style="color: red; text-align: center; font-size: 0.85em;">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form id="adminLoginForm" action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <div class="input-box">
                    <input
                        type="text"
                        placeholder="Admin Phone Number"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        style="width: 250px; max-width: 250px;"
                    >

                    <span id="phoneError" class="error-text"></span>
                </div>

                <div class="input-box">
                    <input
                        type="password"
                        placeholder="Admin Password"
                        id="password"
                        name="password"
                        style="width: 250px; max-width: 250px;"
                    >

                    <span id="passwordError" class="error-text"></span>
                </div>

                <div class="input-checkbox">
                    <input type="checkbox" id="rememberMe" name="rememberMe">
                    <label for="rememberMe">Remember Me</label>
                </div>

                <button
                    type="submit"
                    class="login-btn"
                    style="width: 250px; max-width: 250px;"
                >
                    LOG IN
                </button>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('adminLoginForm');
        const phone = document.getElementById('phone');
        const password = document.getElementById('password');
        const phoneError = document.getElementById('phoneError');
        const passwordError = document.getElementById('passwordError');

        form.addEventListener('submit', function (event) {
            phoneError.textContent = '';
            passwordError.textContent = '';

            let hasError = false;

            if (!/^\d{11}$/.test(phone.value.trim())) {
                phoneError.textContent = 'Phone number must be 11 digits.';
                hasError = true;
            }

            if (password.value.trim() === '') {
                passwordError.textContent = 'Password is required.';
                hasError = true;
            }

            if (hasError) {
                event.preventDefault();
            }
        });
    </script>

</body>
</html>
