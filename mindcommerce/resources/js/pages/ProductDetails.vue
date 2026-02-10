<script setup lang="ts">
import { App, Head, router } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import AppLogo from '@/components/AppLogo.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import ProductController from '@/actions/App/Http/Controllers/ProductController';


defineProps({ prodotto: Object })

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Prodotto',
        href: "/admin/products"
    },
];

</script>

<template>

    <Head title="Prodotto" />


    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <dl v-if="prodotto" class="max-w-md text-heading divide-y divide-default">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-body">ID</dt>
                    <dd class="text-lg font-medium">{{ prodotto.id }}</dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-body">SKU</dt>
                    <dd class="text-lg font-medium">{{ prodotto.SKU }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Name</dt>
                    <dd class="text-lg font-medium">{{ prodotto.name }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Description</dt>
                    <dd class="text-lg font-medium">{{ prodotto.description }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Stock</dt>
                    <dd class="text-lg font-medium">{{ prodotto.stock }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Categories</dt>
                    <dd class="text-lg font-medium">{{ prodotto.categories }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Price</dt>
                    <dd class="text-lg font-medium">{{ prodotto.price }} €</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Created</dt>
                    <dd class="text-lg font-medium">{{ prodotto.created_at }}</dd>
                </div>
            </dl>

            <div v-else>Il prodotto selezionato non esiste</div>
     </div>

    </AppLayout>
</template>
