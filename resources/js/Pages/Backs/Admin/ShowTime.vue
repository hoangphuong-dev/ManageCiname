
<template>
  <div class="demo-app">
    <div class="demo-app-main">
      <div class="w-1/2 m-auto my-4">
        <el-select
          class="w-full"
          placeholder="Chọn phòng chiếu"
          v-model="roomCurrent"
        >
          <el-option
            v-for="item in rooms"
            :key="item.id"
            :value="item.id"
            :label="item.name"
          >
          </el-option>
        </el-select>
      </div>

      <FullCalendar :options="calendarOptions">
        <template v-slot:eventContent="arg">
          <b>{{ arg.timeText }}</b>
          <i>{{ arg.event.title }}</i>
        </template>
      </FullCalendar>
    </div>

    <div>
      <el-dialog title="Thêm suất chiếu" v-model="dialogForm">
        <el-form
          :model="formData"
          label-position="top"
          class="text-center w-full"
          ref="formData"
        >
          <el-form-item label="Chọn phim">
            <el-select
              v-model="formData.movie_id"
              class="w-full"
              placeholder="Chọn phim"
              clearable
            >
              <el-option
                :key="item.id"
                :value="item.id"
                :label="item.name"
                v-for="item in cinema.movies"
                @click="changeMovie(item)"
              >
                <div class="option-grid">
                  <div class="title">Phim : {{ item.name }}</div>
                  <div class="movie_length text-right">
                    Thời lượng: {{ item.movie_length }} phút
                  </div>
                </div>
              </el-option>
            </el-select>

            <!-- THông tin phim vừa chọn  -->
            <div v-if="formData.movie_id > 0">
              <div class="w-full flex text-left mt-4">
                <div
                  class="w-1/3 border-dashed border-2 p-2 border-b-0 text-left"
                >
                  Hình ảnh
                </div>
                <div
                  class="
                    w-2/3
                    border-dashed border-2
                    p-2
                    border-b-0 border-l-0
                    text-left
                  "
                >
                  <img
                    style="height: 120px"
                    :src="
                      'https://i3.ytimg.com/vi/' +
                      videoId(movieCurrent) +
                      '/maxresdefault.jpg'
                    "
                  />
                </div>
              </div>
              <div class="w-full flex text-left">
                <div class="w-1/3 border-dashed border-2 p-2 border-b-0">
                  Tên phim
                </div>
                <div
                  class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                >
                  {{ movieCurrent.name }}
                </div>
              </div>
              <div class="w-full flex text-left">
                <div class="w-1/3 border-dashed border-2 p-2 border-b-0">
                  Đạo diễn
                </div>
                <div
                  class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                >
                  {{ movieCurrent.director }}
                </div>
              </div>
              <div class="w-full flex text-left">
                <div class="w-1/3 border-dashed border-2 p-2 border-b-0">
                  Rated
                </div>
                <div
                  class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                >
                  Cấm người dưới {{ movieCurrent.rated }} tuổi
                </div>
              </div>
              <div class="w-full flex mb-6 text-left">
                <div class="w-1/3 border-dashed border-2 p-2">Thời lượng</div>
                <div class="w-2/3 border-dashed border-2 p-2 border-l-0">
                  {{ movieCurrent.movie_length }} phút
                </div>
              </div>
            </div>
          </el-form-item>

          <el-form-item class="text-left" label="Ngày chiếu">
            <el-date-picker
              v-model="formData.day"
              type="date"
              placeholder="Chọn ngày chiếu"
            />
          </el-form-item>
          <div class="w-full flex">
            <div class="w-1/2">
              <el-form-item class="text-left" label="Thời gian bắt đầu">
                <el-time-select
                  class="w-11/12"
                  v-model="formData.time_start"
                  start="00:00"
                  step="00:30"
                  end="23:59"
                  placeholder="Chọn thời gian bắt đầu"
                />
              </el-form-item>
            </div>
            <div class="w-1/2 text-right">
              <el-form-item class="text-left" label="Thời gian kết thúc">
                <el-time-select
                  class="w-11/12"
                  v-model="formData.time_end"
                  :start="formData.time_start"
                  step="00:30"
                  end="23:59"
                  placeholder="Chọn thời gian kết thúc"
                />
              </el-form-item>
            </div>
          </div>

          <!-- submit -->
          <div class="text-right">
            <span class="dialog-footer">
              <el-button @click="dialogForm = false">Hủy</el-button>
              <el-button type="primary" @click="createShowTime()"
                >Thêm</el-button
              >
            </span>
          </div>
        </el-form>
      </el-dialog>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import interactionPlugin from "@fullcalendar/interaction";
import { Inertia } from "@inertiajs/inertia";
import resourceTimeGridPlugin from "@fullcalendar/resource-timegrid";
import { INITIAL_EVENTS } from "./event-utils";
import { listShowTimeByRoom } from "@/API/main.js";

export default {
  components: {
    FullCalendar, // make the <FullCalendar> tag available
  },
  props: {
    cinema: {
      type: Object,
      required: true,
    },
    rooms: {
      type: Array,
      required: true,
    },
  },

  watch: {
    roomCurrent() {
      this.formData.romm_id = this.roomCurrent;
      this.calendarOptions.initialEvents = 777777;
    },
  },

  data: function () {
    return {
      selected: ref(null),
      calendarOptions: {
        plugins: [
          dayGridPlugin,
          timeGridPlugin,
          interactionPlugin,
          resourceTimeGridPlugin, // needed for dateClick
        ],
        headerToolbar: {
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        buttonText: {
          today: "Hôm nay",
          month: "Tháng",
          week: "Tuần",
          day: "Ngày",
        },
        locale: "vi",
        initialView: "timeGridWeek", // swithch this to resourceTimeGridDay to see resource bug
        initialEvents: [], // alternatively, use the `events` setting to fetch from a feed
        selectable: true,
        editable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        select: this.handleDateSelect,
        eventClick: this.handleEventClick,
        eventsSet: this.handleEvents,
        resources: this.myResources,
        events: this.myEvents,
      },

      dialogForm: false,

      eventGuid: 0,
      currentEvents: [],
      movieCurrent: [],
      roomCurrent: "",

      myEvents: [
        {
          id: 1,
          title: "FFFFFFFF",
          start: new Date().toISOString().replace(/T.*$/, "") + "T14:00:00",
        },
        {
          id: 2,
          title: "EEEEEEEE",
          start: new Date().toISOString().replace(/T.*$/, "") + "T12:00:00",
        },
      ],

      formData: {
        romm_id: "",
        movie_id: "",
        day: "",
        time_start: "",
        time_end: "",
      },
    };
  },

  created() {
    this.fetchDataShowTimeByRoom();
  },

  methods: {
    async fetchDataShowTimeByRoom() {
      this.loading = true;
      listShowTimeByRoom(1)
        .then(({ status, data }) => {
          console.log("FFFF", data);
          // this.rooms.data = status === 200 ? data.data : this.rooms.data;
          // this.rooms.total = data.meta.total;
          // this.rooms.perPage = data.meta.per_page;
          // this.rooms.current_page = data.meta.current_page;
        })
        .catch(() => {});
      this.loading = false;
    },

    resetForm() {
      this.formData.movie_id = "";
    },
    createShowTime() {
      Inertia.post(
        route("admin.showtimes.store"),
        { ...this.formData },
        {
          onBefore,
          onFinish,
          onError: (e) => console.log(e),
          onSuccess: (_) => {
            this.resetForm();
            // this.fetchDataRoom();
            this.dialogForm = !this.dialogForm;
          },
        }
      );
    },
    videoId(row) {
      return getYoutubeId(row);
    },

    changeMovie(item) {
      this.movieCurrent = item;
    },

    createEventId() {
      return String(this.eventGuid++);
    },

    handleDateSelect(selectInfo) {
      if (this.roomCurrent === "") {
        alert("Vui lòng chọn phòng chiếu");
        return false;
      }
      if (selectInfo.start > new Date()) {
        this.formData.day = selectInfo.start.toISOString().replace(/T.*$/, "");
        this.formData.time_start = selectInfo.start.toLocaleTimeString();
        this.formData.time_end = selectInfo.end.toLocaleTimeString();
        this.dialogForm = !this.dialogForm;

        let calendarApi = selectInfo.view.calendar;

        console.log(selectInfo.view.calendar.addEvent);
        calendarApi.unselect(); // clear date selection
        // if (title) {
        //   calendarApi.addEvent({
        //     id: createEventId(),
        //     title,
        //     start: selectInfo.startStr,
        //     end: selectInfo.endStr,
        //   });
        // }
      }
    },

    // handleEventClick(clickInfo) {
    //   if (
    //     confirm(
    //       `Are you sure you want to delete the event '${clickInfo.event.title}'`
    //     )
    //   ) {
    //     clickInfo.event.remove();
    //   }
    // },

    handleEvents(events) {
      this.currentEvents = events;
    },
  },
};
</script>

<style lang='css'>
b {
  /* used for event dates/times */
  margin-right: 3px;
}
.demo-app {
  display: flex;
  min-height: 100%;
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
}

.demo-app-sidebar {
  line-height: 1.5;
  background: #eaf9ff;
  border-right: 1px solid #d3e2e8;
}

.fc-direction-ltr .fc-button-group > .fc-button:not(:first-child) {
  margin-left: -1px;
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
}
.fc .fc-button-group > .fc-button {
  position: relative;
  flex: 1 1 auto;
}
.fc .fc-button:not(:disabled) {
  cursor: pointer;
}
.fc .fc-button-primary {
  background: #ff7777;
  border-color: #ff7777;
}

.demo-app-sidebar-section {
  padding: 2em;
}
.fc .fc-button-primary:not(:disabled):active,
.fc .fc-button-primary:not(:disabled).fc-button-active {
  background: #2c3e50;
  border-color: #2c3e50;
}

.demo-app-main {
  flex-grow: 1;
}
</style>
<style lang="css">
.el-select-dropdown__item {
  height: max-content;
}

.option-grid {
  display: grid;
  grid-template-areas:
    "title movie_length"
    "desc  movie_length";
  line-height: 2 .title, .desc {
    font-size: 14px;
  }
  .title,
  .movie_length {
    font-weight: bold;
  }
  .title {
    grid-area: title;
  }
  .desc {
    grid-area: desc;
  }
  .movie_length {
    grid-area: movie_length;
    justify-self: end;
    align-self: center;
  }
}
</style>