<x-app-layout>
            <div id="mainbod" class="notifications" style="display: block;">
                <h1 style="padding: 30px">Notifications</h1>
                <div class="notifications-collection">
                    @forelse($unread_messages as $unread_message)
                        <div class="notification">
                            <div class="icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="notification-details">
                                <h1>You have recieved message from {{ $unread_message?->sender_name ?? "xyz" }}</h1>
                                <p>Message: <span style="font-style: italic; font-weight: bold;">{{ $unread_message->message }}</span></p>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-danger empty">No Notifications Found!</div>
                    @endforelse
                </div>
            </div>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="/assets/js/start-chat.js" type="module"></script>
<script src="/assets/js/sendMessage.js" type="module"></script>
</x-app-layout>