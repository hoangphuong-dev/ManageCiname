<template>
    <h3 class="page-size">
        全 {{ totalPage }} 件 ({{
            (currentPage - 1) * perPage + 1
        }}～{{
            currentPage * perPage < totalPage
                ? currentPage * perPage
                : totalPage
        }}件を表示)
    </h3>
</template>

<script>
export default {
    name: "PaginateSearch",
    props: {
        totalPage: {
            required: true,
        },
        currentPage: {
            required: true,
        },
        perPage: {
            required: true,
        }
    }
};
</script>
