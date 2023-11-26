<template>
    <AdminLayout>
        <HeadingPage title="Dashboard" />
        <v-container>
            <!-- <pre>

                {{ menu }}    
                </pre
            > -->
        </v-container>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";

const menu = [
    {
        title: "Dashboard",
        icon: "mdi-view-dashboard",
        to: "/admin",
    },
    {
        title: "Gestión de usuarios",
        icon: "mdi-account",
        to: "/admin/users",
    },
    {
        title: "Gestión institucional",
        icon: "mdi-account",
        to: "/admin/users",
        chidrens: [
            {
                title: "Hospital",
                icon: "mdi-account",
                to: "/admin/users",
            },
        ],
    },

    {
        title: "Gestión de servicios",
        icon: "mdi-account",
        to: "/admin/users",
        chidrens: [
            {
                title: "Servicios Finales",
                icon: "mdi-account",
                to: "/admin/users",
            },

            {
                title: "Servicios intermedios",
                icon: "mdi-account",
                to: "/admin/users",
            },
            {
                title: "oficinas",
                icon: "mdi-account",
                to: "/admin/users",
            },
        ],
    },
    {
        title: "Gestión de info. al usuario",
        icon: "mdi-account",
        to: "/admin/users",
        chidrens: [
            {
                title: "Catera de servicios",
                icon: "mdi-account",
                to: "/admin/users",
            },

            {
                title: "Cirucuito de atención",
                icon: "mdi-account",
                to: "/admin/users",
            },
        ],
    },
    {
        title: "Gestión de infomes y publicaciones",
        icon: "mdi-account",
        to: "/admin/users",
        chidrens: [
            {
                title: "Convocatorias",
                icon: "mdi-account",
                to: "/admin/users",
            },
            {
                title: "Compra y servicio",
                icon: "mdi-account",
                to: "/admin/users",
            },

            //AREAS
            {
                title: "Logistica",
                icon: "mdi-account",
                to: "/admin/users",
            },
            {
                title: "Personal", // 
                icon: "mdi-account",
                to: "/admin/users",
            },
            {
                title: "planeamiento",
            },
            {
                title: "Epideomiologia",
            },
            {
                title: "Gestión de calidad",
            },
            {
                title: "Estadistica",
            },
            {
                title: "S. gestion de control interno",
            },
            {
                title: "Normas y documentos",
            },
        ],
    },
    {
        title: "Gestión de noticias",
    },
    {
        title: "Gestión de campañas y eventos",
    },

    {
        title: "Gestión de personal",
        icon: "mdi-account",
        to: "/admin/users",
        chidrens: [
            {
                title: "Medicos",
                icon: "mdi-account",
                to: "/admin/users",
            },
            {
                title: "Autoridades",
                icon: "mdi-account",
                to: "/admin/users",
            },
        ],
    },

    {
        title: "Configuración",
        icon: "mdi-account",
        to: "/admin/users",
        chidrens: [
            {
                title: "Servicios de apoyo",
                icon: "mdi-account",
                to: "/admin/users",
            },
            {
                title: "Epecialidades",
                icon: "mdi-account",
                to: "/admin/users",
            },
        ],
    },
];
</script>
