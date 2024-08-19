import './bootstrap';
import { createApp } from "vue/dist/vue.esm-bundler";

import ChatComponent from "./components/ChatComponent.vue";

const app = createApp({
    components: {
        ChatComponent
    }
});

app.mount("#app");

// import Alpine from 'alpinejs';
//
// window.Alpine = Alpine;
//
// Alpine.start();
