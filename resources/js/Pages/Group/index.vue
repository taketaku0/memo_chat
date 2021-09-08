<template>
    <app-layout title="Group">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Group
            </h2>
        </template>

        <div>
            <div class="max-w-7x1 mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <Link :href="route('group.create')">
                        <jet-button class="bg-blue-700 text-base mb-10">グループを作成</jet-button>
                    </Link>
                </div>
                <table class="table-auto">
                    <thead>
                        <tr>
                            <th class="w-1/12">id</th>
                            <th class="w-3/12">名前</th>
                            <th class="w-4/12">概要</th>
                            <th class="w-1/12">ホスト</th>
                            <th class="w-1/12"></th>
                            <th class="w-1/12"></th>
                            <th class="w-1/12"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="group in groups" :key="group.id">
                            <td class="border px-2 py-2">{{ group.id }}</td>
                            <td class="border px-4 py-2">{{ group.group_name }}</td>
                            <td class="border px-4 py-2">{{ group.group_description }}</td>
                            <td class="border px-2 py-2">{{ group.host }}</td>
                            <template v-if="isMembers(group.id)">
                                <td class="border px-2 py-2 text-center">
                                    <Link :href="route('group.show', group.id)">
                                        <jet-button class="bg-blue-200 text-base">参加</jet-button>
                                    </Link>
                                </td>
                            </template>
                            <template v-else>
                                <td class="border px-2 py-2 text-center">
                                    <Link :href="route('group.join', group.id)">
                                        <jet-button class="bg-blue-200 text-base">参加</jet-button>
                                    </Link>
                                </td>
                            </template>
                            <td class="border px-2 py-2 text-center">
                                <Link :href="route('group.edit', group.id)">
                                    <jet-button class="bg-green-500 text-base">更新</jet-button>
                                </Link>
                            </td>
                            <td class="border px-2 py-2 text-center">
                                <jet-button class="bg-red-500 text-base" @click="deleteGroup(group.id)">削除</jet-button>
                           </td>
                        </tr>
                    </tbody>
                </table>
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
            }
        },
    }
</script>

<style>

</style>