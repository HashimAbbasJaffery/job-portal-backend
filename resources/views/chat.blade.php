<x-app-layout>
            <div id="mainbod">
                <input type="hidden" value="{{ auth()->user()->name }}" id="username"/>
                <input type="hidden" id="sender_id" value="{{ auth()->user()->id }}"/>
                <input type="hidden" id="reciever_id" />
                <div id="contacts" class="contacts">
                    <h1 style="padding: 10px; margin-bottom: 10px; margin-top: 10px;">Contacts</h1>
                    @forelse($contacts as $contact)
                        <div class="contact" data-key="{{ $contact->message_id }}" data-name="{{ $contact->name }}" data-id="{{ $contact->id }}">
                            <div class="contact-photo">
                                <img src="https://placehold.co/50x50" />
                            </div>
                            <div class="contact-name chat-detail">
                                
                                <div >
                                    <h1>{{ $contact->name }}</h1>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, praesentium...</p>
                                </div>
                            </div>
                        </div>
                    @empty 
                        <div class="alert aler-danger">
                            <p>No contacts found in the list</p>
                        </div>
                    @endforelse
                    
                </div>
                <div id="chats">
                    <div id="header" class="profile-details">
                        <div class="profile-image">
                            <img src="https://placehold.co/50x50" />
                        </div>
                        <div class="profile-detail">
                            <h1 class="user-{{ $contact->id }}">Hashim abbas</h1>
                            <div class="online">Online <div class="online-status">&nbsp;</div></div>
                        </div>
                    </div>
                    <div class="chat-box">
                  
                    </div>
                    <div id="sendmsg">
                        <form class="messageForm">
                        <input type="text" placeholder="Send Message..." class="messageContent">
                        <button><i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                    </div>
                </div>
            </div>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="/assets/js/start-chat.js" type="module"></script>
<script src="/assets/js/sendMessage.js" type="module"></script>
</x-app-layout>