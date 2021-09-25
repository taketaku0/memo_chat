<template>
    <app-layout title="Group">
        <template #place>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                グループ
            </h2>
        </template>

        <div class="xl:max-w-7xl xl:mx-auto xl:px-4 xl:sm:px-6 xl:px-8">
            <div class="mx-auto bg-white my-4 py-4 px-4 sm:mx-6 sm:rounded-lg">
                <div class="grid grid-rows-2 sm:grid-rows-1 sm:grid-cols-2 lg:grid-cols-3 mb-10">
                    <div class="mb-4 sm:mb-0">
                        <Link :href="route('group.create')">
                            <jet-button class="bg-blue-700 text-base h-11">グループを作成</jet-button>
                        </Link>
                    </div>
                    <div class="flex flex-row w-full max-w-sm space-x-3 justify-end sm:m-auto lg:col-start-3 lg:col-end-4 h-11">
                        <div class="relative w-full">
                            <input type="text" v-model="searchForm.searchString" class="rounded-lg border-transparent flex-1 h-11 border border-gray-400 appearance-none w-full py-2 pl-4 pr-6 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Enter a group name"/>
                            <button @click.prevent="clearSearchForm" v-if="searchForm.searchString!=''" class="absolute outline-none right-1 top-2.5" type="button">
                                <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" class="w-6 h-6 text-blue-400">
                                    <path fill="currentColor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                </svg>
                            </button>
                        </div>
                        <button @click="serchGroup" class="flex-shrink-0 px-4 py-2 text-base font-semibold text-white bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-purple-200" type="button">
                            検索
                        </button>
                    </div>
                    
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-10">
                    <div class="overflow-hidden shadow-lg rounded-lg mx-auto w-full sm:group_card border border-gray-300 mb-auto" v-for="group in groups" :key="group.id">
                        <div class="bg-white w-full">
                            <div class="group_card_icon" :class="setColor(group.id)"/> 
                            <div class="p-4">
                                <p class="text-indigo-500 text-xl font-medium mb-2">
                                    {{ group.group_name }}
                                </p>
                                <p class="text-gray-800 text-md font-medium mb-2 max-h-32 overflow-y-auto whitespace-pre-wrap overflow-wrap">
                                    {{ group.group_description }}
                                </p>
                                <p class="text-gray-400 text-sm">
                                    {{ users[group.host] }}が作成 
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
                                        <jet-button class="bg-blue-300 text-base mx-1 px-3" @click="joinGroup(group.id)">参加</jet-button>
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
            user: Object,
            joinedGroupId: Array,
            users: Object
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
                searchForm: {
                    searchString: ""
                },
                joinForm: this.$inertia.form({
                    _method: "POST",
                    group_id: '',
                    content: '',
                    joinFlag: true
                }),
                colorList: ['bg-red-300', 'bg-yellow-200', 'bg-green-300', 'bg-blue-300', 'bg-purple-300', 'bg-pink-300'],
                colorChange: true
            }
        },
        methods:{
            deleteGroup(id) {
                const conf = confirm("本当に削除しますか？");
                if(conf) {
                    this.form.delete(route("group.destroy", id), { preserveScroll: true });   
                }
            },
            isMembers(id){
                if(!this.joinedGroupId) return false
                return this.joinedGroupId.some((groupId) => groupId == id);
            },
            isHost(id){
                return this.user.id == id;
            },
            async serchGroup(){
                let response = await axios.post(route("group.search"), this.searchForm);
                if(response.status == 200){
                    this.groups.length = 0;
                    response.data.forEach( (group) => this.groups.push(group) );
                }
            },
            clearSearchForm() {
                this.searchForm.searchString = "";
                this.serchGroup();
            },
            joinGroup(id) {
                this.joinForm.group_id = id;
                this.joinForm.content = this.user.name + "がグループに参加しました";
                this.joinForm.post(route("message.store"));
            },
            setColor(id) {
                let index = id % 6;
                return this.colorList[index];
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

.overflow-wrap {
    overflow-wrap: break-word;
    word-wrap: break-word;
}
</style>