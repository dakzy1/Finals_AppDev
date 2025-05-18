<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FitZone - Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/Appdev_logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @font-face {
            font-family: 'MyFont';
            src: url('/fonts/SportNewsRegular.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        * { box-sizing: border-box; }

        body {
            overflow: hidden;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #4b2953;
            height: 100vh;
            padding: 0;
            box-sizing: border-box;
        }

        .main-container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .fugaz-one-regular {
            font-family: "Fugaz One", sans-serif;
            font-weight: 400;
            font-style: normal;
        }


        .left {
            background: red;
            position: relative;
            width: 100%;
            background-color: #fff;
            overflow-y: auto;
            transition: width 0.4s ease;
            min-height: 100vh;
            scroll-behavior: smooth;
            box-sizing: border-box;
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
            display:none;
            bottom: 20px;
            margin-left: 3%;
            z-index: 1050;
            position: fixed;
            background-color: none;
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
            display:flex;
            flex-direction:column;
            background-color: #fff;
            height: 570vh;
            overflow-x: hidden;
            overflow: hidden;
        }

        .about-navbar {
            position: absolute;
            top: 5px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between; /* space between logo and buttons */
            padding: 0 40px; /* adjust spacing from left/right */
            z-index: 10;
            background: transparent;
            max-width: 100% !important;
            background-attachment: scroll;
        }

        .nav-logo .logo-img {
            height: 100px; /* adjust size as needed */
            cursor: pointer;
            width: auto;
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
            position: relative;
            flex:1;
            width: 100%;
            background-image:url('images/bg-login.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center; 
            align-items: center;     
            text-align: center;      
            height: 100vh;
            min-height:100vh;
            z-index: 0;
            
        }
        .layer-1::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Adjust alpha to control darkness */
            z-index: 1;
        }

        /* Make overlay content above the dark overlay */
        .overlay {
            position: relative;
            z-index: 2;
            color: white; /* Ensure text is visible */
        }

        .overlay h1 {
            font-size: 5rem;
            font-style: italic;
            font-family: 'MyFont', sans-serif;
            text-transform: uppercase;
            color: white;
            letter-spacing: 3px;
            cursor: pointer;
            opacity: 0;
            animation: fadeIn 1s ease-out forwards;
            user-select: none;             /* Disable text selection */
            -webkit-user-select: none;     /* For Safari */
            -ms-user-select: none;         /* For IE/Edge */
            pointer-events: auto;
        }

        h1.animated-title span {
            display: inline-block;
            transition: transform 0.3s ease;
            cursor: pointer;
            font-size: 5rem;
            text-transform: uppercase;
            position: relative;
            margin-right: 5px;
        }

        h1.animated-title span:hover {
            transform: translateY(-10px);
        }

        @keyframes riseUp {
            0% { transform: translateY(0); }
            100% { transform: translateY(-10px); }
        }

        /* Dot effect */
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            position: absolute;
            pointer-events: none;
            animation: pop 0.6s ease-out forwards;
            z-index: 999;
        }

        @keyframes pop {
            0% {
                opacity: 1;
                transform: scale(1);
            }
            100% {
                opacity: 0;
                transform: scale(2) translateY(-20px);
            }
        }


         @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .layer-2 {
            width: 100%;
            flex:1;
            max-width:100%;
            box-sizing: border-box;
            min-height:100vh;
        }

        .contentlayer-2 {
            width: 80%;
            margin:10% auto;
            box-sizing: border-box;
        }

        .brands-section {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 0;
            position: relative;
        }

        .brands-section::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 200px; /* Adjust for how tall the fade should be */
            background: linear-gradient(to top, white, transparent);
            pointer-events: none;
            z-index: 2;
        }

        .container-slide {
            max-width: 100%;
            overflow: hidden;
            position: relative;
            padding: 0 0px;
        }

        .heading-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .heading {
            font-size: 36px;
            font-weight: bold;
            line-height: 1.4;
        }

        .highlight {
            color: #8884ff;
        }

        .slider-wrapper {
            overflow: hidden;
            width: 100%;
        }

        .brands-slider {
            display: flex;
            gap: 24px;
            animation: scroll 30s linear infinite;
            width: max-content;
        }

            @keyframes scroll {
            0% {
                transform: translateX(0%);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        .brand-card {
            background-color: #1a1a1a;
            min-width: 500px;
            max-width: 500px;
            border-radius: 3px;
            padding: 0;
            flex: 0 0 auto;
            text-align: center;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.05);
        }

        .brand-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 3px;
            display: block;
        }

        @media (max-width: 768px) {
            .heading {
                font-size: 24px;
            }
        
            .brand-card {
                min-width: 300px;
            }
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
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            cursor: pointer;
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

        .layer-5 {
            width: 100%;
            flex:1;
        }

        .mission-section {
            padding: 60px 10%;
            border-top: 1px solid #ddd;
            background-color: #fefefe;
            display: flex;
            padding-top: 60px;
            padding-bottom: 60px;
            position: relative;
        }

        .mission-section::before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 1px;
            background-color: #ddd;
            transform: translateX(-50%);
        }

        .container {
            display: flex;
            gap: 60px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
            box-sizing: border-box;
        }

        .left-mission, .right-mission {
            flex: 1;
        }

        .left-mission h1 {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 30px;
        }

        .left-mission p {
            font-size: 1rem;
            line-height: 1.8;
            color: #444;
            max-width: 500px;
        }

        .left-mission .highlight {
            color: #e39c4a;
            font-style: italic;
            margin-top: 10px;
        }

        .right-mission h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .years-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
        }

        .years-box {
            background-color:rgb(75, 45, 145);
            color: white;
            font-size: 2rem;
            font-weight: bold;
            padding: 10px 20px;
        }

        .years-label {
            font-size: 1.3rem;
            color: #555;
        }

        .right-mission .quote {
            font-style: italic;
            color: #e39c4a;
            margin-bottom: 15px;
            max-width: 400px;
        }

        .right-mission p {
            font-size: 1rem;
            line-height: 1.8;
            color: #444;
            max-width: 500px;
        }

        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                border-left: none;
                padding-left: 0;
            }

            .left-mission h1 {
                font-size: 2.4rem;
            }

            .years-box {
                font-size: 1.5rem;
            }
        }

        .footer-layer {
            width: 100%;
            height:45vh;
             background-color: #0f1b1d;
            border-top: 1px solid #ddd; 
            box-sizing: border-box;
        }

        .main-container.show-login .footer-layer {
            height: 70vh;
        }

        .footer-container {
            width: 80%;
            margin: 0 auto;
            background-color: #0f1b1d;
            padding: 60px 40px;
            color: #f1f1f1;
            font-family: 'Segoe UI', sans-serif;       
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            max-width: 1200px;
            margin: 0 auto;
            flex-wrap: wrap;
            gap: 40px;
        }

        .footer-left {
            max-width: 400px;
        }

        .footer-left h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .footer-left p {
            font-size: 0.95rem;
            color: #ccc;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .social-icons i {
            font-size: 1rem;
            background-color: #c5aa7b;
            color: #0f1b1d;
            padding: 8px;
            margin-right: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .social-icons i:hover {
            background-color: #e4cfa1;
        }

        .footer-right {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .contact-card {
            background-color: #132024;
            padding: 30px;
            color: #fff;
            width: 220px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            position: relative; /* for pseudo-element */
            font-size: 0.95rem;
            font-weight: 400;
            gap: 10px;
            z-index: 1;
        }

        .contact-card::after {
            content: '';
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 100%;
            height: 100%;
            background-color:rgb(27, 41, 44); /* Shadow/offset color */
            border-radius: 4px;
            z-index: -1;
        }

        .contact-card i {
            font-size: 1.5rem;
            color: #e4cfa1;
        }

        .contact-card span {
            color: #fff;
            font-size: 0.95rem;
        }

        /* Scoll animation */

        .observe {
            opacity: 0;
        }

        .observe.show {
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }


    </style>
</head>
<body>

<div class="main-container">
    <div class="left" id="left-panel">
        <div class="left-content" id="home">
            <nav class="about-navbar">
                <div class="nav-logo">
                    <img src="images/LogoMaster.png" alt="Logo" class="logo-img" />
                </div>
                <div class="nav-buttons">
                    <a href="#home" class="nav-btn">Home</a>
                    <a href="#about" class="nav-btn">About</a>
                    <a href="#" class="nav-btn" id="login-btn">Login</a>
                </div>
                <div class="nav-buttons">
                    <a href="#" class="nav-btn" data-bs-toggle="modal" data-bs-target="#adminLoginModal"><i class="fa-solid fa-user-tie"></i></a>
                </div>
            </nav>
            <div class="layer-1 show-on-scroll observe">
                <div class="overlay">
                    <h1 class="animated-title"><span>SHAPE</span> <span>YOURSELF</span></h1>
                    <div class="click-effect-container"></div>
                    <p style="color:white;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo, modi?</p>
                </div>
            </div>
            <div class="layer-2 observe">
                <div class="contentlayer-2">
                    <section class="brands-section">
                        <div class="container-slide">
                            <div class="heading-container">
                                <h2 class="heading">
                                    Discipline beats <span class="highlight">motivation</span>
                                </h2>
                            </div>

                            <div class="slider-wrapper">
                                <div class="brands-slider">
                                <!-- Image-only cards -->
                                <div class="brand-card">
                                    <img src="images/using-weight.webp" alt="Dropbox" class="brand-image" />
                                </div>

                                <div class="brand-card">
                                    <img src="images/young-woman.avif" alt="Fivetran" class="brand-image" />
                                </div>

                                <div class="brand-card">
                                    <img src="images/push-up.jpg" alt="Jasper" class="brand-image" />
                                </div>

                                <div class="brand-card">
                                    <img src="images/fitness-center.jpeg" alt="Lattice" class="brand-image" />
                                </div>

                                <div class="brand-card">
                                    <img src="images/background.jpg" alt="NCR" class="brand-image" />
                                </div>

                                <!-- Duplicate for seamless loop -->
                                <div class="brand-card">
                                    <img src="images/using-weight.webp" alt="Dropbox" class="brand-image" />
                                </div>

                                <div class="brand-card">
                                    <img src="images/young-woman.avif" alt="Fivetran" class="brand-image" />
                                </div>

                                <div class="brand-card">
                                    <img src="images/push-up.jpg" alt="Jasper" class="brand-image" />
                                </div>

                                <div class="brand-card">
                                    <img src="images/fitness-center.jpeg" alt="Lattice" class="brand-image" />
                                </div>

                                <div class="brand-card">
                                    <img src="images/background.jpg" alt="NCR" class="brand-image" />
                                </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="layer-3 show-on-scroll observe" id="about" style="margin-top: 80px; padding-top: 1px;">
                <h6 id="offer">What We Offer →</h6>
                <div class="contentlayer-3" id="About">
                    <div class="img-layer-3"></div>
                    <div class="description-3">
                        <h5>Yoga</h5>
                        <h6>Your journey to better health, more energy, and total confidence starts here.</h6>
                    </div>
                </div>
            </div>
            <div class="layer-4 observe">
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
            <div class="layer-5 observe">
                <section class="mission-section">
                    <div class="container">
                        <div class="left-mission">
                            <h1>Our<br>Mission<br>& Vision</h1>
                            <p>
                                To create a welcoming space for people of all levels to improve their health through fun, effective, and personalized fitness experiences.
                            </p>
                            <p class="highlight">
                                Fitness and wellness for everyone — at an affordable price.
                            </p>
                        </div>

                        <div class="right-mission">
                            <h3>About us</h3>
                            <p>
                                To become your go-to fitness destination – known for inclusivity, community vibes, and results-driven programs.
                            </p>

                            <div class="years-container">
                                <div class="years-box">50</div>
                                <div class="years-label">years</div>
                            </div>

                            <p class="quote">
                                The only thing that is better than to work with us is to work for us.
                            </p>

                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, asperiores expedita? Impedit totam minima tempora labore expedita placeat aliquam recusandae!
                            </p>
                        </div>
                    </div>
                </section>
            </div>
            <div class="footer-layer show-on-scroll observe">
                <div class="footer-container">
                    <div class="footer-content">
                        <div class="footer-left block">
                            <h2>Get in Touch</h2>
                            <p>
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate, iste!
                            </p>
                            <div class="social-icons">
                                <i class="fab fa-instagram"></i>
                                <i class="fab fa-linkedin"></i>
                                <i class="fab fa-pinterest"></i>
                                <i class="fab fa-twitter"></i>
                            </div>
                        </div>
                        <div class="footer-right block">
                            <div class="contact-card">
                                <i class="fa-solid fa-phone"></i>
                                <span>123456789</span>
                            </div>
                            <div class="contact-card">
                                <i class="fas fa-envelope"></i>
                                <span>contact@example.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn admin-login-btn" id="scrollTopBtn">
                <i class="fas fa-arrow-up"></i>
            </button>
        </div>
    </div>

    <div class="right" id="login-panel">
        <button id="close-login" class="close-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i></button>
        <h1>FitZone</h1>
        <div class="login-box">
            <h3>Login</h3>
            @if ($errors->any())
                <div class="alert-error">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('login.post') }}">
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

            
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="mb-2">
                    <label>First Name</label>
                    <input type="text" name="first_name" maxlength="50" class="form-control only-letters" required>
                </div>
                <div class="mb-2">
                    <label>Middle Name</label>
                    <input type="text" name="middle_name" maxlength="25" class="form-control only-letters">
                </div>
                <div class="mb-2">
                    <label>Last Name</label>
                    <input type="text" name="last_name" maxlength="25" class="form-control only-letters" required>
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
                    

                    <div class="mb-3">
                        <label for="admin-username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="admin-username" maxlength="25" required>
                    </div>

                    <div class="mb-3">
                        <label for="admin-password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="admin-password" maxlength="25" required>
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
    document.querySelectorAll('.only-letters').forEach(input => {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^a-zA-Z\s\-]/g, '');
        });
    });
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const scrollContainer = document.getElementById("left-panel");
        const scrollTopBtn = document.getElementById("scrollTopBtn");

        scrollContainer.addEventListener("scroll", function () {
            if (scrollContainer.scrollTop > 100) {
                scrollTopBtn.style.display = "block";
            } else {
                scrollTopBtn.style.display = "none";
            }
        });

        scrollTopBtn.addEventListener("click", function () {
            scrollContainer.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    });
</script>

<!-- ADD HERE -->

<script>
  // animate when they enter view
    const observedElements = document.querySelectorAll('.observe');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const el = entry.target;

            if (entry.isIntersecting) {
            // Remove and force reflow to restart animation
                el.classList.remove('show');
            void el.offsetWidth; // This forces a reflow
                el.classList.add('show');
            } else {
                el.classList.remove('show');
            }
        });
    }, {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    });

    observedElements.forEach(el => observer.observe(el));
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const title = document.querySelector('.animated-title');
    const text = title.innerText;
    title.innerHTML = ''; // Clear original text

    // Split letters into spans
    [...text].forEach((letter, index) => {
        const span = document.createElement('span');
        span.innerText = letter;
        span.style.setProperty('--i', index);
        span.addEventListener('click', (e) => createDotEffect(e));
        title.appendChild(span);
    });

    function createDotEffect(e) {
        const dot = document.createElement('div');
        dot.classList.add('dot');

        // Random color
        dot.style.background = `hsl(${Math.random() * 360}, 100%, 50%)`;

        // Position the dot at the click location
        const rect = e.target.getBoundingClientRect();
        dot.style.left = `${rect.left + rect.width / 2}px`;
        dot.style.top = `${rect.top + rect.height / 2}px`;

        document.body.appendChild(dot);

        // Remove dot after animation
        setTimeout(() => {
            dot.remove();
        }, 600);
    }
});
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>