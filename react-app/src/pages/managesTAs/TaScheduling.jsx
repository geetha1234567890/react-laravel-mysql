import { Box, InputBase, Button, Modal, Typography } from '@mui/material';
import { DataGrid } from "@mui/x-data-grid";
import { mockMappingDat } from '../../fakeData/mappingData';
import Header from "../../components/Header/Header";
import Sidebar from "../../components/Sidebar/Sidebar";
import { useEffect, useState } from "react";
import { OnOffSwitch } from '../../components/Switch';
import editIcon from '../../assets/editIcon.png';
import { useNavigate } from 'react-router-dom';
import DynamicTable from '../../components/CommonComponent/DynamicTable';
import { useDispatch, useSelector } from 'react-redux';
import { showTASchedule } from '../../redux/features/taModule/taScheduling';
import Schedule from '../../components/availability/Schedule';
import AssignStudents from '../../components/adminModule/AssignStudents';
import AssignBatches from '../../components/adminModule/AssignBatches';

const TaScheduling = () => {
  const dispatch = useDispatch();
  const { assignStudentOpen, assignBatchOpen, loading } = useSelector((state) => state.taModule);
  const { taSchedule, scheduleSessionOpen } = useSelector((state) => state.taScheduling);
  const [taScheduleData, setTaScheduleData] = useState([]);

  useEffect(() => {
    dispatch(showTASchedule());
  }, [dispatch]);

  useEffect(() => {
    console.log("TASCHEDULE : ", taSchedule)
    if (taSchedule && taSchedule.length > 0) {
      const transformData = taSchedule.map((item, index) => ({
        id: item.ta_data.id,
        name: item.ta_data.name,
        Username: item.ta_data.username,
        Active_Students: item.students,
        Active_Batches: item.batches,
        // Active_Students: item.Active_Students,
        // Active_Batches: item.Active_Batches,
      }));

      setTaScheduleData(transformData);
    }
  }, [taSchedule]);

  const headers = ["S. No.", "TA Name", "Username", "Active Students", "Active Batches", "Action"];

  const actionButtons = [
    {
      type: 'calendar',
    }
  ];

  return (
    <>
      <Header />
      <Sidebar />
      <Box display={"flex"} justifyContent={"space-between"} marginTop={3} alignItems={"center"}>
        <p style={{ fontSize: "44px", justifyContent: "center" }}>TA Scheduling </p>
      </Box>
      <DynamicTable
        headers={headers}
        initialData={taScheduleData}
        actionButtons={actionButtons}
      />
      {scheduleSessionOpen && <Schedule />}
      {assignStudentOpen && <AssignStudents />}
      {assignBatchOpen && <AssignBatches />}
    </>
  );
}

export default TaScheduling;
