<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="/assets/logo.png">
    <link rel="stylesheet" href="/assets/reset.css">
    <link rel="stylesheet" href="/assets/style/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="login-page">
    <div id="wrapper" class="h-full">
        <div class="login" id="login">
            <header class="login-header" style="display: flex;">
                    <img style="margin: 0 auto;" src="/assets/img/logo.png" width="60" alt="">
                    <!-- <div id="logo-detail">    
                        <h1>Techzeme</h1>
                    </div> -->
            </header>
            <x-auth-session-status class="mb-4" :status="session('status')" />

            {{$slot}}

            </div>
    </div>
    <script src="/assets/js/moving-effect.js"></script>
</body>
</html>