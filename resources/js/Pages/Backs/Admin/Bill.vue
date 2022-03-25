   <template #main>
  <div class="bg-gray-100 min-h-full m-4 mb-0 p-4 w-11/12">
    <h2 class="mb-5">Màn Bill</h2>
  </div>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
export default {
  name: "HomeStaff",
  components: {
    AdminLayout,
  },
  data() {
    return {
      loading: false,
    };
  },
  methods: {},
};
</script>
