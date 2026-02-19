<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';

import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { login } from '@/routes';
import { store } from '@/routes/register';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User',
        href: "/admin/user"
    }, {
        title: 'Crea',
        href: "/admin/user/create"
    },
];

</script>
<template>

    <Head title="Crea Prodotto" />


    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="size-50 flex align-middle">
        <Form method="POST"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        name="name"
                        placeholder="Full name"
                    />
                    <InputError :message="errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="surname">Surname</Label>
                    <Input
                        id="surname"
                        type="text"
                        required
                        autofocus
                        :tabindex="2"
                        autocomplete="surname"
                        name="surname"
                        placeholder="Full surname"
                    />
                    <InputError :message="errors.surname" />
                </div>
                <div class="grid gap-2">
                    <Label for="cf">CF</Label>
                    <Input
                        id="cf"
                        type="text"
                        required
                        autofocus
                        :tabindex="3"
                        autocomplete="cf"
                        name="cf"
                        placeholder="fiscal code"
                    />
                    <InputError :message="errors.cf" />
                </div>
                <div class="grid gap-2">
                    <Label for="tel">Phone</Label>
                    <Input
                        id="tel"
                        type="text"
                        required
                        autofocus
                        :tabindex="4"
                        autocomplete="tel"
                        name="tel"
                        placeholder="Phone number"
                    />
                    <InputError :message="errors.tel" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        :tabindex="5"
                        autocomplete="email"
                        name="email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="6"
                        autocomplete="new-password"
                        name="password"
                        placeholder="Password"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="7"
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="Confirm password"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <div class="grid gap-2">
                    <Label for="admin">Admin?</Label>
                    <Checkbox
                        id="admin"


                        name="admin"

                    />
                    <InputError :message="errors.admin " />
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full"
                    tabindex="5"
                    :disabled="processing"
                    data-test="register-user-button"
                >
                    <Spinner v-if="processing" />
                    Create User
                </Button>
            </div>

        </Form>
        </div>
    </AppLayout>
</template>
