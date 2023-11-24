<template>
    <!-- <v-row>
        <v-col cols="12">
            <v-text-field v-model="dniSearch" label="Buscar"></v-text-field>
            <v-btn @click="dniSearchFuntion"> Buscar </v-btn>
        </v-col>
    </v-row> -->

    <SimpleForm
        :formularioJson="edit ? formStructureEdit : formStructure"
        v-model="form"
        @onCancel="$emit('onCancel')"
        @onSumbit="submit"
    >
</SimpleForm>
</template>

<script setup>
import SimpleForm from "@/components/SimpleForm.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";
const emit = defineEmits(["onCancel", "onSubmit"]);

const props = defineProps({
    planta: [String, Number],
    formData: {
        type: Object,
        default: {
            name: "",
            fatherLastName: "",
            motherLastName: "",
            documentNumber: "",
            phoneNumber: "",
            email: "",
            password: "",
            role: "",
        },
    },
    edit: {
        type: Boolean,
        default: false,
    },
    url: String,
});

const dniSearch = ref(null);

const dniSearchFuntion = async () => {
    let res = await axios.get(`/api/dni/${dniSearch.value}`);
    console.log(res.data);

    form.name = res.data.nombres;
    form.fatherLastName = res.data.apellidoPaterno;
    form.motherLastName = res.data.apellidoMaterno;
    form.documentNumber = res.data.numeroDocumento;
};

const form = useForm({ ...props.formData });

const formStructure = [
    {
        key: "documentNumber",
        label: "DNI",
        type: "text",
        required: true,
        cols: 12,
        colMd: 4,
    },
    {
        key: "name",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        colMd: 8,
    },
    {
        key: "fatherLastName",
        label: "Apellido Paterno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "motherLastName",
        label: "Apellido Materno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "email",
        label: "Correo",
        type: "email",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "password",
        label: "Contraseña",
        type: "password",
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "phoneNumber",
        label: "Teléfono",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "role",
        label: "Rol",
        options: ["Administrador", "Operador"],
        type: "select",
        required: true,
        cols: 12,
        colMd: 6,
    },
];

const formStructureEdit = [
    {
        key: "documentNumber",
        label: "DNI",
        type: "text",
        required: true,
        cols: 12,
        colMd: 4,
    },
    {
        key: "name",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        colMd: 8,
    },
    {
        key: "fatherLastName",
        label: "Apellido Paterno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "motherLastName",
        label: "Apellido Materno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "email",
        label: "Correo",
        type: "email",
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "phoneNumber",
        label: "Teléfono",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "role",
        label: "Rol",
        options: ["Administrador", "Operador"],
        type: "select",
        required: true,
        cols: 12,
        colMd: 6,
    },
];

const submit = async () => {
    form.prov_plan_id = props.planta;
    if (props.edit) form.put(props.url, option);
    else form.post(props.url, option);
};

const option = {
    onSuccess: (page) => {
        console.log("onSuccess");
        emit("onCancel");
    },
    onError: (errors) => {
        console.log("onError");
    },
    onFinish: (visit) => {
        console.log("onFinish");
    },
};
</script>
