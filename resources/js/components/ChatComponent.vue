<template>
    <div>
        <h1 class="group_name">テストグループ</h1>
        <div>
            {{ messages }}
        </div>
        <div class="chat_area">
            <div v-for="message in messages" :key="message.id">
                <div>{{ message }}</div>
            </div>
        </div>
        <form class="text_box">
            <input v-model="messageData.message">
            <button type="button" @click.prevent="send">送信</button>
        </form>
    </div>
</template>

<script>
export default {
    
    data() {
        return {
            messages: ["test","test2"],
            messageData: {
                user_id: 1,
                message: ''
            }
        }
    },
    methods: {
        async send() {
            await axios.post('/messages', this.messageData)
            //console.log(this.messageData.message)
            this.messageData.message = ""
        },
        connectChannel() {
            Echo.channel("testChannel").listen("MessageReceived", (e) => {
                console.log(e.message)
                this.messages.push(e.message)
            })
            console.log("connect Channel1")
        }
    },
    mounted() {
        this.connectChannel()
    }
}
</script>