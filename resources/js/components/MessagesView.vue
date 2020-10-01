<template>
    <div class="messages-view">
        <div class="messages-panel" v-if="selected_friend">
            <div class="messeges-top-bar">
                <div class="messages-title">{{ selected_friend ? selected_friend.name : 'Select A Friend'}}</div>

                <div class="status-section">
                    <div class="status online"></div>
                    Active Now
                </div>
                <div class="divider"></div>
            </div>

            <div class="messages-container">
                <div class="messages" ref="feed">
                    <div v-for="(message, index) in messages" :key="index">
                        <div class="message message-sent" v-if="user.id === message.sender_id">
                            <div class="message-text message-text-sent">{{message.text}}</div>
                        </div>
                        
                        <div class="message" v-else>
                            <div class="message-recieved">
                                <div class="message-profile">
                                    <img :src="selected_friend.profile_image" class="message-profile-image">
                                </div>
                                <div class="message-text">{{message.text}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="messeges-bottom-bar"> 
                <textarea class="message-input" placeholder="Type Your Message..." v-model="new_message" @keyup.enter="SendMessage"></textarea>
            </div>
        </div>
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
                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight
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
    .messages-view {
        height: 100vh;
        overflow-y: auto;
        padding: 0px;
        width: 100%;
        background-color: white;
        padding: 20px 20px 0px 30px;
    }


    .messages-title {
        font-size: 25px;
        font-weight: bolder;
        color: #415766;
    }

    .messeges-top-bar {
        height: 100px;
    }

    .messages {
        height: calc(100% - 170px);
        max-height: calc(100% - 170px);
        overflow-y: auto;
    }

    .message-input {
        width: 100%;
        resize: none;
        font-size: 18px;
        padding: 15px;
        height: 60px;
        margin-top: 10px;
        border: none;
        color: #3E5B70;
        border-top: 1px solid #CDDAE4;
    }

    .message-input:focus {
        outline: none;
    }

    .message {
        margin: 10px;
        margin-bottom: 20px;
    }

    .message-text {
        background-color:#EBF4FB;
        padding: 7px 24px 7px 24px;
        border-radius: 50px;
        display: inline-block;
        color: #5A7385;
        font-size: 20px;
    }

    .message-sent {
        text-align: right;
    }

    .message-text-sent {
        background-color: #F74949;
        color: white;

        -webkit-box-shadow: 0px 0px 13px -7px rgba(239,65,65,1);
        -moz-box-shadow: 0px 0px 13px -7px rgba(239,65,65,1);
        box-shadow: 0px 0px 13px -7px rgba(239,65,65,1);
    }

    .status-section {
        color: #A6B9C9;
        font-weight: 100;
        font-size: 16px;
    }

    .status {
        display: inline-block;
        margin: 0;
        border-radius: 50%;
        width: 13px;
        height: 13px;
        border: 2px solid white;
        margin-top: 2px;
        margin-right: 7px;
        position: relative;
        top: 2px;
    }

    .online {
        background-color: #2FD756;
    }

    .offline {
        background-color: #F92B2B;
    }

    .divider {
        border-bottom: 1px solid #CDDAE4;
    }

    .messeges-bottom-bar {
        height: 60px;
    }

    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }

    ::-webkit-scrollbar-thumb {
        background: #888; 
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555; 
    }

    .message-recieved {
        display: flex;
    }

    .message-profile-image {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 15px;
    }
</style>