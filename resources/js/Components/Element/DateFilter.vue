<template>
    <div class="mr-2">
        <div class="text-sm text-blackPrimary-300">{{ title }}</div>
        <el-date-picker
            @change="onFilter"
            v-model="modelSelect"
            :type="typeDate"
            clearable
            start-placeholder="Ngày bắt đầu"
            end-placeholder="Ngày kết thúc"
            size="large"
            value-format="YYYY-MM-DD"
            :disabled-date="disabledDate"
        />
    </div>
</template>

<script>
export default {
    name: "SelectFilter",
    props: {
        typeDate: { type: String, required: true },
        title: { type: String, required: true },
        type: { type: String, required: true },
        modelSelect: { required: true },
    },
    emits: ["onchangeFilter"],

    methods: {
        onFilter() {
            this.$emit("onchangeFilter", this.modelSelect, this.type);
        },

        disabledDate(time) {
            let d = new Date();
            return time.getTime() > d.setDate(d.getDate() - 1);
        },
    },
};
</script>
