import pusherConfig from "./pusherConfig.js";
import { truncateString } from "./utils/helpers.js";
import subscriptions from "./subscriptions.js";

const reciever_id = document.getElementById("user_id");
const channel_name = `notification.${reciever_id.value}`;

const notifications = pusherConfig.subscribe(channel_name);
subscriptions.push(channel_name);

notifications.bind('notification-event', function(data) {
    const senderContact = document.querySelector(`.contact[data-id='${data.sender_id}'] .recent-messages`);
    if(senderContact) {
        const recentMessage = `${data.sender_name}: ${data.message}`;
        senderContact.textContent = truncateString(60, recentMessage);
        return;
    }
    const notificationBell = document.querySelector(".notification-bell");
    notificationBell.classList.remove("none")
    console.log(data);
});