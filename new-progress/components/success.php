<?php
// Generate a random order number if not provided in URL
$orderNumber = isset($_GET['order_id']) ? $_GET['order_id'] : 'ORD-' . date('Y') . '-' . rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>TOUCHFIND | Order Confirmed</title>
    <!-- Main CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }
        
        html, body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            background-color: #121212;
            color: white;
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
        }
        
        .success-container {
            background-color: #1e293b;
            border-radius: 15px;
            width: 92%;
            max-width: 600px;
            padding: min(8vw, 50px) min(5vw, 30px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .success-icon {
            width: min(15vw, 70px);
            height: min(15vw, 70px);
            background-color: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: min(5vw, 20px);
            animation: scaleIn 0.5s ease-out;
        }
        
        .success-icon svg {
            width: min(9vw, 40px);
            height: min(9vw, 40px);
            fill: white;
        }
        
        h1 {
            font-size: clamp(24px, 5vw, 32px);
            font-weight: 600;
            margin: 10px 0 clamp(20px, 7vw, 40px);
            animation: fadeIn 0.5s ease-out 0.3s both;
        }
        
        .order-number-box {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: clamp(15px, 4vw, 20px);
            width: 100%;
            max-width: 450px;
            margin-bottom: clamp(20px, 5vw, 30px);
            animation: fadeIn 0.5s ease-out 0.5s both;
        }
        
        .order-number-label {
            font-size: clamp(14px, 3vw, 16px);
            color: #94a3b8;
            margin-bottom: 10px;
        }
        
        .order-number {
            font-size: clamp(18px, 4vw, 24px);
            font-weight: 700;
            letter-spacing: 1px;
            word-break: break-all;
        }
        
        .thank-you {
            font-size: clamp(16px, 3.5vw, 18px);
            color: #94a3b8;
            margin-bottom: clamp(30px, 8vw, 40px);
            animation: fadeIn 0.5s ease-out 0.7s both;
        }
        
        .footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: clamp(12px, 2.5vw, 14px);
            color: #64748b;
            animation: fadeIn 0.5s ease-out 0.9s both;
        }
        
        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            70% {
                transform: scale(1.1);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .continue-button {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: clamp(10px, 3vw, 12px) clamp(15px, 5vw, 25px);
            border-radius: 5px;
            font-weight: 600;
            font-size: clamp(14px, 3vw, 16px);
            cursor: pointer;
            margin-bottom: 30px;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), 
                        transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .continue-button.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .continue-button:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
            transition: all 0.3s ease;
        }
        
        .continue-button:active {
            transform: translateY(1px);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.4);
            transition: all 0.1s ease;
        }
        
        /* Additional responsive adjustments */
        @media screen and (max-height: 700px) {
            .success-container {
                padding-top: 20px;
                padding-bottom: 20px;
            }
            
            .footer {
                position: relative;
                margin-top: 20px;
                bottom: auto;
            }
        }
        
        @media screen and (max-width: 320px) {
            .success-container {
                padding: 20px 15px;
            }
            
            .order-number-box {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
            </svg>
        </div>
        
        <h1>Order Confirmed!</h1>
        
        <div class="order-number-box">
            <div class="order-number-label">Order Number</div>
            <div class="order-number">#<?php echo $orderNumber; ?></div>
        </div>
        
        <div class="thank-you">Thank you for your purchase!</div>
        
        <div class="footer">© 2024 TOUCHFIND. All rights reserved.</div>
    </div>
    
    <script>
        // Clear cart after successful order
        document.addEventListener('DOMContentLoaded', function() {
            // Clear the cart in localStorage
            localStorage.setItem('touchfindCart', JSON.stringify([]));
            
            // Add button to go back to shopping with smoother animation
            setTimeout(() => {
                const container = document.querySelector('.success-container');
                const footer = document.querySelector('.footer');
                
                // Create button with class instead of inline styles
                const button = document.createElement('button');
                button.textContent = 'Continue Shopping';
                button.className = 'continue-button';
                
                // Add click handler
                button.onclick = function() {
                    window.location.href = 'categories.php';
                };
                
                // Insert before footer
                container.insertBefore(button, footer);
                
                // Trigger animation after a short delay for smoother effect
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        button.classList.add('visible');
                    }, 50);
                });
            }, 1200);
        });
    </script>
</body>
</html>