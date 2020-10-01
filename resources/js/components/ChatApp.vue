<template>
    <div class="chat-app">
        <NavBar :user="user" :url="url" />

        <FriendsList :friends="friends" @selected="SelectFriend" />

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
            NavBar
        },
    
        data () {
            return {
                friends: [],
                messages: [],
                selected_friend: null
            }
        },

        mounted() {
            Echo.private(`messages.${this.user.id}`).listen('NewMessage', (e) => {
                this.handleIncoming(e.message)
            })
            
            axios.get('/contacts').then((response) => {
                this.friends = response.data
            }).catch((e) => {
                console.log(e.response)
            })
        },

        methods: {
            SelectFriend: function (friend_object) {
                this.selected_friend = friend_object.friend
                axios.get(`/messages/${friend_object.friend.id}`).then((response) => {
                    this.messages = response.data
                    this.friends[friend_object.index].unread_count = 0
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

            handleIncoming: function (message) {
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
            }
        }
    }
</script>

<style scoped>
    .chat-app {
        display: flex;
    }
</style>