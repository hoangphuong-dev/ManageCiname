<template>
  <div>
    <h3 class="text-center pb-6">Bình luận về phim</h3>
    <!-- list comment  -->
    <div v-for="item in comments" :key="item.id">
      <div v-if="item.parent_id === 0">
        <div class="flex">
          <el-avatar
            shape="square"
            :size="50"
            :src="getImage(item?.user.image) || '/uploads/customer.png'"
          />
          <h4 class="mt-4 ml-4">{{ item?.user.name }}</h4>
        </div>
        <div class="w-full my-2 border p-2 rounded">{{ item.content }}</div>
        <div class="w-full mb-8">
          <span class="cursor-pointer mx-2 font-bold hover:text-blue-500">
            Thích
          </span>
          <span
            @click="reply(item.id)"
            class="cursor-pointer mx-2 font-bold hover:text-blue-500"
            >Trả lời
          </span>
          <span class="cursor-pointer mx-2 font-bold hover:text-blue-500">
            {{ item.created_at }}
          </span>
        </div>
      </div>

      <!-- show comment children  -->
      <div class="ml-20" v-for="each in comments" :key="each.id">
        <div v-if="each.parent_id === item.id">
          <div class="flex">
            <el-avatar
              shape="square"
              :size="50"
              :src="getImage(each?.user.image) || '/uploads/customer.png'"
            />
            <h4 class="mt-4 ml-4">{{ each?.user.name }}</h4>
          </div>
          <div class="w-full my-2 border p-2 rounded">{{ each.content }}</div>
          <div class="w-full mb-8">
            <span class="cursor-pointer mx-2 font-bold hover:text-blue-500">
              Thích
            </span>
            <span
              @click="reply(item.id)"
              class="cursor-pointer mx-2 font-bold hover:text-blue-500"
              >Trả lời
            </span>
            <span class="cursor-pointer mx-2 font-bold hover:text-blue-500">
              {{ each.created_at }}
            </span>
          </div>
        </div>
      </div>
      <!-- end show comment children -->

      <!-- rep comment  -->
      <div
        v-if="showFormReply === item.id"
        style="width: calc(100% - 5rem)"
        class="mb-6 ml-20"
      >
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
            <el-form ref="formReply" :model="formReply" :rules="ruleReply">
              <el-form-item prop="content">
                <el-input
                  v-model="formReply.content"
                  :rows="5"
                  type="textarea"
                  placeholder="Viết bình luận ..."
                  @keyup.ctrl.enter="submitReply()"
                />
              </el-form-item>
            </el-form>
          </div>

          <div class="text-center mt-4">
            <el-button @click="submitReply()" type="success" plain
              >Trả lời</el-button
            >
          </div>
        </div>
      </div>
      <!-- end rep comment  -->
    </div>
    <!-- end list comment  -->

    <!-- form comment  -->
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
              @keyup.ctrl.enter="submitComment()"
            />
          </el-form-item>
        </el-form>
      </div>

      <div class="text-center mt-4">
        <el-button @click="submitComment()" type="success" plain
          >Bình luận</el-button
        >
      </div>
    </div>
    <!-- end form comment  -->
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
      showFormReply: 0,
      comments: [],
      form: {
        movie_id: "",
        user_id: "",
        content: "",
        parent_id: 0,
      },
      formReply: {
        movie_id: "",
        user_id: "",
        content: "",
        parent_id: "",
      },
      rules: {
        content: [
          {
            required: true,
            message: "Nội dung bình luận không được để trống !",
            triger: "change",
          },
        ],
      },
      ruleReply: {
        content: [
          {
            required: true,
            message: "Nội dung bình luận không được để trống !",
            triger: "change",
          },
        ],
      },
    };
  },

  created() {
    this.fetchData();
  },

  methods: {
    reply(id) {
      this.showFormReply = id;
      this.formReply.parent_id = id;
    },

    submitReply() {
      this.checkLogin;
      this.formReply.user_id = this.user?.id;
      this.formReply.movie_id = this.movie?.id;
      this.$refs["formReply"][0].validate((valid) => {
        if (valid) {
          Inertia.post(route("comments.store", this.formReply));
        }
      });
      this.formReply.content = "";
      this.showFormReply = "";
      this.fetchData();
    },

    submitComment() {
      this.checkLogin;
      this.form.user_id = this.user?.id;
      this.form.movie_id = this.movie?.id;
      this.$refs["form"].validate((valid) => {
        if (valid) {
          Inertia.post(route("comments.store", this.form));
        }
      });
      this.form.content = "";
      this.fetchData();
    },

    checkLogin() {
      if (this.user === null) {
        Inertia.get(route("customer.login"));
        return true;
      }
    },

    async fetchData() {
      getCommentMovie()
        .then((res) => {
          this.comments = res.data;
        })
        .catch(() => {});
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