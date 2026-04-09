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

    <Head title="Errore" />


    <AppLayout :breadcrumbs="[]">

       <h1>Si è verificato un errore, riprova</h1>
    </AppLayout>
</template>
