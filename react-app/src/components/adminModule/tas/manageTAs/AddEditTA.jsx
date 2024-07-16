import React, { useEffect, useState } from "react";
import { useForm, Controller } from "react-hook-form";
import "bootstrap/dist/css/bootstrap.min.css";
import "./AddEdit.css";
import moment from "moment";
import { useDispatch, useSelector } from "react-redux";
import {
  Box,
  Button,
  Typography,
  Grid,
  DialogActions,
  Divider,
} from "@mui/material";
import AssignStudents from "../../AssignStudents";
import AssignBatches from "../../AssignBatches";
import CustomFormControl from "../../../CustomFields/CustomFromControl";
import CustomTextField from "../../../CustomFields/CustomTextField";
import {
  transformedTimeZones,
  genders,
  qualificationOptions,
  validateTimeZone,
} from "../../../CustomFields/FormOptions";
import CustomDateField from "../../../CustomFields/CustomDateField";
import {
  closeSuccessPopup,
  createTA,
  openAssignBatches,
  openAssignStudents,
  openSuccessPopup,
  updateTA,
  accessTaName,
} from "../../../../redux/features/taModule/taSlice";
import SubmitPopup from "../../SubmitPopup";
import dayjs from "dayjs";
import AvatarInput from "../../../CustomFields/AvatarInput";
import PhoneInput from "react-phone-input-2";
import "react-phone-input-2/lib/style.css";

const AddEditTA = ({ data }) => {
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
  // const [taName, setTAName] = useState("");
  const [dateOfBirth, setDateOfBirth] = useState(null);
  const [phoneNumber, setPhoneNumber] = useState("");
  const dispatch = useDispatch();
  const { successPopup, assignStudentOpen, assignBatchOpen } = useSelector(
    (state) => state.taModule
  );

  useEffect(() => {
    if (data) {
      console.log("data",data);
      const formattedDate = moment(data.date_of_birth).format("YYYY-MM-DD");
      setDateOfBirth(formattedDate);
      dispatch(accessTaName(data));

      // Convert base64 image to blob
      if (data.profile_picture) {
        const byteCharacters = atob(data.profile_picture);
        const byteNumbers = Array.from(byteCharacters, (char) =>
          char.charCodeAt(0)
        );
        const byteArray = new Uint8Array(byteNumbers);
        const blob = new Blob([byteArray], { type: "image/jpeg" });
        const blobUrl = URL.createObjectURL(blob);
        setSelectedImage(blobUrl);
      }

      setValue("name", data.name);
      setValue("username", data.username);
      setValue("password", data.password);
      setValue("location", data.location);
      setValue("address", data.address);
      setValue("pincode", data.pincode);
      setValue("time_zone", data.time_zone);
      setValue("gender", data.gender);
      setValue("email", data.email);
      setValue("date_of_birth", formattedDate);
      setValue("highest_qualification", data.highest_qualification);
      setValue("about_me", data.about_me);
      setPhoneNumber(data.phone);
    }
  }, [data, setValue, dispatch]);

  const handleAssignStudents = () => {
    dispatch(openAssignStudents());
  };

  const handleAssignBatches = () => {
    dispatch(openAssignBatches());
  };

  const onSubmit = async (formData) => {
    // setTAName(formData.name);

    const { email, time_zone, ...updatedFormData } = formData;

    updatedFormData.date_of_birth = dateOfBirth;
    updatedFormData.phone = phoneNumber;

    if (selectedImage) {
      const base64Data = selectedImage.replace(
        /^data:image\/(png|jpeg|jpg);base64,/,
        ""
      );
      updatedFormData.profile_picture = base64Data;
    }

    try {
      if (data) {
        const updateRes = await dispatch(
          updateTA({ id: data.id, data: updatedFormData })
        ).unwrap();
        console.log("UPDATE RES : ", updateRes)
        dispatch(openSuccessPopup());
        dispatch(accessTaName(updateRes));
      } else {
        
        updatedFormData.email = email
        updatedFormData.time_zone = time_zone
        const createRes = await dispatch(createTA(updatedFormData)).unwrap();
        dispatch(openSuccessPopup());
        dispatch(accessTaName(createRes.ta));
      }
    } catch (error) {
      console.error("Error submitting form:", error);
    }
  };

  const nameValue = watch("name", "");
  const aboutMeValue = watch("about_me", "");

  const handleDateChange = (date, field) => {
    const formattedDate = date ? moment(date).format("YYYY-MM-DD") : "";
    setDateOfBirth(formattedDate);
    field.onChange(formattedDate);
  };

  return (
    <Box sx={{ p: 3 }}>
      <DialogActions>
        <Grid container alignItems="center">
          {data ? (
            <>
              <Grid item xs>
                <Typography variant="h4" sx={{ mb: 4, font: "Nunito Sans" }}>
                  Edit TA
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
                Create TA
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
          mx: "auto",
        }}
      >
        <form onSubmit={handleSubmit(onSubmit)} noValidate>
          <Box display="flex " alignItems="center" mb={4}>
            <AvatarInput
              name="x_picture"
              selectedImage={selectedImage}
              setSelectedImage={setSelectedImage}
            />
            <Box ml={4}>
              <Typography
                variant="h5"
                sx={{
                  fontSize: "24px",
                  fontWeight: "600",
                  font: "Nunito Sans",
                  color: "#1A1E3D",
                }}
              >
                {nameValue || "Name of the TA"}
              </Typography>
              <Typography
                variant="body2"
                sx={{
                  fontSize: "16px",
                  fontWeight: "400",
                  mb: 4,
                  color: "#5F6383",
                  font: "Nunito Sans",
                }}
              >
                {aboutMeValue || "Short Description"}
              </Typography>
              {/* <CustomTextField
                label="Short Description"
                name="short_description"
                placeholder="Enter About TA"
                register={register}
                validation={{ required: "About Me is required" }}
                errors={errors}
                multiline
                rows={2}
                sx={{ width: "400px" }}
              /> */}
            </Box>
          </Box>
          <Divider sx={{ mt: 2, mb: 4, border: "1px solid #C2C2E7" }} />

          <Grid container spacing={6}>
            <Grid item xs={12} sm={6} md={4}>
              {/* TA name */}
              <CustomTextField
                label="TA Name"
                name="name"
                placeholder="Enter TA Name"
                register={register}
                validation={{
                  required: "Name is required",
                  minLength: {
                    value: 3,
                    message: "Name must be at least 3 characters long",
                  },
                  pattern: {
                    value: /^[A-Za-z\s]+$/,
                    message: "Name must contain only letters and spaces",
                  },
                }}
                errors={errors}
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
                    // value: /^[A-Za-z0-9_]+$/,
                    message:
                      "Username can only contain letters, numbers, and underscores",
                  },
                }}
                errors={errors}
              />
            </Grid>

            {!data && (
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
                />
              </Grid>
            )}

            <Grid item xs={12} sm={6} md={4}>
              <CustomTextField
                label="Address"
                name="address"
                placeholder="Enter Address"
                register={register}
                validation={{
                  required: "Address is required",
                  maxLength: {
                    value: 200,
                    message: "Address must not exceed 200 characters",
                  },
                }}
                errors={errors}
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
                type="number"
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
              />
            </Grid>
            {/* {console.log("DATA : ", data)} */}

            <Grid item xs={12} sm={6} md={4}>
              <Controller
                control={control}
                name="date_of_birth"
                render={({ field }) => (
                  <CustomDateField
                    label="Date of Birth"
                    name="date_of_birth"
                    value={dateOfBirth}
                    onChange={(date) => handleDateChange(date, field)}
                    error={!!errors.date_of_birth}
                    helperText={errors.date_of_birth?.message}
                  />
                )}
                rules={{ required: "Date of Birth is required" }}
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
            {/* <Grid item xs={12} sm={6} md={4}>
              <CustomDateField
                label="Date Of Birth"
                value={
                  data
                    ? moment(data.date_of_birth).format("YYYY-MM-DD")
                    : dateOfBirth
                }
                onChange={setDateOfBirth}
                name="dateOfBirth"
                register={register}
                validation={{ required: "Date of birth is required" }}
                errors={errors}
                sx={{ width: "100%" }}
              />
            </Grid> */}

            <Grid item xs={12} sm={6} md={4}>
              <Controller
                name="highest_qualification"
                control={control}
                rules={{ required: "Highest Qualification is required" }}
                render={({ field }) => (
                  <>
                    {/* {console.log("DATA highest_qualification : ", field.value)} */}
                    <CustomFormControl
                      label="Highest Qualification"
                      name="highest_qualification"
                      value={field.value}
                      onChange={field.onChange}
                      errors={errors}
                      options={qualificationOptions}
                    />
                  </>
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
              <PhoneInput
                name="phone"
                country={"in"}
                value={phoneNumber}
                onChange={(phone) => setPhoneNumber(phone)}
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
            </Grid>
            <Grid item xs={12}>
              <CustomTextField
                label="About Me"
                name="about_me"
                placeholder="Enter About TA"
                register={register}
                validation={{ required: "About Me is required" }}
                errors={errors}
                multiline
                rows={4}
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
          open={successPopup}
          handleClose={() => dispatch(closeSuccessPopup())}
          title= {`${taName} successfully created.`}
          actions={actions}
        /> */}
        {successPopup && <SubmitPopup componentname={"ADDEDITTA"} />}
        {assignStudentOpen && <AssignStudents />}
        {assignBatchOpen && <AssignBatches />}
      </Box>
    </Box>
  );
};

export default AddEditTA;
