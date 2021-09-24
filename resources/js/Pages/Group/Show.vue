<template>
    <app-layout title="グループ">
        <template #place>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{group.group_name}}
            </h2>
        </template>
        
        <div class="xl:max-w-7xl xl:mx-auto xl:px-4 xl:sm:px-6 xl:px-8">
            <div class="xl:flex xl:justify-between xl:h-16">
                <div class="sm:py-4 w-full mx-auto chatBox sm:chatBox sm:w-2/3" :class="{'inline-block': width < 1280}">
                    <div class="sm:pl-6 lg:pl-8 items-center h-full">
                        <div class="bg-blue-200 shadow-xl sm:rounded-lg h-full relative">
                            <div class="messageContainer overflow-y-auto pb-1 overscroll-none" id="messageContainer">
                                <div v-for="message in messages" :key="message.id">
                                    <div class="flow-root w-auto">
                                        <div v-if="message.user_id == null" class="bg-gray-400 max-w-2/3 w-max mx-auto my-2 p-2 rounded-lg overflow-wrap whitespace-pre-wrap text-gray-200 text-xs">
                                            {{ message.content }}
                                        </div>
                                        <div v-else-if="message.user_id == user.id" class="bg-green-300 max-w-2/3 w-max mx-4 my-2 p-2 rounded-lg float-right overflow-wrap whitespace-pre-wrap">
                                            {{ message.content }} 
                                        </div>
                                        <template v-else>
                                            <div class="text-xs mx-4 w-max mt-2">
                                                {{ members[message.user_id] }}
                                            </div>
                                            <div class="bg-white max-w-2/3 w-max mx-4 mb-2 p-2 rounded-lg overflow-wrap whitespace-pre-wrap">
                                                {{ message.content }}
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute w-full flex justify-between bg-gray-300 bottom-0">
                                <textarea class="flex-grow m-2 py-2 px-4 mr-1 rounded-t-md border border-gray-300 bg-gray-200 resize-none outline-none" placeholder="Message..." v-model="messageData.content" @blur="toggleCalendarFlag" @focus="toggleCalendarFlag"></textarea>
                                <template v-if="calendarFlag">
                                    <button class="m-2 outline-none" @click.prevent="createSchedule">
                                        <svg 
                                            class="svg-inline--fa text-blue-400 fa-paper-plane fa-w-16 w-12 h-12 py-2 mr-2"
                                            aria-hidden="true" 
                                            focusable="false"
                                            data-prefix="fas"
                                            data-icon="paper-plane"
                                            role="img"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512">
                                            <g>
                                                <path class="st0" d="M164.893,89.791c13.875,0,25.126-11.243,25.126-25.134V25.118C190.019,11.252,178.768,0,164.893,0
                                                    s-25.135,11.252-25.135,25.118v39.538C139.758,78.548,151.018,89.791,164.893,89.791z" style="fill: rgb(96, 165, 250);"></path>
                                                <path class="st0" d="M350.184,89.791c13.867,0,25.126-11.243,25.126-25.134V25.118C375.31,11.252,364.05,0,350.184,0
                                                    c-13.875,0-25.135,11.252-25.135,25.118v39.538C325.048,78.548,336.309,89.791,350.184,89.791z" style="fill: rgb(96, 165, 250);"></path>
                                                <path class="st0" d="M437.25,35.807h-39.865v28.849c0,26.04-21.169,47.218-47.201,47.218c-26.032,0-47.209-21.178-47.209-47.218
                                                    V35.807h-90.881v28.849c0,26.04-21.178,47.218-47.2,47.218c-26.032,0-47.21-21.178-47.21-47.218V35.807H74.75
                                                    c-38.977,0-70.575,31.599-70.575,70.575v335.043C4.175,480.401,35.773,512,74.75,512H437.25c38.976,0,70.575-31.599,70.575-70.575
                                                    V106.382C507.825,67.406,476.226,35.807,437.25,35.807z M473.484,441.425c0,19.978-16.256,36.235-36.235,36.235H74.75
                                                    c-19.979,0-36.235-16.257-36.235-36.235V150.984h434.969V441.425z" style="fill: rgb(96, 165, 250);"></path>
                                                <rect x="174.928" y="382.512" class="st0" width="63.591" height="63.591" style="fill: rgb(96, 165, 250);"></rect>
                                                <rect x="174.928" y="283.96" class="st0" width="63.591" height="63.591" style="fill: rgb(96, 165, 250);"></rect>
                                                <rect x="76.385" y="382.512" class="st0" width="63.582" height="63.591" style="fill: rgb(96, 165, 250);"></rect>
                                                <rect x="76.385" y="283.96" class="st0" width="63.582" height="63.591" style="fill: rgb(96, 165, 250);"></rect>
                                                <rect x="372.032" y="185.417" class="st0" width="63.583" height="63.582" style="fill: rgb(96, 165, 250);"></rect>
                                                <rect x="273.48" y="185.417" class="st0" width="63.591" height="63.582" style="fill: rgb(96, 165, 250);"></rect>
                                                <polygon class="st0" points="350.041,293.216 331.127,278.51 296.686,322.811 276.238,306.454 261.273,325.142 300.677,356.673 	
                                                    " style="fill: rgb(96, 165, 250);"></polygon>
                                                <rect x="372.032" y="283.96" class="st0" width="63.583" height="63.591" style="fill: rgb(96, 165, 250);"></rect>
                                                <rect x="273.48" y="382.512" class="st0" width="63.591" height="63.591" style="fill: rgb(96, 165, 250);"></rect>
                                                <rect x="174.928" y="185.417" class="st0" width="63.591" height="63.582" style="fill: rgb(96, 165, 250);"></rect>
                                            </g>
                                        </svg>
                                    </button>
                                </template>
                                <button class="m-2 outline-none" @click.prevent="send">
                                    <svg 
                                        class="svg-inline--fa text-blue-400 fa-paper-plane fa-w-16 w-12 h-12 py-2 mr-2"
                                        aria-hidden="true" 
                                        focusable="false"
                                        data-prefix="fas"
                                        data-icon="paper-plane"
                                        role="img"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                        <path
                                            fill="currentColor"
                                            d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <template v-if="width >= 640">
                    <div class="sm:py-4 w-auto mx-auto chatBox sm:w-1/3 align-top chatBox sm:chatBox" :class="{'inline-block': width < 1280}">
                        <div class="sm:px-6 lg:px-8 h-full">
                            <div class="bg-gray-100 shadow-xl sm:rounded-lg h-full overflow-y-auto">
                                <div class="container flex flex-col mx-auto w-full items-center justify-center">
                                    <div class="px-4 py-5 sm:px-6 w-full border dark:bg-gray-800 bg-white shadow mb-2 rounded-md">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                            メンバーリスト
                                        </h3>
                                    </div>
                                    <ul class="flex flex-col w-full">
                                        <li v-for="member in members" :key="member" class="border-gray-400 flex flex-row mb-2 mx-2">
                                            <div class="shadow border bg-red-100 rounded-md flex flex-1 items-center p-4">
                                                <div class="font-medium dark:text-white">
                                                    {{member}}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <jet-dialog-modal :show="modal.showFlag" @close="this.clearData">
            <template #title> {{ modal.headTitle }} </template>
            <template #content>
                <div class="mt-1">
                    <jet-label for="title" value="タイトル" />
                    <jet-input id="title" type="text" class="mt-1 block w-full border-gray-900" v-model="form.title" />
                    <jet-input-error v-if="validateMessage.title" :message="validateMessage.title" class="mt-2" />
                </div>
                <div class="mt-2">
                    <jet-label for="description" value="詳細" />
                    <textarea id="description" v-model="form.description" class="mt-1 block w-full form-input rounded-md shadow-sm"></textarea>
                </div>
                <div>
                    <div class="sm:inline-block sm:align-top mt-2">
                        <jet-label for="startDate" value="開始" />
                        <flat-pickr v-model="modal.startDate" :config="dateConfig" placeholder="----/--/--" class="w-full start" id="startDate"></flat-pickr>
                        <jet-input-error v-if="validateMessage.startDate" :message="validateMessage.startDate" class="mt-2" />
                    </div>
                    <div class="sm:inline-block sm:align-top mt-2">
                        <jet-label v-if="width >= 640" class="text-white select-none" for="startTime" value="時間" />
                        <flat-pickr v-model="modal.startTime" :config="timeConfig" placeholder="--:--" class="w-full" id="startTime"></flat-pickr>
                        <jet-input-error v-if="validateMessage.startTime" :message="validateMessage.startTime" class="mt-2" />
                    </div>
                </div>
                <div>                
                    <div class="sm:inline-block sm:align-top mt-2">
                        <jet-label for="endDate" value="終了" />
                        <flat-pickr v-model="modal.endDate" :config="dateConfig" placeholder="----/--/--" class="w-full" id="endDate"></flat-pickr>
                        <jet-input-error v-if="validateMessage.endDate" :message="validateMessage.endDate" class="mt-2" />
                    </div>
                    <div class="sm:inline-block sm:align-top mt-2">
                        <jet-label v-if="width >= 640" class="text-white select-none" for="endTime" value="時間" />
                        <flat-pickr v-model="modal.endTime" :config="timeConfig" placeholder="--:--" class="w-full" id="endTime"></flat-pickr>
                        <jet-input-error v-if="validateMessage.endTime" :message="validateMessage.endTime" class="mt-2" />
                    </div>
                </div>
            </template>
            <template #footer>
                <jet-button type="button" @click="clearData" class="mr-2">閉じる</jet-button>
                <jet-button type="button" @click="validateForm" class="bg-blue-700">追加</jet-button>    
            </template>
        </jet-dialog-modal>  

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { nextTick } from '@vue/runtime-core';
    import JetButton from '@/Jetstream/Button'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetInputError from '@/Jetstream/InputError'
    import FlatPickr from 'vue-flatpickr-component'
    import 'flatpickr/dist/flatpickr.css'
    import 'flatpickr/dist/themes/material_green.css'
    import { Japanese } from "flatpickr/dist/l10n/ja.js"

    export default {
        props: {
            group: Object,
            user: Object,
            members: Object,
            messages: Object,
        },
        data() {
            return {
                messageData: {
                    user_id: this.user.id,
                    group_id: this.group.id,
                    content: ''
                },
                form: {
                    _method: "",
                    title: "",
                    description: "",
                    start: "",
                    end: "",
                    user_id: this.user.id,
                },
                modal: {
                    showFlag: false,
                    headTitle: "",
                    startDate: "",
                    endDate: "",
                    startTime: "",
                    endTime: "",
                },
                dateConfig: {
                    dateFormat: "Y-m-d",
                    locale: Japanese,
                    altInput: true,
                    altFormat: "Y/m/d (D)",
                },
                timeConfig: {
                    enableTime: true,
                    dateFormat: "H:i",
                    noCalendar: true,
                    time_24hr: true,
                    locale: Japanese,
                    minuteIncrement: 1,
                    defaultMinute: 0,
                    defaultHour: 0,
                },
                validateMessage: {},
                validateMessageList: {
                    title: 'タイトルは必須です',
                    startDate: '開始日を入力してください',
                    startTime: '開始時間を入力してください',
                    endDate: '終了日を入力してください',
                    endTime: '終了時間を入力してください',
                },
                width: window.innerWidth,
                calendarFlag: true,
            }
        },
        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetInput,
            JetLabel,
            JetInputError,
            FlatPickr,
        },
        methods: {
            createSchedule() {
                this.modal.headTitle = "新規作成";
                this.toggleShowFlag();
            },
            validateForm() {
                this.validateMessage = {};
                if(this.form.title == "")
                    this.validateMessage.title = this.validateMessageList.title;
                if(this.modal.startDate == "")
                    this.validateMessage.startDate = this.validateMessageList.startDate;
                if(this.modal.startTime == "")
                    this.validateMessage.startTime = this.validateMessageList.startTime;
                if(this.modal.endDate == "")
                    this.validateMessage.endDate = this.validateMessageList.endDate;
                if(this.modal.endTime == "")
                    this.validateMessage.endTime = this.validateMessageList.endTime;
                
                if(Object.keys(this.validateMessage).length == 0) {        
                    this.form.start = this.modal.startDate + "T" + this.modal.startTime;
                    this.form.end = this.modal.endDate + "T" + this.modal.endTime;
                    this.storeSchedule();
                }
            },
            async storeSchedule() {
                this.form._method = "POST";
                const response = await axios.post(route("schedule.store"), this.form);
                this.clearData();
            },
            async send() {
                if(this.messageData.content == '') 
                    return;
                await axios.post(route("message.store"), this.messageData);
                this.messages.push({"user_id" : this.messageData.user_id, "group_id" : this.messageData.group_id, "content" : this.messageData.content });
                this.messageData.content = "";
                await nextTick();
                this.scrollMessage();
                if(!this.calendarFlag)
                    this.toggleCalendarFlag();
            },
            scrollMessage() {
                if(this.messages.length == 0) 
                    return;
                const messageContainer = document.getElementById('messageContainer');
                const elementsMessage = messageContainer.children;
                const elementMessage = elementsMessage[elementsMessage.length-1];
                elementMessage.scrollIntoView(false);
            },
            handleResize() {
                this.width = window.innerWidth;
            },
            toggleCalendarFlag() {
                if(this.messageData.content != '') 
                    this.calendarFlag = true;
                this.calendarFlag = !this.calendarFlag;
            },
            clearModal() {
                if(this.modal.showFlag)
                    this.toggleShowFlag();
                this.modal.headTitle = "";
                this.modal.startDate = "";
                this.modal.endDate =  "";
                this.modal.startTime = "";
                this.modal.endTime = "";
            },
            clearForm() {
                this.form.title = "";
                this.form.description = "";
                this.form.start = "";
                this.form.end = "";
                this.form._method = "";
            },
            clearData() {
                this.clearModal();
                this.clearForm();
                this.validateMessage = {};
            },
            toggleShowFlag() {
                this.modal.showFlag = !this.modal.showFlag;
            },
            connect() {
                Echo.channel("memo-chat-channel." + this.group.id)
                    .listen("MessageReceived", async (e) => {
                        this.messages.push(e.messageData);
                        await nextTick();
                        this.scrollMessage();
                    }).listen("newMemberJoined", (e) => {
                        for (var key in e.memberData) {
                            this.members[key] = e.memberData[key];
                        }
                    });
            },
            disconnect() {
                Echo.leave("memo-chat-channel." + this.group.id);
            },
        },
        mounted() {
            this.connect();
            this.scrollMessage();
            window.addEventListener('resize', this.handleResize);
        },
        beforeUnmount() {
            this.disconnect();
            window.removeEventListener('resize', this.handleResize);
        },
    }
</script>

<style>
.chatBox {
    height: calc(100vh - 66px);
}

@media (min-width: 640px) {
    .sm\:chatBox {
        height: calc(100vh - 80px);
    }
}

.messageContainer {
    height: calc(100% - 82px);
}

.max-w-2\/3 {
    max-width: calc(66.6666%);
}

.overflow-wrap {
    overflow-wrap: break-word;
    word-wrap: break-word;
}

.st0{fill:#4B4B4B;}
</style>