import React, { useEffect, useState } from "react";
import { useForm, Controller } from "react-hook-form";
import "bootstrap/dist/css/bootstrap.min.css";
import moment from "moment-timezone";
import { useDispatch , useSelector } from "react-redux";
import {
  Box,
  Button,
  Typography,
  Grid,
  DialogActions,
  Divider,
} from "@mui/material";
import {
  closeSuccessPopup,
  createCoach,
  openAssignBatches,
  openAssignStudents,
  openSuccessPopup,
  updateCoach,
  accessCoachName,
} from "../../../../redux/features/CoachModule/coachSlice";
import CloseIcon from "@mui/icons-material/Close";
import { PhotoCamera } from "@mui/icons-material";
import AssignStudents from "../../AssignStudents";
import AssignCoachBatches from "../../../../pages/ManageCoaches/AssignedCoachBatches";
import dayjs from "dayjs";
import PhoneInput from "react-phone-input-2";
import "react-phone-input-2/lib/style.css";
import SubmitPopup from "../../SubmitPopup";
import CustomTextField from "../../../CustomFields/CustomTextField";
import CustomFormControl from "../../../CustomFields/CustomFromControl";
import CustomDateField from "../../../CustomFields/CustomDateField";
import AvatarInput from "../../../CustomFields/AvatarInput";
import {
  genders,
  qualificationOptions,
  transformedTimeZones
} from "../../../CustomFields/FormOptions";
import ReusableDialog from "../../../CustomFields/ReusableDialog";
import Header from "../../../Header/Header";
import Sidebar from "../../../Sidebar/Sidebar";

function AddEditCoach({ data }) {
  const {
    register,
    handleSubmit,
    control,
    setValue,
    watch,
    formState: { errors },
  } = useForm({
    defaultValues: {
      gender: "",
      time_zone: "",
      highest_qualification: "",
      date_of_birth: null,
    },
  });
  
  const [selectedImage, setSelectedImage] = useState(null);
  const [open, setOpen] = useState(false);
  const [phoneNumber, setPhoneNumber] = useState("");
  const [assignStudent, setAssignStudent] = useState(false);
  const [assignBatch, setAssignBatch] = useState(false);
  const [edit, setEdit] = useState(false);
  const dispatch = useDispatch();
  const [dateOfBirth, setDateOfBirth] = useState(null);
  const [taName, setTAName] = useState();
  const {  successPopup, assignStudentOpen, assignBatchOpen } = useSelector((state) => state.coachModule);

  useEffect(() => {
    if (data) {
      console.log("data",data);
      const formattedDate = dayjs(dateOfBirth).format("YYYY-MM-DD HH:mm:ss");
      console.log("DATE birth : ", data.date_of_birth);

      //convert base64 image to blob
      if (data.profile_picture) {
        const byteCharacters = atob(data.profile_picture);
        const byteNumbers = new Array(byteCharacters.length);
        for (let i = 0; i < byteCharacters.length; i++) {
          byteNumbers[i] = byteCharacters.charCodeAt(i);
        }
        const byteArray = new Uint8Array(byteNumbers);
        const blob = new Blob([byteArray], { type: "image/jpeg" });
        const blobUrl = URL.createObjectURL(blob);

        console.log("blobUrl", blobUrl);
        setSelectedImage(blobUrl);
      }

      setValue("name", data.name);
      // setValue("short_description", data.short_description);
      setValue("username", data.username);
      setValue("password", data.password);
      setValue("location", data.location);
      setValue("address", data.address);
      setValue("pincode", data.pincode);
      setValue("time_zone", data.time_zone);
      setValue("gender", data.gender);
      setValue("email", data.email);
      setValue("date_of_birth", data.date_of_birth);
      setDateOfBirth(data.date_of_birth);
      setValue("highest_qualification", data.highest_qualification);
      setValue("about_me", data.about_me);
      setPhoneNumber(data.phone);

    }
  }, [data, setValue, setSelectedImage]);
  const handleFileChange = (e) => {
    const file = e.target.files[0];
    const reader = new FileReader();

    reader.onloadend = () => {
      setSelectedImage(reader.result);
    };

    if (file) {
      reader.readAsDataURL(file);
    }
  };

  const handleAssignStudents = () => {
    setAssignStudent(true);
  };

  const handleAssignBatches = () => {
    setAssignBatch(true);
  };

  const handleClose = () => {
    setOpen(false);
    setAssignStudent(false);
    setAssignBatch(false);
  };

  const onSubmit = async (coachData) => {
    console.log("Data", data);
    console.log("Coach Data", coachData);

    setTAName(coachData.name);
    const formattedDate = dayjs(dateOfBirth).format("YYYY-MM-DD HH:mm:ss");
    coachData.date_of_birth = formattedDate;

    if (selectedImage instanceof Blob || selectedImage instanceof File) {
      const reader = new FileReader();
      reader.onloadend = () => {
        coachData.profile_picture = reader.result;
      };
    }
    console.log("Selected Image", selectedImage);
    coachData.profile_picture = selectedImage;

    if (data) {
      console.log("editing Id", data.id, "editing Data", data);
      const updateRes = await dispatch(
        updateCoach({ id: data.id, data: data })
      ).unwrap();
      // console.log("Updated : ", updateRes);
      // console.log("Updated Name: ", updateRes.username);
      dispatch(openSuccessPopup());
      dispatch(accessCoachName(updateRes.username));
    } else {
      const createRes = await dispatch(createCoach(coachData)).unwrap();
      // console.log("Created : ", createRes);
      console.log("Created Name: ", createRes.coach);
      dispatch(openSuccessPopup());
      dispatch(accessCoachName(createRes.coach));
    }
  };
  const actions = (
    <>
      <Button
        variant="contained"
        onClick={handleAssignStudents}
        sx={{
          backgroundColor: "#F56D3B",
          color: "white",
          borderRadius: "50px",
          textTransform: "none",
          padding: "10px 20px",
          fontWeight: "700",
          fontSize: "16px",
          "&:hover": {
            backgroundColor: "#D4522A",
          },
        }}
      >
        Assign Students
      </Button>
      <Button
        variant="outlined"
        onClick={handleAssignBatches}
        sx={{
          backgroundColor: "white",
          color: "#F56D3B",
          border: "2px solid #F56D3B",
          borderRadius: "50px",
          textTransform: "none",
          fontWeight: "700",
          fontSize: "16px",
          padding: "10px 20px",
          "&:hover": {
            backgroundColor: "#F56D3B",
            color: "white",
          },
        }}
      >
        Assign Batches
      </Button>
    </>
  );

  return (
  <>
  <Header/>
  <Sidebar/>
    <Box sx={{ bgcolor: "#f8f9fa", p: 3 }}>
      <DialogActions sx={{ p: 2 }}>
        <Grid container alignItems="center">
          {edit ? (
            <>
              <Grid item xs>
                <Typography variant="h4" sx={{ mb: 4 }}>
                  Edit Coach
                </Typography>
              </Grid>
              <Grid item>
                <Box display="flex" justifyContent="center" gap={2}>
                  <Button
                    variant="contained"
                    onClick={handleAssignStudents}
                    sx={{
                      backgroundColor: "#F56D3B",
                      color: "white",
                      height: "60px",
                      width: "201px",
                      borderRadius: "50px",
                      textTransform: "none",
                      padding: "18px 30px",
                      fontWeight: "700",
                      fontSize: "16px",
                      "&:hover": {
                        //backgroundColor: '#D4522A'
                      },
                    }}
                  >
                    Assign Students
                  </Button>
                  <Button
                    variant="outlined"
                    onClick={handleAssignBatches}
                    sx={{
                      backgroundColor: "white",
                      color: "#F56D3B",
                      height: "60px",
                      width: "194px",
                      border: "2px solid #F56D3B",
                      borderRadius: "50px",
                      textTransform: "none",
                      fontWeight: "700",
                      fontSize: "16px",
                      padding: "18px 30px",
                      "&:hover": {
                        //backgroundColor: '#F56D3B',
                        //color: 'white'
                      },
                    }}
                  >
                    Assign Batches
                  </Button>
                </Box>
              </Grid>
            </>
          ) : (
            <Grid item xs>
              <Typography variant="h4" sx={{ mb: 4 }}>
                Create Coach
              </Typography>
            </Grid>
          )}
        </Grid>
      </DialogActions>

      <Box
        sx={{
          bgcolor: "white",
          borderRadius: 2,
          p: 4,
          boxShadow: 3,
          maxWidth: 1400,
          mx: "auto",
        }}
      >
        <Box display="flex " alignItems="center" mb={4}>
          <Box position="relative" display="inline-flex" flexDirection="column">
          <AvatarInput
              name="x_picture"
              selectedImage={selectedImage}
              setSelectedImage={setSelectedImage}
            />
          </Box>
          <Box ml={4}>
            <Typography
              variant="h5"
              sx={{
                fontSize: "24px",
                fontWeight: "600",
                font: "Nohemi",
                color: "#1A1E3D",
              }}
            >
              Name of the Coach
            </Typography>
            <Typography
              variant="body2"
              sx={{
                fontSize: "16px",
                fontWeight: "400",
                mb: 4,
                color: "#5F6383",
                font: "Nohemi",
              }}
            >
              Short Description
            </Typography>
          </Box>
        </Box>
        <Divider sx={{ mt: 2, mb: 4, border: "1px solid #C2C2E7" }} />

        <form onSubmit={handleSubmit(onSubmit)} noValidate>
          <Grid container spacing={6}>
            <Grid item xs={12} sm={6} md={4}>
              <CustomTextField
                label="Coach Name"
                name="name"
                placeholder="Enter Coach Name"
                register={register}
                validation={{
                  required: "Username is required",
                  minLength: {
                    value: 3,
                    message: "Username must be at least 3 characters long",
                  },
                  maxLength: {
                    value: 20,
                    message: "Username cannot exceed 20 characters",
                  },
                  pattern: {
                    value: /^[A-Za-z0-9_]+$/,
                    message:
                      "Username can only contain letters, numbers, and underscores",
                  },
                }}
                errors={errors}
                error={!!errors.coachname}
                helperText={errors.coachname?.message}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={4}>
              <CustomTextField
                label="Username"
                name="username"
                placeholder="Enter Username"
                register={register}
                validation={{
                  required: "Username is required",
                  minLength: {
                    value: 3,
                    message: "Username must be at least 3 characters long",
                  },
                  maxLength: {
                    value: 20,
                    message: "Username cannot exceed 20 characters",
                  },
                  pattern: {
                    value: /^[A-Za-z0-9_]+$/,
                    message:
                      "Username can only contain letters, numbers, and underscores",
                  },
                }}
                errors={errors}
                helperText={errors.username?.message}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={4}>
              <CustomTextField
                label="Password"
                name="password"
                type="password"
                placeholder="Enter Password"
                register={register}
                validation={{
                  required: "Password is required",
                  minLength: {
                    value: 8,
                    message: "Password must be at least 8 characters long",
                  },
                  maxLength: {
                    value: 20,
                    message: "Password cannot exceed 20 characters",
                  },
                  pattern: {
                    value:
                      /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/,
                    message:
                      "Password must include at least one uppercase letter, one lowercase letter, one number, and one special character",
                  },
                }}
                errors={errors}
                helperText={errors.password?.message}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={4}>
              <CustomTextField
                label="Address"
                name="address"
                register={register}
                validation={{
                  required: "Address is required",
                  maxLength: {
                    value: 200,
                    message: "Address must not exceed 200 characters",
                  },
                }}
                errors={errors}
                helperText={errors.address?.message}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={4}>
              <CustomTextField
                label="Location"
                name="location"
                placeholder="Enter Location"
                register={register}
                validation={{
                  required: "Location is required",
                  maxLength: {
                    value: 200,
                    message: "Location must not exceed 200 characters",
                  },
                }}
                errors={errors}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={4}>
              <CustomTextField
                label="PIN Code"
                name="pincode"
                placeholder="Enter PIN Code"
                register={register}
                validation={{
                  required: "PIN Code is required",
                  pattern: {
                    value: /^[a-zA-Z0-9-]*$/,
                    message: "PIN Code must be alphanumeric",
                  },
                  minLength: {
                    value: 3,
                    message: "PIN Code must be at least 3 characters long",
                  },
                  maxLength: {
                    value: 10,
                    message: "PIN Code cannot exceed 10 characters",
                  },
                }}
                errors={errors}
                helperText={errors.pinCode?.message}
              />
            </Grid>
          
            <Grid item xs={12} sm={6} md={4}>
              <Controller
                name="time_zone"
                control={control}
                rules={{ required: "Time Zone is required" }}
                render={({ field }) => (
                  <CustomFormControl
                    label="Time Zone"
                    name="time_zone"
                    value={field.value}
                    onChange={field.onChange}
                    errors={errors}
                    options={transformedTimeZones}
                  />
                )}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={4}>
              <Controller
                name="gender"
                control={control}
                rules={{ required: "Gender is required" }}
                render={({ field }) => (
                  <CustomFormControl
                    label="Gender"
                    name="gender"
                    value={field.value}
                    onChange={field.onChange}
                    errors={errors}
                    options={genders}
                  />
                )}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={4}>
              <CustomDateField
                label="Date Of Birth"
                value={dateOfBirth}
                onChange={setDateOfBirth}
                name="dateOfBirth"
                register={register}
                validation={{ required: "Date of birth is required" }}
                errors={errors}
                sx={{ width: "100%" }}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={4}>
              <Controller
                name="highest_qualification"
                control={control}
                rules={{ required: "Highest Qualification is required" }}
                render={({ field }) => (
                  <CustomFormControl
                    label="Highest Qualification"
                    name="highest_qualification"
                    value={field.value}
                    onChange={field.onChange}
                    errors={errors}
                    options={qualificationOptions}
                  />
                )}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={4}>
              <CustomTextField
                label="Email Address"
                name="email"
                placeholder="Enter Email Address"
                register={register}
                validation={{
                  required: "Email is required",
                  pattern: {
                    value: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
                    message: "Invalid email address",
                  },
                }}
                errors={errors}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={4}>
              <Controller
                name="phone"
                control={control}
                rules={{ required: "Phone number is required" }} // Setting validation rules
                render={({ field }) => (
                  <PhoneInput
                    country={"in"}
                    value={field.value} // Binding the value to the field value
                    onChange={field.onChange} // Handling the onChange event
                    containerStyle={{ width: "100%" }}
                    inputStyle={{
                      width: "100%",
                      borderRadius: "50px",
                      borderColor: "#D0D0EC",
                      height: "60px",
                    }}
                    buttonStyle={{
                      borderRadius: "50px 0 0 50px",
                      height: "60px",
                      paddingLeft: "10px",
                    }}
                  />
                )}
              />
            </Grid>
            <Grid item xs={12}>
              <CustomTextField
                label="About Me"
                name="about_me"
                type="text"
                placeholder="Enter About Coach"
                multiline
                rows={4}
                register={register}
                validation={{ required: "About Me is required" }}
                errors={errors}
                helperText={errors.aboutMe?.message}
              />
            </Grid>
          </Grid>
          <Button
            type="submit"
            variant="contained"
            style={{
              borderRadius: "50px",
              padding: "18px 30px",
              marginTop: 30,
              backgroundColor: "#F56D3B",
              height: "60px",
              width: "121px",
              fontSize: "16px",
              fontWeight: "700px",
              text: "#FFFFFF",
            }}
            
          >
            Submit
          </Button>
        </form>
        {/* <ReusableDialog
          open={open}
          handleClose={handleClose}
          title="'Coach' successfully created."
          actions={actions}
        /> */}
        {successPopup && <SubmitPopup componentname={"ADDITCOACH"} />}
       
       
        {assignStudentOpen && <AssignStudents />}
        {assignBatchOpen && <AssignCoachBatches />}
      </Box>
    </Box>
  </>
  );
}

export default AddEditCoach;
