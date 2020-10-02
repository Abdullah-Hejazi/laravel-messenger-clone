<template>
    <div class="chat-app">
        <NavBar
            :user="user"
            :url="url"
            @onselectchat="SelectChat"
            @onselectrequests="SelectRequests"
            :requests="recieved_requests.length"
        />

        <FriendsList
            v-if="friends_list"
            :friends="friends"
            @selected="SelectFriend"
            @onaddfriend="AddNewFriend"
        />
        
        <FriendRequests
            v-if="!friends_list"
            :sent_requests="sent_requests"
            :recieved_requests="recieved_requests"
            @accept-request="AcceptFriendRequest"
            @reject-request="RejectFriendRequest"
            @cancel-request="CancelFriendRequest"
        />

        <MessagesView
            :messages="messages"
            :selected_friend="selected_friend"
            :user="user"
            @send_message="SendMessage"
        />

    </div>
</template>

<script>
    import FriendsList from './FriendsList.vue';
    import FriendRequests from './FriendRequests.vue';
    import MessagesView from './MessagesView.vue';
    import NavBar from './NavBar.vue';

    export default {
        props: {
            user: {
                type: Object,
                required: true
            },
            url: {
                type: String,
            }
        },

        components: {
            FriendsList,
            MessagesView,
            NavBar,
            FriendRequests
        },
    
        data () {
            return {
                friends: [],
                messages: [],
                selected_friend: null,
                sent_requests: [],
                recieved_requests: [],
                friends_list: false
            }
        },

        mounted() {
            Echo.private(`messanger.${this.user.id}`).listen('MessangerEvent', (e) => {
                if (e.type == 'message') {
                    this.handleIncomingMessage(e.message)
                } else if (e.type == 'friend_request_recieved') {
                    this.handleIncomingRequest(e.message)
                } else if (e.type == 'friend_request_accepted') {
                    this.handleIncomingAccept(e.message)
                } else if (e.type == 'friend_request_rejected') {
                    this.handleIncomingReject(e.message)
                }
            })

            this.SelectChat()
        },

        methods: {
            LoadData: function () {
                axios.get('/contacts').then((response) => {
                    this.friends = response.data
                })

                axios.get('/friends/requests').then((response) => {
                    this.sent_requests = response.data.sent
                    this.recieved_requests = response.data.recieved
                })
            },

            AcceptFriendRequest: function (request) {
                axios.post(`/friends/requests/${request.request_id}/accept`).then((response) => {
                    this.recieved_requests.splice(request.index, 1);
                })
            },

            RejectFriendRequest: function (request) {
                axios.post(`/friends/requests/${request.request_id}/reject`).then((response) => {
                    this.recieved_requests.splice(request.index, 1);
                })
            },

            CancelFriendRequest: function (request) {
                axios.post(`/friends/requests/${request.request_id}/cancel`).then((response) => {
                    this.sent_requests.splice(request.index, 1);
                })
            },

            SelectFriend: function (friend_object) {
                this.selected_friend = friend_object.friend
                axios.get(`/messages/${friend_object.friend.id}`).then((response) => {
                    this.messages = response.data
                    this.friends[friend_object.index].unread_count = 0
                })
            },

            SelectChat: function () {
                this.friends_list = true

                axios.get('/contacts').then((response) => {
                    this.friends = response.data

                    if (this.friends.length > 0) {
                        this.SelectFriend({
                            friend: this.friends[0].friend,
                            index: 0
                        })
                    }
                })
            },
            
            SelectRequests: function () {
                this.friends_list = false
                this.selected_friend = null

                axios.get('/friends/requests').then((response) => {
                    this.sent_requests = response.data.sent
                    this.recieved_requests = response.data.recieved
                })
            },

            SendMessage: function (message) {
                axios.post(`messages/${this.selected_friend.id}`, {
                    text: message,
                }).then((response) => {
                    this.messages.push(response.data)

                    for(var i = 0; i < this.friends.length; i++) {
                        if (this.friends[i].friend.id == parseInt(response.data.reciever_id)) {
                            this.friends[i].last_message = response.data
                        }
                    }
                })
            },

            handleIncomingMessage: function (message) {
                var audio = new Audio('/alert.mp3')
                audio.play()

                if(this.selected_friend && this.selected_friend.id == message.sender_id){
                    this.messages.push(message)
                    axios.post(`/message/${message.id}/read`)

                    for(var i = 0; i < this.friends.length; i++) {
                        if (this.friends[i].friend.id == message.sender_id) {
                            this.friends[i].last_message = message
                        }
                    }

                    return
                } else {
                    for(var i = 0; i < this.friends.length; i++) {
                        if (this.friends[i].friend.id == message.sender_id) {
                            this.friends[i].last_message = message
                            this.friends[i].unread_count++
                        }
                    }
                }
            },
        
            AddNewFriend: function (friend_email) {
                axios.post('friends/add', {
                    'email': friend_email
                }).then((response) => {
                    this.LoadData()
                })
            },

            handleIncomingRequest: function (message) {
                var audio = new Audio('/alert.mp3')
                audio.play()

                this.recieved_requests.push(message)
            },

            handleIncomingAccept: function (message) {
                var audio = new Audio('/alert.mp3')
                audio.play()

                this.LoadData()
            },

            handleIncomingReject: function (message) {
                var audio = new Audio('/alert.mp3')
                audio.play()

                this.LoadData()
            }
        }
    }
</script>

<style scoped>
    .chat-app {
        display: flex;
    }
</style>