<template>
  <app-layout>
    <div class="pb-12 pt-6">
      <div class="mx-auto">
        <div class="w-full shadow-lg p-4">
          Success Tai ve PDF :

          <el-button size="small" @click="downloadPDF(bill_id)" type="danger">
            PDF
          </el-button>
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
    bill_id: Number,
  },

  data() {
    return {};
  },
  methods: {
    downloadPDF(id) {
      window.location.href = route("download_bill_pdf", id);
    },
  },
};
</script>
