<template>
    <el-pagination
        class="el-pagination-custom"
        @current-change="onPageChanged"
        v-model:currentPage="modelValue"
        background
        layout="prev, pager, next"
        :page-size="pageSize"
        :total="total"
        :pager-count="5"
    >
    </el-pagination>
</template>

<script>
export default {
    name: "PaginationCustom",
    emits: ['current-change'],
    props: {
        total: {
            required: true,
        },
        modelValue: {
            required: true,
        },
        pageSize: {
            required: true,
        },
    },
    setup(props, context) {
        const onPageChanged = (val) => {
            context.emit("current-change", val);
        };

        return {
            onPageChanged,
        };
    },
};
</script>

<style>
.el-pagination-custom,
.el-pagination-custom .el-pager {
    display: flex;
    justify-content: center;
}
.el-pagination-custom button > i {
    display: flex !important;
    justify-content: center !important;
}
.el-pagination-custom button,
.el-pagination-custom .more {
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent !important;
    border: 2px solid #cccccc !important;
    width: 40px;
    height: 40px;
}

.el-pagination-custom li:hover {
    color: #a5c242 !important;
}

.el-pagination-custom li {
    background: transparent !important;
    border: 2px solid #cccccc !important;
    display: flex;
    justify-content: center;
    align-items: center;
    color: black;
    width: 40px;
    height: 40px;
}

.el-pagination-custom li.active {
    border-color: #a5c242 !important;
    color: #a5c242 !important;
}

@media (max-width: 640px) {
    .el-pagination-custom .more,
    .el-pagination-custom button,
    .el-pagination-custom li {
        width: 30px;
        height: 30px;
    }
    .custom-paginate-box {
        display: block;
    }
    .page-size{
        text-align: center;
    }
}
@media (max-width: 320px) {
    .el-pagination-custom {
        overflow-x: auto;
    }
}
</style>
