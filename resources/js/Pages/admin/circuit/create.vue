<template>
    <SimpleForm
        :formularioJson="formStructure"
        v-model="form"
        @onCancel="$emit('onCancel')"
        @onSumbit="submit"
    >
        <template #field.guideFile>
            <v-card variant="tonal">
                <CropCompressImage
                    :aspect-ratio="16 / 9"
                    @onCropper="
                        (previewImg1 = $event.blob), (form.guideFile = $event.file)
                    "
                />

                <v-img
                    v-if="previewImg1"
                    class="mx-auto"
                    :width="300"
                    aspect-ratio="16/9"
                    cover
                    :src="previewImg1"
                ></v-img>

                <v-img
                    v-if="form.guideFilePath && !previewImg1"
                    class="mx-auto"
                    :width="300"
                    aspect-ratio="16/9"
                    cover
                    :src="form.guideFilePath"
                ></v-img>
            </v-card>
        </template>



        <template #field.resolutionFile>
            <v-card variant="tonal">
                <CropCompressImage
                    :aspect-ratio="16 / 9"
                    @onCropper="
                        (previewImg2 = $event.blob), (form.resolutionFile = $event.file)
                    "
                />

                <v-img
                    v-if="previewImg2"
                    class="mx-auto"
                    :width="300"
                    aspect-ratio="16/9"
                    cover
                    :src="previewImg2"
                ></v-img>

                <v-img
                    v-if="form.resolutionFilePath && !previewImg2"
                    class="mx-auto"
                    :width="300"
                    aspect-ratio="16/9"
                    cover
                    :src="form.resolutionFilePath"
                ></v-img>
            </v-card>
        </template>
    </SimpleForm>
</template>

<script setup>
import { ref } from "vue";
import SimpleForm from "@/components/SimpleForm.vue";
import { useForm } from "@inertiajs/vue3";
import { useObjectUrl } from "@vueuse/core";
import CropCompressImage from "@/components/CropCompressImage.vue";
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


const previewImg1 = ref(null);
const previewImg2 = ref(null);



const form = useForm({ ...props.formData ,
        guideFilePath: props.formData.guideFile ? '/storage/' + props.formData.guideFile : null,
        resolutionFilePath: props.formData.resolutionFile ? '/storage/' + props.formData.resolutionFile : null,
        guideFile: null,
        resolutionFile: null,
});

const submit = async () => {
    form.transform((data) => ({
        ...data,
        // guideFile: data.guideFile ? data.guideFile[0] : null,
        // resolutionFile: data.resolutionFile ? data.resolutionFile[0] : null,
    })).post(props.url, option);
};

const fileListDocs = ref([]);
const fileListResolution = ref([]);

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

const handleFileChangeResolution = (event) => {
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
    fileListResolution.value = _fileList;
};

const cancelUploadGuide = () => {
    fileListDocs.value = [];
    form.guideFile = null;
};

const cancelUploadResolution = () => {
    fileListResolution.value = [];
    form.resolutionFile = null;
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
