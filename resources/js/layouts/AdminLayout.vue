<template>
    <v-app id="inspire">
        <v-app-bar class="" color="grey-lighten-4" elevation="1">
            <v-btn class="me-2" icon="mdi-menu" @click="drawer = !drawer">
            </v-btn>

            <v-spacer></v-spacer>

            <v-avatar
                @click="signOut"
                class="me-3"
                color="surface-variant"
                size="32"
                icon="mdi-logout"
                variant="flat"
            ></v-avatar>
        </v-app-bar>

        <v-footer app color="grey" height="30"></v-footer>

        <v-navigation-drawer floating v-model="drawer" class="bg-primary">
            <v-toolbar color="primary">
                <v-list-item :title="user?.name" :subtitle="user?.role">
                    <template #prepend>
                        <v-avatar color="white">
                            {{ user?.name[0] }}
                        </v-avatar>
                    </template>
                </v-list-item>
            </v-toolbar>

            <MenuApp  :userRole="user?.role" />
        </v-navigation-drawer>

        <v-main>
            <slot />
        </v-main>

        <v-snackbar v-model="snackbar" multi-line color="success" vertical>
            {{ flash.success }}

            <template v-slot:actions>
                <v-btn
                    color="dark"
                    variant="text"
                    @click="snackbar = false"
                    icon="mdi-close"
                ></v-btn>
            </template>
        </v-snackbar>

        <v-snackbar v-model="snackbarError" vertical multi-line color="error">
            <v-expansion-panels>
                <v-expansion-panel
                    elevation="0"
                    class="bg-transparent w-100"
                    :text="error.details"
                >
                    <v-expansion-panel-title
                        expand-icon="mdi-plus"
                        collapse-icon="mdi-minus"
                    >
                        {{ error.error }}
                    </v-expansion-panel-title>
                </v-expansion-panel>
            </v-expansion-panels>

            <template v-slot:actions>
                <v-btn
                    class="px-3"
                    color="white"
                    variant="tonal"
                    @click="snackbarError = false"
                    prepend-icon="mdi-close"
                >
                    Cerrar
                </v-btn>
            </template>
        </v-snackbar>
    </v-app>
</template>

<script setup>
import { ref, onMounted, computed, watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { useDisplay } from "vuetify";
import MenuApp from "../components/MenuApp.vue";

const { mobile } = useDisplay();
const drawer = ref(false);

onMounted(() => {
    drawer.value = !mobile.value;
    console.log(mobile.value); // false
});

const user = computed(() => usePage().props?.user);

const flash = computed(() => usePage().props?.flash);
const error = computed(() => usePage().props?.errors);


const snackbar = ref(false);
const snackbarError = ref(false);

watch(
    () => flash.value,
    (newValue) => {
        if (newValue && newValue.success) {
            snackbar.value = true;
        } else {
            snackbar.value = false;
        }
    }
);

watch(
    () => error.value,
    (newValue) => {
        if (newValue.details && newValue.error) {
            snackbarError.value = true;
        } else {
            snackbarError.value = false;
        }
    }
);

const signOut = async () => {
    router.post("/auth/sign-out");
};

const items = [
    {
        title: "Dashboard",
        icon: "mdi-view-dashboard",
        action: () => router.get("/a"),
    },
    {
        title: "Gestión de usuarios",
        icon: "mdi-account-group",
        action: () => router.get("/a/users"),
    },

    {
        title: "Gestión de personal",
        icon: "mdi-account-group",
        action: () => router.get("/a/workers"),
    },

    {
        title: "Gestión Institucional ",
        icon: "mdi-account-group",
        action: () => router.get("/a/institutional"),
    },
    {
        title: "Objetivos de la institución",
        icon: "mdi-account-group",
        action: () => router.get("/a/objetives"),
    },

    {
        title: "Gestión General ",
        icon: "mdi-account-group",
        action: () => router.get("/a/circuit"),
    },

    {
        title: "Portafolio de Servicios",
        icon: "mdi-account-group",
        action: () => router.get("/a/servicePortfolio"),
    },
    {
        title: "Servicios de apoyo",
        icon: "mdi-account-group",
        action: () => router.get("/a/supporting-services"),
    },
    {
        title: "Gestión de oficinas",
        icon: "mdi-account-group",
        action: () => router.get("/a/offices"),
    },
    {
        title: "Servicios finales",
        icon: "mdi-account-group",
        action: () => router.get("/a/final-services"),
    }
];
</script>
