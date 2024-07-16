import React from 'react'
import Header from '../../../components/Header/Header'
import Sidebar from '../../../components/Sidebar/Sidebar'
import { Box } from '@mui/material'
import CoachTemplateForm from './TemplateForm/CoachTemplateFrom'

const CreateTemplate = () => {
  return (
    <>
        <Header />
        <Sidebar />
        <Box
          display={"flex"}
          justifyContent={"space-between"}
          marginTop={3}
          alignItems={"center"}
        >
          <p style={{ fontSize: "44px", justifyContent: "center" }}>
            Creating Template
          </p>
          
        </Box>
        <CoachTemplateForm />
    </>
  )
}

export default CreateTemplate