import messageTemplate from "./messageTemplate.js";
import pusher from "./pusherConfig.js";
import subscriptions from "./subscriptions.js";

const contacts = document.querySelectorAll(".contact");
contacts.forEach(contact => {
    contact.addEventListener("click", function() {
    const overlay = document.querySelector(".overlay");
    if(!overlay.classList.contains("none")) {
        overlay.classList.add("none");
        overlay.style.display = "none";
    }
    const name = contact.dataset.name;
    const id = contact.dataset.id;
    const key = contact.dataset.key;
    let img = contact.dataset.img;
    // if(!img) {
    //     img = "https://placehold.co/50x50";
    // }
     
    const activeContact = document.querySelector(".active-contact");
    activeContact?.classList.remove("active-contact");

    contact.classList.add("active-contact");
    const recieverId = document.getElementById("reciever_id")
    recieverId.value = id;
    const usernameLabel = document.querySelector(`.user-contact`);
    usernameLabel.textContent = name;
    const profileImage = document.querySelector(".profile-image img");
    profileImage.setAttribute("src", `${ !img ? 'https://placehold.co/50x50' : '/uploads/' + img }`);

        
    const senderId = document.getElementById("sender_id");
    const recieverIds = document.getElementById("reciever_id");

    const communication_between = [ senderId.value, recieverIds.value ];
    const channelName = `${Math.min(...communication_between)}.${Math.max(...communication_between)}.channel`;


  
        var channel = pusher.subscribe(channelName);

        if(subscriptions.length > 1) {
            pusher.unsubscribe(subscriptions[1]);
            subscriptions[1] = channelName;
        } else {
            subscriptions.push(channelName);
        }
        console.log(subscriptions)

        channel.bind('dispatch-message', function(data) {
            console.log(data);
            const recentMessage = document.querySelector(".active-contact .recent-messages");
            const chatBox = document.querySelector(".chat-box");
            const sender_id = document.getElementById("sender_id");
            
            // It executes when the message is recieved by another person to append the data
            // into the chat box

            if(parseInt(sender_id.value) !== data.sender_id) {
                chatBox.innerHTML += messageTemplate("reciever", data.message, data.name, data.profile_pic, data.type, data.task_id);
            } 
            
            var myDiv = document.querySelector('.chat-box');
            myDiv.scrollTop = myDiv.scrollHeight;
        });

        axios.get(`/get/message/${key}`)
            .then(res => {
                console.log(res);
                const { messages } = res.data[0];
                const senderId = res.data[1];
                const messageCollection = JSON.parse(messages);                
                const chatbox = document.querySelector(".chat-box");
                chatbox.innerHTML = "";
                messageCollection.forEach(message => {
                    let template = "";
                    if(message.sender == senderId) {
                        template = messageTemplate("sender", message.message, message.name, message.profile_pic, message.type, message.task_id);
                    } else {
                        template = messageTemplate("reciever", message.message, message.name, message.profile_pic, message.type, message.task_id);
                    }
                    chatbox.innerHTML += template;
                    
                    var myDiv = document.querySelector('.chat-box');
                    myDiv.scrollTop = myDiv.scrollHeight;
                })
            })
            .catch(err => {
                console.log(err)
            })
    })
})