<template>
    <div class="modal">
        <div class="modal-content">
            <span class="close" @click="$emit('onclose')">&times;</span>
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>
    .modal {
        display: block;
        z-index: 1;
        width: 600px;
        
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(calc(100% / -2), -100px);
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        text-align: right;
    }

    .close:hover, .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>