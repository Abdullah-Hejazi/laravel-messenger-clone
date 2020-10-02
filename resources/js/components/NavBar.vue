<template>
    <div class="navbar">
        <div class="image-container">
            <img class="profile-image" :src="user.profile_image">
            <div class="option-button" @click="chat = true; $emit('onselectchat')">
                <v-icon name="comments" :class="chat ? 'top-bar-item top-bar-item-selected' : 'top-bar-item'" />
            </div>

            <div class="option-button" @click="chat = false; $emit('onselectrequests')">
                <v-icon name="user-friends" :class="!chat ? 'top-bar-item top-bar-item-selected' : 'top-bar-item'" />
                <div class="notification" v-if="requests > 0"> {{ requests }}</div>
            </div>
        </div>

        <div class="menu">
            <v-icon name="cog" class="menu-item" />
            <v-icon name="sign-out-alt" class="menu-item" @click="Logout" />
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                required: true,
                default: {
                    profile_image: 'profile.jpg'
                }
            },

            requests: {
                type: Number,
                default: 0
            },

            url: {
                type: String
            },
        },

        data () {
            return {
                chat: true
            }
        },

        methods: {
            Logout: function () {
                let csrf = this.GetMeta('csrf-token')

                axios.post(`${this.url}/logout`, {
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    }
                })

                window.location.href = `${this.url}/login`;
            },

            GetMeta: function (metaName) {
                const metas = document.getElementsByTagName('meta');

                for (let i = 0; i < metas.length; i++) {
                    if (metas[i].getAttribute('name') === metaName) {
                    return metas[i].getAttribute('content');
                    }
                }

                return '';
            },

        }
    }
</script>

<style scoped>

.navbar {
    width: 100px;
    background-color: #181F2E;
    height: 100vh;
    padding: 0;
    display: flex;
    flex-direction: column;
}

.image-container {
    width: 100%;
    padding-bottom: 10px;
    background-color: #141A26;
}

.menu {
    width: 100%;
    height: 150px;
    background-color: #202A3F;
    color: white;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.menu-item {
    width: 100%;
    height: 30px;
    cursor: pointer;
    margin-top: 20px;
    margin-bottom: 20px;
}

.profile-image {
    border-radius: 50%;
    border: 1px solid #F04141;
    width: 70px;
    height: 70px;
    position: relative;
    top: 15px;
}

.signout-link {
    color: white;
}

.signout-link:visited {
    color: white;
}

.option-button {
    text-align: center;
    cursor: pointer;
}

.top-bar-item {
    margin: 30px auto 0px auto;
    color: white;
    width: 30px;
    height: 30px;
    display: block;
}

.top-bar-item-selected {
    color: #F04141;
}

.notification {
    background-color: rgb(255, 225, 159);
    color: black;
    font-size: 12px;
    width: 17px;
    height: 17px;
    border-radius: 50%;
    font-weight: bold;
    display: inline-block;
}

</style>