<script setup lang="ts">
import { App, Head, router, Form } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Prodotto',
        href: "/admin/products"
    }, {
        title: 'Crea',
        href: "/admin/products/create"
    },
];

</script>

<template>

    <Head title="Crea Prodotto" />


    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="size-50 flex align-middle">
            <Form method="post" v-slot="{ errors, processing }" class="flex flex-col gap-6">
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="SKU">SKU</Label>
                        <Input id="SKU" type="text" name="SKU" required autofocus :tabindex="1" />
                        <InputError :message="errors.SKU" />
                    </div>

                    <div class="grid gap-2">
                        <div class="flex items-center justify-between">
                            <Label for="name">Name</Label>
                        </div>
                        <Input id="name" type="text" name="name" required :tabindex="2" />
                        <InputError :message="errors.name" />
                    </div>
                    <div class="grid gap-2">
                        <div class="flex items-center justify-between">
                            <Label for="description">Description</Label>
                        </div>
                        <Input id="description" type="text" name="description" required :tabindex="3" />
                        <InputError :message="errors.description" />
                    </div>

                    <div class="grid gap-2">
                        <div class="flex items-center justify-between">
                            <Label for="categories">Categories</Label>
                        </div>
                        <Input id="categories" type="text" name="categories" required :tabindex="4" />
                        <InputError :message="errors.categories" />
                    </div>
                    <div class="grid gap-2">
                        <div class="flex items-center justify-between">
                            <Label for="stock">Stock</Label>
                        </div>
                        <Input id="stock" type="number" name="stock" required :tabindex="5" />
                        <InputError :message="errors.stock" />
                    </div>
                    <div class="grid gap-2">
                        <div class="flex items-center justify-between">
                            <Label for="price">Price</Label>
                        </div>
                        <Input id="price" type="number" name="price" required :tabindex="6" step="0.01" />
                        <InputError :message="errors.price" />
                    </div>  
                      <div class="grid gap-2">
                        <div class="flex items-center justify-between">
                            <Label for="price2">Price</Label>
                        </div>
                        <Input id="price2" type="number" name="price2" required :tabindex="6" step="0.01" />
                        <InputError :message="errors.price2" />
                    </div>


                    <Button type="submit" class="mt-4 w-full" :tabindex="7" :disabled="processing"
                        data-test="save-button">
                        <Spinner v-if="processing" />
                        Save
                    </Button>
                </div>


            </Form>
        </div>
    </AppLayout>
</template>
