<template>
    <v-app app>
        <v-form class="w-100 h-screen d-flex justify-center align-center" @submit.prevent="signInHandler">
            <v-card width="400">
                <v-card-item>
                    <v-img
                        class="mx-auto"
                        width="150"
                        src="/assets/logos/logo.png"
                    />
                </v-card-item>
                <v-card-item>
                    <v-row>
                        <v-col cols="12" class="mt-2">
                            <v-text-field v-model="form.email"  label="Correo"></v-text-field>
                        </v-col>
                        <v-col cols="12" class="mt-2">
                            <v-text-field v-model="form.password"  type="password" label="Contraseña"></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-item>
                <v-card-actions>
                    <v-btn type="submit" variant="flat" block color="primary">Login</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-app>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { router } from '@inertiajs/vue3'


const form = ref({
    email: "admin@goyeneche.com",
    password: "password",
});


const signInHandler = async () => {
    router.post('/auth/sign-in', form.value);
};
</script>
