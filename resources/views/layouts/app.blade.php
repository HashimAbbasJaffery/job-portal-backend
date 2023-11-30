<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Techzeme | Chat</title>
        <link rel="stylesheet" href="/assets/style/reset.css">
        <link rel="stylesheet" href="/assets/style/style.css">
        <script src="https://kit.fontawesome.com/3a7e8b6e65.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="main">
            <div id="nav" class="side-navbar">
                <h1>Techzeme.</h1>
                <nav>
                    <ul><li><a href="#"><i class="fa-solid fa-user"></i><span style="display: inline-block; margin-left: 20px;">Users</span></a></li></ul>
                    <ul><li><a href="#"><i class="fa-solid fa-list-check"></i><span style="display: inline-block; margin-left: 20px;">Tasks</span></a></li></ul>
                    <ul><li class="active"><a href="#"><i class="fa-solid fa-message"></i><span style="display: inline-block; margin-left: 20px;">Chats</span></a></li></ul>
                    <ul><li><a href="#"><i class="fa-solid fa-plus"></i><span style="display: inline-block; margin-left: 20px;">Assign Tasks</span></a></li></ul>
                    <ul><li><a href="#"><i class="fa-solid fa-list-check"></i><span style="display: inline-block; margin-left: 20px;">Tasks</span></a></li></ul>
                </nav>
            </div>
                {{ $slot }}

                    </div>
    </body>
    <script>
          function scrollToBottom() {
            var myDiv = document.querySelector('.chat-box');
            myDiv.scrollTop = myDiv.scrollHeight;
        }

        // Call the function to scroll to the bottom (you can trigger this event based on your requirements)
        scrollToBottom();
    </script>
</html>
