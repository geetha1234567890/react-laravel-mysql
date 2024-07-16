import { ScheduleComponent, Day, Week, WorkWeek, Month, Agenda, Inject } from '@syncfusion/ej2-react-schedule';
import * as React from 'react';
import './cal.css';
import Header from "../Header/Header";
import Sidebar from "../Sidebar/Sidebar";

function NewCal() {
  const data = [
    {
      Id: 1,
      Subject: 'Meeting',
      StartTime: new Date(),
      EndTime: new Date(),
    },
  ];

  return (
    <>
      <Header />
      <Sidebar />
    
    <ScheduleComponent
      selectedDate={new Date()}
      eventSettings={{
        dataSource: data,
      }}
    >
      <Inject services={[Day, Week, WorkWeek, Month, Agenda]} />
      </ScheduleComponent>
    </>
  );
}

export default NewCal;
