<x-app-layout>
            <div id="mainbod" style="display: flex;">
                <input type="hidden" value="{{ auth()->user()->name }}" id="username"/>
                <input type="hidden" id="sender_id" value="{{ auth()->user()->id }}"/>
                <input type="hidden" id="reciever_id" />
                <input type="hidden" id="user_dp" value="{{ auth()->user()->profile->profile_picture }}" />
                <div id="contacts" class="contacts">
                    <h1 style="padding: 10px; margin-bottom: 10px; margin-top: 10px;">Contacts</h1>
                    @forelse($contacts as $contact)
                        <div class="contact" data-img="{{ $contact->profile->profile_picture }}" data-key="{{ $contact->message_id }}" data-name="{{ $contact->name }}" data-id="{{ $contact->id }}">
                            <div class="contact-photo">
                                @if($contact->profile->profile_picture)
                                    <img src="/uploads/{{ $contact->profile->profile_picture }}" style="height: 50px; width: 50px;"/>
                                @else 
                                    <img src="https://placehold.co/50x50" />
                                @endif
                            </div>
                            <div class="contact-name chat-detail">
                                
                                <div>
                                    <h1>{{ $contact->name }}</h1>
                                    <p class="recent-messages recent-{{ $contact->message }}">{{ $contact?->lastMessage->name ?? "" }}: {{ $contact?->lastMessage->message ?? "No Message Found" }}</p>
                                </div>
                            </div>
                        </div>
                    @empty 
                        <div class="empty">
                            <p>No contacts found in the list</p>
                        </div>
                    @endforelse
                    
                </div>
                <div id="chats" style="position: relative;">
                <div class="overlay" style="position: absolute;">
                    <div style="text-align: center;">
                        <i class="fa-solid fa-address-book" style="margin-bottom: 10px;"></i>
                        <p>Click any contacts to start chatting right away!</p>
                    </div>
                </div>
                
                    <div id="header" class="profile-details">
                        <div class="profile-image">
                            <img src="https://placehold.co/50x50" style="width: 50px; height: 50px;"/>
                        </div>
                        <div class="profile-detail">
                            <h1 class="user-contact"></h1>
                            {{-- <div class="online">Online <div class="online-status">&nbsp;</div></div> --}}
                        </div>
                    </div>
                    <div class="chat-box">
                  
                    </div>
                    <div id="sendmsg">
                        <form class="messageForm">
                        <input type="text" placeholder="Send Message..." class="messageContent">
                        <button><i class="fa-solid fa-paper-plane" style="font-size : 20px ;"></i></button>
                    </form>
                    </div>
                </div>
            </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const assigner = urlParams.get('assigner');
    const contact = document.querySelector(`.contact[data-id='${assigner}']`);
        contact.click();
    })
</script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="/assets/js/start-chat.js" type="module"></script>
<script src="/assets/js/sendMessage.js" type="module"></script>
<script src="/assets/js/typing.js" type="module"></script>
</x-app-layout>