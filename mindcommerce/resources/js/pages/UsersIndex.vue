<script setup lang="ts">
import { App, Head, router } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import AppLogo from '@/components/AppLogo.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';

defineProps({ users: Object })

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Utenti',
        href: "/admin/user"
    },
];

function loadUser(id: Number) {
    router.get("/admin/user/" + id)
}
</script>

<template>

    <Head title="Utenti" />


    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

            <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                <table class="w-full text-sm text-left rtl:text-right text-body">
                    <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Surname
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                CF
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Tel
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Admin
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" v-on:click="loadUser(user.id)"
                            class="bg-neutral-primary border-b border-default">
                            <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                {{ user.name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ user.surname }}
                            </td>
                            <td class="px-6 py-4">
                                {{ user.CF }}
                            </td>
                            <td class="px-6 py-4">
                                {{ user.tel }}
                            </td>
                            <td class="px-6 py-4">


                                <div v-if="user.admin">IS admin</div>

                                <div v-else>IS NOT admin</div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>

    </AppLayout>
</template>
