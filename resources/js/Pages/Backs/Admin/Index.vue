<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">Thống kê</h2>

        <div class="w-full shadow-xl p-4">
          <h3 class="text-center py-2">Doanh thu của rạp theo tháng</h3>
          <!-- lọc theo tháng  -->
          <el-form
            label-position="top"
            ref="filter"
            :model="filter"
            :rules="rules"
          >
            <div class="flex">
              <el-form-item class="mr-4" label="Từ tháng">
                <el-date-picker
                  v-model="filter.date_from"
                  type="month"
                  placeholder="Chọn tháng"
                />
              </el-form-item>

              <el-form-item label="Đến tháng">
                <el-date-picker
                  v-model="filter.date_to"
                  type="month"
                  placeholder="Chọn tháng"
                  @change="inertia()"
                />
              </el-form-item>
            </div>
          </el-form>
          <!-- end lọc theo tháng  -->
          <!-- Biểu đồ doanh thu theo tháng  -->
          <div v-if="data.length !== 0">
            <Chart
              :size="{ width: 150 * data.length, height: 600 }"
              :data="data"
              :margin="margin"
              :direction="direction"
            >
              <template #layers>
                <Grid strokeDasharray="2,2" />
                <Bar
                  :dataKeys="['month', 'revenua']"
                  :barStyle="{ fill: 'rgba(243, 244, 200)' }"
                />
              </template>
            </Chart>
          </div>
          <el-empty
            v-else
            description="Không có dữ liệu cho các tháng này"
          ></el-empty>
          <!-- Kết thúc biểu đồ doanh thu theo tháng -->
        </div>
      </div>
    </template>
  </admin-layout>
</template>


<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { defineComponent, ref } from "vue";
import { Chart, Grid, Bar, Line } from "vue3-charts";

export default defineComponent({
  name: "HomeStaff",
  components: { Chart, Grid, Bar, Line, AdminLayout },
  props: {
    data: Object,
  },

  setup() {
    const direction = ref("horizontal");
    const margin = ref({
      left: 0,
      top: 20,
      right: 20,
      bottom: 0,
    });
    return { direction, margin };
  },

  data() {
    return {
      filter: {
        date_from: "",
        date_to: "",
      },
    };
  },

  methods: {
    inertia() {
      Inertia.get(
        route(
          "admin.home_admin",
          { ...this.filter },
          {
            onError: (e) => console.log(e),
            onSuccess: (data) => {},
          }
        )
      );
    },
  },
});
</script>
