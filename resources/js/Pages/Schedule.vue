<template>
    <app-layout title="schedule">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <FullCalendar :options="calendarOptions" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import '@fullcalendar/core/vdom'
    import FullCalendar from '@fullcalendar/vue3'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import AppLayout from '@/Layouts/AppLayout';

    export default {
        components: {
            FullCalendar,
            AppLayout
        },
        data() {
            return {
                calendarOptions: {
                    plugins: [dayGridPlugin, interactionPlugin],
                    initialView: 'dayGridMonth'
                }
            }
        },
        methods: {
        }
    }
</script>

<style>

</style>