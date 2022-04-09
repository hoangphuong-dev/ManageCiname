<template>
  <div>
    <div
      :class="classImage"
      class="relative inline-block align-top items-center rounded border border-solid border-blackPrimary-100 hover:cursor-pointer"
      @click="$refs.inputUpload.click()"
    >
      <div class="absolute h-max top-0 bottom-0 right-0 left-0 m-auto text-center text-sm leading-5">
        <img class="inline-block w-5 h-5" src="/images/svg/plus.svg" alt="" />
        <div>アップロード</div>
      </div>
      <input
        class="hidden"
        ref="inputUpload"
        type="file"
        name="file"
        @change="handleFileChange($event)"
        :accept="accept"
      />
    </div>

    <ul class="preview-upload inline align-top items-center">
      <li
        :class="classImage"
        class="ml-2 mb-3 relative inline-block group"
        v-for="(image, index) in listImagePreview"
        :key="index"
      >
        <el-image v-if="image.url" :src="image.url" class="rounded w-full h-full object-cover" alt></el-image>
        <img
          src="/images/svg/delete.svg"
          class="hidden group-hover:block absolute p-2.5 h-10 w-10 top-2 right-2 bg-white rounded cursor-pointer"
          @click.prevent="removeImage(image)"
        />
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'UploadImageList',
  props: {
    accept: {
      type: String,
      default: 'image/*',
    },
    classImage: {
      type: String,
      default: 'w-40 h-32',
    },
    listImage: {
      type: Array,
      required: false,
      default: [],
    },
    classImage: {
      type: String,
      default: 'w-40 h-32',
    },
  },
  data() {
    return {
      listImagePreview: [],
    }
  },
  created() {
    this.listImagePreview = [...this.listImage]
  },
  methods: {
    handleFileChange(e) {
      const files = e.target.files || e.dataTransfer.files
      if (files.length) {
        const image = files[0]
        if (!image.name.match(/.(jpg|jpeg|png)$/i)) {
          return this.$message.error('Error ...')
        }

        let reader = new FileReader()
        reader.onload = (e) => {
          this.listImagePreview.push({ url: e.target.result })
        }
        reader.readAsDataURL(image)
        this.$emit('uploadImage', image)
      }
      e.target.value = null
    },
    removeImage(image) {
      this.$confirm('Are you sure to delete this image?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        const index = this.listImagePreview.indexOf(image)
        this.listImagePreview.splice(index, 1)

        this.$emit('removeImage', image)
      })
    },
  },
}
</script>
