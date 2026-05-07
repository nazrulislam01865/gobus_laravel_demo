<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoBus | Admin Sign Up</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/signup.css') }}">

    <style>
        .field-error {
            display: block;
            color: red;
            font-size: 0.8em;
            margin-top: 5px;
            width: 250px;
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="leftSide">
            <h2>Welcome Admin!</h2>

            <p>Already have an admin account?</p>

            <a href="{{ route('admin.login') }}" class="btn">
                LOG IN
            </a>
        </div>

        <div class="rightSide">
            <h2>Create Admin Account</h2>

            <form action="{{ route('admin.signup.submit') }}" method="POST">
                @csrf

                <div class="input-box">
                    <input
                        type="text"
                        placeholder="Admin Username"
                        name="username"
                        style="width: 250px; max-width: 250px;"
                        value="{{ old('username') }}"
                    >

                    @error('username')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-box">
                    <input
                        type="email"
                        placeholder="Admin Email"
                        name="email"
                        style="width: 250px; max-width: 250px;"
                        value="{{ old('email') }}"
                    >

                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-box">
                    <input
                        type="text"
                        placeholder="Admin Phone Number"
                        name="phone"
                        style="width: 250px; max-width: 250px;"
                        value="{{ old('phone') }}"
                    >

                    @error('phone')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-box">
                    <input
                        type="text"
                        placeholder="Admin NID Number"
                        name="nid"
                        style="width: 250px; max-width: 250px;"
                        value="{{ old('nid') }}"
                    >

                    @error('nid')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-box">
                    <input
                        type="password"
                        placeholder="Password"
                        name="password"
                        style="width: 250px; max-width: 250px;"
                    >

                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-box">
                    <input
                        type="password"
                        placeholder="Confirm Password"
                        name="password_confirmation"
                        style="width: 250px; max-width: 250px;"
                    >

                    @error('password_confirmation')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="signup-btn">
                    SIGN UP
                </button>
            </form>
        </div>
    </div>

</body>
</html>
