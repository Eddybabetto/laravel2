<script setup lang="ts">
import { App, Head, router, Form } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import AppLogo from '@/components/AppLogo.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import Button from '@/components/ui/button/Button.vue';
import { ref } from 'vue'

import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';

import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';

const props = defineProps({ prodotto: Object })

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Prodotto',
        href: "/admin/products"
    },
];

let prodotto_edit = ref(Object.assign({}, props.prodotto))
let editabile = ref(false)
let url_update = "/admin/products/" + props.prodotto?.id

function modificaProdotto() {
    editabile.value = !editabile.value
}

function resetProdotto() {
    prodotto_edit.value = Object.assign({}, props.prodotto)
}

</script>

<template>

    <Head title="Prodotto" />


    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <dl v-if ="prodotto && !editabile" class="max-w-md text-heading divide-y divide-default">
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
            </dl>

            <div v-else-if="prodotto && editabile">
                <div class="size-50 flex align-middle">

                    <Form method="put" @success="modificaProdotto" :action=url_update v-slot="{ errors, processing }"
                        class="flex flex-col gap-6">
                        <div class="grid gap-6">
                            <div class="grid gap-2">
                                <Label for="SKU">SKU</Label>
                                <Input v-model="prodotto_edit.SKU" id="SKU" type="text" name="SKU" required disabled
                                    :tabindex="1" />
                                <InputError :message="errors.SKU" />
                            </div>

                            <div class="grid gap-2">
                                <div class="flex items-center justify-between">
                                    <Label for="name">Name</Label>
                                </div>
                                <Input id="name" v-model="prodotto_edit.name" type="text" name="name" required
                                    :tabindex="2" />
                                <InputError :message="errors.name" />
                            </div>
                            <div class="grid gap-2">
                                <div class="flex items-center justify-between">
                                    <Label for="description">Description</Label>
                                </div>
                                <Input id="description" v-model="prodotto_edit.description" type="text"
                                    name="description" required :tabindex="3" />
                                <InputError :message="errors.description" />
                            </div>

                            <div class="grid gap-2">
                                <div class="flex items-center justify-between">
                                    <Label for="categories">Categories</Label>
                                </div>
                                <Input id="categories" v-model="prodotto_edit.categories" type="text" name="categories"
                                    required :tabindex="4" />
                                <InputError :message="errors.categories" />
                            </div>
                            <div class="grid gap-2">
                                <div class="flex items-center justify-between">
                                    <Label for="stock">Stock</Label>
                                </div>
                                <Input id="stock" type="number" v-model="prodotto_edit.stock" name="stock" required
                                    :tabindex="5" />
                                <InputError :message="errors.stock" />
                            </div>
                            <div class="grid gap-2">
                                <div class="flex items-center justify-between">
                                    <Label for="price">Price</Label>
                                </div>
                                <Input id="price" type="number" v-model="prodotto_edit.price" name="price" required
                                    :tabindex="6" step="0.01" />
                                <InputError :message="errors.price" />
                            </div>


                            <Button type="submit" class="mt-4 w-full" :tabindex="7" :disabled="processing"
                                data-test="save-button">
                                <Spinner v-if="processing" />
                                Save
                            </Button>

                        </div>


                    </Form>
                    <br />

                </div>
            </div>

            <div v-else>Il prodotto selezionato non esiste</div>

            <Button class="ml-auto mr-0" v-on:click="modificaProdotto()">Modifica Prodotto</Button>
            <Button v-if="editabile" class="ml-auto mr-0" v-on:click="resetProdotto()">resetta Prodotto</Button>

        </div>

    </AppLayout>
</template>
