<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* ACTIVITY: add any css here */
        p {
            font-family: Verdana, sans-serif;
            color: #2F4F4F;
        }
        body {
            background-color:#FFE4C4;
        }
    </style>
</head>
<body>
    <p>Hello, {{ $name }}!</p>
    <p>Thank you for registering. To continue, please visit our website <a href="{{ $app_url }}">here</a>.</p>
    <p>Thank you!</p>
</body>
</html>