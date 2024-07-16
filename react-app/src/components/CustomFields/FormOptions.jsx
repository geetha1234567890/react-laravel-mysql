export const timeZones = [
  { country: "India", time_zone: "IST", utc_offset: -5.0 },
  { country: "Greenland", time_zone: "UTC", utc_offset: -5.0 },
  { country: "Afghanistan", time_zone: "Asia/Kabul", utc_offset: 4.5 },
  { country: "Albania", time_zone: "Europe/Tirane", utc_offset: 1.0 },
  { country: "Algeria", time_zone: "Africa/Algiers", utc_offset: 1.0 },
  { country: "Andorra", time_zone: "Europe/Andorra", utc_offset: 1.0 },
  { country: "Angola", time_zone: "Africa/Luanda", utc_offset: 1.0 },
  {
    country: "Antigua and Barbuda",
    time_zone: "America/Antigua",
    utc_offset: -4.0,
  },
  {
    country: "Argentina",
    time_zone: "America/Argentina/Buenos_Aires",
    utc_offset: -3.0,
  },
  { country: "Armenia", time_zone: "Asia/Yerevan", utc_offset: 4.0 },
  { country: "Australia", time_zone: "Australia/Sydney", utc_offset: 10.0 },
  { country: "Austria", time_zone: "Europe/Vienna", utc_offset: 1.0 },
  { country: "Azerbaijan", time_zone: "Asia/Baku", utc_offset: 4.0 },
  { country: "Paraguay", time_zone: "America/Asuncion", utc_offset: -3.0 },
  { country: "Peru", time_zone: "America/Lima", utc_offset: -5.0 },
  { country: "Philippines", time_zone: "Asia/Manila", utc_offset: 8.0 },
  { country: "Poland", time_zone: "Europe/Warsaw", utc_offset: 1.0 },
  { country: "Portugal", time_zone: "Europe/Lisbon", utc_offset: 0.0 },
  { country: "Qatar", time_zone: "Asia/Qatar", utc_offset: 3.0 },
  { country: "Romania", time_zone: "Europe/Bucharest", utc_offset: 2.0 },
  { country: "Russia", time_zone: "Europe/Moscow", utc_offset: 3.0 },
  { country: "Rwanda", time_zone: "Africa/Kigali", utc_offset: 2.0 },
  {
    country: "Saint Kitts and Nevis",
    time_zone: "America/St_Kitts",
    utc_offset: -4.0,
  },
  { country: "Saint Lucia", time_zone: "America/St_Lucia", utc_offset: -4.0 },
  {
    country: "Saint Vincent and the Grenadines",
    time_zone: "America/St_Vincent",
    utc_offset: -4.0,
  },
  // Add more time zones here
];

export const genders = [
  { value: "Male", label: "Male" },
  { value: "Female", label: "Female" },
  { value: "Other", label: "Other" },
];

export const qualificationOptions = [
  { value: "Secondary School", label: "Secondary School" },
  { value: "Post Secondary School", label: "Post Secondary School" },
  { value : 'PHD in Computer Science', label: 'PHD in Computer Science' },
  { value: "Bachelor's Degree", label: "Bachelor's Degree" },
  { value: "Master's Degree", label: "Master's Degree" },
  { value: "Doctorate", label: "Doctorate" },
];

export const validateTimeZone = (value) => {
  if (!value) return "Time Zone is required";
  if (!timeZones.some((tz) => tz.time_zone === value)) return "Invalid time zone selected";
  return true;
};


export const transformedTimeZones = timeZones.map((tz) => ({
  value: tz.time_zone,
  label: `${tz.country}`,
}));
