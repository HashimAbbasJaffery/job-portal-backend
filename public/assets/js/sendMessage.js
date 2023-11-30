import messageTemplate from "./messageTemplate.js";
const form = document.querySelector(".messageForm");

form.addEventListener("submit", function(e) {
    e.preventDefault();
    const chatbox = document.querySelector(".chat-box");
    const message = document.querySelector(".messageContent");

    const username = document.getElementById("username");
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
        message: lastMessage
    })
        .then(res => {
            console.log(res)
        })
        .catch(err => {
            console.log(err)
        })
})