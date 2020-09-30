<template>
    <div class="container">
        <div class="row">
            <MessagesView
                class="col-8"
                :messages="messages"
                :selected_friend="selected_friend"
                :user="user"
                @send_message="SendMessage"
            />
            <friends-list :friends="friends" class="col-4" @selected="SelectFriend" />
        </div>
    </div>
</template>

<script>
    import FriendsList from './FriendsList.vue';
    import MessagesView from './MessagesView.vue';

    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },

        components: {
            FriendsList,
            MessagesView
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
                console.log('here')
                this.handleIncoming(e.message)
            })
            
            axios.get('/contacts').then((response) => {
                this.friends = response.data
            })
        },

        methods: {
            SelectFriend: function (friend) {
                this.selected_friend = friend
                axios.get(`/messages/${friend.id}`).then((response) => {
                    this.messages = response.data
                })
            },

            SendMessage: function (message) {
                axios.post(`messages/${this.selected_friend.id}`, {
                    text: message,
                }).then((response) => {
                    this.messages.push(response.data)
                })
            },

            handleIncoming: function (message) {
                if(this.selected_friend && this.selected_friend.id == message.sender_id){
                    this.messages.push(message)
                    return
                }

                alert('recieved message')
            }
        }
    }
</script>
