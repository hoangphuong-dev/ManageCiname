<template>
    <div class="min-h-164 group relative w-full h-full cursor-pointer border-solid border flex justify-center items-center border-lightGreen" @click="handleClick">
        <div v-if="!(isPreview && imgSrc !== null)" >
            <img class="mx-auto" src="/images/svg/plus.svg" alt="">
            <p class="txt-upload">アップロード</p>
        </div>
        <div class="absolute top-0 left-0 w-full h-full" v-else>
            <img class="w-full h-full" :src="imgSrc" alt="">
        </div>
        <img v-if="isPreview && imgSrc !== null" src="/images/svg/delete.svg" class="hidden group-hover:block absolute p-2.5 h-10 w-10 top-2 right-2 bg-white rounded cursor-pointer" @click="removeImage">
        <input @change="onFileChange" type="file" class="hidden" :ref="setRef" :id="id" accept="image/*">
    </div>
</template>

<script>
import {v4 as uuidV4} from 'uuid';
import { ref } from 'vue';

export default {
    name: "ImageUpload",
    props: {
        isPreview: {
            type: Boolean,
            default: true
        },
        modelValue: {
            type: File
        }
    },
    setup(props, context) {
        const id = uuidV4();

        const refInput = ref(null);
        const setRef = el => refInput.value = el;

        const allowShow = ref(true);

        const handleClick = _ => {
            allowShow.value && refInput.value.click();
        }

        const imgSrc = ref(null);

        const emit = file => {
            context.emit("update:modelValue", file);

            context.emit("onChange", file);
        }

        const onFileChange = e => {
            const file = (e.target.files || e.dataTransfer.files)[0];

            props.isPreview && (imgSrc.value = URL.createObjectURL(file));

            emit(file);

            e.target.value = null;
        }

        const removeImage = e => {
            allowShow.value = false;
            setTimeout(() => allowShow.value = true, 100);
            emit(null);
            imgSrc.value = null;
        }

        return {
            id,
            imgSrc,
            handleClick,
            setRef,
            onFileChange,
            removeImage
        }
    }
}
</script>

<style scoped>
.txt-upload {
    color: #a5c242;
    font-size: 12px;
    margin-top: 6px;
}
.min-h-164 {
    min-height: 164px;
}
</style>
