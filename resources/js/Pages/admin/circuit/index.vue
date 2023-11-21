<template>
    <AdminLayout>
        <HeadingPage
            title="Documento Guía"
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
                    <DataTable :headers="headers" :items="items" :url="url">
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

                        <template v-slot:item.guide_name="{ item }">
                            <a
                                :href="item.guideFilePath"
                                target="_blank"
                                class="text-black text-decoration-none"
                            >
                                <v-icon
                                    size="x-small"
                                    color="red"
                                    icon="mdi-file-pdf-box"
                                />
                                {{ item.guide_name }}
                            </a>
                        </template>

                        <template v-slot:item.resolution_name="{ item }">
                            <a
                                :href="item.resolutionFilePath"
                                target="_blank"
                                class="text-black text-decoration-none"
                            >
                                <v-icon
                                    size="x-small"
                                    color="red"
                                    icon="mdi-file-pdf-box"
                                />
                                {{ item.resolution_name }}
                            </a>
                        </template>

                        <template v-slot:item.is_active="{ item }">
                            <v-chip
                                color="success"
                                text-color="white"
                                v-if="item.is_active"
                            >
                                Activo
                            </v-chip>
                            <v-chip color="error" text-color="white" v-else>
                                Inactivo
                            </v-chip>
                        </template>
                    </DataTable>
                </v-card-item>
            </v-card>
        </v-container>

    </AdminLayout>
</template>
<script setup>
import { ref } from "vue";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import { useForm } from "@inertiajs/vue3";
import BtnDialog from "../../../components/BtnDialog.vue";
import create from "./create.vue";
import DataTable from "@/components/DataTable.vue";

const props = defineProps({
    items: Object,
    headers: Array,
    filters: Object,
});

const form = useForm({
    name: "",
    description: "",
});

const formStructure = [
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
const url = "/a/circuit";

const submit = async () => {
    form.post("/a/institutional", {
        onSuccess: () => {
            console.log("success");
        },
        onError: () => {
            console.log("error");
        },
        onFinish: () => {
            console.log("finish");
        },
    });
};
</script>
