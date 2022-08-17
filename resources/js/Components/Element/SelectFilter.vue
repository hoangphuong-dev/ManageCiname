<template>
    <div class="mr-2">
        <div class="text-sm text-blackPrimary-300">{{ title }}</div>
        <el-select
            filterable
            v-model="modelSelect"
            @change="onFilter"
            clearable
        >
            <el-option
                v-for="item in listOption"
                :key="item.id"
                :label="item.name"
                :value="item.id"
            ></el-option>
        </el-select>
    </div>
</template>

<script>
export default {
    name: "SelectFilter",
    props: {
        type: {
            type: String,
        },
        modelSelect: {
            type: Number,
        },
        listOption: {
            type: Object,
        },
    },
    emits: ["onchangeFilter"],
    data() {
        return {
            title: "",
        };
    },

    created() {
        this.mapType();
    },

    methods: {
        onFilter() {
            this.$emit("onchangeFilter", this.modelSelect, this.type);
        },

        mapType() {
            switch (this.type) {
                case "display":
                    this.title = "Loại trang";
                    break;

                case "movie_genre":
                    this.title = " Thể loại phim";
                    break;

                case "status":
                    this.title = "Trạng thái";
                    break;

                case "type_of_work":
                    this.title = "Loại công việc";
                    break;

                case "voucher":
                    this.title = "Voucher";
                    break;

                case "province":
                    this.title = "Chọn thành phố";
                    break;

                default:
                    this.title = "Undefine";
                    break;
            }
        },
    },
};
</script>
