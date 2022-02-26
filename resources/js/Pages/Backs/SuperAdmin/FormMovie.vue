<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="text-center my-5">Thêm Phim</h2>

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

              <!-- Trailler -->
              <el-form-item label="Trailler" prop="trailler">
                <el-input v-model="formData.trailler"></el-input>
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
                      class="custom-el-form-item w-full"
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
                  class="text-center"
                  title="Thêm thể loại phim"
                  v-model="dialogFormVisibleMovieGenre"
                >
                  <el-form
                    class="text-center w-1/2 m-auto"
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

                    <el-form-item label="Giá tiền thể loại" prop="price">
                      <el-input
                        v-model="formDataMoviegenre.price"
                        autocomplete="off"
                        placeholder="Nhập giá tiền"
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
                      class="custom-el-form-item w-full"
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
                  class="text-center"
                  title="Thêm diễn viên"
                  v-model="dialogFormVisibleCast"
                >
                  <el-form
                    class="text-center w-1/2 m-auto"
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

              <!-- Khu vực chiếu phim -->
              <el-form-item
                label="Thành phố được phép chiếu phim"
                prop="province"
              >
                <el-select
                  class="custom-el-form-item w-full"
                  v-model="formData.province"
                  placeholder="Chọn khu vực"
                  clearable
                  multiple
                >
                  <el-option
                    v-for="item in adminInfo"
                    :key="item.province.id"
                    :label="item.province.name"
                    :value="item.province.id"
                  ></el-option>
                </el-select>
              </el-form-item>
            </div>
          </div>
          <div class="w-full">
            <!-- Mô tả chi tiết phim -->
            <el-form-item label="Mô tả chi tiết" prop="description">
              <editor
                api-key="4ef3zvav0qudmex3qwfywihrcyw1nenban69inpf40obfgdh"
                v-model="formData.description"
                :init="{
                  height: 400,
                  menubar: false,
                  plugins: [
                    'fullscreen advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount image',
                  ],
                  toolbar:
                    'fullscreen | undo redo | formatselect | bold italic forecolor backcolor | \
                                        alignleft aligncenter alignright alignjustify | \
                                        bullist numlist outdent indent | removeformat | image',
                  image_title: true,
                  automatic_uploads: true,
                  file_picker_types: 'image',
                  file_picker_callback: filePicker,
                  image_description: false,
                  image_title: false,
                  fullscreen_native: true,
                }"
              />
            </el-form-item>
          </div>
        </el-form>

        <!-- submit -->
        <div class="flex justify-center mt-8">
          <el-form-item>
            <el-button class="btn-submit--style" @click="onSubmit"
              >Thêm</el-button
            >
          </el-form-item>
        </div>
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
  createMovie,
  createMovieGenre,
  listMovieGenre,
  createCast,
  listCast,
} from "@/API/main.js";

export default {
  name: "FormAdminInfo",
  components: { AdminLayout, CirclePlus, Editor },
  props: {
    adminInfo: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      dialogFormVisibleMovieGenre: false,
      dialogFormVisibleCast: false,
      movie_genres: [],
      casts: [],
      formData: {
        name: "",
        director: "",
        description: "",
        trailler: "",
        movie_length: "",
        rated: "",
        province: [],
        movie_genre: [],
        cast: [],
      },
      formDataMoviegenre: {
        name: "",
        price: "",
      },
      formDataCast: {
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
        trailler: [
          {
            required: true,
            message: "Trường này không được trống ",
            trigger: "blur",
          },
          // {
          //     pattern: /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/,
          //     message: "Đường link không phải của youtube",
          //     trigger: "blur",
          // },
        ],
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
        province: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "change",
        },
        movie_genre: {
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
        price: {
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
    };
  },
  created() {
    this.fetchDataMovieGenre();
    this.fetchDataCast();
  },
  methods: {
    onOpenDialogMovieGenre() {
      this.formDataMoviegenre.name = "";
      this.formDataMoviegenre.price = "";
      this.dialogFormVisibleMovieGenre = true;
    },
    onOpenDialogCast() {
      this.formDataCast.name = "";
      this.dialogFormVisibleCast = true;
    },
    async onSubmit() {
      this.dialogFormVisibleMovieGenre = false;
      this.$refs["formMovie"].validate(async (valid) => {
        if (valid) {
          await createMovie(
            toFormData({ ...this.formData }, "", { indices: true })
          )
            .then(async (res) => {
              this.$message.success("Create success");
            })
            .catch(() => {
              this.$message.error("Server Error");
            });
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
