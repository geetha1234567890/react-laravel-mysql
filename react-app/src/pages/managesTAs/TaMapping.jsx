import React, { useEffect, useState } from "react";
import { Box } from "@mui/material";
import { useDispatch, useSelector } from "react-redux";
import { showTAMapping } from "../../redux/features/taModule/taSlice";
import Header from "../../components/Header/Header";
import Sidebar from "../../components/Sidebar/Sidebar";
import DynamicTable from "../../components/CommonComponent/DynamicTable";
import { mockMappingDat } from "../../fakeData/mappingData";

const headers = [
  "S. No.",
  "TA Name",
  "Username",
  "Active Students",
  "Active Batches",
  "Actions",
];

const actionButtons = [
  // {
  //   type: "switch",
  // },
  {
    type: "delete",
    onClick: (id) => console.log(`Delete clicked for id ${id}`),
  },
];

const TaMapping = () => {
  const dispatch = useDispatch();
  const { taMapping, loading } = useSelector((state) => state.taModule);
  const [taMappingData, setTaMappingData] = useState([]);
  console.log("tamapping " ,taMapping);

  useEffect(() => {
    dispatch(showTAMapping());
  }, [dispatch]);

  useEffect(() => {
    if (taMapping && taMapping.length > 0) {
      const transformData = taMapping.map((item, index) => ({
        id: item.id,
        name: item.name,
        Username: item.username,
        Active_Students: item.Active_Students,
        Active_Batches: item.Active_Batches,
      }));

      setTaMappingData(transformData);
    }
  }, [taMapping]);

  return (
    <>
      <Header />
      <Sidebar />
      <Box display={"flex"} justifyContent={"space-between"} marginTop={3}>
        <p
          style={{
            fontSize: "44px",
            justifyContent: "center",
            marginBottom: "20px",
            fontFamily:"ExtraLight"
          }}
        >
          TA Mapping
        </p>
      </Box>
      <DynamicTable
        headers={headers}
        initialData={taMappingData}
        actionButtons={actionButtons}
        componentName={"TAMAPPING"}
      />
    </>
  );
};

export default TaMapping;
