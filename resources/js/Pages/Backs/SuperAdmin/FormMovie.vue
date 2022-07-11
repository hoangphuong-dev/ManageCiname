<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="my-5">Thêm Phim</h2>
        <el-form
          class="el-form--style"
          ref="formMovie"
          :model="formData"
          label-position="top"
          :rules="rules"
        >
          <div class="w-full flex">
            <div class="w-1/2 p-2 m-2">
              <!-- tên -->
              <el-form-item label="Tên phim" prop="name">
                <el-input v-model="formData.name"></el-input>
              </el-form-item>

              <!-- Đạo diễn -->
              <el-form-item label="Đạo diễn" prop="director">
                <el-input v-model="formData.director"></el-input>
              </el-form-item>

              <!-- trailer -->
              <el-form-item label="trailer" prop="trailer">
                <el-input v-model="formData.trailer"></el-input>
              </el-form-item>

              <!-- Thời lượng -->
              <el-form-item label="Thời lượng" prop="movie_length">
                <el-input v-model="formData.movie_length"></el-input>
              </el-form-item>

              <!-- Giới hạn độ tuổi -->
              <el-form-item label="Giới hạn độ tuổi" prop="rated">
                <el-input v-model="formData.rated"></el-input>
              </el-form-item>
            </div>
            <div class="w-1/2 p-2 m-2">
              <!-- Thể loại phim -->
              <div class="flex w-full">
                <div class="w-11/12">
                  <el-form-item label="Chọn thể loại" prop="movie_genre">
                    <el-select
                      class="w-full"
                      v-model="formData.movie_genre"
                      placeholder="Thể loại phim"
                      clearable
                      multiple
                    >
                      <el-option
                        v-for="item in movie_genres"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id"
                      ></el-option>
                    </el-select>
                  </el-form-item>
                </div>
                <div
                  class="w-1/12 m-auto mt-8 -mr-8 cursor-pointer"
                  @click="onOpenDialogMovieGenre"
                >
                  <el-icon><circle-plus /></el-icon>
                </div>
              </div>
              <!-- Dialog thể loại phim -->
              <div class="customer_dialog">
                <el-dialog
                  title="Thêm thể loại phim"
                  v-model="dialogFormVisibleMovieGenre"
                >
                  <el-form
                    class="w-1/2 m-auto"
                    ref="movieGenreForm"
                    :model="formDataMoviegenre"
                    label-position="top"
                    :rules="rulesMovieGenre"
                  >
                    <!-- Tên thể loại -->
                    <el-form-item label="Tên thể loại" prop="name">
                      <el-input
                        v-model="formDataMoviegenre.name"
                        autocomplete="off"
                        placeholder="Nhập tên"
                      ></el-input>
                    </el-form-item>
                  </el-form>
                  <!-- submit -->
                  <div class="text-right">
                    <span class="dialog-footer">
                      <el-button @click="dialogFormVisibleMovieGenre = false"
                        >Hủy</el-button
                      >
                      <el-button type="primary" @click="submitMovieGenre"
                        >Thêm</el-button
                      >
                    </span>
                  </div>
                </el-dialog>
              </div>
              <!-- Diễn viên -->
              <div class="flex w-full">
                <div class="w-11/12">
                  <el-form-item label="Chọn diễn viên" prop="cast">
                    <el-select
                      class="w-full"
                      v-model="formData.cast"
                      placeholder="Diễn viên"
                      clearable
                      multiple
                    >
                      <el-option
                        v-for="item in casts"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id"
                      ></el-option>
                    </el-select>
                  </el-form-item>
                </div>
                <div
                  class="w-1/12 m-auto mt-8 -mr-8 cursor-pointer"
                  @click="onOpenDialogCast"
                >
                  <el-icon><circle-plus /></el-icon>
                </div>
              </div>
              <!-- Dialog diễn viên -->
              <div class="customer_dialog">
                <el-dialog
                  title="Thêm diễn viên"
                  v-model="dialogFormVisibleCast"
                >
                  <el-form
                    class="w-1/2 m-auto"
                    ref="CastForm"
                    :model="formDataCast"
                    label-position="top"
                    :rules="rulesCast"
                  >
                    <!-- Tên diễn viên -->
                    <el-form-item label="Tên diễn viên" prop="name">
                      <el-input
                        v-model="formDataCast.name"
                        autocomplete="off"
                        placeholder="Nhập tên"
                      ></el-input>
                    </el-form-item>
                  </el-form>
                  <!-- submit -->
                  <div class="text-right">
                    <span class="dialog-footer">
                      <el-button @click="dialogFormVisibleCast = false"
                        >Hủy</el-button
                      >
                      <el-button type="primary" @click="submitCast"
                        >Thêm</el-button
                      >
                    </span>
                  </div>
                </el-dialog>
              </div>

              <!-- Định dạng -->
              <div class="flex w-full">
                <div class="w-11/12">
                  <el-form-item label="Chọn định dạng" prop="format">
                    <el-select
                      class="w-full"
                      v-model="formData.format"
                      placeholder="Định dạng"
                      clearable
                      multiple
                    >
                      <el-option
                        v-for="item in formats"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id"
                      ></el-option>
                    </el-select>
                  </el-form-item>
                </div>
                <div
                  class="w-1/12 m-auto mt-8 -mr-8 cursor-pointer"
                  @click="onOpenDialogFormat"
                >
                  <el-icon><circle-plus /></el-icon>
                </div>
              </div>

              <!-- Dialog định dạng -->
              <div class="customer_dialog">
                <el-dialog
                  title="Thêm định dạng"
                  v-model="dialogFormVisibleFormat"
                >
                  <el-form
                    class="w-1/2 m-auto"
                    ref="FormatForm"
                    :model="formDataFormat"
                    label-position="top"
                    :rules="rulesFormat"
                  >
                    <!-- Tên diễn viên -->
                    <el-form-item label="Tên định dạng" prop="name">
                      <el-input
                        v-model="formDataFormat.name"
                        autocomplete="off"
                        placeholder="Nhập tên"
                      ></el-input>
                    </el-form-item>
                  </el-form>
                  <!-- submit -->
                  <div class="text-right">
                    <span class="dialog-footer">
                      <el-button @click="dialogFormVisibleFormat = false"
                        >Hủy</el-button
                      >
                      <el-button type="primary" @click="submitFormat"
                        >Thêm</el-button
                      >
                    </span>
                  </div>
                </el-dialog>
              </div>
            </div>
          </div>
          <div class="w-full">
            <!-- Mô tả chi tiết phim -->
            <el-form-item label="Mô tả chi tiết" prop="description">
              <editor v-model="formData.description" :init="{ height: 400 }" />
            </el-form-item>
          </div>
          <!-- submit -->
          <div class="flex justify-center mt-8">
            <el-form-item>
              <el-button class="btn-submit--style" @click="onSubmit"
                >Thêm</el-button
              >
            </el-form-item>
          </div>
        </el-form>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import { toFormData } from "@/libs/form";
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import Editor from "@tinymce/tinymce-vue";
import { CirclePlus } from "@element-plus/icons-vue";
import {
  createMovieGenre,
  listMovieGenre,
  createFormat,
  listFormat,
  createCast,
  listCast,
} from "@/API/main.js";
import { Inertia } from '@inertiajs/inertia';

export default {
  name: "FormAdminInfo",
  components: { AdminLayout, CirclePlus, Editor },
  data() {
    return {
      dialogFormVisibleMovieGenre: false,
      dialogFormVisibleFormat: false,
      dialogFormVisibleCast: false,
      movie_genres: [],
      formats: [],
      casts: [],
      formData: {
        name: "",
        director: "",
        description: "",
        trailer: "",
        movie_length: "",
        rated: "",
        format: [],
        movie_genre: [],
        cast: [],
      },
      formDataMoviegenre: {
        name: "",
      },
      formDataCast: {
        name: "",
      },
      formDataFormat: {
        name: "",
      },
      rules: {
        name: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
        director: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
        description: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "change",
        },
        cast: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "change",
        },
        // trailer: [
        //   {
        //     required: true,
        //     message: "Trường này không được trống ",
        //     trigger: "blur",
        //   },
        //   {
        //     pattern:
        //       /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/,
        //     message: "Đường link không phải của youtube",
        //     trigger: "blur",
        //   },
        // ],
        movie_length: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
        rated: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
        movie_genre: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "change",
        },
        format: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "change",
        },
      },
      rulesMovieGenre: {
        name: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
      },
      rulesCast: {
        name: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
      },
      rulesFormat: {
        name: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
      },
    };
  },
  created() {
    this.fetchDataMovieGenre();
    this.fetchDataFormat();
    this.fetchDataCast();
  },
  methods: {
    onOpenDialogMovieGenre() {
      this.formDataMoviegenre.name = "";
      this.formDataMoviegenre.price = "";
      this.dialogFormVisibleMovieGenre = true;
    },
    onOpenDialogFormat() {
      this.formDataFormat.name = "";
      this.dialogFormVisibleFormat = true;
    },
    onOpenDialogCast() {
      this.formDataCast.name = "";
      this.dialogFormVisibleCast = true;
    },
    async onSubmit() {
      this.dialogFormVisibleMovieGenre = false;
      this.$refs["formMovie"].validate(async (valid) => {
        if (valid) {
          Inertia.post(route('superadmin.movie.store'), { ...this.formData }) 
        }
      });
    },
    async submitMovieGenre() {
      this.$refs["movieGenreForm"].validate(async (valid) => {
        if (valid) {
          await createMovieGenre(
            toFormData({ ...this.formDataMoviegenre }, "", { indices: true })
          )
            .then(async (res) => {
              this.$message.success("Create success");
              this.fetchDataMovieGenre();
              this.dialogFormVisibleMovieGenre = false;
            })
            .catch(() => {
              this.$message.error("Server Error");
            });
        }
      });
    },
    async submitCast() {
      this.$refs["CastForm"].validate(async (valid) => {
        if (valid) {
          await createCast(
            toFormData({ ...this.formDataCast }, "", { indices: true })
          )
            .then(async (res) => {
              this.$message.success("Create success");
              this.fetchDataCast();
              this.dialogFormVisibleCast = false;
            })
            .catch(() => {
              this.$message.error("Server Error");
            });
        }
      });
    },

    async submitFormat() {
      this.$refs["FormatForm"].validate(async (valid) => {
        if (valid) {
          await createFormat(
            toFormData({ ...this.formDataFormat }, "", { indices: true })
          )
            .then(async (res) => {
              this.$message.success("Create success");
              this.fetchDataCast();
              this.dialogFormVisibleFormat = false;
            })
            .catch(() => {
              this.$message.error("Server Error");
            });
        }
      });
    },

    async fetchDataMovieGenre() {
      this.loading = true;
      listMovieGenre()
        .then(({ status, data }) => {
          this.movie_genres = status === 200 ? data.data : this.movie_genres;
        })
        .catch(() => {});
      this.loading = false;
    },

    async fetchDataFormat() {
      this.loading = true;
      listFormat()
        .then(({ status, data }) => {
          this.formats = status === 200 ? data : this.formats;
        })
        .catch(() => {});
      this.loading = false;
    },

    async fetchDataCast() {
      this.loading = true;
      listCast()
        .then(({ status, data }) => {
          this.casts = status === 200 ? data : this.casts;
        })
        .catch(() => {});
      this.loading = false;
    },
  },
};
</script>