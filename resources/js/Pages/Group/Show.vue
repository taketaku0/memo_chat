<template>
    <app-layout title="グループ">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{group.group_name}}
            </h2>
        </template>

        <div>
            <div class="py-12">
                <button type="button" @click="debug">デバッグ</button>
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 items-center">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="chat_area">
                            <div v-for="message in messages" :key="message.id">
                                <div>{{members[message.user_id]}}: {{ message.content }}</div>
                            </div>
                        </div>
                        <form class="w-full max-w-sm">
                            <div class="flex items-center border-b border-teal-500 py-2">
                                <input class="bg-transparent w-full text-gray-700 mr-3 py-1 px-2 leading-tight" type="text" v-model="messageData.content">
                                <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-black py-1 px-2 rounded" type="button" @click.prevent="send">
                                    送信
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    props: {
        group: Object,
        user: Object,
        members: Object,
        messages: Object
    },
    data() {
        return {
            messageData: {
                user_id: this.user.id,
                group_id: this.group.id,
                content: ''
            },
        }
    },
    components: {
        AppLayout,
    },
    methods: {
        async send() {
            if(this.messageData.content == '')
                return;
            await axios.post('/messages', this.messageData);
            this.messages.push({"user_id" : this.messageData.user_id, "group_id" : this.messageData.group_id, "content" : this.messageData.content });
            this.messageData.content = "";
            console.log("message sended.");
        },
        connect() {
            Echo.channel("memo-chat-channel." + this.group.id).listen("MessageReceived", (e) => {
                console.log(e.messageData);
                this.messages.push(e.messageData);
            });
            console.log("connected memo-chat-channel." + this.group.id);
        },
        disconnect() {
            Echo.leave("memo-chat-channel." + this.group.id);
            console.log("disconnected memo-chat-channel." + this.group.id);
        },
        debug() {
            console.log(this.messages);
        }
    },
    mounted() {
        this.connect();
    },
    beforeUnmount() {
        this.disconnect();
    },
}
</script>