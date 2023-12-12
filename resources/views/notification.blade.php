<x-app-layout>
            <div id="mainbod" class="notifications" style="display: block;">
                <h1 style="padding: 30px">Notifications</h1>
                <div class="notifications-collection">
                    @forelse($messages as $message)
                        <div class="notification" id="message-{{ $loop->index }}" data-id="{{ $message->id }}">
                            <div class="icon">
                                @if($message->type === "message")
                                    <i class="envelope-icon fa-solid fa-envelope"></i>
                                @elseif($message->type === "new_task")
                                    <i class="envelope-icon fa-solid fa-file"></i>
                                @endif
                            </div>
                            <div class="notification-details">
                                <h1 style="display: flex; justify-content: space-between; align-items: center; position: relative;">
                                    @if($message->type == "message")    
                                        You have recieved message from {{ $message?->sender_name ?? "xyz" }}
                                        {{-- <i class="fa-solid fa-file"></i> --}}
                                    @elseif($message->type === "new_task")
                                        You have recieved new task from {{ $message?->sender_name ?? "xyz" }}
                                    @endif 
                                    <i class="fa-solid fa-xmark message-{{ $loop->index }}" style="color: #111433; display: none; font-size:18px; position: absolute; right: 0px;"></i>
                                </h1>
                                <p>Message: <span style="">{{ $message->message }}</span></p>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-danger empty">Oops..!! No Notifications Found!</div>
                    @endforelse
                </div>
            </div>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const notifications = document.querySelectorAll(".notification");
    notifications.forEach(notification => {
        notification.addEventListener("mouseover", function() {
            const id = notification.id;
            const delete_icon = document.querySelector(`.${id}`);
            delete_icon.style.display = "inline-block";
        })
        notification.addEventListener("mouseout", function() {
            const id = notification.id;
            const delete_icon = document.querySelector(`.${id}`);
            delete_icon.style.display = "none";
        });
        notification.addEventListener("click", function() {
            let id = notification.dataset.id;
            axios.delete(`/notification/${id}/delete`)
                .then(res => {
                    if(res.data === 1) {
                        const collection = document.querySelector(".notifications-collection");
                        notification.remove();
                        if(collection.children.length === 0) {
                            collection.innerHTML = `<div class="alert alert-danger empty">Oops..!! No Notifications Found!</div>`;
                        }
                    }
                })
                .catch(err => {
                    console.log(err);
                })
            
        })
    })
</script>
</x-app-layout>