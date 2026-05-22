<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HobbyHub</title>

    <link rel="shortcut icon" href="./favicon.ico">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        body {
            min-height: 100vh;
            color: white;
            background: url("landing.jpg") center/cover no-repeat;
            overflow-x: hidden;
        }

        .overlay-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.55);
            z-index: 0;
        }

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 18px 34px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            background: #10131add;
            backdrop-filter: blur(12px);

            border-bottom: 1px solid rgba(255, 255, 255, .08);

            z-index: 2;
        }

        .brand {
            font-size: 1.5rem;
            font-weight: 900;

            background: linear-gradient(90deg, #fff, #8fcfff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth {
            display: flex;
            gap: 12px;
        }

        /* BUTTON STYLING (NOW REAL BUTTONS) */
        .auth button {
            cursor: pointer;

            color: white;

            padding: 10px 18px;
            border-radius: 12px;

            background: linear-gradient(90deg, #338bff, #4eb0ff);
            border: none;

            font-weight: 700;

            transition: 0.2s;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        }

        .auth button:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .auth button:active {
            transform: translateY(0px);
        }

        .hero {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            text-align: center;
            padding: 40px;

            position: relative;
            z-index: 2;
        }

        .overlay {
            max-width: 900px;
        }

        .overlay h1 {
            font-size: 4.5rem;
            font-weight: 900;
            margin-bottom: 20px;

            color: white;
            text-shadow: 0 8px 30px rgba(0, 0, 0, 0.9);
        }

        .overlay p {
            font-size: 1.2rem;
            line-height: 1.7;

            color: #f3f4f6;

            background: rgba(0, 0, 0, 0.45);
            padding: 18px 22px;
            border-radius: 16px;

            backdrop-filter: blur(8px);

            margin-bottom: 40px;
        }

        .button {
            display: inline-block;
            padding: 18px 34px;

            border-radius: 16px;

            text-decoration: none;
            font-weight: 900;
            font-size: 1.05rem;

            color: white;

            background: linear-gradient(90deg, #338bff, #4eb0ff);

            transition: .2s;
        }

        .button:hover {
            transform: translateY(-3px);
        }

        @media(max-width:800px) {
            .overlay h1 {
                font-size: 3rem;
            }

            .overlay p {
                font-size: 1rem;
            }
        }
    </style>

</head>

<body>

    <div class="overlay-bg"></div>

    <div class="topbar">

        <div class="brand">
            HobbyHub
        </div>

        <div class="auth">

            <button onclick="location.href='login.php'">Log In</button>
            <button onclick="location.href='signup.php'">Sign Up</button>

        </div>

    </div>

    <div class="hero">

        <div class="overlay">

            <h1>Discover HobbyHub</h1>

            <p>
                Find people who share your hobbies and passions.
                Build, compete, create, and join communities for coding, music, LEGO, photography, gaming, and more.
            </p>

            <a class="button" href="login.php">
                Explore Clubs →
            </a>

        </div>

    </div>

</body>

</html>