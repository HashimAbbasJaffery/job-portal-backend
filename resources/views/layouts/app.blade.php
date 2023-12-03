<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Techzeme | Chat</title>
        <link rel="stylesheet" href="/assets/style/reset.css">
        <link rel="stylesheet" href="/assets/style/style.css">
        <script src="https://kit.fontawesome.com/3a7e8b6e65.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
        @stack("styles")
    </head>
    <body style="position: relative;">
        <input type="hidden" id="user_id" value="{{ auth()->user()->id }}" />
        <div id="main">
            <div id="nav" class="side-navbar">
                <h1>Techzeme.</h1>
                <nav>
                    <ul><li><a href="#"><i class="fa-solid fa-door-open"></i><span style="display: inline-block; margin-left: 20px;">{{ auth()->user()->name }}</span></a></li></ul>
                    <ul><li><a href="#"><i class="fa-solid fa-user"></i><span style="display: inline-block; margin-left: 20px;">Users</span></a></li></ul>
                    <ul><li><a href="#"><i class="fa-solid fa-list-check"></i><span style="display: inline-block; margin-left: 20px;">Tasks</span></a></li></ul>
                    <ul><li class="active"><a href="#"><i class="fa-solid fa-message"></i><span style="display: inline-block; margin-left: 20px;">Chats</span></a></li></ul>
                    <ul><li><a href="#"><i class="fa-solid fa-plus"></i><span style="display: inline-block; margin-left: 20px;">Assign Tasks</span></a></li></ul>
                    <ul>
                        <li>
                            <a href="#" >
                                <i class="fa-solid fa-bell" style="position: relative;">
                                    <div class="{{ $notification_count ? '' : 'none' }} notification-bell" style="width:9px; height: 9px; border-radius: 50px; background: #23c552; position: absolute; top: -4px; right: 0px;">&nbsp;</div>
                                </i>
                                <span style="display: inline-block; margin-left: 20px;">Notification</span>
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="#">
                                <i class="fa-solid fa-power-off"></i>
                                <span style="display: inline-block; margin-left: 20px;">Log Out</span>
                            </a>
                        </li> 
                    </ul>
                </nav>
            </div>
                {{ $slot }}

                    </div>
    </body>
    
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script type="module" src="/assets/js/initializer.js"></script>
    <script>
          function scrollToBottom() {
            var myDiv = document.querySelector('.chat-box');
            myDiv.scrollTop = myDiv.scrollHeight;
        }

        // Call the function to scroll to the bottom (you can trigger this event based on your requirements)
        scrollToBottom();
    </script>
    @stack("scripts")
</html>
