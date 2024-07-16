// CalendarComponent.jsx
import React, { useState } from "react";
import moment from "moment";
import { Calendar, momentLocalizer, Views } from 'react-big-calendar';
import "react-big-calendar/lib/css/react-big-calendar.css";
import "moment/locale/en-gb";
// import initialEvents from "./events";  // Import the events
// import { tokens } from "../../theme";
import Header from "../Header/Header";
import Sidebar from "../Sidebar/Sidebar";
moment.locale("en-GB");
const localizer = momentLocalizer(moment);
const allViews = Object.keys(Views).map(k => Views[k]);
const CalendarComponent = ({ eventsList, addEvent /*,handleSelectEvent*/}) => {
  // const [eventsList, setEventsList] = useState([]);

  const handleSelectSlot = ({ start, end }) => {
    const title = window.prompt("New Event name");
    if (!title) return;
    const startDateTime = window.prompt("Enter start date and time (YYYY-MM-DD HH:MM)", moment(start).format("YYYY-MM-DD HH:mm"));
    const endDateTime = window.prompt("Enter end date and time (YYYY-MM-DD HH:MM)", moment(end).format("YYYY-MM-DD HH:mm"));

    const newStart = moment(startDateTime, "YYYY-MM-DD HH:mm").toDate();
    const newEnd = moment(endDateTime, "YYYY-MM-DD HH:mm").toDate();

    // setEventsList(prev => [...prev, { title, start: newStart, end: newEnd }]);
    addEvent(title, newStart, newEnd); 
    };
    

    return (
    <>
    <Header />
    <Sidebar />
      
    <div style={{ height: 700 }}>
      <Calendar
        localizer={localizer}
        defaultDate={new Date()}
        views={Calendar.Views}
        events={eventsList}
        step={60}
        selectable
        // onSelectEvent={handleSelectEvent}
        onSelectSlot={handleSelectSlot}
    />
    </div>
    </>
  );
};

export default CalendarComponent;
