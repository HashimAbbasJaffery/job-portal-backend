import pusherConfig from "./pusherConfig.js";

const reciever_id = document.getElementById("user_id");
const notifications = pusherConfig.subscribe(`notification.${reciever_id.value}`);


notifications.bind('notification-event', function(data) {
    const notificationBell = document.querySelector(".notification-bell");
    notificationBell.classList.remove("none")

});