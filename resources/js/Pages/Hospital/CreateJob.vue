<template>
  <app-layout>
    <job-form></job-form>
  </app-layout>
</template>

<script>
import JobForm from '../../Components/Job/JobForm.vue'
import AppLayout from '../../Layouts/AppLayout.vue'
export default {
  name: 'CreateJob',
  components: { JobForm, AppLayout },
}
</script>

<style></style>
