<script setup lang="ts">
import { App, Head, router } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import AppLogo from '@/components/AppLogo.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';

defineProps({ prodotti: Object })

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Prodotti',
        href: "/admin/products"
    },
];


function NavigaA(id_prodotto:any){
    router.get("/admin/products/"+id_prodotto)
}

</script>

<template>

    <Head title="Prodotti" />


    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
 
          <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Product name
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            SKU
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Stock
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="prodotto in prodotti" class="bg-neutral-primary border-b border-default" v-on:click="NavigaA(prodotto.id)">
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                           {{ prodotto.name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ prodotto.SKU }}
                        </td>
                        <td class="px-6 py-4">
                            {{ prodotto.description }}
                        </td>
                        <td class="px-6 py-4">
                            {{ prodotto.price }}
                        </td>
                        <td class="px-6 py-4">
                            {{ prodotto.stock }}
                        </td>
                    </tr>
  
                </tbody>
            </table>
        </div>
        </div>

    </AppLayout>
</template>
