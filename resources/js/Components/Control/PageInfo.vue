<template>
  <h3 class="page-size mt-2">
    Tổng {{ totalPage }} ({{ (currentPage - 1) * perPage + 1 }}～{{
      currentPage * perPage < totalPage ? currentPage * perPage : totalPage
    }})
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
    },
  },
};
</script>
