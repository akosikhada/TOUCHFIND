<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>TOUCHFIND | WELCOME PAGE</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }
        
        body {
            background-color: #1a1a1a;
            color: white;
            height: 100vh;
            position: relative;
            overflow: hidden;
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
        }
        
        .title {
            font-size: clamp(2rem, 8vw, 3.5rem);
            font-weight: bold;
            letter-spacing: 2px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.3s;
            margin-bottom: clamp(0.5rem, 2vw, 1rem);
        }
        
        .subtitle {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.6s;
            font-size: clamp(0.875rem, 3vw, 1rem);
            max-width: 90%;
            margin-left: auto;
            margin-right: auto;
        }
        
        .subtitle.mt-3 {
            margin-top: clamp(0.5rem, 2vw, 1rem) !important;
        }
        
        .subtitle.mb-5 {
            margin-bottom: clamp(1rem, 4vw, 3rem) !important;
        }
        
        .continue-button {
            width: clamp(60px, 15vw, 80px);
            height: clamp(60px, 15vw, 80px);
            border: 2px solid white;
            border-radius: 5px;
            background-color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            z-index: 10;
            overflow: hidden;
            opacity: 0;
            transform: scale(0.8);
            animation: fadeInScale 0.8s ease forwards;
            animation-delay: 0.9s;
        }
        
        .continue-button:hover {
            background-color: #444;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
        }
        
        .continue-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        
        .continue-button:hover::before {
            left: 100%;
        }
        
        .arrow-icon {
            width: clamp(30px, 8vw, 40px);
            height: clamp(30px, 8vw, 40px);
            transition: transform 0.3s ease;
            position: relative;
        }
        
        .continue-button:hover .arrow-icon {
            transform: translateX(5px);
            filter: brightness(1.3);
        }
        
        .background-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }
        
        .main-content {
            position: relative;
            z-index: 5;
            background-color: rgba(26, 26, 26, 0.7);
            padding: clamp(20px, 5vw, 40px);
            border-radius: 10px;
            opacity: 0;
            animation: fadeIn 1s ease forwards;
            animation-delay: 0.1s;
            width: clamp(280px, 90%, 500px);
        }
        
        /* Responsive floating icons */
        .floating-icon {
            position: absolute;
            opacity: 0;
            animation: fadeInFloat 1.5s ease forwards;
        }
        
        #hammer-icon {
            top: 10%;
            left: 8%;
            width: clamp(50px, 10vw, 90px);
            transform: rotate(-15deg);
            animation-delay: 1.2s;
        }
        
        #nail-icon {
            top: 25%;
            right: 12%;
            width: clamp(20px, 5vw, 35px);
            transform: rotate(25deg);
            animation-delay: 1.4s;
        }
        
        #wrench-icon {
            bottom: 15%;
            right: 10%;
            width: clamp(60px, 12vw, 110px);
            transform: rotate(10deg);
            animation-delay: 1.6s;
        }
        
        #box-icon {
            top: 60%;
            left: 12%;
            width: clamp(25px, 7vw, 45px);
            animation-delay: 1.8s;
        }
        
        #tool-icon {
            bottom: 25%;
            left: 20%;
            width: clamp(40px, 8vw, 70px);
            transform: rotate(-20deg);
            animation-delay: 2.0s;
        }
        
        #box-icon2 {
            top: 15%;
            left: 50%;
            width: clamp(20px, 4vw, 30px);
            transform: rotate(15deg);
            animation-delay: 2.2s;
        }
        
        #nail-icon2 {
            bottom: 20%;
            left: 50%;
            width: clamp(15px, 4vw, 25px);
            transform: rotate(-10deg);
            animation-delay: 2.4s;
        }
        
        #box-icon3 {
            top: 40%;
            right: 25%;
            width: clamp(20px, 5vw, 35px);
            transform: rotate(5deg);
            animation-delay: 2.6s;
        }
        
        #nail-icon3 {
            top: 75%;
            right: 35%;
            width: clamp(30px, 7vw, 55px);
            transform: rotate(-30deg);
            opacity: 0;
            animation-delay: 2.8s;
        }
        
        #hammer-icon2 {
            top: 35%;
            left: 25%;
            width: clamp(35px, 8vw, 65px);
            transform: rotate(20deg);
            opacity: 0;
            animation-delay: 3.0s;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .floating-icon {
                opacity: 0.2; /* Make icons slightly less prominent on mobile */
            }
            
            .main-content {
                background-color: rgba(26, 26, 26, 0.8); /* Slightly darker background on mobile */
            }
        }
        
        @media (max-height: 600px) {
            .title {
                margin-bottom: 0.25rem;
            }
            
            .subtitle.mt-3 {
                margin-top: 0.25rem !important;
            }
            
            .subtitle.mb-5 {
                margin-bottom: 0.75rem !important;
            }
            
            .main-content {
                padding: 15px;
            }
        }
        
        @media (max-width: 360px) {
            .background-container {
                display: none; /* Hide floating icons on very small screens */
            }
        }

        /* Entrance Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @keyframes fadeInFloat {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 0.3;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="background-container">
        <div class="floating-icon" id="hammer-icon">
            <img src="../assets/hammer-icon.png" alt="Hammer" class="img-fluid">
        </div>
        <div class="floating-icon" id="nail-icon">
            <img src="../assets/nail-icon.png" alt="Nail" class="img-fluid">
        </div>
        <div class="floating-icon" id="wrench-icon">
            <img src="../assets/hammer-icon.png" alt="Hammer" class="img-fluid">
        </div>
        <div class="floating-icon" id="box-icon">
            <img src="../assets/box-icon.png" alt="Box" class="img-fluid">
        </div>
        <div class="floating-icon" id="tool-icon">
            <img src="../assets/wrench-icon.png" alt="Wrench" class="img-fluid">
        </div>
        <div class="floating-icon" id="box-icon2">
            <img src="../assets/box-icon.png" alt="Box" class="img-fluid">
        </div>
        <div class="floating-icon" id="nail-icon2">
            <img src="../assets/nail-icon.png" alt="Nail" class="img-fluid">
        </div>
        <div class="floating-icon" id="box-icon3">
            <img src="../assets/box-icon.png" alt="Box" class="img-fluid">
        </div>
        <div class="floating-icon" id="nail-icon3">
            <img src="../assets/wrench-icon.png" alt="Wrench" class="img-fluid">
        </div>
        <div class="floating-icon" id="hammer-icon2">
            <img src="../assets/box-icon.png" alt="Box" class="img-fluid">
        </div>
    </div>

    <div class="container-fluid d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="text-center mb-4 main-content">
            <h1 class="title">TOUCHFIND</h1>
            <p class="subtitle mt-3"><i>An interactive kiosk system for effortless product discovery and navigation</i></p>
            <p class="subtitle mb-5">Touch to continue</p>
            
            <div class="continue-button d-flex justify-content-center align-items-center mx-auto">
                <img src="../assets/arrow-icon.png" alt="Continue" class="arrow-icon">
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.continue-button').addEventListener('click', function() {
            window.location.href = 'categories.php';
        });
        
        // Add touch events for mobile
        document.querySelector('.continue-button').addEventListener('touchstart', function() {
            this.style.backgroundColor = '#444';
        });
        
        document.querySelector('.continue-button').addEventListener('touchend', function() {
            this.style.backgroundColor = '#333';
            window.location.href = 'categories.php';
        });
    </script>
</body>
</html>