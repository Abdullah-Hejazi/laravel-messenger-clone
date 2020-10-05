<template>
    <div class="navbar">
        <div class="image-container">
            <img class="profile-image" :src="'images/' + user.profile_image">
            <div class="option-button" @click="chat = true; $emit('onselectchat')">
                <v-icon name="comments" :class="chat ? 'top-bar-item top-bar-item-selected' : 'top-bar-item'" />
            </div>

            <div class="option-button" @click="chat = false; $emit('onselectrequests')">
                <v-icon name="user-friends" :class="!chat ? 'top-bar-item top-bar-item-selected' : 'top-bar-item'" />
                <div class="notification" v-if="requests > 0"> {{ requests }}</div>
            </div>
        </div>

        <div class="menu">
            <v-icon name="cog" class="menu-item" @click="select_pimg_dialog = true" />
            <v-icon name="sign-out-alt" class="menu-item" @click="Logout" />
        </div>

        <Modal @onclose="select_pimg_dialog = false" v-if="select_pimg_dialog">
            <div class="add-modal-title">Change Profile Picture</div>
            <div class="add-modal-box">
                <input type="file" class="form-input" id="img" name="img" accept="image/*" ref="selectImage">
            </div>

            <div class="add-modal-button" @click="ChangePicture">Change Picture</div>
        </Modal>
    </div>
</template>

<script>
    import Modal from './Modal';

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

        components: { Modal },

        data () {
            return {
                chat: true,
                select_pimg_dialog: false
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

            ChangePicture: function () {
                var file = this.$refs.selectImage.files[0]

                if (!file) return

                var formData = new FormData();
                formData.append("image", file);

                axios.post('/settings/picture/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((response) => {
                    this.select_pimg_dialog = false
                    this.$emit('change-picture', response.data.image)
                })
            }
        }
    }
</script>

<style scoped>

.navbar {
    width: 100px;
    background-color: #0f0f0f;
    height: 100vh;
    padding: 0;
    display: flex;
    flex-direction: column;
}

.image-container {
    width: 100%;
    padding-bottom: 10px;
    background-color: #0f0f0f;
}

.menu {
    width: 100%;
    height: 150px;
    background-color: #0f0f0f;
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
    border: 2px solid #41a1f0;
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
    color: #41a1f0;
}

.notification {
    background-color: rgb(255, 190, 49);
    color: black;
    font-size: 12px;
    width: 17px;
    height: 17px;
    border-radius: 50%;
    font-weight: bold;
    display: inline-block;
}

.add-modal-title {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
}


.add-modal-button {
    width: 200px;
    margin: 15px auto;
    background-color: #41a1f0;
    color: white;

    -webkit-box-shadow: 0px 0px 13px -7px #41a1f0;
    -moz-box-shadow: 0px 0px 13px -7px #41a1f0;
    box-shadow: 0px 0px 13px -7px #41a1f0;

    padding: 7px 24px 7px 24px;
    border-radius: 50px;
    font-size: 20px;
    text-align: center;
    cursor: pointer;
}

.add-modal-button:hover {
    background-color: #5eb6ff;
}

</style>