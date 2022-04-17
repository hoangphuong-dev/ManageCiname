<template>
  <app-layout>
    <div class="bg-white min-h-full m-4 mb-0 p-4">
      <h2 class="mb-5">Tài khoản của tôi</h2>

      <div class="w-full shadow-xl p-4 m-auto my-6">
        <el-form ref="form" :rules="rules" :model="form" label-position="top">
          <!-- avartar -->

          <div class="w-1/6 m-auto mb-6">
            <h3 class="mb-4">Ảnh đại diện</h3>
            <div
              class="
                w-48
                h-60
                flex
                justify-center
                items-center
                border
                rounded
                hover:cursor-pointer
              "
              @click="$refs.inputUpload.click()"
            >
              <div
                class="xl:flex flex-col justify-center items-center"
                v-if="!imagePreview"
              >
                <el-empty description="Không có dữ liệu"></el-empty>
                <p class="text-red-200">Chọn ảnh</p>
              </div>
              <img
                v-else
                :src="imagePreview"
                class="rounded w-full h-full object-cover"
              />
              <input
                class="hidden"
                ref="inputUpload"
                type="file"
                @change="handleFileChange($event)"
              />
            </div>
          </div>
          <!-- end avartar -->
          <el-form-item label="Họ tên" prop="name">
            <el-input v-model="form.name" />
          </el-form-item>

          <el-form-item label="Email" prop="email">
            <el-input v-model="form.email" />
          </el-form-item>

          <el-form-item label="Số điện thoại" prop="phone">
            <el-input v-model="form.phone" />
          </el-form-item>
          {{ user }}

          <el-button @click="submit()" class="text-center" type="danger">
            Cập nhật
          </el-button>
        </el-form>
      </div>
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
  props: {
    user: {
      type: Object,
      require: true,
    },
  },

  data: function () {
    return {
      imagePreview: "",
      loading: false,
      form: {
        id: this.user.id,
        name: this.user.name,
        image: "",
        phone: this.user.phone,
        email: this.user.email,
      },
      rules: {
        name: {
          required: true,
          message: "Trường này không được để trống",
          trigger: "blur",
        },
        email: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
          {
            type: "email",
            message: "Địa chỉ email không đúng định dạng ",
            trigger: "blur",
          },
        ],
        phone: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
          {
            validator: function (err, value, callback) {
              let val = value.replace(/\s+/g, " ");
              if (
                !(val.length >= 9 && val.length <= 12) ||
                value.includes(" ")
              ) {
                return callback("Số  điện thoại không đúng định dạng !");
              }
              callback();
            },
            trigger: "blur",
          },
        ],
      },
    };
  },
  methods: {
    async submit() {
      this.$refs["form"].validate((valid) => {
        if (valid) {
          Inertia.post(
            route("customer.update-profile", this.form),
            {},
            { onBefore, onFinish, preserveScroll: true }
          );
        }
      });
    },

    handleFileChange(e) {
      console.log("FFF", e);
      const files = e.target.files || e.dataTransfer.files;
      if (files.length) {
        const image = files[0];
        if (!image.name.match(/.(jpg|jpeg|png)$/i)) {
          return this.$message.error("Error ...");
        }

        let reader = new FileReader();
        reader.onload = (e) => {
          this.imagePreview = e.target.result;
        };
        this.form.image = image;

        console.log("image", image);
        reader.readAsDataURL(image);
      }
    },

    isValidHttpUrl(string) {
      let url;
      try {
        url = new URL(string);
      } catch (_) {
        return false;
      }
      return url.protocol === "http:" || url.protocol === "https:";
    },

    getImage(file) {
      console.log(file);
      if (!file) return;
      if (this.isValidHttpUrl(file)) return file;
      return `/uploads/${file}`;
    },
  },
};
</script>
