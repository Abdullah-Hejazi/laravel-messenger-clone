<template>
    <div class="friends-container">
        <div class="search-container">
            <h2>Friend Requests</h2>
        </div>
        <div v-for="(request, index) in recieved_requests" :key="request.id">
            <div class="friend">
                <div>
                    <img :src="'images/' + request.user.profile_image" :alt="request.user.name" class="friend-profile-image">
                    <div class="friend-name">{{ request.user.name }}</div>
                </div>
                <div class="options-panel">
                    <div class="options-button" @click="EmitEvent('accept-request', request.id, index)">
                        <v-icon name="user-check" class="accept-icon" />
                    </div>
                    <div class="options-button" @click="EmitEvent('reject-request', request.id, index)">
                        <v-icon name="times" class="reject-icon" />
                    </div>
                </div>
            </div>
            <div class="divider"></div>
        </div>

        <div v-for="(request, index) in sent_requests" :key="request.id">
            <div class="friend">
                <div>
                    <img :src="'images/' + request.friend.profile_image" :alt="request.friend.name" class="friend-profile-image">
                    <div class="friend-name">{{ request.friend.name }}</div>
                </div>

                <div class="options-panel">
                    <div class="options-button" @click="EmitEvent('cancel-request', request.id, index)">
                        <v-icon name="times" class="reject-icon" />
                    </div>
                </div>
            </div>
            <div class="sent-text">You sent this request</div>
            <div class="divider"></div>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            sent_requests: {
                type: Array,
                default: () => {
                    return []
                }
            },

            recieved_requests: {
                type: Array,
                default: () => {
                    return []
                }
            }
        },

        methods: {
            EmitEvent: function (name, request_id, index) {
                this.$emit(name, {
                    request_id: request_id,
                    index: index
                })
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
        background-color: #E2EEF7;
    }

    .friend {
        padding: 25px;
        padding-bottom: 0px;
        display: flex;
        justify-content: space-between;
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%,rgba(255,255,255,0) 100%);
    }

    .friend-profile-image {
        width: 55px;
        height: 55px;
        border-radius: 50%;
    }

    .friend-name {
        display: inline-block;
        padding-top: 13px;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        margin-left: 10px;
        color: #001429;
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
        margin: 10px auto;
        border-bottom: 1px solid #CBD9E4;
    }

    .options-panel {
        align-self: flex-end;
    }

    .options-button {
        display: inline-block;
        cursor: pointer;
        padding: 15px 5px 15px 5px;
    }

    .accept-icon {
        color: #2FD756;
        width: 23px;
        height: 23px;
    }

    .reject-icon {
        color: #F92B2B;
        width: 23px;
        height: 23px;
    }

    .sent-text {
        text-align: center;
    }

</style>