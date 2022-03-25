<template>
  <app-layout>
    <div class="pb-12 pt-6">
      <div class="mx-auto">
        <h2 class="pb-4">Xac nhan thong tin</h2>
        <div class="w-full shadow-lg p-4 my-6">
          <h2>Thong tin phim</h2>
        </div>

        <div class="w-full shadow-lg p-4 my-6">
          <h2>Thong tin phim</h2>
        </div>

        <div class="w-full shadow-lg p-4 my-6">
          <h2>Thong tin nguoi dat</h2>

          <el-form
            class="text-center w-full"
            ref="formData"
            :model="formData"
            label-position="top"
            :rules="rules"
          >
            <!-- Tên rạp -->
            <el-form-item label="Tên nguoi dat" prop="name">
              <el-input
                v-model="formData.name"
                autocomplete="off"
                placeholder="Nhập tên"
              ></el-input>
            </el-form-item>

            <!--email -->
            <el-form-item label="Email" prop="email">
              <el-input
                v-model="formData.email"
                autocomplete="off"
                placeholder="Nhập tên"
              ></el-input>
            </el-form-item>

            <!-- phone -->
            <el-form-item label="So dien thoai" prop="phone">
              <el-input
                v-model="formData.phone"
                autocomplete="off"
                placeholder="Nhập tên"
              ></el-input>
            </el-form-item>

            <div class="text-center">
              <el-button type="danger" @click="submit()">Thanh toan</el-button>
            </div>
          </el-form>
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
  props: {},

  data() {
    return {
      formData: {
        name: "",
        email: "",
        phone: "",
      },

      rules: {
        name: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "change",
          },
        ],
        email: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "change",
          },
        ],
        phone: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "change",
          },
        ],
      },
    };
  },
  methods: {
    submit() {
      Inertia.post(route("order", { ...this.formData }), {
        onBefore,
        onFinish,
      });
    },
  },
};
</script>
