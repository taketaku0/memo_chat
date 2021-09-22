<template>
    <app-layout title="Group">
        <template #place>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Group
            </h2>
        </template>

        <div>
            <div class="max-w-7x1 mx-auto py-10 sm:px-6 lg:px-8">
                <jet-form-section @submitted="editGroup">
                    <template #title>グループ更新</template>
                    <template #description>グループ情報を更新します</template>
                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="group_name" value="グループ名" />
                            <jet-input id="group_name" type="text" class="mt-1 block w-full" v-model="form.group_name" />
                            <jet-input-error v-if="form.errors.group_name" :message="validateMessage.group_name" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="group_description" value="グループの概要" />
                            <textarea id="group_description" v-model="form.group_description" class="mt-1 block w-full form-input rounded-md shadow-sm"></textarea>
                        </div>
                    </template>
                    <template #actions>
                        <Link :href="route('group.index')">
                            <jet-button type="button" class=" mr-2">戻る</jet-button>
                        </Link>
                        <jet-button class="bg-blue-700">更新</jet-button>
                    </template>
                </jet-form-section>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';
    import JetFormSection from '@/Jetstream/FormSection';
    import JetInput from '@/Jetstream/Input';
    import JetLabel from '@/Jetstream/Label';
    import JetButton from '@/Jetstream/Button';
    import JetInputError from "@/Jetstream/InputError";
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        props: ['group'],
        components: { 
            AppLayout,
            JetFormSection,
            JetInput,
            JetLabel,
            JetButton,
            JetInputError,
            Link,
        },
        data() {
            return {
                form: this.$inertia.form({
                    _method: "PUT",
                    group_name: this.group.group_name,
                    group_description: this.group.group_description,
                    host: this.group.host,
                }),
                validateMessage: {
                    group_name: "グループ名は必須です。",
                },
            }
        },
        methods: {
            editGroup(){
                this.form.put(route("group.update", this.group.id), {
                    errorBag: 'updateGroup',
                    preserveScroll: true
                });
            },
        }
    }
</script>

<style>

</style>