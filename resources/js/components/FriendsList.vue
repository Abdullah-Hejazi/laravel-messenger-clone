<template>
    <div class="friends-container">
        <div class="search-container">
            <div class="search-box">
                <v-icon name="search" class="search-icon" />
                <input type="text" name="search" placeholder="Search..." class="search-input" v-model="search">
            </div>

            <v-icon name="user-plus" class="add-user-icon" @click="add_user_dialog = true" />
        </div>
        <div v-for="(friend, index) in friends_list" :key="index" @click="SelectFriend(friend.friend, index)">
            <div :class="currentIndex != index ? 'friend':'friend friend_selected'">
                <div>
                    <img :src="'images/' + friend.friend.profile_image" :alt="friend.friend.name" class="friend-profile-image">
                    <div class="status online"></div>
                </div>
                <div class="friend-info">
                    <div class="friend-name">{{ friend.friend.name }}</div>
                    <div class="friend-last-message" v-if="friend.last_message">{{friend.last_message.text}}</div>
               
                    <div class="notification-line" v-if="friend.unread_count > 0">
                        <div class="notification"></div>
                        <div class="notification-text" > {{friend.unread_count}} Unread Messeges </div>
                    </div>
                </div>
            </div>
            <div class="divider"></div>
        </div>

        <Modal @onclose="add_user_dialog = false" v-if="add_user_dialog">
            <div class="add-modal-title">Add a friend</div>
            <div class="add-modal-box">
                <input type="email" class="form-input" placeholder="Enter the email" v-model="new_friend_email">
            </div>

            <div class="add-modal-button" @click="AddFriend">Add Friend</div>
        </Modal>
    </div>
</template>

<script>
    import Modal from './Modal';

    export default {
        props: {
            friends: {
                type: Array,
                default: () => {
                    return []
                }
            }
        },

        components: {
            Modal,
        },

        data() {
            return {
                currentIndex: 0,
                friends_list: [],
                search: '',
                add_user_dialog: false,
                new_friend_email: ''
            }
        },

        mounted() {
            this.resetFriends()
        },

        methods: {
            SelectFriend: function (friend, index) {
                this.currentIndex = index

                this.$emit('selected', {friend: friend, index: index})
            },

            AddFriend: function () {
                this.$emit('onaddfriend', this.new_friend_email)
            },

            SearchUsers: function () {
                this.resetFriends()
                this.friends_list = this.friends_list.filter(friend => friend.friend.name.toLowerCase().includes(this.search.toLowerCase()))
            },

            resetFriends: function () {
                this.friends_list = this.friends
            }
        },

        watch: {
            friends: function (friends) {
                this.resetFriends()
            },

            search: function (search) {
                this.SearchUsers()
            }
        }
    }
</script>

<style scoped>
    .friends-container {
        height: 100vh;
        overflow-y: auto;
        width: 600px;
        max-width: calc(50vw - 100px);
        padding: 0;
        background-color: #EBF4FB;
    }

    .search-container {
        width: 100%;
        padding: 20px;
        text-align: center;
        display: flex;
        background-color: #E2EEF7;
    }

    .search-input {
        border: none;

        border-radius: 50px;
        border: 1px solid #ececec;
        padding: 10px;
        font-size: 14px;
        padding-left: 30px;
        width: 80%;
        color: #a2b0b9;
    }

    .search-icon {
        position: relative;
        color: #D2DDE4;
        left: 30px;
        top: 2px;
    }

    .search-input:focus {
        border: none;
        outline: none;
    }

    .friend {
        padding: 25px;
        cursor: pointer;
        display: flex;
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%,rgba(255,255,255,0) 100%);
    }

    .friend_selected {
        background: rgb(255,255,255);
        background: linear-gradient(90deg, rgba(255,255,255,0.4) 0%,rgba(255,255,255,0) 100%);
        border-left: 5px solid #FF4C4B;
    }

    .friend-profile-image {
        width: 55px;
        height: 55px;
        border-radius: 50%;
    }
    .friend-name {
        font-weight: bold;
        font-size: 18px;
        margin-left: 10px;
        color: #001429;
    }

    .friend-last-message {
        margin-left: 10px;
        max-width: 260px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        color: #526D7F;
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

    .divider {
        width: 80%;
        margin: 0 auto;
        border-bottom: 1px solid #CBD9E4;
    }

    .status {
        margin: 0;
        border-radius: 50%;
        width: 13px;
        height: 13px;
        border: 2px solid white;
        position: relative;
        bottom: 10px;
    }

    .online {
        background-color: #2FD756;
    }

    .offline {
        background-color: #F92B2B;
    }

    .search-box {
        display: inline-block;
        flex-grow: 5;
    }

    .add-user {
        flex-grow: 1;
    }

    .add-user-icon {
        position: relative;
        top: 8px;
        left: 2px;

        margin-left: 20px;
        width: 25px;
        height: 25px;
        color: #EF4141;
        font-size: 20px;
        text-align: center;
        cursor: pointer;
    }

    .notification-line {
        display: flex;
        color: #7e7e7e;
        font-size: 10px;
    }

    .notification {
        margin: 0;
        border-radius: 50%;
        width: 13px;
        height: 13px;
        background-color: #F92B2B;
        margin-left: 5px;
        margin-right: 5px;
        position: relative;
    }

    .add-modal-title {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
    }

    .form-input {
        background-color: #E5E8ED;
        color: black;
        border: none;
        border-radius: 5px;
        padding: 16px;
        font-size: 18px;
        width: 100%;
    }

    .form-input:focus {
        border: none;
        outline: none;
    }

    
    .form-input {
        margin-top: 10px;
        border: none;
        border-radius: 50px;
        border: 1px solid #ececec;
        padding: 10px;
        font-size: 14px;
        padding-left: 30px;
        width: 100%;
        color: #637580;
    }

    .form-input:focus {
        border: none;
        outline: none;
    }

    ::-webkit-input-placeholder {
        color: #7C8290;
    }
    
    :-ms-input-placeholder {
        color: #7C8290;
    }
    
    ::placeholder {
        color: #7C8290;
    }

    .add-modal-button {
        width: 200px;
        margin: 15px auto;
        background-color: #F74949;
        color: white;

        -webkit-box-shadow: 0px 0px 13px -7px rgba(239,65,65,1);
        -moz-box-shadow: 0px 0px 13px -7px rgba(239,65,65,1);
        box-shadow: 0px 0px 13px -7px rgba(239,65,65,1);

        padding: 7px 24px 7px 24px;
        border-radius: 50px;
        font-size: 20px;
        text-align: center;
        cursor: pointer;
    }

    .add-modal-button:hover {
        background-color: #ff5f5f;
    }

</style>