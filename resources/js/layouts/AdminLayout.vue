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
                variant="flat"
            ></v-avatar>
        </v-app-bar>

        <v-footer app color="grey" height="30"></v-footer>

        <v-navigation-drawer floating v-model="drawer" class="bg-primary">
            <v-toolbar color="primary">
                <v-list-item
                    prepend-avatar="https://cdn.vuetifyjs.com/images/lists/1.jpg"
                    title="Nombre usuario"
                    subtitle="Administrador"
                />
            </v-toolbar>

            <v-list nav theme="dark">
                <v-list-subheader>MENU</v-list-subheader>
                <v-list-item
                    v-for="item in items"
                    :key="item.title"
                    link
                    @click="item.action"
                >
                    <template v-slot:prepend>
                        <v-icon>{{ item.icon }}</v-icon>
                    </template>

                    <v-list-item-title>
                        {{ item.title }}
                    </v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-main>
            <slot />
        </v-main>
    </v-app>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import { useDisplay } from "vuetify";

const { mobile } = useDisplay();
const drawer = ref(false);

onMounted(() => {
    drawer.value = !mobile.value;
    console.log(mobile.value); // false
});

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
        title: "Gestión General ",
        icon: "mdi-account-group",
        action: () => router.get("/a/circuit"),
    },
];
</script>
