<template>
  <div class="flex items-center">
    <el-input
      class="h-10"
      v-model="name"
      clearable
      @input="filter.name = name"
      @keyup.enter="submit"
      :placeholder="label"
      @change="onChange"
    >
    </el-input>
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
      default: "",
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
