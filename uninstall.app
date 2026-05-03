<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hobby Hub</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        body {
            background: radial-gradient(circle at top, #0b1220, #05070f);
            color: #e5e7eb;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* TOP BAR */
        .topbar {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 28px;
            background: rgba(10, 12, 20, 0.7);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            z-index: 1000;
        }

        .brand {
            font-weight: 700;
            letter-spacing: 1px;
        }

        .auth {
            display: flex;
            gap: 12px;
        }

        .auth a {
            color: #e5e7eb;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: 0.25s ease;
        }

        .auth a:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        /* CONTENT */
        .container {
            padding: 120px 40px 60px;
            max-width: 1400px;
            margin: auto;
            text-align: center;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        p {
            color: #a1a1aa;
            margin-bottom: 40px;
        }

        /* GRID */
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        @media (max-width: 1100px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        /* CARD */
        .card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 22px;
            text-align: left;
            transition: 0.3s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            border-color: rgba(79, 209, 255, 0.35);
            box-shadow: 0 0 25px rgba(79, 209, 255, 0.12);
        }

        .card h3 {
            margin-bottom: 6px;
        }

        .card p {
            font-size: 0.9rem;
            margin-bottom: 14px;
        }

        /* ENTER BUTTON */
        .enter {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.06);
            color: #e5e7eb;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: 0.25s ease;
        }

        .enter:hover {
            box-shadow: 0 0 18px rgba(79, 209, 255, 0.5);
            border-color: rgba(79, 209, 255, 0.4);
            transform: translateY(-2px);
        }

        .tag {
            margin-top: 40px;
            color: #71717a;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <div class="topbar">
        <div class="brand">Hobby Hub</div>
        <div class="auth">
            <a href="login.html">Log In</a>
            <a href="signup.html">Sign Up</a>
        </div>
    </div>

    <div class="container">
        <h1>Active Hobby Clubs</h1>
        <p>Join communities built around real skills, creativity, and competition.</p>

        <div class="grid">

            <div class="card">
                <h3>Cardistry</h3>
                <p>Master flourishes, cuts, and visual card magic.</p>
                <a class="enter" href="cardistry.html">Enter Club</a>
            </div>

            <div class="card">
                <h3>Speedcubing</h3>
                <p>Solve cubes faster with algorithms and practice.</p>
                <a class="enter" href="cubing.html">Enter Club</a>
            </div>

            <div class="card">
                <h3>LEGO Engineering</h3>
                <p>Build complex mechanical creations and designs.</p>
                <a class="enter" href="lego.html">Enter Club</a>
            </div>

            <div class="card">
                <h3>Mechanical Keyboards</h3>
                <p>Customize, build, and design keyboard setups.</p>
                <a class="enter" href="keyboards.html">Enter Club</a>
            </div>

            <div class="card">
                <h3>Guitar</h3>
                <p>Learn riffs, solos, and music theory.</p>
                <a class="enter" href="guitar.html">Enter Club</a>
            </div>

            <div class="card">
                <h3>Yo-Yo Tricks</h3>
                <p>Advanced string tricks and freestyle combos.</p>
                <a class="enter" href="yoyo.html">Enter Club</a>
            </div>

            <div class="card">
                <h3>Photography</h3>
                <p>Capture, edit, and share visual storytelling.</p>
                <a class="enter" href="photo.html">Enter Club</a>
            </div>

            <div class="card">
                <h3>Coding</h3>
                <p>Build projects, games, and real-world apps.</p>
                <a class="enter" href="coding.html">Enter Club</a>
            </div>

        </div>

        <div class="tag">More clubs unlock as the community grows.</div>

    </div>

</body>

</html>