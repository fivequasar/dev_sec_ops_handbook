<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        nav {
            background-color: #444;
            color: #fff;
            padding: 0.5em;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 1em;
            margin: 0 0.5em;
        }

        .product {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 1em;
        }

        .product-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 1em;
            padding: 1em;
            width: 300px;
            text-align: center;
        }

        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 1em;
            text-align: center;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 1em;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .urlbar {
            width: 400px;
            height: 30px;
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .urlbar:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
    <title>Sandbox Website</title>
</head>

<body>

    <div>
        <span class="url">URL</span>
        <input id="urlInput" type="text" value="" style="width:620px; height:25px; font-size: 16px;">
        <button style="padding: 5px 20px; font-size: 14px;" onclick="editURL()">Go</button>
    </div>

    <header>
        <h1>Sandbox Website</h1>
    </header>

    <nav>
        <a href="">Home</a>
        <a href="">My Profile</a>
        <a href="">Logout</a>
    </nav>

    <div class="profile-container">
        <h2>Your Profile</h2>
        <img class="profile-picture" src="/images/profile_icon.jpg" alt="Profile Picture">

        <br>
        <script>
            function editURL() {

                var urlInput = document.getElementById("urlInput");
                window.history.pushState({}, '', urlInput.value);
                location.reload();

            }
            document.getElementById("urlInput").value = document.URL;
            var username = document.URL.indexOf("username=") + 9;
            var user = unescape(document.URL.substring(username));
            document.write("Hello, " + user + "!");
        </script>


    </div>



    <footer>
        &copy; Sandbox Environment
    </footer>


</body>

</html>
