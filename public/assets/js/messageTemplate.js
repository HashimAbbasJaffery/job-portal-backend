const messageTemplate = (type, message, username, profile_pic, messageType, taskId) => (
    `<div class="message ${type}-msg">
        <div class="message-profile ${type}-profile">
            <img style="width: 30px; height: 30px;" loading="lazy" src="${ !profile_pic ? 'https://placehold.co/30x30' : '/uploads/' + profile_pic }" />
        </div>
        <div class="sender">
            <h1>${username}</h1>
            <p>${message}</p>
            ${ messageType === "new_task" ? "<a href='/task/" + taskId + "' class='chat-link'>Details</a>" : "" }
            ${ messageType === "submit_task" ? "<a href='/task/" + taskId + "/download' class='chat-link'>Download</a>" : "" }
        </div>
    </div>`
)
export default messageTemplate;