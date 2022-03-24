<template>
  <app-layout>
    <div class="pb-12 pt-6">
      <div class="mx-auto">
        <div class="w-full shadow-lg p-4">
          Thong bao thang cong voi in ve o day nnhe
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";

export default {
  components: { AppLayout },
  props: {
    // showtime: Object,
  },

  data() {
    return {};
  },
  methods: {
    submit() {
      Inertia.get(route("confirm_order", { ...this.formData }), {
        onBefore,
        onFinish,
      });
    },
  },
};
</script>
