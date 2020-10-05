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
        border-radius: 10px;
        box-shadow:
      0 0.5px 1.2px rgba(0, 0, 0, 0.039),
      0 1.1px 2.7px rgba(0, 0, 0, 0.055),
      0 1.9px 4.6px rgba(0, 0, 0, 0.065),
      0 2.9px 6.9px rgba(0, 0, 0, 0.071),
      0 4.1px 10px rgba(0, 0, 0, 0.075),
      0 5.8px 14.2px rgba(0, 0, 0, 0.077),
      0 8.3px 20.1px rgba(0, 0, 0, 0.077),
      0 12px 29.2px rgba(0, 0, 0, 0.076),
      0 18.6px 45px rgba(0, 0, 0, 0.074),
      0 33px 80px rgba(0, 0, 0, 0.07);

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