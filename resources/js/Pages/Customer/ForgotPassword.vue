<template>
  <app-layout>
    <div class="pb-12 pt-6">
      <div class="mx-auto">
        <div style="height: 29rem" class="w-full shadow-lg p-4">
          <forgot-password></forgot-password>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import ForgotPassword from "@/Components/ForgotPassword.vue";

export default {
  components: { AppLayout, ForgotPassword },

  data() {
    return {};
  },
  methods: {},
};
</script>
