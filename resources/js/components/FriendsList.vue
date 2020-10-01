<template>
    <div class="friends-container">
        <div class="search-container">
            <div class="search-box">
                <v-icon name="search" class="search-icon" />
                <input type="text" name="search" placeholder="Search..." class="search-input" v-model="search">
            </div>
            <div class="add-user" @click="AddUser">
                <div class="add-user-button">
                    <v-icon name="user-plus" class="add-user-icon" scale="2" />
                </div>
            </div>
        </div>
        <div v-for="(friend, index) in friends_list" :key="index" @click="SelectFriend(friend.friend, index)">
            <div :class="currentIndex != index ? 'friend':'friend friend_selected'">
                <div>
                    <img :src="friend.friend.profile_image" :alt="friend.friend.name" class="friend-profile-image">
                    <div class="status online"></div>
                </div>
                <div class="friend-info">
                    <div class="friend-name">{{ friend.friend.name }}</div>
                    <div class="friend-last-message">Hello there my friend how are you doing today Hello there my friend how are you doing todayHello there my friend how are you doing today</div>
                </div>
            </div>
            <div class="divider"></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            friends: {
                type: Array,
                default: () => {
                    return []
                }
            }
        },

        data() {
            return {
                currentIndex: 0,
                friends_list: [],
                search: ''
            }
        },

        mounted() {
            this.resetFriends()
        },

        methods: {
            SelectFriend: function (friend, index) {
                this.currentIndex = index

                this.$emit('selected', friend)
            },

            AddUser: function () {
                // add user
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
        width: 500px;
        max-width: calc(50vw - 100px);
        padding: 0;
        background-color: #EBF4FB;
    }

    .search-container {
        width: 100%;
        padding: 20px;
        text-align: center;
        display: flex;
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
        display: inline-block;
        margin: 0;
        border-radius: 50%;
        width: 13px;
        height: 13px;
        border: 2px solid white;
        position: relative;
        right: 16px;
        top: 23px;
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

    .add-user-button {
        margin-left: 20px;
        background-color: #EF4141;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        color: white;
        font-size: 20px;
        text-align: center;
        cursor: pointer;

        -webkit-box-shadow: 0px 0px 13px -7px rgba(239,65,65,1);
        -moz-box-shadow: 0px 0px 13px -7px rgba(239,65,65,1);
        box-shadow: 0px 0px 13px -7px rgba(239,65,65,1);

        transition: background-color .2s linear;
    }

    .add-user-button:hover {
        background-color: #ff6464;
    }

    .add-user-icon {
        position: relative;
        top: 8px;
        left: 2px;
    }

</style>