import React from 'react'
import AddEditCoach from '../../components/adminModule/coaches/manageCoaches/AddEditCoach'
import Header from '../../components/Header/Header'
import Sidebar from '../../components/Sidebar/Sidebar'

const CreateCoachPage = () => {
    return (
        <>
        <Header />
        <Sidebar />
        <AddEditCoach />
        </>
    )
}

export default CreateCoachPage