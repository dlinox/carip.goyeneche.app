<template>
    <v-list v-model:opened="menuOpen" nav density="compact">
        <v-list-subheader>Menu</v-list-subheader>

        <template v-for="(menu, index) in menuMain" :key="index">
            <template v-if="menu.group == null">
                <v-list-item
                    :prepend-icon="menu.icon"
                    :title="menu.title"
                    color="info"
                    :class="
                        router.page.url == menu.to
                            ? 'v-list-item--active text-white'
                            : ''
                    "
                    @click="router.get(`${baseUrl}/${menu.to}`)"
                />
            </template>
            <template v-else>
                <v-list-group :value="menu.value">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            :prepend-icon="menu.icon"
                            :title="menu.title"
                            color="black"
                        ></v-list-item>
                    </template>
                    <template v-for="submenu in menu.group">
                        <template v-if="submenu.group == null">
                            <v-list-item
                                :title="submenu.title"
                                color="black"
                                :class="
                                    router.page.url == '/a/' + submenu.to
                                        ? 'v-list-item--active text-white'
                                        : ''
                                "
                                @click="router.get(`${baseUrl}/${submenu.to}`)"
                            >
                                <template #prepend>
                                    <v-icon class="ms-0 me-2" size="x-large"
                                        >mdi-circle-small
                                    </v-icon>
                                </template>
                            </v-list-item>
                        </template>
                        <template v-else>
                            <v-list-group :value="submenu.value">
                                <template v-slot:activator="{ props }">
                                    <v-list-item
                                        v-bind="props"
                                        :title="submenu.title"
                                        color="black"
                                    >
                                        <template #prepend>
                                            <v-icon class="mr-2" size="x-large"
                                                >mdi-circle-small
                                            </v-icon>
                                        </template>
                                    </v-list-item>
                                </template>

                                <v-list-item
                                    v-for="(subsubmenu, k) in submenu.group"
                                    :key="k"
                                    :title="subsubmenu.title"
                                    :value="subsubmenu.value"
                                    color="primary"
                                    @click="goToPage(subsubmenu.to)"
                                    :class="
                                        subsubmenu.to == router.page.url
                                            ? 'v-list-item--active text-primary'
                                            : ''
                                    "
                                >
                                    <template #prepend>
                                        <v-icon class="ms-3 me-2" size="x-large"
                                            >mdi-circle-small
                                        </v-icon>
                                    </template>
                                </v-list-item>
                            </v-list-group>
                        </template>
                    </template>
                </v-list-group>
            </template>
        </template>
    </v-list>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const baseUrl = "/a";
const menuOpen = ref([router.page.url.split("/")[2]]);

const menuMain = [
    {
        title: "Dashboard",
        value: "dashboard",
        icon: "mdi-monitor-dashboard",
        to: "",
        group: null,
    },

    {
        title: "Gestión de usuarios",
        value: "users",
        icon: "mdi-inbox-arrow-down-outline",
        to: "users",
        group: null,
    },

    {
        title: "Gestion institucional",
        value: "institutional",
        icon: "mdi-file-cabinet",
        to: "#",
        group: [
            {
                title: "Hospital",
                value: "institutional",
                icon: "mdi-inbox-arrow-down-outline",
                to: "institutional",
                group: null,
            },

            {
        title: "Getion del personal",
        value: "institutional",
        icon: "mdi-inbox-arrow-down-outline",
        to: "workers",
        group: null,
    },
        ],
    },

    {
        title: "Gestión de servicios",
        value: "services",
        icon: "mdi-inbox-arrow-down-outline",
        to: "consultas",
        group: [
            {
                title: "Servicios finales",
                value: "services",
                icon: "mdi-inbox-arrow-down-outline",
                to: "final-services",
                group: null,
            },
            {
                title: "Servicios intermedios",
                value: "services",
                icon: "mdi-inbox-arrow-down-outline",
                to: "intermediate-services",
                group: null,
            },

            {
                title: "Oficinas",
                value: "services",
                icon: "mdi-inbox-arrow-down-outline",
                to: "offices",
                group: null,
            },
        ],
    },

    {
        title: "Gestión de info. al usuario",
        value: "info",
        icon: "mdi-inbox-arrow-down-outline",
        to: "#",
        group: [
            {
                title: "Cartera de servicios",
                value: "info",
                icon: "mdi-inbox-arrow-down-outline",
                to: "servicePortfolio",
                group: null,
            },
            {
                title: "Cirucuito de atención",
                value: "info",
                icon: "mdi-inbox-arrow-down-outline",
                to: "circuit",
                group: null,
            },
        ],
    },

    {
        title: "Gestión de infomes y publicaciones",
        value: "plubli",
        icon: "mdi-inbox-arrow-down-outline",
        to: "mensajes",
        group: [
            {
                title: "Convocatorias",
                value: "plubli",
                icon: "mdi-inbox-arrow-down-outline",
                to: "announcements",
                group: null,
            },
            {
                title: "Compra y servicio",
                value: "plubli",
                icon: "mdi-inbox-arrow-down-outline",
                to: "purchase-and-service",
                group: null,
            },
        ],
    },
    {
        title: "Getion de noticias",
        value: "consultar",
        icon: "mdi-inbox-arrow-down-outline",
        to: "news",
        group: null,
    },
    {
        title: "Gestion de campañas y eventos",
        value: "consultar",
        icon: "mdi-inbox-arrow-down-outline",
        to: "events-and-campaigns",
        group: null,
    },


    {
        title: "Configuración",
        value: "configuracion",
        icon: "mdi-cog-outline",
        to: "#",
        group: [
            {
                title: "Servicios de apoyo",
                value: "consultar",
                icon: "mdi-inbox-arrow-down-outline",
                to: "supporting-services",
                group: null,
            },
            {
                title: "Epecialidades",
                value: "consultar",
                icon: "mdi-inbox-arrow-down-outline",
                to: "specialties",
                group: null,
            },

            {
                title: "Areas",
                value: "consultar",
                icon: "mdi-inbox-arrow-down-outline",
                to: "areas",
                group: null,
            },
        ],
    },
];

//const currentMenu = computed(() => router.page.url.split('/')[1] );
const goToPage = (to) => {
    console.log("to");
    router.get(`${baseUrl}/${to}`);
};
</script>

<style scoped>
.v-list-group__items .v-list-item {
    padding-inline-start: 25px !important;
}
</style>
