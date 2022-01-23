<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">màn của superadmin</h2>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
export default {
  name: "HomeStaff",
  components: {
    AdminLayout,
  },
  data() {
    return {};
  },
  methods: {},
};
</script>
