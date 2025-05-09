<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FitZone - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/Appdev_logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

        html {
            scroll-behavior: smooth;
        }
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #4b2953;
            height: 100vh;
            overflow: hidden;
        }

        .main-container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .left {
            width: 100%;
            background-color: #fff;
            overflow-y: auto;
            transition: width 0.4s ease;
            height: 100vh;
        }

        .right {
            width: 0;
            overflow: hidden;
            background-color: #4b2953;
            color: #f9eebd;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: width 0.4s ease, padding 0.4s ease;
        }

        .main-container.show-login .left {
            width: 60%;
        }

        .main-container.show-login .right {
            width: 40%;
            padding: 1rem;
        }

        .close-btn {
            position: absolute;
            top: 30px;
            right: 20px;
            background: transparent;
            color: #f9eebd;
            font-size: 1.5rem;
            border: none;
            cursor: pointer;
            z-index: 20;

            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .main-container.show-login .close-btn {
            opacity: 1;
            pointer-events: auto;
        }

        .left::-webkit-scrollbar {
            width: 8px;
        }

        .left::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 10px;
        }

        .left::-webkit-scrollbar-thumb {
            background-color: #cccccc;
            border-radius: 10px;
            border: 2px solid #f0f0f0;
        }

        .left::-webkit-scrollbar-thumb:hover {
            background-color: #999999;
        }


        .right h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0 auto 30px auto;
        }

        .login-box {
            background-color: #5c2e68;
            padding: 40px;
            border-radius: 7px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            margin: 0 auto !important;
        }

        .login-box h3 {
            margin-bottom: 20px;
            font-weight: bold;
            color: #fbeec1;
            text-align: center;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"]#password {
            width: 100%;
            padding: 12px 10px;
            margin-bottom: 15px;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #f9eebd;
            color: #fff;
            outline: none;
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
            position: fixed;
            top: 50%;
            right: 8rem; /* space from right edge */
            transform: translateY(-50%); /* center vertically only */
            width: 80%;
            max-width: 400px;
            background: #774c8b;
            color: #fbeec1;
            padding: 1.5rem 1.2rem;
            border-radius: 15px;
            animation: slideInRight 0.5s forwards;
            z-index: 10;
            box-shadow: 0 6px 15px rgba(0,0,0,0.25);
            max-height: 90vh;
            overflow-y: auto;
        }



        @keyframes slideInRight {
            0% { transform: translateY(-50%) translateX(30%); opacity: 0; }
            100% { transform: translateY(-50%) translateX(0); opacity: 1; }
        }


        .register-popup form .mb-2, 
        .register-popup form .mb-3 {
            margin-bottom: 0.6rem; /* tighter space between fields */
        }

        .register-popup input, 
        .register-popup select {
            padding: 6px 10px; /* smaller input box height */
            font-size: 0.9rem;
        }

        .register-popup {
            padding: 1.5rem 1.2rem; /* less padding inside popup */
            max-height: 90vh; /* prevent modal from getting too tall */
            overflow-y: auto; /* enable scroll if needed */
        }

        .register-popup h4 {
            color: #fbeec1;
            margin-bottom: 0.8rem;
            text-align: center;
            font-size: 1.5rem; /* slightly smaller title */
        }

        .register-popup label {
            color: #fbeec1;
            font-size: 0.9rem; /* smaller labels */
        }

        .register-popup input,
        .register-popup select {
            background-color: #fbeec1;
            color: #512e5f;
            border: none;
            font-size: 0.9rem; /* smaller input text */
            padding: 8px; /* smaller input box height */
        }

        .register-popup input:focus,
        .register-popup select:focus {
            outline: 2px solid #f2547d;
            box-shadow: none;
        }

        .alert-error {
            background-color: #f2547d;
            color: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            margin-bottom: 0.8rem;
            font-size: 0.85rem;
        }

        .btn-success, .btn-secondary {
            padding: 8px 12px;
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
        
        .admin-login-btn {
            bottom: 20px;
            right: 20px;
            z-index: 1050;
            position: fixed;
            background-color: #fbeec1;
            color: #4b2953;
            font-family: 'Segoe UI', sans-serif;
            font-size: 0.85rem;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .admin-login-btn:hover {
            background-color: #e4d59c;
            color: #3b1e40;
        }
        #adminLoginModal .form-control {
            background-color: #f9eebd !important;
            color: #4b2953 !important;
            border: 1px solid #e4d59c;
            font-weight: 500;
        }

        #adminLoginModal .form-control:focus {
            background-color: #fffde7 !important;
            color: #4b2953 !important;
            border-color: #f2547d;
            box-shadow: 0 0 0 0.2rem rgba(242, 84, 125, 0.25);
        }

        .left-content {
            position: relative;
            display:flex;
            flex-direction:column;
            background-color: #fff;
            border-radius: 7px;
            height: 400vh;
            overflow-x: hidden;
        }

        .about-navbar {
            position: absolute; 
            top: 30px;           
            width: 100%;
            display: flex;
            justify-content: center;
            z-index: 10;         
            background: transparent; 
            max-width:100% !important;
        }

        .nav-buttons {
            display: flex;
            gap: 2rem;
        }

        .nav-btn {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            padding: 0.5rem 1.2rem;
            transition: all 0.3s ease;
        }

        .nav-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            backdrop-filter: blur(4px);
        }

        #login-btn{
            border: 1px solid #f9eebd;
        }


        .layer-1 {
            flex:1;
            width: 100%;
            background-image:url('images/bg-login.jpeg');
            background-size: cover;
            background-attachment: scroll;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center; 
            align-items: center;     
            text-align: center;      
            height: 100vh;
            min-height:100vh;  
        }

        .overlay h1 {
            color: #fff;
            font-size: 50px;
            margin: 0;
        }
        .layer-2 {
            width: 100%;
            flex:1;
            max-width:100%;
            box-sizing: border-box;
            min-height:100vh;
        }

        .contentlayer-2 {
            display: flex;
            width: 80%;
            height: 50%;
            margin:11% auto;
            box-sizing: border-box;
            
        }

        .description-2 {
            flex:1;
            display: flex;
            justify-content: center;  
            align-items: center; 
            text-align: center;
            padding: 20px;
            background-color:rgb(252, 249, 246);
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .description h6 {
            margin: 0;           
        }

        .img-layer-2 {
            flex:1;
            width: 100%;
            background-image:url('images/header.jpg');
            background-size: cover;
            background-attachment: scroll;
            background-repeat: no-repeat;
            padding:20px;
        }

        .layer-3 {
            width: 100%;
            flex:1;
        }

        .layer-3 #offer {
            display: inline-block;
            background-color:rgb(75, 45, 145);
            margin-left: 10%;
            color: #fff;
            border-radius:2px;
            padding:15px;
        }

        .img-layer-3 {
            flex:1;
            width: 100%;
            background-image:url('images/yoga_body.jpg');
            background-size: cover;
            background-attachment: scroll;
            background-repeat: no-repeat;
            padding:20px;
        }

        .description-3 {
            flex:1;
            flex-direction: column;
            display: flex;
            justify-content: center;  
            align-items: center; 
            text-align: center;
            padding: 20px;
            background-color:rgb(252, 249, 246);
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .description-3 h5 {
            margin-bottom:60px;
        }

        .contentlayer-3 {
            display: flex;
            width: 80%;
            height: 50%;
            margin:10% auto;
            box-sizing: border-box;
        }

        .layer-4 {
            width: 100%;
            flex:1;
        }

        .contentlayer-4 {
            display: flex;
            justify-content: space-between; 
            gap: 20px;
            flex-wrap: nowrap; 
            width: 80%;         
            margin: 10% auto;   
            box-sizing: border-box;
        }

        .card {
            width: 18rem;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            font-family: 'Segoe UI', sans-serif;
        }

        .card img {
            width: 100%;
            height: auto;
            display: block;
        }

        .card-body {
            padding: 16px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0 0 10px;
            color: #333;
        }

        .card-text {
            font-size: 0.95rem;
            line-height: 1.5;
            color: #555;
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="left" id="left-panel">
        <div class="left-content">
            <nav class="about-navbar">
                <div class="nav-buttons">
                    <a href="#" class="nav-btn">Home</a>
                    <a href="#About" class="nav-btn">About</a>
                    <a href="#" class="nav-btn" id="login-btn">Login</a>
                    <a href="#" class="nav-btn" data-bs-toggle="modal" data-bs-target="#adminLoginModal"><i class="fa-solid fa-user-tie"></i></a>
                </div>
            </nav>
            <div class="layer-1">
                <div class="overlay">
                    <h1>WELCUM to FitZone</h1>
                    <p style="color:white;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo, modi?</p>
                </div>
            </div>
            <div class="layer-2">
                <div class="contentlayer-2" id="About">
                    <div class="description-2">
                        <h6>Your journey to better health, more energy, and total confidence starts here.</h6>
                    </div>
                    <div class="img-layer-2"></div>
                </div>
            </div>
            <div class="layer-3">
                <h6 id="offer">What We Offer →</h6>
                <div class="contentlayer-3" id="About">
                    <div class="img-layer-3"></div>
                    <div class="description-3">
                        <h5>Yoga</h5>
                        <h6>Your journey to better health, more energy, and total confidence starts here.</h6>
                    </div>
                </div>
            </div>
            <div class="layer-4">
                <div class="contentlayer-4">
                    <div class="card rounded-0">
                        <img src="images/HIIT.avif" alt="Card image" />
                        <div class="card-body">
                            <h5 class="card-title">HIIT</h5>
                            <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card’s content.
                            </p>
                        </div>
                    </div>

                    <div class="card rounded-0">
                        <img src="images/Zumba.webp" alt="Card image" />
                        <div class="card-body">
                            <h5 class="card-title">ZUMBA</h5>
                            <p class="card-text">
                            More content goes here, describing features, benefits, or anything else.
                            </p>
                        </div>
                    </div>

                    <div class="card rounded-0">
                        <img src="images/Cardio.avif" alt="Card image" />
                        <div class="card-body">
                            <h5 class="card-title">CARDIO</h5>
                            <p class="card-text">
                            More content goes here, describing features, benefits, or anything else.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="right" id="login-panel">
        <button id="close-login" class="close-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i></button>
        <h1>FitZone</h1>
        <div class="login-box">
            <h3>Login</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" placeholder="Email" maxlength="50" required>
                <div style="position: relative;">
                    <input type="password" name="password" id="password" placeholder="Password" maxlength="50" required>
                    <span onclick="togglePassword()" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); border: none; cursor: pointer; outline: none;">
                        👁
                    </span>
                </div>
                
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
                    <label>First Name</label>
                    <input type="text" name="first_name" maxlength="50" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Middle Name</label>
                    <input type="text" name="middle_name" maxlength="25" class="form-control">
                </div>
                <div class="mb-2">
                    <label>Last Name</label>
                    <input type="text" name="last_name" maxlength="25" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Gender</label>
                    <select name="gender" class="form-control" required>
                        <option value="" disabled selected>Select your gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Email</label>
                    <input type="email" name="email" maxlength="25" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Password</label>
                    <input type="password" name="password" maxlength="25" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" maxlength="25" class="form-control" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Create Account</button>
                    <button type="button" class="btn btn-secondary" id="close-register">Close</button>
                </div>
            </form>
        </div>

<!--<button class="btn position-fixed admin-login-btn" data-bs-toggle="modal" data-bs-target="#adminLoginModal">
    Admin
</button>-->

<!-- Admin Login Modal -->
<div class="modal fade" id="adminLoginModal" tabindex="-1" aria-labelledby="adminLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="adminLoginModalLabel">Admin Login</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="admin-username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="admin-username" required>
                    </div>

                    <div class="mb-3">
                        <label for="admin-password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="admin-password" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Login</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const loginBtn = document.getElementById('login-btn');
    const closeBtn = document.getElementById('close-login');
    const mainContainer = document.querySelector('.main-container');

    // Show the login panel
    loginBtn.addEventListener('click', function (e) {
      e.preventDefault();
      mainContainer.classList.add('show-login');
    });

    // Hide the login panel
    closeBtn.addEventListener('click', function () {
      mainContainer.classList.remove('show-login');
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
