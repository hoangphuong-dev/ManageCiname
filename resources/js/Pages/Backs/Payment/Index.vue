<template>
  <admin-layout v-loading="loading">
    <template #main>
      <h1>Developing</h1>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
export default {
  name: 'Admin',
  components: { AdminLayout },
  data() {
    return {
      loading: false,
    }
  },
  methods: {
    //
  },
}
</script>
