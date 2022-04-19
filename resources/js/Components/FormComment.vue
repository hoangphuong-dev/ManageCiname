<template>
  <div>
    <div class="flex">
      <el-avatar
        shape="square"
        :size="50"
        :src="getImage(user?.image) || '/uploads/customer.png'"
      />
      <h4 class="mt-4 ml-4">{{ user?.name }}</h4>
    </div>
    <div class="w-full mt-2">
      <el-form ref="form" :model="form" :rules="rules">
        <el-form-item prop="content">
          <el-input
            v-model="form.content"
            :rows="5"
            type="textarea"
            placeholder="Viết bình luận ..."
            @keyup.ctrl.enter="submit()"
          />
        </el-form-item>
      </el-form>
    </div>
    <div class="text-center mt-4">
      <el-button @click="submit()" type="success" plain>Bình luận</el-button>
    </div>
  </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";

export default {
  props: {
    user: {
      type: Object,
      require: true,
    },
    movie: {
      type: Object,
      require: true,
    },
  },

  data: function () {
    return {
      province: "",
      provinces: [],
      cinemas: [],
      form: {
        movie_id: "",
        user_id: "",
        content: "",
        parent_id: 0,
      },
      rules: {
        content: [
          {
            required: true,
            message: "Nội dung bình luận không được để trống !",
            trigger: "blur",
          },
        ],
      },
    };
  },

  methods: {
    async submit() {
      if (this.user === null) {
        Inertia.get(route("customer.login"));
        return true;
      }
      this.form.user_id = this.user?.id;
      this.form.movie_id = this.movie?.id;
      this.$refs["form"].validate((valid) => {
        if (valid) {
          Inertia.post(route("comments.store", this.form));
          this.form.content = "";
        }
      });
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
      if (!file) return;
      if (this.isValidHttpUrl(file)) return file;
      return `/uploads/${file}`;
    },
  },
};
</script>