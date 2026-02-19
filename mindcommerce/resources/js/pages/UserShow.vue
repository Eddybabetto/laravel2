<script setup lang="ts">
import { App, Head, router } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

import Button from '@/components/ui/button/Button.vue';
import { ref } from 'vue'

import InputError from '@/components/InputError.vue';


import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';

import { Form } from '@inertiajs/vue3';

const props = defineProps({ user: Object })

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Utenti',
        href: "/admin/user"
    },
];

let user_edit = ref(Object.assign({}, props.user))
user_edit.value.admin = !!user_edit.value.admin
let editabile = ref(false);
function modificaProdotto() {
    editabile.value = !editabile.value
}

function resetUtente() {
    user_edit.value = Object.assign({}, props.user)
    user_edit.value.admin = !!user_edit.value.admin
}
function eliminaUtente() {
    router.delete("/admin/user/" + props?.user?.id)
}
</script>

<template>

    <Head title="Utenti" />


    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">


            <dl v-if="user && !editabile" class="max-w-md text-heading divide-y divide-default">
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
                    <dd class="text-lg font-medium">{{ user.surname }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Cf</dt>
                    <dd class="text-lg font-medium">{{ user.cf }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Telephone</dt>
                    <dd class="text-lg font-medium">{{ user.tel }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-body">Admin</dt>
                    <dd v-if="user.admin" class="text-lg font-medium"> E' UN ADMIN </dd>
                    <dd v-else class="text-lg font-medium"> NON E' UN ADMIN </dd>
                </div>
            </dl>

            <div v-else-if="user && editabile">
                <div class="size-50 flex align-middle">

                    <Form method="put" :reset-on-success="['password', 'password_confirmation']"
                        v-slot="{ errors, processing }" class="flex flex-col gap-6">
                        <div class="grid gap-6">
                            <div class="grid gap-2">
                                <Label for="name">Name</Label>
                                <Input v-model="user_edit.name" id="name" type="text" required autofocus :tabindex="1"
                                    autocomplete="name" name="name" placeholder="Full name" />
                                <InputError :message="errors.name" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="surname">Surname</Label>
                                <Input id="surname" v-model="user_edit.surname" type="text" required autofocus
                                    :tabindex="2" autocomplete="surname" name="surname" placeholder="Full surname" />
                                <InputError :message="errors.surname" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="cf">CF</Label>
                                <Input id="cf" v-model="user_edit.CF" type="text" required autofocus :tabindex="3"
                                    autocomplete="cf" name="cf" placeholder="fiscal code" />
                                <InputError :message="errors.cf" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="tel">Phone</Label>
                                <Input id="tel" v-model="user_edit.tel" type="text" required autofocus :tabindex="4"
                                    autocomplete="tel" name="tel" placeholder="Phone number" />
                                <InputError :message="errors.tel" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="email">Email address</Label>
                                <Input id="email" v-model="user_edit.email" type="email" required :tabindex="5"
                                    autocomplete="email" name="email" placeholder="email@example.com" />
                                <InputError :message="errors.email" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="password">Old Password</Label>
                                <Input id="old_password" type="password" required :tabindex="6"
                                    autocomplete="old_password" name="old_password" placeholder="old password" />
                                <InputError :message="errors.old_password" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="password">Password</Label>
                                <Input id="password" type="password" required :tabindex="6" autocomplete="new-password"
                                    name="password" placeholder="Password" />
                                <InputError :message="errors.password" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="password_confirmation">Confirm password</Label>
                                <Input id="password_confirmation" type="password" required :tabindex="7"
                                    autocomplete="new-password" name="password_confirmation"
                                    placeholder="Confirm password" />
                                <InputError :message="errors.password_confirmation" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="admin">Admin?</Label>
                                <Checkbox v-model="user_edit.admin" id="admin" name="admin" />
                                <InputError :message="errors.admin" />
                            </div>

                            <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="processing"
                                data-test="register-user-button">
                                <Spinner v-if="processing" />
                                Update User
                            </Button>
                        </div>

                    </Form>
                </div>

            </div>
            <Button class="ml-auto mr-0" v-on:click="modificaProdotto()">Modifica Utente</Button>
            <Button class="ml-auto mr-0 btn-danger" v-on:click="eliminaUtente()">Elimina Utente</Button>


        </div>
    </AppLayout>
</template>
