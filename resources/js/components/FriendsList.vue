<template>
    <div class="container friends-container">
        <div class="friends-title">Friends</div>
        <div v-for="(friend, index) in friends" :key="index" :class="currentIndex != index ? 'friend':'friend friend_selected'" @click="SelectFriend(friend.friend, index)">
            <img :src="friend.friend.profile_image" :alt="friend.friend.name" class="friend-profile-image">
            <div class="friend-name">{{ friend.friend.name }}</div>
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
            }
        },

        methods: {
            SelectFriend: function (friend, index) {
                this.currentIndex = index

                this.$emit('selected', friend)
            }
        }
    }
</script>

<style scoped>
    .friends-container {
        border-left: 1px solid rgb(224, 224, 224);
        height: 500px;
        overflow-y: auto;
        padding: 0;
    }

    .friends-title {
        font-size: 25px;
        font-weight: bold;
        text-align: center;
    }

    .friend {
        padding: 25px;
        border-bottom: 1px solid rgb(223, 223, 223);
        cursor: pointer;
        background-color: #f8fafc;
        transition: background-color .5s ease;
    }

    .friend_selected {
        background-color: rgb(236, 236, 236);
    }

    .friend:hover {
        background-color: #fcf7f7;
    }

    .friend-profile-image {
        width: 70px;
        height: 70px;
        border-radius: 50%;
    }

    .friend-name {
        display: inline-block;
        font-weight: bold;
        margin-left: 10px;
    }
</style>