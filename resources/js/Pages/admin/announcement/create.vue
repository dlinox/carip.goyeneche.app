<template>
    <SimpleForm
        :formularioJson="formStructure"
        v-model="form"
        @onCancel="$emit('onCancel')"
        @onSumbit="submit"
    >
        <template #field.document>
            <v-list-item class="py-0">
                <v-file-input
                    @change="handleFileChangeDoc"
                    v-model="form.document"
                    show-size
                    single
                    :clearable="false"
                    label="Seleccione el documento"
                    accept="application/pdf"
                    class="mb-1 mt-2"
                >
                    <template v-if="form.document" #append>
                        <v-btn
                            variant="tonal"
                            rounded="lg"
                            icon="mdi-close"
                            size="small"
                            @click="cancelUploadGuide"
                        />
                    </template>
                </v-file-input>
            </v-list-item>

            <v-card variant="tonal">
                <v-list-item
                    v-for="(file, fileIndex) in fileListDocs"
                    :key="file.name"
                >
                    <template v-slot:prepend>
                        <a :href="file.url" target="_blank" class="me-3">
                            <v-icon color="red" icon="mdi-file-pdf-box">
                            </v-icon>
                        </a>
                    </template>

                    <v-list-item-title>
                        <small> {{ file.name }} </small>
                    </v-list-item-title>
                    <v-list-item-subtitle>
                        {{ file.size }} bytes
                    </v-list-item-subtitle>

                    <v-list-item-subtitle class="text-red">
                        <small>
                            {{ form.errors.document }}
                        </small>
                    </v-list-item-subtitle>
                </v-list-item>
            </v-card>

        </template>

      
    </SimpleForm>

</template>

<script setup>
import { ref } from "vue";
import SimpleForm from "@/components/SimpleForm.vue";
import { useForm } from "@inertiajs/vue3";
import { useObjectUrl } from "@vueuse/core";
const emit = defineEmits(["onCancel", "onSubmit"]);

const props = defineProps({
    formData: {
        type: Object,
        default: (props) =>
            props.formStructure?.reduce((acc, item) => {
                acc[item.key] = item.default;

                return acc;
            }, {}),
    },
    formStructure: {
        type: Array,
    },
    edit: {
        type: Boolean,
        default: false,
    },
    url: String,
});

const form = useForm({ ...props.formData, document: null });

const submit = async () => {
    form.transform((data) => ({
        ...data,
        document: data.document ? data.document[0] : null,
    })).post(props.url, option);
};

const fileListDocs = ref([]);

const handleFileChangeDoc = (event) => {
    const files = event.target.files; // Obtén los archivos seleccionados
    const _fileList = []; // Array para almacenar los objetos de archivo

    // Recorre los archivos y crea un objeto para cada uno
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const fileObject = {
            url: useObjectUrl(file),
            name: file.name,
            size: file.size,
            type: file.type,
        };

        _fileList.push(fileObject); // Agrega el objeto de archivo al array
    }

    // Asigna el array fileList a una propiedad en el data del componente
    fileListDocs.value = _fileList;
};

const cancelUploadGuide = () => {
    fileListDocs.value = [];
    form.document = null;
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
