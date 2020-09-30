<template>
    <div class="container">
        <div class="messages-container" ref="feed">
            <div class="messages-title">{{ selected_friend ? selected_friend.name : 'Friend Name'}}</div>
            <div class="messages">
                <div :class="user.id === message.sender_id ? 'message message-sent' : 'message'" v-for="(message, index) in messages" :key="index">
                    <div :class="user.id === message.sender_id ? 'message-text message-text-sent' : 'message-text'">{{message.text}}</div>
                </div>
                <div></div>
            </div>
        </div>
        <textarea class="message-input" placeholder="Type Your Message..." v-model="new_message" @keyup.enter="SendMessage"></textarea>
    </div>
</template>

<script>
    export default {
        props: {
            messages: {
                type: Array,
                default: () => {
                    return []
                }
            },

            selected_friend: {
                type: Object,
                default: null
            },

            user: {
                type: Object,
                required: true
            }
        },

        data () {
            return {
                new_message: '',
            }
        },

        methods: {
            SendMessage() {
                if(this.new_message == '' || !this.selected_friend) {
                    return
                }

                var currentMessage = this.new_message
                this.new_message = ''

                this.$emit('send_message', currentMessage)
            },

            scrollToBottom() {
                setInterval(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight
                }, 50)
            }
        },

        watch: {
            messages: function (messages) {
                this.scrollToBottom()
            },

            selected_friend: function (selected_friend) {
                this.scrollToBottom()
            }
        }
    }
</script>

<style scoped>
    .messages-container {
        padding: 0px;
        overflow-y: auto;
        height: 500px;
        display: flex;
        flex-direction: column;
    }

    .messages-title {
        font-size: 25px;
        font-weight: bold;
        border-bottom: 1px solid rgb(226, 226, 226);
    }

    .messages {
        flex-grow: 1;
        background-color: rgb(255, 248, 248);
    }

    .message-input {
        width: 100%;
        resize: none;
        font-size: 18px;
        padding: 5px;
        height: 50px;
        margin-top: 10px;
        border-radius: 5px;
    }

    .message {
        margin: 10px;
    }

    .message-text {
        background-color: rgb(226, 226, 226);
        padding: 7px 14px 7px 14px;
        border-radius: 50px;
        display: inline-block;
        font-size: 20px;
    }

    .message-sent {
        text-align: right;
    }

    .message-text-sent {
        background-color: rgb(0, 153, 255);
        color: white;
    }
</style>