<template>
  <app-layout>
    <div class="pb-12 pt-6">
      <div class="mx-auto">
        <div style="height: 35rem" class="w-full shadow-lg p-4">
          <change-password :id="id"></change-password>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import ChangePassword from "@/Components/ChangePassword.vue";

export default {
  components: { AppLayout, ChangePassword },

  props: {
    id: String,
  },

  data() {
    return {};
  },
  methods: {},
};
</script>
