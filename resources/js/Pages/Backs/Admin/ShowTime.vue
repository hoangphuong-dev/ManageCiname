
<template>
  <div class="demo-app">
    <div class="demo-app-main">
      <FullCalendar :options="calendarOptions">
        <template v-slot:eventContent="arg">
          <b>{{ arg.timeText }}</b>
          <i>{{ arg.event.title }}</i>
        </template>
      </FullCalendar>
    </div>
  </div>
</template>

<script>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import resourceTimeGridPlugin from "@fullcalendar/resource-timegrid";
import { INITIAL_EVENTS, createEventId } from "./event-utils";

export default {
  components: {
    FullCalendar, // make the <FullCalendar> tag available
  },

  data: function () {
    return {
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
        initialView: "timeGridDay", // swithch this to resourceTimeGridDay to see resource bug
        initialEvents: INITIAL_EVENTS, // alternatively, use the `events` setting to fetch from a feed
        editable: true,
        // selectable: true,
        // selectMirror: true,
        // dayMaxEvents: true,
        // weekends: true,
        // select: this.handleDateSelect,
        // eventClick: this.handleEventClick,
        eventsSet: this.handleEvents,
        resources: this.myResources,
        events: this.myEvents,
        /* you can update a remote database when these fire:
        eventAdd:
        eventChange:
        eventRemove:
        */
      },
      currentEvents: [],
      myResources: [{ id: 1, title: "works" }],
      myEvents: [
        {
          id: 1,
          title: "All-day event",
          start: new Date().toISOString().replace(/T.*$/, ""),
        },
        {
          id: 3,
          title: "Timed event",
          start: new Date().toISOString().replace(/T.*$/, "") + "T12:00:00",
        },
      ],
    };
  },

  methods: {
    handleDateSelect(selectInfo) {
      console.log("FFFF", selectInfo);
      let title = prompt("Please enter a new title for your event");
      let calendarApi = selectInfo.view.calendar;

      // calendarApi.unselect(); // clear date selection
      // if (title) {
      //   calendarApi.addEvent({
      //     id: createEventId(),
      //     title,
      //     start: selectInfo.startStr,
      //     end: selectInfo.endStr,
      //     allDay: selectInfo.allDay,
      //   });
      // }
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

.demo-app-sidebar-section {
  padding: 2em;
}

.demo-app-main {
  flex-grow: 1;
}

.fc {
  /* the calendar root */
  max-width: 1100px;
  margin: 0 auto;
}
</style>
