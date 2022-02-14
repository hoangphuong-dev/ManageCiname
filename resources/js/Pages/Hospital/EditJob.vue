<template>
  <app-layout>
    <job-form :job="job"></job-form>
  </app-layout>
</template>

<script>
import JobForm from '../../Components/Job/JobForm.vue'
import AppLayout from '../../Layouts/AppLayout.vue'
export default {
  name: 'EditJob',
  props: {
    job: Object,
  },
  components: { JobForm, AppLayout },
}
</script>

<style></style>
