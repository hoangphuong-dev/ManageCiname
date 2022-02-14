<template>
  <app-layout>
    <div class="py-12">
      <div class="mx-auto messenger-window__custom">
        <div class="bg-white overflow-hidden shadow-xl">
          <form-contact />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import FormContact from "../../Components/Contacts/FormContact.vue";
export default {
  name: "CreateJob",
  components: { FormContact, AppLayout },
};
</script>

<style></style>
