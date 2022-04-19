<template>
  <div>
    <h3 class="text-center py-6">Bình luận về phim</h3>
    <!-- list comment  -->
    <div v-for="item in comments" :key="item.id">
      <div class="flex">
        <el-avatar
          shape="square"
          :size="50"
          :src="getImage(item?.user.image) || '/uploads/customer.png'"
        />
        <h4 class="mt-4 ml-4">{{ item?.user.name }}</h4>
      </div>
      <div class="w-full my-2 border p-2 rounded">{{ item.content }}</div>
      <div class="w-full mb-10">Thích / Trả lời /{{ item.created_at }}</div>
    </div>

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
import { getCommentMovie } from "@/API/main.js";

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
      comments: [],
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
            trigger: "change",
          },
        ],
      },
    };
  },

  created() {
    this.fetchData();
  },

  methods: {
    async fetchData() {
      console.log(99999);
      getCommentMovie()
        .then((res) => {
          console.log(55555, res.data);
          this.comments = res.data;
        })
        .catch(() => {});
    },

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
      this.fetchData();
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