<template>
    <AdminLayout>
        <HeadingPage
            title="Portafolio de Servicios"
            subtitle="Cartera de Servicio"
            class="bg-white"
        >
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
                            @on-cancel="dialog"
                            :formStructure="formStructure"
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
                        :url="url"
                        withAction
                    >
                        <template v-slot:header="{ filter }">
                            <v-row class="py-3" justify="end">
                                <v-col cols="6">
                                    <v-text-field
                                        v-model="filter.search"
                                        label="Buscar"
                                    />
                                </v-col>
                            </v-row>
                        </template>

                        <template v-slot:item.guideName="{ item }">
                            <a
                                :href="`/storage/${item.guideFile}`"
                                target="_blank"
                                class="text-black text-decoration-none"
                            >
                                <v-icon
                                    size="x-small"
                                    color="red"
                                    icon="mdi-file-pdf-box"
                                />
                                {{ item.guideName }}
                            </a>
                        </template>

                        <template v-slot:item.resolutionName="{ item }">
                            <a
                                :href="`/storage/${item.resolutionFile}`"
                                target="_blank"
                                class="text-black text-decoration-none"
                            >
                                <v-icon
                                    size="x-small"
                                    color="red"
                                    icon="mdi-file-pdf-box"
                                />
                                {{ item.resolutionName }}
                            </a>
                        </template>

                        <template v-slot:item.isActive="{ item }">
                            <v-btn
                                :color="item.isActive ? 'blue' : 'red'"
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
                                {{ item.isActive ? "Activo" : "Inactivo" }}
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
import { useForm, router } from "@inertiajs/vue3";
import BtnDialog from "../../../components/BtnDialog.vue";
import create from "./create.vue";
import DataTable from "@/components/DataTable.vue";
import DialogConfirm from "@/components/DialogConfirm.vue";

const props = defineProps({
    items: Object,
    headers: Array,
    filters: Object,
});

const formStructure = [
    {
        key: "datePublished",
        label: "Fecha de publicacion",
        type: "date",
        required: true,
        cols: 12,
        //default fecha actual
        default: new Date().toISOString().slice(0, 10),
    },
    {
        key: "guideName",
        label: "Titulo del documento guia",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "guideFile",
        label: "Archivo Guia",
        type: "text",
        required: true,
        cols: 12,
        default: null,
    },
    {
        key: "resolutionName",
        label: "Titulo Resolucion",
        type: "text",
        required: true,
        cols: 12,
        default: null,
    },
    {
        key: "resolutionFile",
        label: "Resolucion",
        type: "text",
        required: true,
        cols: 12,
        default: null,
    },
];

const primaryKey = "id";
const url = "/a/servicePortfolio";
</script>
