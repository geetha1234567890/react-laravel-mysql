import "./App.css";
import "bootstrap-icons/font/bootstrap-icons.css";

import './assets/fonts/Nohemi-Bold.ttf';
import './assets/fonts/Nohemi-ExtraLight.ttf';
import './assets/fonts/Nohemi-Light.ttf';
import './assets/fonts/Nohemi-Medium.ttf';
import './assets/fonts/Nohemi-Regular.ttf';
import './assets/fonts/Nohemi-SemiBold.ttf'

import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.min.js";
import Main from "./components/Main/Main";
import { Route, Routes } from "react-router-dom";
import Layout from "./Layout";
import Login from "./components/AUTH/Login";
import LinkPage from "./components/AUTH/LinkPage";
import Unauthorized from "./components/AUTH/Unauthorized";
import RequireAuth from "./components/Hooks/RequireAuth";
import Dashboard from "./components/Dashboard";
import ManagesTAs from "./pages/managesTAs/ManagesTAs";
import TAAvailability from "./pages/managesTAs/TaAvaialablity";
import ManageCoaches from "./pages/ManageCoaches/ManageCoaches";
import CoachMapping from "./pages/ManageCoaches/CoachMapping";
import CoachTemplate from "./pages/ManageCoaches/CoachingTemplate/CoachTemplate";
import CoachAvialability from "./pages/managesTAs/CoachAvialability";
import CoachScheduling from "./pages/ManageCoaches/CoachScheduling";
import AllRoutes from "./components/AllRoutes/AllRoutes";
import TaMapping from "./pages/managesTAs/TaMapping";
import TaScheduling from "./pages/managesTAs/TaScheduling";
import Calendar from "./components/Calender/indexCalender";
import StudentPage from "./pages/students/StudentPage";
import MyProfile from "./components/RoleRoute/CommonComponent/MyProfile";
import CallRecords from "./components/RoleRoute/CommonComponent/CallRecords";
import Messages from "./components/RoleRoute/CommonComponent/Messages";
import CallRequest from "./components/RoleRoute/CommonComponent/CallRequest";
import ScheduledCalls from "./components/RoleRoute/CommonComponent/ScheduledCalls";
import MyCalender from "./components/RoleRoute/CommonComponent/MyCalender";
import Mystudents from "./components/RoleRoute/CommonComponent/Mystudents";
import AssignedStudent from "./pages/managesTAs/AssignedStudent";
// import StudentList from './pages/Student/StudentList';
import AddEditTA from "./components/adminModule/tas/manageTAs/AddEditTA";
import AssignCoachBatches from "./pages/ManageCoaches/AssignedCoachBatches";
import AssignCoachStudent from "./pages/ManageCoaches/AssignedCoachStudent";
import CreateCoachPage from "./pages/ManageCoaches/CreateCoachPage";
import CoachCalender from "./pages/ManageCoaches/CoachCalender";
import CreateTAPage from "./pages/managesTAs/CreateTAPage";
import AssignedBatches from "./pages/managesTAs/AssignedBatches";
import TaCalender from "./pages/managesTAs/TaCalendar";
import BatchPage from "./pages/batches/BatchPage";
import CreateTemplate from "./pages/ManageCoaches/CoachingTemplate/CreateTemplate";
import TemplateName from "./pages/ManageCoaches/CoachingTemplate/TemplateName";
import WheelOfLife from "./pages/coachingTools/wheelOfLife/WheelOfLife";
const ROLES = {
  Teaching: 2001,
  Coaches: 1984,
  Admin: 5150,
};

function App() {
  return (
    <Routes>
      <Route path="/" element={<Layout />}>
        {/* Public Routes */}
        <Route path="login" element={<Login />} />
        <Route path="linkpage" element={<LinkPage />} />
        <Route path="unauthorized" element={<Unauthorized />} />

        {/* Protected Routes */}
        <Route element={<RequireAuth allowedRoles={[ROLES.Admin]} />}>
          <Route path="/" element={<Main page="Dashboard" />}>
            <Route index element={<Dashboard />} />
            <Route path="dashboard" element={<Dashboard />} />

            <Route path="ta-manage" element={<ManagesTAs page="Manage TA" />} />
            <Route
              path="createta"
              element={<CreateTAPage page="Create TA" />}
            />
            <Route path="AddEditTA" element={<AddEditTA page="Edit Ta" />} />
            <Route
              path="ta-mapping"
              element={<TaMapping page="TA Mapping" />}
            />
            <Route
              path="/active-students/:id"
              element={<AssignedStudent page="Assigned Students" />}
            />
            <Route
              path="/active-batches/:id"
              element={<AssignedBatches page="Assigned Batches" />}
            />
            <Route
              path="/active-Coach-batches/:id"
              element={<AssignCoachBatches page="Assigned Coach Batches"/>}
            />
            <Route
              path="/active-Coach-students/:id"
              element={<AssignCoachStudent page="Assigned Coach Student" />}
            />
            <Route
              path="ta-availability"
              element={<TAAvailability page="TA Availability" />}
            />
            <Route
              path="ta-scheduling"
              element={<TaScheduling page="TA Scheduling" />}
            />
            <Route
              path="ta-calendar/:name/:id"
              element={<TaCalender page="Calendar" />}
            />
            {/* <Route path='calendar' element={<Calendar page="Calendar" />} /> */}
            <Route
              path="coach-manage"
              element={<ManageCoaches page="Manage Coaches" />}
            />
            <Route
              path="createcoach"
              element={<CreateCoachPage page="Create Coach" />}
            />
            <Route
              path="coach-mapping"
              element={<CoachMapping page="Coach Mapping" />}
            />
            <Route
              path="coach-manage/tacalender"
              element={<CoachCalender />}
            />
            <Route
              path="coach-template"
              element={<CoachTemplate page="Coach Template" />}
            />

            <Route
              path="create-template"
              element={<CreateTemplate page="Create Template" />}
            />
            <Route
              path="template-name"
              element={<TemplateName page="Template Name" />}
            />
            <Route
              path="coach-availability"
              element={<CoachAvialability page="Coach Availability" />}
            />
            <Route
              path="coach-scheduling"
              element={<CoachScheduling page="Coach Scheduling" />}
            />
            <Route path="students" element={<StudentPage />} />
            <Route path="batches" element={<BatchPage />} />
            {/* <Route path='/student-list' element={<StudentList page="Student" />} /> */}
            <Route path="coaching-tools" element={<WheelOfLife />} />
          </Route>
        </Route>

        <Route element={<RequireAuth allowedRoles={[ROLES.Teaching]} />}>
          <Route path="/" element={<Main page="Teaching Assistant" />}>
            <Route
              path="my-profile"
              element={<MyProfile page="My Profile" />}
            />
            <Route
              path="my-student"
              element={<Mystudents page="My Students" />}
            />
            <Route
              path="my-calender"
              element={<MyCalender page="My Calender" />}
            />
            <Route
              path="schedule-calls"
              element={<ScheduledCalls page="Schedule Calls" />}
            />
            <Route
              path="call-requests"
              element={<CallRequest page="Call Request" />}
            />
            <Route path="messages" element={<Messages page="Messages" />} />
            <Route
              path="call-records"
              element={<CallRecords page="Call Records" />}
            />
          </Route>
        </Route>

        <Route element={<RequireAuth allowedRoles={[ROLES.Coaches]} />}>
          <Route path="/" element={<Main page="Manage Coaches" />}></Route>
        </Route>

        <Route element={<RequireAuth allowedRoles={[ROLES.Coaches]} />}></Route>

        {/* Missed */}
        <Route path="*" element={<AllRoutes />} />
      </Route>
    </Routes>
  );
}

export default App;

// Previous changes

{
  /* <div className="App">
<Grid container spacing={0.5}>
  <Grid item xs={12}>
    <Header />
  </Grid>
  <Grid item xs={2} sx={{ background: 'linear-gradient(to bottom, #362f9c, #7931a3)', height: '90vh'}}>
      <Sidebar />
  </Grid>
  <Grid item xs={10}>
    <ManagesTAs/>
  </Grid>
</Grid>
</div> */
}
