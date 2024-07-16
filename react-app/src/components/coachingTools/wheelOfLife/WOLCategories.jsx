import React from 'react'
import Header from '../../Header/Header';
import Sidebar from '../../Sidebar/Sidebar';
import DynamicTable from '../../CommonComponent/DynamicTable';

const WOLCategories = () => {

    const headers = ['S. No.', 'Wheel Of Life Category', 'Action'];

    const dummyData = [
        { category: 'Health' },
        { category: 'Wealth' },
        { category: 'Family' },
        { category: 'Friends' },
        { category: 'Romance' },
        { category: 'Personal Growth' },
        { category: 'Fun & Recreation' },
        { category: 'Physical Environment' },
    ];

    const actionButtons = [
        {
            type: 'edit',
            onClick: (id) => {
                console.log('Edit', id)
            }
        },
        {
            type: 'delete',
            onClick: (id) => {
                console.log('Delete', id)
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
                        Wheel Of Life Categories
                    </p>
                    <div className='inputBtnContainer'>
                        <button className='buttonContainer'>
                            <i className="fas fa-plus"></i>    
                            <span>Add New WOL Category</span>
                        </button>
                    </div>
                </Box>
                {dummyData.length > 0 ? (
                    <DynamicTable
                        headers={headers}
                        initialData={dummyData}
                        actionButtons={actionButtons}
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

export default WOLCategories