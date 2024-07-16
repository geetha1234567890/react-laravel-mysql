import React from 'react'
import Header from '../../../components/Header/Header';
import Sidebar from '../../../components/Sidebar/Sidebar';
import DynamicTable from '../../../components/CommonComponent/DynamicTable';
import { Box } from '@mui/material';

const headers = ['S. No.', 'Student Name', 'Batch', 'Attempted On', 'View Report'];

const dummyData = [
    { studentName: 'John Doe', batch: 'Batch 1', attemptedOn: '12/12/2021' },
    { studentName: 'Jane Doe', batch: 'Batch 2', attemptedOn: '12/12/2021' },
    { studentName: 'John Doe', batch: 'Batch 1', attemptedOn: '12/12/2021' },
    { studentName: 'Jane Doe', batch: 'Batch 2', attemptedOn: '12/12/2021' },
    { studentName: 'John Doe', batch: 'Batch 1', attemptedOn: '12/12/2021' },
    { studentName: 'Jane Doe', batch: 'Batch 2', attemptedOn: '12/12/2021' },
    { studentName: 'John Doe', batch: 'Batch 1', attemptedOn: '12/12/2021' },
    { studentName: 'Jane Doe', batch: 'Batch 2', attemptedOn: '12/12/2021' },
    { studentName: 'John Doe', batch: 'Batch 1', attemptedOn: '12/12/2021' },
    { studentName: 'Jane Doe', batch: 'Batch 2', attemptedOn: '12/12/2021' }
];

const WheelOfLife = () => {

    const actionButtons = [
        {
            type: 'view',
            onClick: (id) => {
                console.log('View Report', id)
            }
        }
    ]

    return (
        <>
            <Header />
            <Sidebar />
            <>
                <Box display="flex" justifyContent="space-between" marginTop={3} alignItems={"center"}>
                    <p style={{ fontSize: "44px", justifyContent: "center" }}>
                        Wheel Of Life
                    </p>
                    <div className='inputBtnContainer'>
                        <button className='buttonContainer'>WOL Categories</button>
                        <button className='buttonContainer'>WOL Instructions</button>
                        <button className='buttonContainer'>WOL Questions</button>
                        <button className='buttonContainer'>WOL Options Config</button>
                        <button className='buttonContainer'>WOL Test Config</button>
                    </div>
                </Box>
                {dummyData.length > 0 ? (
                    <DynamicTable
                        headers={headers}
                        initialData={dummyData}
                        actionButtons={actionButtons}
                    //componentName={"WOL"}
                    />
                ) : (
                    <div>
                        <p>No Data Available</p>
                    </div>
                )}
            </>
        </>
    )
}

export default WheelOfLife