import messageTemplate from "./messageTemplate.js";
const form = document.querySelector(".messageForm");
import { truncateString } from "./utils/helpers.js";

form.addEventListener("submit", function(e) {
    e.preventDefault();
    const chatbox = document.querySelector(".chat-box");
    const message = document.querySelector(".messageContent");
    if(!message.value) return;
    const activeContact = document.querySelector(".active-contact");
    const key = activeContact.dataset.key;

    let recentMessage = document.querySelector(".active-contact .recent-messages");
    const string = `${username.value}: ${message.value}`;
    recentMessage.textContent = truncateString(60, string);
    chatbox.innerHTML += messageTemplate("sender", message.value, username.value);
    const lastMessage = message.value;
    message.value = "";

    var myDiv = document.querySelector('.chat-box');
    myDiv.scrollTop = myDiv.scrollHeight;

    const senderId = document.getElementById("sender_id");
    const recieverIds = document.getElementById("reciever_id");

    axios.post("/sendMessage", {
        sender_id: senderId.value,
        reciever_id: recieverIds.value,
        message: lastMessage,
        key: key
    })
        .then(res => {
            console.log(res)
        })
        .catch(err => {
            console.log(err)
        })
})