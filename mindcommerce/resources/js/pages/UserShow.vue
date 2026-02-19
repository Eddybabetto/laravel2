<script setup lang="ts">
import { App, Head, router } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import AppLogo from '@/components/AppLogo.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { ref } from 'vue'

defineProps({ user: Object })

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Utenti',
        href: "/admin/user"
    },
];

let editabile = ref(false);
function modificaProdotto() {
    editabile.value = !editabile.value
}
</script>

<template>
    <Head title="Utenti" />


    <AppLayout :breadcrumbs="breadcrumbs">

        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >


        <dl v-if ="user && !editabile" class="max-w-md text-heading divide-y divide-default">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-body">Name</dt>
                    <dd class="text-lg font-medium">{{ user.name }}</dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-body">Email</dt>
                    <dd class="text-lg font-medium">{{ user.email }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Surname</dt>
                    <dd class="text-lg font-medium">{{ user.surname}}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Cf</dt>
                    <dd class="text-lg font-medium">{{ user.cf}}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Telephone</dt>
                    <dd class="text-lg font-medium">{{ user.tel }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Admin</dt>
                    <dd v-if ="user.admin" class="text-lg font-medium"> E' UN ADMIN </dd>
                     <dd v-else class="text-lg font-medium"> NON  E' UN ADMIN </dd>
                </div>
            </dl>

          <div v-else-if="user && editabile"></div>
             <Button class="ml-auto mr-0" v-on:click="modificaProdotto()">Modifica Utente</Button>


        </div>
    </AppLayout>
</template>
