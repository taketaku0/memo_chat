<template>
    <app-layout title="Group">
        <template #place>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Group
            </h2>
        </template>

        <div class="xl:max-w-7xl xl:mx-auto xl:px-4 xl:sm:px-6 xl:px-8">
            <div class="mx-auto bg-white my-4 py-4 px-4 sm:mx-6">
                <div class="grid grid-rows-2 sm:grid-rows-1 sm:grid-cols-2 lg:grid-cols-3 mb-6">
                    <div class="mb-1 sm:mb-0">
                        <Link :href="route('group.create')">
                            <jet-button class="bg-blue-700 text-base">グループを作成</jet-button>
                        </Link>
                    </div>
                    <div class="flex flex-row w-full max-w-sm space-x-3 space-y-3 space-y-0 justify-start sm:m-auto lg:col-start-3 lg:col-end-4">
                        <input type="text" class="rounded-lg border-transparent flex-1 appearance-none border border-gray-400 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Enter a group name"/>
                        <button class="flex-shrink-0 px-4 py-2 text-base font-semibold text-white bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-purple-200" type="button">
                            検索
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="overflow-hidden shadow-lg rounded-lg cursor-pointer m-auto w-full sm:group_card border border-gray-300 mb-6" v-for="group in groups" :key="group.id">
                        <div class="bg-white w-full">
                            <div class="group_card_icon bg-blue-500" /> 
                            <div class="p-4">
                                <p class="text-indigo-500 text-md font-medium">
                                    {{ group.group_name }}
                                </p>
                                <p class="text-gray-800 text-xl font-medium mb-2">
                                    {{ group.group_description }}
                                </p>
                                <p class="text-gray-400 font-light text-md">
                                    {{ group.host }}
                                </p>
                            </div>
                            <div class="mr-1 mb-2">
                                <div class="flex flex-row justify-end ml-4 text-sm">
                                    <template v-if="isMembers(group.id)">
                                        <Link :href="route('group.show', group.id)">
                                            <jet-button class="bg-blue-300 text-base mx-1 px-3">参加</jet-button>
                                        </Link>
                                    </template>
                                    <template v-else>
                                        <Link :href="route('group.join', group.id)">
                                            <jet-button class="bg-blue-300 text-base mx-1 px-3">参加</jet-button>
                                        </Link>
                                    </template>
                                    <template v-if="isHost(group.host)">
                                        <Link :href="route('group.edit', group.id)">
                                            <jet-button class="bg-green-500 text-base mx-1 px-3">更新</jet-button>
                                        </Link>
                                        <jet-button class="bg-red-500 text-base mx-1 px-3" @click="deleteGroup(group.id)">削除</jet-button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';
    import JetButton from '@/Jetstream/Button';
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default {
        props: {
            groups: Object,
            user: Object
        },
        components: { 
            Head,
            AppLayout,
            JetButton,
            Link,
        },
        data() {
            return {
                form: this.$inertia.form({
                    _method: "DELETE"
                }),
            }
        },
        methods:{
            deleteGroup(id) {
                this.form.delete(route("group.destroy", id), {
                    preserveScroll: true,
                });
            },
            isMembers(id){
                return this.user.id == id;
            },
            isHost(id){
                return this.user.id == id;
            }
        },
    }
</script>

<style>
@media (min-width: 640px) {
    .sm\:group_card {
        max-width: 270px;
    }
}

.group_card_icon{
    height: 146px;
}
</style>