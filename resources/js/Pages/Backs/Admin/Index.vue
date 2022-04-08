<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">màn của thống kê toàn thành phố</h2>

        <div>
          <Chart :data="data" :margin="margin" :direction="direction">
            <template #layers>
              <Grid strokeDasharray="2,2" />
              <Bar :dataKeys="['name', 'pl']" :barStyle="{ fill: '#90e0ef' }" />
              <Bar
                :dataKeys="['name', 'avg']"
                :barStyle="{ fill: '#0096c7' }"
              />
              <Line :dataKeys="['name', 'avg']" type="step" />
            </template>
          </Chart>
        </div>
      </div>
    </template>
  </admin-layout>
</template>


<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import { defineComponent } from "vue";
import { Chart, Grid, Bar, Line } from "vue3-charts";
import { ref } from "vue";

export default defineComponent({
  name: "HomeStaff",
  components: { Chart, Grid, Bar, Line, AdminLayout },
  setup() {
    const data = [];

    const direction = ref("horizontal");
    const margin = ref({
      left: 0,
      top: 20,
      right: 20,
      bottom: 0,
    });

    return { data, margin, direction };
  },
});
</script>
