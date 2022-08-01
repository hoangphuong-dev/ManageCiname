<template>
    <div class="mr-2">
        <div class="text-sm text-blackPrimary-300">Ngày đăng ký</div>
        <el-date-picker
            @change="onFilter"
            v-model="modelSelect"
            type="daterange"
            :clearable="false"
            start-placeholder="Ngày bắt đầu"
            end-placeholder="Ngày kết thúc"
            size="large"
        />
    </div>
</template>

<script>
export default {
    name: "SelectFilter",
    props: {
        title: { type: String, required: true },
        type: { type: String, required: true },
        modelSelect: { type: Array, required: true },
    },
    emits: ["onchangeFilter"],

    methods: {
        onFilter() {
            this.$emit("onchangeFilter", this.modelSelect, this.type);
        },
    },
};
</script>
