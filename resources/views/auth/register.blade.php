<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fit N Right - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #4b2953;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .left {
            width: 50%;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .left h2 {
            color: #c74856;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .left img {
            width: 70%;
            max-width: 400px;
        }

        .right {
            flex: 1;
            background-color: #4b2953;
            color: #f9eebd;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            padding: 1rem;
        }

        .right h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .login-box {
            background-color: #5c2e68;
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        .login-box h3 {
            margin-bottom: 20px;
            font-weight: bold;
            color: #fbeec1;
            text-align: center;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 10px;
            margin-bottom: 15px;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #f9eebd;
            color: #fff;
        }

        input::placeholder {
            color: #ddd;
        }

        .remember-forgot {
            font-size: 0.9em;
            color: #f9eebd;
            margin-bottom: 20px;
        }

        .login-btn {
            width: 100%;
            background-color: #f9eebd;
            color: #4b2953;
            font-weight: bold;
            border: none;
            padding: 12px;
            cursor: pointer;
            border-radius: 5px;
        }

        .signup {
            margin-top: 20px;
            font-size: 0.9em;
            color: #f9eebd;
            text-align: center;
        }

        .signup a {
            color: #fbeec1;
            font-weight: bold;
            text-decoration: underline;
            cursor: pointer;
        }

        .register-popup {
            display: none;
            position: absolute;
            top: 5%;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 500px;
            background: #774c8b;
            color: #fbeec1;
            padding: 2rem;
            border-radius: 20px;
            animation: slideIn 0.5s forwards;
            z-index: 10;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        @keyframes slideIn {
            0% { transform: translate(-50%, -20%) scale(0.8); opacity: 0; }
            100% { transform: translate(-50%, 0) scale(1); opacity: 1; }
        }

        .register-popup h4 {
            color: #fbeec1;
            margin-bottom: 1rem;
            text-align: center;
        }

        .register-popup label {
            color: #fbeec1;
        }

        .register-popup input {
            background-color: #fbeec1;
            color: #512e5f;
            border: none;
        }

        .register-popup input:focus {
            outline: 2px solid #f2547d;
            box-shadow: none;
        }

        .alert-error {
            background-color: #f2547d;
            color: #fff;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .btn-success {
            background-color: #fbeec1;
            color: #512e5f;
            font-weight: bold;
        }

        .btn-secondary {
            background-color: transparent;
            border: 1px solid #fbeec1;
            color: #fbeec1;
        }

        .btn-secondary:hover {
            background-color: #fbeec1;
            color: #512e5f;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="left">
        <h2>A Leap to Fitness</h2>
        <img src="{{ asset('images/fitness-woman.jpg') }}" alt="Fitness Woman">
    </div>

    <div class="right">
        <h1>Fit N Right</h1>
        <div class="login-box">
            <h3>Login</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                
                <div class="remember-forgot">
                    <label><input type="checkbox" name="remember"> Remember me</label>
                </div>

                <button type="submit" class="login-btn">LOGIN</button>
            </form>

            <div class="signup">
                <p>Don't have an account? <a id="show-register">Sign Up</a></p>
            </div>
        </div>

        <!-- Registration Pop-Up -->
        <div class="register-popup shadow" id="register-popup">
            <h4>Create Your FitZone Account</h4>

            @if ($errors->any())
                <div class="alert-error">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf
                <div class="mb-2">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Create Account</button>
                    <button type="button" class="btn btn-secondary" id="close-register">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const signUpBtn = document.getElementById("show-register");
    const registerPopup = document.getElementById("register-popup");
    const closeBtn = document.getElementById("close-register");

    signUpBtn.addEventListener("click", () => {
        registerPopup.style.display = "block";
    });

    closeBtn.addEventListener("click", () => {
        registerPopup.style.display = "none";
    });
</script>

</body>
</html>
