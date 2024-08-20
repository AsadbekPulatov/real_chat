<template>
    <div class="card mt-3">
        <div class="card-body m-3" style="height: 500px; overflow-y: scroll; overflow-x: hidden;"
             ref="messagesContainer">
            <div class="card w-75 m-2"
                 style="box-shadow: 0px 0px 4px 4px #dbdcde; border-radius: 0px 25px 25px 50px; border: 2px solid darkblue"
                 v-for="message in messages"
                 :class="message.sender_id !== currentUser.id ? 'float-start':'float-end'"
                 :key="message.id"
            >
                <div class="p-3">
                    <p style="color: darkblue;"><i class="bi bi-person-circle" style="font-size: 30px;"></i>
                        {{ message.sender.name }}</p>
                    <p style="color: black">{{ message.text }}
                        <span class="float-end">
                            <i class="bi bi-clock"></i> {{ new Date(message.created_at).toLocaleDateString('us') }}
                            <span v-if="message.sender_id === currentUser.id">
                                <i v-if="message.is_read"
                                   class="bi bi-check-all" style="font-size: 25px;"></i>
                                    <i v-else class="bi bi-check" style="font-size: 25px;"></i>
                            </span>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <form action="" class="m-3" method="post">
            <div class="input-group">
                <input
                    class="form-control"
                    placeholder="Type a message..."
                    type="text"
                    name="message"
                    v-model="newMessage"
                    @keydown="sendTypingEvent"
                    @keyup.enter="sendMessage">
                <button @click="sendMessage" class=" btn btn-primary" type="button"><i class="bx bxl-telegram"></i> Send</button>
            </div>
            <small v-if="isFriendTyping" class="text-gray-700">
                {{ friend.name }} is typing...
            </small>
        </form>
    </div>
</template>

<script setup>
import axios from "axios";
import {nextTick, onMounted, ref, watch} from "vue";

const props = defineProps({
    friend: {
        type: Object,
        required: true,
    },
    currentUser: {
        type: Object,
        required: true,
    },
});

const messages = ref([]);
const newMessage = ref("");
const messagesContainer = ref(null);
const isFriendTyping = ref(false);
const isFriendTypingTimer = ref(null);

const markAsRead = (messageId) => {
    axios.post(`/messages/${messageId}/mark-as-read`).then(response => {
        console.log('Message marked as read', response.data);
    });
};

watch(
    messages,
    () => {
        nextTick(() => {
            messagesContainer.value.scrollTo({
                top: messagesContainer.value.scrollHeight,
                behavior: "smooth",
            });
        });
        messages.value.forEach(message => {
            if (message.sender_id !== props.currentUser.id && !message.is_read) {
                markAsRead(message.id);
            }
        });
    },
    {deep: true}
);

const sendMessage = () => {
    if (newMessage.value.trim() !== "") {
        axios
            .post(`/messages/${props.friend.id}`, {
                message: newMessage.value,
            })
            .then((response) => {
                messages.value.push(response.data);
                newMessage.value = "";
            });
    }
};

const sendTypingEvent = () => {
    Echo.private(`chat.${props.friend.id}`).whisper("typing", {
        userID: props.currentUser.id,
    });
};

onMounted(() => {
    axios.get(`/messages/${props.friend.id}`).then((response) => {
        console.log(response.data);
        messages.value = response.data;
    });

    Echo.private(`chat.${props.currentUser.id}`)
        .listen("MessageSent", (response) => {
            messages.value.push(response.message);
        })
        .listen("MessageRead", (response) => {
            const message = messages.value.find(m => m.id === response.message_id);
            if (message) {
                message.is_read = response.is_read;
            }
        })
        .listenForWhisper("typing", (response) => {
            isFriendTyping.value = response.userID === props.friend.id;

            if (isFriendTypingTimer.value) {
                clearTimeout(isFriendTypingTimer.value);
            }

            isFriendTypingTimer.value = setTimeout(() => {
                isFriendTyping.value = false;
            }, 1000);
        });
});
</script>
