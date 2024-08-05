<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Food Network</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        /* Header styles */
        .header {
            background-color: #588157;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .header .logo {
            font-size: 32px;
            font-weight: bold;
        }

        .header .logo b {
            color: #ff6347;
        }

        /* Main styles */
        main {
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            color: #333;
        }

        .container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 300px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #588157;
        }

        .card a {
            display: block;
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #ff6347;
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .card a:hover {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>

<body>
    <header class="header">
        <p class="logo">Welcome to Easy <b>Food</b> Network</p>
    </header>
    
    <main>
        <div class="container">
            <div class="card">
                <div class="title">Login</div>
                <a href="NGO/ngosignin.php">NGO</a>
                <a href="signin.php">Donor</a>
                <a href="delivery/deliverylogin.php">Delivery</a>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
