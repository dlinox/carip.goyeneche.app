<template>
    <SimpleForm
        :formularioJson="formStructure"
        v-model="form"
        @onCancel="$emit('onCancel')"
        @onSumbit="submit"
    >
        <template #field.img_path>
            <v-card variant="tonal">
                <CropCompressImage
                    :aspect-ratio="16 / 9"
                    @onCropper="
                        (previewImg = $event.blob), (form.img_path = $event.file)
                    "
                />

                <v-img
                    v-if="previewImg"
                    class="mx-auto"
                    :width="300"
                    aspect-ratio="16/9"
                    cover
                    :src="previewImg"
                ></v-img>

                <v-img
                    v-if="form.photoUrl && !previewImg"
                    class="mx-auto"
                    :width="300"
                    aspect-ratio="16/9"
                    cover
                    :src="form.photoUrl"
                ></v-img>
            </v-card>
        </template>
    </SimpleForm>
</template>

<script setup>
import { ref } from "vue";
import SimpleForm from "@/components/SimpleForm.vue";
import { useForm } from "@inertiajs/vue3";
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



const form = useForm({ ...props.formData });

const submit = async () => {

    if (props.edit) {
        form.put(props.url, option);
        return;
    }

    
    form.post(props.url, option);
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
