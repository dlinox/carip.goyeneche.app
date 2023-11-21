<template>
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
                            <v-col cols="6">
                                <BtnDialog title="Nuevo" width="700px">
                                    <template v-slot:activator="{ dialog }">
                                        <v-btn
                                            @click="dialog"
                                            prepend-icon="mdi-plus"
                                            variant="flat"
                                        >
                                            Doctor
                                        </v-btn>
                                    </template>
                                    <template v-slot:content="{ dialog }">
                                        <create
                                            @on-cancel="dialog"
                                            :formStructure="formStructureDoctor"
                                            :url="url"
                                        />
                                    </template>
                                </BtnDialog>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="filter.search"
                                    label="Buscar"
                                />
                            </v-col>
                        </v-row>
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
                                    :url="url + '/' + item[`${primaryKey}`]"
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
                                            url + '/' + item[`${primaryKey}`]
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
</template>
<script setup>
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
const url = "/a/workers";

const specialties = [
    {
        id: 1,
        name: "Cardiología",
        description: "Especialización en el corazón y los vasos sanguíneos.",
    },
    {
        id: 2,
        name: "Ortopedia",
        description:
            "Tratamiento de deformidades o discapacidades funcionales del sistema esquelético.",
    },
    {
        id: 3,
        name: "Dermatología",
        description: "Enfermedades de la piel, cabello y uñas.",
    },
    {
        id: 4,
        name: "Neurología",
        description: "Estudio del sistema nervioso.",
    },
    {
        id: 5,
        name: "Ginecología",
        description: "Salud reproductiva femenina.",
    },
];

const formStructureDoctor = [
    {
        key: "documentNumber",
        label: "DNI",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },
    {
        key: "cmp",
        label: "Nro. de Colegiatura",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },
    {
        key: "name",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "fatherLastName",
        label: "Apellido Paterno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },
    {
        key: "motherLastName",
        label: "Apellido Materno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },
    {
        key: "specialty",
        label: "Especialidad",
        type: "combobox",
        itemTitle: "name",
        itemValue: "id",
        options: specialties,
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "description",
        label: "Descripción",
        type: "textarea",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "photo",
        label: "Foto",
        type: "file",
        required: true,
        cols: 12,
        default: null,
    },
];
</script>
