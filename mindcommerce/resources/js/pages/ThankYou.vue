<script setup lang="ts">
import { App, Head } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import AppLogo from '@/components/AppLogo.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import ProductCard from '@/components/ProductCard.vue';


const props = defineProps({ products: Object })

</script>

<template>

    <Head title="GRazie!" />


    <AppLayout :breadcrumbs="[]">

       <h1>Grazie per il tuo acquisto</h1>
    </AppLayout>
</template>
