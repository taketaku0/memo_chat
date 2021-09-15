<template>
    <app-layout title="schedule">
        <template #place>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Schedule
            </h2>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <button type="button" @click="debug">debug</button>
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div class="py-2 sm:px-6 lg:px-8">
                        <jet-button type="button" @click="createSchedule">予定を追加</jet-button>
                        <div class="my-2">
                            <full-calendar :options="calendarOptions" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <jet-dialog-modal :show="modal.showFlag" @close="clearModal">
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
                <div class="inline-block mt-2">
                    <jet-label for="start" value="開始" />
                    <flat-pickr v-model="modal.startData" :config="dateConfig" placeholder="----/--/--" class="w-full"></flat-pickr>
                    <jet-input-error v-if="validateMessage.startData" :message="validateMessage.startData" class="mt-2" />
                </div>
                <div class="inline-block mt-2 sm:ml-1">
                    <flat-pickr v-model="modal.startTime" :config="timeConfig" placeholder="--:--" class="w-full"></flat-pickr>
                    <jet-input-error v-if="validateMessage.startTime" :message="validateMessage.startTime" class="mt-2" />
                </div>
                <div class="inline-block mt-2">
                    <jet-label for="end" value="終了" />
                    <flat-pickr v-model="modal.endData" :config="dateConfig" placeholder="----/--/--" class="w-full"></flat-pickr>
                    <jet-input-error v-if="validateMessage.endData" :message="validateMessage.endData" class="mt-2" />
                </div>
                <div class="inline-block mt-2 sm:ml-1">
                    <jet-label for="end" value="" />
                    <flat-pickr v-model="modal.endTime" :config="timeConfig" placeholder="--:--" class="w-full"></flat-pickr>
                    <jet-input-error v-if="validateMessage.endTime" :message="validateMessage.endTime" class="mt-2" />
                </div>
            </template>
            <template #footer>
                <jet-button type="button" @click="clearModal" class="mr-2">閉じる</jet-button>
                <jet-button type="button" @click="validateForm" class="bg-blue-700">追加</jet-button>
            </template>
        </jet-dialog-modal>    
    </app-layout>
</template>

<script>
    import '@fullcalendar/core/vdom'
    import FullCalendar from '@fullcalendar/vue3'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import listPlugin from '@fullcalendar/list'
    import timeGridPlugin from '@fullcalendar/timegrid'
    import jaLocale from '@fullcalendar/core/locales/ja'
    import AppLayout from '@/Layouts/AppLayout'
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
        props: ['schedules', 'user_id'],
        components: {
            FullCalendar,
            AppLayout,
            JetButton,
            JetDialogModal,
            JetInput,
            JetLabel,
            JetInputError,
            FlatPickr
        },
        data() {
            return {
                calendarOptions: {
                    plugins: [dayGridPlugin, interactionPlugin, listPlugin, timeGridPlugin],
                    initialView: 'dayGridMonth',
                    locale: jaLocale,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    selectable: true,
                    navLinks: true,
                    businessHours: true,
                    editable: true,
                    dayCellContent: this.dayCellContent,
                    events: this.schedules,
                    dayMaxEvents: 5,
                    nowIndicator: true,
                    eventClick: this.eventClick,
                    dateClick: this.dateClick,
                    contentHeight: 'auto',
                    eventResize: this.eventResize,
                    eventDrop: this.eventDrop
                },
                form: {
                    _method: "",
                    title: "",
                    description: "",
                    start: "",
                    end: "",
                    user_id: this.user_id,
                },
                modal: {
                    showFlag: false,
                    headTitle: "",
                    startData: "",
                    endData: "",
                    startTime: "",
                    endTime: "",
                },
                dateConfig: {
                    dateFormat: "Y-m-d",
                    locale: Japanese
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
            }
        },
        methods: {
            dayCellContent(e) {
                e.dayNumberText = e.dayNumberText.replace('日', '');
            },
            dateClick(info) {
                
            },
            eventClick(info) {
                console.log('Event: ' + info.event.title);
                console.log('time: ' + info.event.start);
            },
            eventResize(info) {
                console.log(info);
            },
            eventDrop(info) {
                console.log(info);
            },
            debug() {
                console.log(this.schedules);
            },
            toggleShowFlag() {
                this.modal.showFlag = !this.modal.showFlag;
            },
            createSchedule() {
                this.modal.headTitle = "新規作成";
                this.toggleShowFlag();
            },
            async storeSchedule() {
                this.form.start = this.modal.startData + "T" + this.modal.startTime;
                this.form.end = this.modal.endData + "T" + this.modal.endTime;
                this.form._method = "POST";
                const response = await axios.post(route("schedule.store"), this.form);
                this.schedules.push({"id":response.id, "title": this.form.title, "description": this.form.description, "start": this.form.start, "end": this.form.end});
                this.clearModal();
                this.clearForm();
            },
            setModal() {

            },
            clearModal() {
                this.toggleShowFlag();
                this.modal.headTitle = "";
                this.modal.startData = "";
                this.modal.endData =  "";
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
            validateForm() {
                this.validateMessage = {};
                if(this.form.title == "")
                    this.validateMessage.title = 'タイトルは必須です';
                if(this.modal.startData == "")
                    this.validateMessage.startData = '開始日を入力してください';
                if(this.modal.startTime == "")
                    this.validateMessage.startTime = '開始時間を入力してください';
                if(this.modal.endData == "")
                    this.validateMessage.endData = '終了日を入力してください';
                if(this.modal.endTime == "")
                    this.validateMessage.endTime = '終了時間を入力してください';
                if(Object.keys(this.validateMessage).length == 0)
                    this.storeSchedule();
            }
        }
    }
</script>

<style>

</style>