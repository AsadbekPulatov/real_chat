<template>
    <div v-for="user in new_users" class="col-4 p-3 d-flex align-items-center">
        <div
            :class="user.is_online ? 'bg-success': 'bg-secondary'"
             class="rounded-circle d-flex align-items-center justify-content-center text-white"
             style="width: 50px; height: 50px;">
            {{ user.name[0] }}
        </div>
        <a class="ml-2 text-dark font-monospace" :href=" '/chat/'+user.id ">{{ user.name }}</a>
    </div>
</template>

<script>
export default {
    name: "UserComponent",
    data(){
        return {
            new_users: this.users,
        }
    },
    props: {
        users: {
            type: Object,
            required: true,
        },
        currentUser: {
            type: Object,
            required: true,
        },
    },
    mounted() {
        Echo.join('online-users')
            .here((users) => {
                users.forEach(user => {
                    this.updateUserOnlineStatus(user.id, true);
                });
            })
            .joining((user) => {
                this.updateUserOnlineStatus(user.id, user.is_online)
            })
            .leaving((user) => {
                this.updateUserOnlineStatus(user.id, false)
            });
    },
    methods: {
        updateUserOnlineStatus(userId, isOnline) {
            // alert(userId, isOnline)
            const user = this.new_users.find(user => user.id === userId);
            if (user) {
                user.is_online = isOnline; // Update the online status
                console.log(`User ${userId} status updated. Current online users:`, this.new_users);
            }
        }
    }
}
</script>

<style scoped>

</style>
