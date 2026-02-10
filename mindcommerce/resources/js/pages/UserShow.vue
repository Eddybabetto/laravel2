<script setup lang="ts">
import { App, Head, router } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import AppLogo from '@/components/AppLogo.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';

defineProps({ user: Object })

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Utenti',
        href: "/admin/user"
    },
];

function loadUser(id:Number){
    router.get("/admin/user/"+id)
}
</script>

<template>
    <Head title="Utenti" />


    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >

       {{ user }}
        

        </div>
    </AppLayout>
</template>
