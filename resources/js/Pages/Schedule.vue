<template>
    <app-layout title="schedule">
        <template #place>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                スケジュール
            </h2>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div class="py-2 mx-auto sm:px-6 lg:px-8">
                        <div>
                            <jet-button type="button" @click="createSchedule" class="align-middle inline-block">予定を追加</jet-button>
                            <div class="inline-block text-3xl align-middle ml-4">{{ calendarTitle }}</div>    
                        </div>
                        <div class="my-2">
                            <full-calendar :options="calendarOptions" :key="key" />
                        </div>
                    </div>
                </div>
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
                <div :class="{flex: !modal.createFlag, 'justify-between': !modal.createFlag}">
                    <jet-delete-button type="button" @click="deleteSchedule" v-if="!modal.createFlag" class="text-left">削除</jet-delete-button>
                    <div>
                        <jet-button type="button" @click="clearData" class="mr-2">閉じる</jet-button>
                        <jet-button type="button" @click="validateForm" class="bg-blue-700" v-if="modal.createFlag">追加</jet-button>
                        <jet-button type="button" @click="validateForm" class="bg-blue-700" v-else>更新</jet-button>
                    </div>
                </div>
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
    import JetDeleteButton from '@/Jetstream/DangerButton'
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
            JetDeleteButton,
            JetDialogModal,
            JetInput,
            JetLabel,
            JetInputError,
            FlatPickr,
        },
        data() {
            return {
                calendarOptions: {
                    plugins: [dayGridPlugin, interactionPlugin, listPlugin, timeGridPlugin],
                    initialView: 'dayGridMonth',
                    locale: jaLocale,
                    headerToolbar: {
                        left: 'prev,next today',
                        //center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    buttonText: {
                        list: '一覧'
                    },
                    views: {
                        dayGridMonth: {
                            titleFormat: this.titleFormat
                        },
                        timeGridWeek: {        
                            titleFormat: this.titleFormat,
                            dayHeaderFormat: function (date) {
                                const day = date.date.day;
                                const weekNum = date.date.marker.getDay();
                                const week = ['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'][weekNum];
                                return day + ' ' + week;
                            },
                        },
                        timeGridDay: {
                            titleFormat: this.titleFormat
                        },
                        listMonth: {
                            titleFormat: this.titleFormat
                        }
                    },
                    selectable: true,
                    navLinks: true,
                    businessHours: false,
                    editable: true,
                    dayCellContent: this.dayCellContent,
                    events: this.schedules,
                    dayMaxEvents: 5,
                    nowIndicator: true,
                    eventClick: this.eventClick,
                    dateClick: this.dateClick,
                    contentHeight: 'auto',
                    eventResize: this.eventResize,
                    eventDrop: this.eventDrop,
                    viewClassNames: this.viewClassNames,
                },
                form: {
                    _method: "",
                    title: "",
                    description: "",
                    start: "",
                    end: "",
                    id: "",
                    user_id: this.user_id,
                },
                modal: {
                    showFlag: false,
                    createFlag: false,
                    headTitle: "",
                    startDate: "",
                    endDate: "",
                    startTime: "",
                    endTime: "",
                    lock: false,
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
                calendarTitle: "",
                key: 0,
                width: window.innerWidth
            }
        },
        methods: {
            dayCellContent(e) {
                e.dayNumberText = e.dayNumberText.replace("日", "");
            },
            titleFormat(date) {
                const year = date.date.year;
                const startMonth = date.start.month + 1;
                const endMonth = date.end.month + 1;
                const day = date.date.day;

                if(this.calendarOptions.initialView == "dayGridMonth" || this.calendarOptions.initialView == "timeGridWeek" || this.calendarOptions.initialView == "listMonth") {
                    if (startMonth === endMonth)
                        this.calendarTitle = year + "年" + startMonth + "月";
                    else
                        this.calendarTitle = year + "年" + startMonth + "～" + endMonth + "月";
                }
                else if(this.calendarOptions.initialView == "timeGridDay")
                    this.calendarTitle = year + "年" + startMonth + "月" + day + "日";
            },
            viewClassNames(info){
                this.calendarOptions.initialView = info.view.type;
            },
            dateClick(info) {
                if(this.modal.lock) return;
                this.modal.headTitle = "新規作成";
                this.modal.createFlag = true;
                this.modal.startDate = info.dateStr;
                this.modal.endDate = info.dateStr;
                this.toggleShowFlag();
            },
            eventClick(info) {
                this.modal.headTitle = "詳細"
                this.form.title = info.event.title;
                this.form.description = info.event.extendedProps.description;
                this.modal.startDate = info.event.startStr.substr(0, 10);
                this.modal.startTime = info.event.startStr.substr(11, 5);
                this.modal.endDate = info.event.endStr.substr(0, 10);
                this.modal.endTime = info.event.endStr.substr(11, 5);
                this.form.id = info.event.id;
                this.toggleShowFlag();
            },
            eventResize(info) {
                this.setForm(info);
            },
            eventDrop(info) {
                this.setForm(info);
            },
            setForm(info){
                this.modal.lock = true;
                this.form.title = info.event.title;
                this.form.description = info.event.extendedProps.description;
                this.form.start = info.event.startStr;
                this.form.end = info.event.endStr;
                this.form.id = info.event.id;
                this.updateSchedule();
            },
            createSchedule() {
                if(this.modal.lock) return;
                this.modal.headTitle = "新規作成";
                this.modal.createFlag = true;
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
                    if(this.calendarOptions.initialView == "timeGridDay" || this.calendarOptions.initialView == "timeGridWeek"){
                        this.form.start = this.modal.startDate.substr(0, 10) + "T" + this.modal.startTime;
                        this.form.end = this.modal.endDate.substr(0, 10) + "T" + this.modal.endTime;    
                    }
                    else{
                        this.form.start = this.modal.startDate + "T" + this.modal.startTime;
                        this.form.end = this.modal.endDate + "T" + this.modal.endTime;
                    }
                    if(this.modal.createFlag)
                        this.storeSchedule();
                    else 
                        this.updateSchedule();
                }
            },
            async storeSchedule() {
                this.form._method = "POST";
                const response = await axios.post(route("schedule.store"), this.form);
                this.schedules.push({"id": response.data.id, "title": this.form.title, "description": this.form.description, "start": this.form.start, "end": this.form.end});
                this.clearData();
            },
            async updateSchedule() {
                this.lock();
                this.form._method = "PUT";
                const response = await axios.put(route("schedule.update", this.form.id), this.form);
                const index = this.schedules.findIndex(el => el.id == response.data.id);
                this.schedules[index] = {"id":response.data.id, "title": this.form.title, "description": this.form.description, "start": this.form.start, "end": this.form.end};
                this.clearData();
                this.unlock();
            },
            async deleteSchedule() {
                const conf = confirm("本当に削除しますか？");
                if(conf) {
                    const response = await axios.delete(route("schedule.destroy", this.form.id));
                    if(response.status == 204) {
                        const index = this.schedules.findIndex(el => el.id == this.form.id);
                        this.schedules.splice(index, 1);
                        this.clearData();
                    }
                }
            },
            clearModal() {
                if(this.modal.showFlag)
                    this.toggleShowFlag();
                this.modal.createFlag = false;
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
                this.form.id = "";
            },
            clearData() {
                this.clearModal();
                this.clearForm();
                this.validateMessage = {};
                this.toggleKey();
            },
            toggleKey() {
                this.key = this.key ? 0 : 1;
            },
            toggleShowFlag() {
                this.modal.showFlag = !this.modal.showFlag;
            },
            lock(){
                this.calendarOptions.navLinks = false;
                this.calendarOptions.editable = false;
                this.modal.lock = true;
            },
            unlock(){
                this.calendarOptions.navLinks = true;
                this.calendarOptions.editable = true;
                this.modal.lock = false;
            },
            handleResize() {
                this.width = window.innerWidth;
            },
        },
        mounted: function() {
            window.addEventListener('resize', this.handleResize);
        },
        beforeUnmount: function() {
            window.removeEventListener('resize', this.handleResize);
        }
    }
</script>

<style>
.fc-day-sun {
    background-color: #ffc2cf
}

.fc-day-sat {
    background-color: #b8e5ff;
}
</style>