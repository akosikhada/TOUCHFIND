<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | WELCOME PAGE</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a1a;
            color: white;
            height: 100vh;
            position: relative;
            overflow: hidden;
        }
        
        .title {
            font-size: 3.5rem;
            font-weight: bold;
            letter-spacing: 2px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.3s;
        }
        
        .subtitle {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.6s;
        }
        
        .continue-button {
            width: 80px;
            height: 80px;
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
            width: 40px;
            height: 40px;
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
            padding: 40px;
            border-radius: 10px;
            opacity: 0;
            animation: fadeIn 1s ease forwards;
            animation-delay: 0.1s;
        }
        
        .floating-icon {
            position: absolute;
            opacity: 0;
            animation: fadeInFloat 1.5s ease forwards;
        }
        
        #hammer-icon {
            top: 10%;
            left: 8%;
            width: 90px;
            transform: rotate(-15deg);
            animation-delay: 1.2s;
        }
        
        #nail-icon {
            top: 25%;
            right: 12%;
            width: 35px;
            transform: rotate(25deg);
            animation-delay: 1.4s;
        }
        
        #wrench-icon {
            bottom: 15%;
            right: 10%;
            width: 110px;
            transform: rotate(10deg);
            animation-delay: 1.6s;
        }
        
        #box-icon {
            top: 60%;
            left: 12%;
            width: 45px;
            animation-delay: 1.8s;
        }
        
        #tool-icon {
            bottom: 25%;
            left: 20%;
            width: 70px;
            transform: rotate(-20deg);
            animation-delay: 2.0s;
        }
        
        #box-icon2 {
            top: 15%;
            left: 50%;
            width: 30px;
            transform: rotate(15deg);
            animation-delay: 2.2s;
        }
        
        #nail-icon2 {
            bottom: 20%;
            left: 50%;
            width: 25px;
            transform: rotate(-10deg);
            animation-delay: 2.4s;
        }
        
        #box-icon3 {
            top: 40%;
            right: 25%;
            width: 35px;
            transform: rotate(5deg);
            animation-delay: 2.6s;
        }
        
        #nail-icon3 {
            top: 75%;
            right: 35%;
            width: 55px;
            transform: rotate(-30deg);
            opacity: 0;
            animation-delay: 2.8s;
        }
        
        #hammer-icon2 {
            top: 35%;
            left: 25%;
            width: 65px;
            transform: rotate(20deg);
            opacity: 0;
            animation-delay: 3.0s;
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
            <img src="../assets/hammer-icon.png" alt="Wrench" class="img-fluid">
        </div>
        <div class="floating-icon" id="box-icon">
            <img src="../assets/box-icon.png" alt="Box" class="img-fluid">
        </div>
        <div class="floating-icon" id="tool-icon">
            <img src="../assets/wrench-icon.png" alt="Tool" class="img-fluid">
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
            <img src="../assets/wrench-icon.png" alt="Screwdriver" class="img-fluid">
        </div>
        <div class="floating-icon" id="hammer-icon2">
            <img src="../assets/box-icon.png" alt="Hammer" class="img-fluid">
        </div>
    </div>

    <div class="container-fluid d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="text-center mb-4 main-content">
            <h1 class="title">TOUCHFIND</h1>
            <p class="fs-6 mb-3 subtitle mt-3"><i>An interactive kiosk system for effortless product discovery and navigation</i></p>
            <p class="fs-5 mb-5 subtitle">Touch to continue</p>
            
            <div class="continue-button d-flex justify-content-center align-items-center mx-auto">
                <img src="../assets/arrow-icon.png" alt="Continue" class="arrow-icon">
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.continue-button').addEventListener('click', function() {
            // Simple relative path navigation - go to categories.php in the same folder
            window.location.href = 'categories.php';
        });
    </script>
</body>
</html>