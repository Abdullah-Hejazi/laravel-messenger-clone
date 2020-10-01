<template>
    <div class="navbar">
        <div class="image-container">
            <img class="profile-image" :src="user.profile_image">
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

            url: {
                type: String
            },
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
    height: 100px;
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
    left: 15px;
    top: 15px;
}

.signout-link {
    color: white;
}

.signout-link:visited {
    color: white;
}

</style>