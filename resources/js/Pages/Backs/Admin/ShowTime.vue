<template>
  <div class="p-4">
    <FullCalendar :events="events" :options="options" />
  </div>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import "@fullcalendar/core/vdom"; // solves problem with Vite
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
export default {
  name: "ShowTime",
  components: {
    AdminLayout,
    FullCalendar,
  },
  data() {
    return {
      options: {
        plugins: [dayGridPlugin, timeGridPlugin],
        initialDate: "2019-01-01",
        headerToolbar: {
          left: "prev,next",
          center: "title",
          right: "dayGridMonth,timeGridWeek",
        },
        editable: true,
      },
      events: [
        {
          id: 1,
          title: "All Day Event",
          start: "2019-01-01",
        },
        {
          id: 2,
          title: "Long Event",
          start: "2019-01-07",
          end: "2019-01-10",
        },
        {
          id: 3,
          title: "Repeating Event",
          start: "2019-01-09T16:00:00",
        },
        {
          id: 4,
          title: "Repeating Event",
          start: "2019-01-16T16:00:00",
        },
        {
          id: 5,
          title: "Conference",
          start: "2019-01-11",
          end: "2019-01-13",
        },
        {
          id: 6,
          title: "Meeting",
          start: "2019-01-12T10:30:00",
          end: "2019-01-12T12:30:00",
        },
      ],
    };
  },
};
</script>

<style>
.fc .fc-button-primary {
  background: #ff7777;
  margin-right: 4px;
  border-color: #ff7777;
}
.fc .fc-button-primary:not(:disabled).fc-button-active {
  background: #ff7777;
  border-color: #ff7777;
  margin-right: 4px;
}
</style>
