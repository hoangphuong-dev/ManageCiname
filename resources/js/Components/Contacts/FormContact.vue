<template>
  <div class="w-full">
    <div class="head-title flex pt-10 pb-10 justify-center">
      <p>お問合せ</p>
    </div>
    <div class="main flex">
      <div class="main__form w-full md:w-1/2 pr-4">
        <el-form
          class="el-form--style"
          ref="contactForm"
          :model="formData"
          label-position="top"
          :rules="rules"
        >
          <el-form-item
            v-if="user.role === 1"
            label="病院名"
            prop="company_name"
            :error="$errors.first('company_name')"
          >
            <el-input v-model="formData.company_name"></el-input>
          </el-form-item>

          <el-form-item
            v-if="user.role === 1"
            label="担当者氏名 "
            prop="name"
            :error="$errors.first('name')"
          >
            <el-input v-model="formData.name"></el-input>
          </el-form-item>

          <el-form-item
            v-if="user.role === 2"
            label="氏名 "
            prop="name"
            :error="$errors.first('name')"
          >
            <el-input v-model="formData.name"></el-input>
          </el-form-item>

          <el-form-item
            label="メールアドレス"
            prop="email"
            :error="$errors.first('email')"
          >
            <el-input v-model="formData.email"></el-input>
          </el-form-item>
          <el-form-item
            label="電話番号"
            prop="phone_number"
            :error="$errors.first('phone_number')"
          >
            <el-input v-model="formData.phone_number"></el-input>
          </el-form-item>
          <el-form-item
            prop="question_content"
            label="お問合せ内容"
            :error="$errors.first('question_content')"
          >
            <el-input
              v-model="formData.question_content"
              type="textarea"
              :rows="10"
            ></el-input>
          </el-form-item>
          <div class="flex justify-center">
            <el-form-item>
              <el-button class="btn-submit--style" @click="onSubmit"
                >送信</el-button
              >
            </el-form-item>
          </div>
        </el-form>
      </div>
      <div class="main__company-info w-1/2 pl-4">
        <div class="company-name mb-5">VRST株式会社</div>
        <div class="company-address flex items-center mb-2">
          <el-image class="mr-3" src="/images/svg/address.svg"></el-image>
          <span>株式会社VRST 東京都新宿区箪笥町34　VORT神楽坂Ⅰ　8階</span>
        </div>
        <div class="company-phone flex items-center mb-2">
          <el-image class="mr-3" src="/images/svg/phone.svg"></el-image>
          <span>12-1134-886</span>
        </div>
        <div class="company-email flex items-center mb-2">
          <el-image class="mr-3" src="/images/svg/letter.svg"></el-image>
          <span>anfi@gmail.com</span>
        </div>
        <div class="company-map w-full" id="map"></div>
        <div class="company-socials">
          <p class="font-bold">フォローする</p>
          <div class="company-social__list flex mt-5">
            <div v-for="(social, indexSocial) in socials" :key="indexSocial">
              <el-image
                class="mr-5 cursor-pointer"
                :src="`/images/svg/socials/${social.img_url}.svg`"
              ></el-image>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { createContact } from "../../API/contact.js";
import { toFormData } from "@/libs/form";
import { reactive, ref } from "vue";
export default {
  computed: {
    user() {
      return this.$page.props.user;
    },
  },
  data() {
    return {
      formData: {
        name: "",
        company_name: "",
        email: "",
        phone_number: "",
        question_content: "",
      },
      socials: [
        {
          img_url: "twt",
        },
        {
          img_url: "youtube",
        },
      ],
      rules: {
        name: {
          required: true,
          message: "Please input this",
          trigger: "blur",
        },
        company_name: {
          required: true,
          message: "Please input this",
          trigger: "blur",
        },
        email: [
          {
            required: true,
            message: "Please input this",
            trigger: "blur",
          },
          {
            type: "email",
            message: "Please input correct email address",
            trigger: "blur",
          },
        ],
        phone_number: [
          {
            required: true,
            message: "Please input this",
            trigger: "blur",
          },
          {
            validator: function (err, value, callback) {
              let val = value.replace(/\s+/g, " ");
              if (
                !(val.length >= 9 && val.length <= 12) ||
                value.includes(" ")
              ) {
                return callback("Please input correct phone number");
              }
              callback();
            },
            trigger: "blur",
          },
        ],

        question_content: {
          required: true,
          message: "Please input this",
          trigger: "blur",
        },
      },
    };
  },
  mounted() {
    var head = document.getElementsByTagName("head")[0];
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.onload = () => {
      this.initMap();
    };
    script.src =
      "https://maps.googleapis.com/maps/api/js?key=AIzaSyAdppE_VDsVlaRnzkQT-7u4Ek9YCZlQYTs&libraries=&v=weekly";
    script.async = true;
    head.appendChild(script);
  },
  methods: {
    async onSubmit() {
      this.$refs["contactForm"].validate(async (valid) => {
        if (valid) {
          await createContact(
            toFormData({ ...this.formData }, "", { indices: true })
          )
            .then(async (res) => {
              this.$message.success("Create success");
            })
            .catch(() => {
              this.$message.error("Server Error");
            });
        }
        this.refresh();
      });
    },
    refresh() {
      this.formData.name = "";
      this.formData.company_name = "";
      this.formData.email = "";
      this.formData.phone_number = "";
      this.formData.question_content = "";
    },
    initMap() {
      const coordinate = { lat: 35.7001881, lng: 139.7343482 };
      const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 18,
        center: coordinate,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false,
      });

      new google.maps.Marker({
        position: coordinate,
        map: map,
      });
    },
  },
};
</script>
<style>
.el-form--label-top .el-form-item__label {
  padding: 0px;
}
.el-form-item__label {
  line-height: 25px;
  margin-top: 25px;
}
.head-title {
  font-style: normal;
  font-weight: bold;
  font-size: 36px;
  line-height: 42px;
  color: #ff7777;
}
.main {
  padding: 0px 88px;
  margin-bottom: 120px;
}
.el-form-item {
  margin-bottom: 16px;
  line-height: 0px;
}
.btn-submit--style {
  width: 184px;
  height: 48px;
  background: #fca442;
  border-radius: 8px;
  color: white;
  font-weight: 600;
  font-size: 24px;
}

.company-name {
  font-style: normal;
  font-weight: bold;
  font-size: 24px;
  line-height: 32px;
  color: #fca442;
}
.company-map {
  height: 335px;
  margin-top: 18px;
  margin-bottom: 28px;
  background-color: pink;
}
@media (max-width: 1200px) {
}
@media (max-width: 1024px) {
  .btn-cancel--style {
    width: 120px;
  }
  .btn-submit--style {
    width: 120px;
  }
}
@media (max-width: 767px) {
  .main {
    display: block;
  }
  .main__form {
    width: 100% !important;
    padding-right: 0px;
  }
  .main__company-info {
    width: 100% !important;
    padding-left: 0px;
  }
  .btn-submit--style {
    margin-left: 0px;
  }
}
@media (max-width: 640px) {
  .main {
    display: block;
    padding: 0px 40px;
  }
  .main__form {
    width: 100% !important;
    padding-right: 0px;
  }
  .main__company-info {
    width: 100% !important;
    padding-left: 0px;
  }
}
</style>
