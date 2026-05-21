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

            background:
                url("landing.jpg");

            background-size: cover;

            background-position: center;

            background-repeat: no-repeat;

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

            border-bottom:
                1px solid rgba(255, 255, 255, .08);

            z-index: 1000;

        }

        .brand {

            font-size: 1.5rem;

            font-weight: 900;

            background:
                linear-gradient(90deg,
                    #ffffff,
                    #8fcfff);

            -webkit-background-clip: text;

            -webkit-text-fill-color: transparent;

        }

        .auth {

            display: flex;

            gap: 12px;

        }

        .auth a {

            text-decoration: none;

            color: white;

            padding: 10px 18px;

            border-radius: 12px;

            background: #1d2635;

            border:
                1px solid rgba(255, 255, 255, .08);

            transition: .2s;

        }

        .auth a:hover {

            background: #2a3850;

        }

        .hero {

            height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            text-align: center;

            padding: 40px;

        }

        .overlay {

            max-width: 900px;

        }

        .overlay h1 {

            font-size: 4.8rem;

            font-weight: 900;

            margin-bottom: 20px;

            text-shadow:
                0 10px 40px rgba(0, 0, 0, .5);

        }

        .overlay p {

            font-size: 1.2rem;

            line-height: 1.7;

            color: #e7e7e7;

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

            background:
                linear-gradient(90deg,
                    #338bff,
                    #4eb0ff);

            transition: .2s;

        }

        .button:hover {

            transform:
                translateY(-3px);

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

    <div class="topbar">

        <div class="brand">

            HobbyHub

        </div>

        <div class="auth">

            <a href="login.php">

                Log In

            </a>

            <a href="signup.php">

                Sign Up

            </a>

        </div>

    </div>

    <div class="hero">

        <div class="overlay">

            <h1>

                Discover HobbyHub

            </h1>

            <p>

                Find people who enjoy the same hobbies as you.

                Join communities for building, coding, photography, music, puzzles, collecting, creativity, and more.

                Create clubs, explore interests, and grow together.

            </p>

            <a class="button" href="login.php">

                Explore Clubs →

            </a>

        </div>

    </div>

</body>

</html>