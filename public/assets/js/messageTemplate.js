const messageTemplate = (type, message, username) => (
    `<div class="message ${type}-msg">
        <div class="message-profile ${type}-profile">
            <img src="https://placehold.co/30x30" />
        </div>
        <div class="sender">
            <h1>${username}</h1>
            <p>${message}</p>
        </div>
    </div>`
)
export default messageTemplate;