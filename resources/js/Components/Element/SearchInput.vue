<template>
    <div class="flex items-center">
        <el-input
            class="h-10"
            v-model="name"
            @input="filter.name = name"
            @keyup.enter="submit"
            :placeholder="label"
            @change="onChange"
        ></el-input>

        <button
            class="hover-animation btn-primary bg-red-400 h-10 -ml-1 z-10"
            @click.prevent="submit"
        >
            <img src="/images/search.svg" />
        </button>
    </div>
</template>
<script>
import { Search } from "@element-plus/icons";
import { ref } from "vue";
export default {
    name: "SearchInput",
    components: { Search },
    props: {
        filter: {
            default: {},
            type: Object,
        },
        label: {
            default: "Tìm kiếm",
            type: String,
        },
        modelValue: {
            type: String,
        },
    },
    emits: ["submit", "update:modelValue"],

    setup(props, { emit }) {
        const name = ref(props?.modelValue || "");

        const submit = (e) => {
            emit("submit", e);
        };

        const onChange = (_) => {
            emit("update:modelValue", name.value);
        };
        return { name, submit, onChange };
    },
};
</script>
