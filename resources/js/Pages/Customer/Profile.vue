<template>
  <app-layout>
    <div class="bg-white min-h-full m-4 mb-0 p-4">
      <h2 class="mb-5">Tài khoản của tôi</h2>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import ViewBill from "@/Components/ViewBill.vue";

export default {
  components: { AppLayout, ViewBill },
  props: {},

  data: function () {
    return {
      loading: false,
    };
  },
  methods: {},
};
</script>
