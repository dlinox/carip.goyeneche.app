<template>
    <AdminLayout>
        <HeadingPage title="Sliders" subtitle="Gestion de la web">
            <template #actions>
                <BtnDialog title="Nuevo" width="700px">
                    <template v-slot:activator="{ dialog }">
                        <v-btn
                            @click="dialog"
                            prepend-icon="mdi-plus"
                            variant="flat"
                        >
                            Nuevo
                        </v-btn>
                    </template>
                    <template v-slot:content="{ dialog }">
                        <create
                            :form-structure="formStructure"
                            @on-cancel="dialog"
                            :url="url"
                        />
                    </template>
                </BtnDialog>
            </template>
        </HeadingPage>

        <v-container fluid>
            <v-card>
                <v-card-item>
                    <DataTable
                        :headers="headers"
                        :items="items"
                        with-action
                        :url="url"
                    >
                        <template v-slot:header="{ filter }">
                            <v-row class="py-3" justify="end">
                                <v-col cols="6"> </v-col>
                                <v-col cols="6">
                                    <v-text-field
                                        v-model="filter.search"
                                        label="Buscar"
                                    />
                                </v-col>
                            </v-row>
                        </template>

                        <template v-slot:item.image="{ item }">
                            <v-img
                                v-if="item.image"
                                :src="`/storage/${item.image}`"
                                width="50px"
                                height="50px"
                            />
                        </template>

                        <template v-slot:item.link="{ item }">
                            <a :href="item.link" target="_blank">
                                {{ item.link }}
                            </a>
                        </template>


                        <template v-slot:item.is_active="{ item }">
                            <v-btn
                                :color="item.is_active ? 'blue' : 'red'"
                                variant="tonal"
                            >
                                <DialogConfirm
                                    text="¿Cambiar estado del usuario?"
                                    @onConfirm="
                                        () =>
                                            router.patch(
                                                url +
                                                    '/' +
                                                    item[`${primaryKey}`] +
                                                    '/change-state'
                                            )
                                    "
                                />
                                {{ item.is_active ? "Activo" : "Inactivo" }}
                            </v-btn>
                        </template>

                        <template v-slot:action="{ item }">
                            <BtnDialog title="Editar" width="500px">
                                <template v-slot:activator="{ dialog }">
                                    <v-btn
                                        color="info"
                                        icon
                                        variant="outlined"
                                        density="comfortable"
                                        @click="dialog"
                                    >
                                        <v-icon
                                            size="x-small"
                                            icon="mdi-pencil"
                                        ></v-icon>
                                    </v-btn>
                                </template>
                                <template v-slot:content="{ dialog }">
                                    <create
                                        @on-cancel="dialog"
                                        :formStructure="formStructure"
                                        :form-data="item"
                                        :edit="true"
                                        :url="url"
                                    />
                                </template>
                            </BtnDialog>

                            <v-btn
                                icon
                                variant="outlined"
                                density="comfortable"
                                class="ml-1"
                                color="red"
                            >
                                <DialogConfirm
                                    @onConfirm="
                                        () =>
                                            router.delete(
                                                url +
                                                    '/' +
                                                    item[`${primaryKey}`]
                                            )
                                    "
                                />
                                <v-icon
                                    size="x-small"
                                    icon="mdi-delete-empty"
                                ></v-icon>
                            </v-btn>
                        </template>
                    </DataTable>
                </v-card-item>
            </v-card>
        </v-container>

    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import BtnDialog from "@/components/BtnDialog.vue";
import DialogConfirm from "@/components/DialogConfirm.vue";
import DataTable from "@/components/DataTable.vue";
import create from "./create.vue";

import { router } from "@inertiajs/core";
import { ref } from "vue";

const props = defineProps({
    items: Object,
    headers: Array,
    filters: Object,
});

const primaryKey = "id";
const url = "/a/sliders";

const formStructure = [
    {
        key: "title",
        label: "Titulo",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "subtitle",
        label: "Subtitulo",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "link",
        label: "Link mas informacion",
        type: "text",
        required: false,
        cols: 12,
        default: "",
    },
    {
        key: "image",
        label: "imagen",
        type: "file",
        required: false,
        cols: 12,
        default: null,
    },
    
];
</script>
