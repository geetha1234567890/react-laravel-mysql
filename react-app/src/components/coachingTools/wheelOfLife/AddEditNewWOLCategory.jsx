import React, { useEffect } from 'react'
import ReusableDialog from '../../CustomFields/ReusableDialog'
import { Grid } from '@mui/material'
import CustomTextField from '../../CustomFields/CustomTextField'

const AddEditNewWOLCategory = (data) => {
    const [categoryName, setCategoryName] = useState("")

    const handleSubmit = () => {
        console.log('Submit')
        if(data){
            console.log('Edit')
        } 
        console.log('Add')
    }

    useEffect(() => {
        console.log(data)
        if(data){
            setCategoryName(data.category)
        }
    }, [data])

    const actions = (
        <Button
            onClick={handleSubmit}
            style={{
                backgroundColor: "#F56D3B",
                borderColor: "#F56D3B",
                color: "#FFFFFF",
            }}
        >
            Submit
        </Button>
    )

    const content = (
        <Grid container spacing={2} justifyContent="center">
            <Grid item sm={6}>
                <CustomTextField
                    label="WOL Category"
                    value={categoryName}
                    onChange={(e) => setCategoryName(e.target.value)}
                />
            </Grid>
        </Grid>
    )

    return (
        <ReusableDialog
            open={""}
            handleClose={""}
            title="Add New WOL Category"
            actions={actions}
        />
    )
}

export default AddEditNewWOLCategory