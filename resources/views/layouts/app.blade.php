<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Techzeme</title>
        <link rel="icon" type="image/x-icon" href="/assets/logo.png">
        <link rel="stylesheet" href="/assets/style/reset.css">
        <link rel="stylesheet" href="/assets/style/style.css">
        <script src="https://kit.fontawesome.com/3a7e8b6e65.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        />
        @stack("styles")
    </head>
    <body style="position: relative;">
        <div class="flash-message animate__animated none">
            <p style="margin-bottom: 0px; padding: 10px;">It is flash message</p>
        </div>
        <input type="hidden" id="user_id" value="{{ auth()->user()->id }}" />
        <div id="main">
            <div id="nav" class="side-navbar">
                {{-- <h1>Techzeme.</h1> --}}
                <img src="/assets/img/logo.png" height="50px" style="margin: 10px 0px; margin-bottom: 55px !important;">
                {{-- <p style="text-align: center;padding: 10px; font-family: sans-serif">Welcome <br> {{ auth()->user()->name }}</p> --}}
                <nav>
                    @can("allowed-user", auth()->user())
                        <ul onclick="redirect('/users')"><li class="{{ request()->routeIs("users") ? "active" : "" }}"><a href="#"><i class="fa-solid fa-user"></i><span style="display: inline-block; margin-left: 20px;"></span></a></li></ul>
                    @endcan
                    <ul onclick="redirect('/tasks')"><li class="{{ request()->routeIs("tasks") ? "active" : "" }}"><a href="#"><i class="fa-solid fa-list-check"></i><span style="display: inline-block; margin-left: 20px;"></span></a></li></ul>
                    <ul onclick="redirect('/chats')"><li class="{{ request()->routeIs("chats") ? "active" : "" }}"><a href="#"><i class="fa-solid fa-message"></i><span style="display: inline-block; margin-left: 20px;"></span></a></li></ul>
                    {{-- <i class=""></i> --}}
                    
                    @can("allowed-role", auth()->user())
                        <ul><li onclick="redirect('/roles')" class="{{ request()->routeIs("roles") ? "active" : "" }}"><a href="#"><i class="fa-solid fa-hand-sparkles"></i><span style="display: inline-block; margin-left: 20px;"></span></a></li></ul>
                    @endcan
                    <ul onclick="redirect('notifications')">
                        <li class="{{ request()->routeIs("notifications") ? "active" : "" }}">
                            <a href="#" >
                                <i class="fa-solid fa-bell" style="position: relative;">
                                    <div class="{{ $notification_count ? '' : 'none' }} notification-bell" style="width:9px; height: 9px; border-radius: 50px; background: red; position: absolute; top: -4px; right: 0px;">&nbsp;</div>
                                </i>
                                <span style="display: inline-block; margin-left: 20px;"></span>
                            </a>
                        </li>
                    </ul>
                    <ul onclick="redirect('/setting')">
                        <li class="{{ request()->routeIs("setting") ? "active" : "" }}">
                            <a href="#" >
                                <i class="fa-solid fa-gear" style="position: relative;">
                                </i>
                                <span style="display: inline-block; margin-left: 20px;"></span>
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <li class="logout">
                            <a>
                                <i class="fa-solid fa-power-off"></i>
                                <span style="display: inline-block; margin-left: 20px;"></span>
                            </a>
                        </li>
                    </ul>
                    {{-- <i class="fa-solid fa-gear"></i> --}}
                    
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
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const redirect = href => {
            window.location.href = href; 
        }
    </script>
    <script>

        const logout = document.querySelector(".logout");
        logout.addEventListener("click", function() {
            axios.post("/logout")
                .then(res => {
                    window.location.href = "/login"
                })
                .catch(err => {
                    console.log(err);
                })
        }) 

    </script>
    @stack("scripts")
</html>
