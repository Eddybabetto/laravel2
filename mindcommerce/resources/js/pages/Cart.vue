<script setup lang="ts">
import { App, Head } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import ProductCart from '@/components/ProductCart.vue';
const props = defineProps({ products_in_cart: Object })

</script>

<template>

    <Head title="Cart" />


    <AppLayout :breadcrumbs="[]">
        <div class="flex flex-wrap overflow-auto">
            <ProductCart v-for="product in products_in_cart" :product="product">
            </ProductCart>
        </div>

    </AppLayout>
</template>
