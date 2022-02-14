<template>
  <app-layout>
    <hospital-form :hospital="hospital" :hospitalTypes="hospitalTypes"></hospital-form>
  </app-layout>
</template>

<script>
import HospitalForm from '@/Components/Profile/HospitalForm.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
export default {
  name: 'Profile',
  components: { HospitalForm, AppLayout },
  props: {
    hospitalTypes: {
      type: Array,
      defaul: [],
    },
    hospital: Object,
  },
}
</script>

<style></style>
