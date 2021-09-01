<template>
    <app-layout title="Group">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Group
            </h2>
        </template>

        <div>
            <div class="max-w-7x1 mx-auto py-10 sm:px-6 lg:px-8">
                <button @click="debug(groups)">ログ出力</button>
                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>名前</th>
                            <th>概要</th>
                            <th>ホスト</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="group in groups" :key="group.id">
                            <td class="border px-4 py-2">{{ group.id }}</td>
                            <td class="border px-4 py-2">{{ group.group_name }}</td>
                            <td class="border px-4 py-2">{{ group.group_description }}</td>
                            <td class="border px-4 py-2">{{ group.host }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default{
        components: { 
            AppLayout 
        },
        props:{
            groups:{
                type: Array
            }
        },
        methods:{
            debug(message){
                console.log(message);
            }
        }
    }
</script>

<style>

</style>