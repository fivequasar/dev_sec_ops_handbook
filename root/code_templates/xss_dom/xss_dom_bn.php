<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/root/css/sandbox.css">
</head>

<body>


    <script>
        var url = document.URL + "?username=" + "Isaiah";
        var username = url.indexOf("username=") + 9;
        var user = unescape(url.substring(username));
        document.write("Hello, " + user + "!");
    </script>


    <!-- <script>
        var username = document.URL.indexOf("username=") + 9;
        var user = unescape(document.URL.substring(username));
        document.write("Hello, " + user + "!");
    </script> -->




</body>

</html>