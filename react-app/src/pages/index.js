import Login from './components/AUTH/Login'
import LinkPage from './components/AUTH/LinkPage'
import Unauthorized from './components/AUTH/Unauthorized'
import RequireAuth from './components/Hooks/RequireAuth'
import Dashboard from './components/Dashboard'
import ManagesTAs from './pages/managesTAs/ManagesTAs';
import TAAvailability from './pages/managesTAs/TaAvaialablity'
import ManageCoaches from './pages/ManageCoaches/ManageCoaches';
import CoachMapping from './pages/ManageCoaches/CoachMapping';
import CoachTemplate from './pages/ManageCoaches/CoachTemplate';
import CoachAvialability from './pages/ManageCoaches/CoachAvialability';
import CoachScheduling from './pages/ManageCoaches/CoachScheduling';
import AllRoutes from './components/AllRoutes/AllRoutes'
import TaMapping from './pages/managesTAs/TaMapping';
import TaScheduling from './pages/managesTAs/TaScheduling';
import Calendar from './components/Calender/indexCalender';
import StudentPage from './pages/students/StudentPage';
import MyProfile from './components/RoleRoute/CommonComponent/MyProfile';
import CallRecords from './components/RoleRoute/CommonComponent/CallRecords';
import Messages from './components/RoleRoute/CommonComponent/Messages';
import CallRequest from './components/RoleRoute/CommonComponent/CallRequest';
import ScheduledCalls from './components/RoleRoute/CommonComponent/ScheduledCalls';
import MyCalender from './components/RoleRoute/CommonComponent/MyCalender';
import Mystudents from './components/RoleRoute/CommonComponent/Mystudents';



export { Login, LinkPage, Unauthorized, RequireAuth, Dashboard, ManagesTAs, TAAvailability, ManageCoaches, CoachMapping, CoachTemplate, CoachAvialability, CoachScheduling, AllRoutes, TaMapping };