import { useMemo, useState } from 'react';
import {
  MRT_EditActionButtons,
  MaterialReactTable,
  // createRow,
  useMaterialReactTable,
} from 'material-react-table';
import {
  Box,
  Button,
  DialogActions,
  DialogContent,
  DialogTitle,
  IconButton,
  Tooltip,
} from '@mui/material';
import {
  QueryClient,
  QueryClientProvider,
  useMutation,
  useQuery,
  useQueryClient,
} from '@tanstack/react-query';
import managetas from '../../fakeData/manageTAs.json'
import editIcon from '../../assets/editIcon.png';
import { OnOffSwitch } from '../../components/Switch';
import EditIcon from '@mui/icons-material/Edit';
import ControlPointOutlinedIcon from '@mui/icons-material/ControlPointOutlined';
import Header from '../../components/Header/Header';
import Sidebar from '../../components/Sidebar/Sidebar';

const TAtable = () => {
  const [validationErrors, setValidationErrors] = useState({});

  const columns = useMemo(
    () => [

      {
        accessorKey: 'taName',
        header: 'TA Name',
        muiEditTextFieldProps: {
          required: true,
          error: !!validationErrors?.taName,
          helperText: validationErrors?.taName,
          //remove any previous validation errors when user focuses on the input
          onFocus: () =>
            setValidationErrors({
              ...validationErrors,
              taName: undefined,
            }),
          //optionally add validation checking for onBlur or onChange
        },
      },

      {
        accessorKey: 'username',
        header: 'Username',
        enableEditing: false
      },

      {
        accessorKey: 'location',
        header: 'Location',
        editVariant: 'select',
        editSelectOptions: managetas['locations'], // TODO: options for select location
        muiEditTextFieldProps: {
          select: true,
          error: !!validationErrors?.location,
          helperText: validationErrors?.location,
        },
      },
      {
        accessorKey: 'timezone',
        header: 'Time Zone',
        editVariant: 'select',
        editSelectOptions: managetas['timezones'],  // options for select timezone
        muiEditTextFieldProps: {
          select: true,
          error: !!validationErrors?.timezone,
          helperText: validationErrors?.timezone,
        },

      },
      {
        id: 'actions',
        header: 'Actions',
        enableEditing: false,
        Cell: ({ row, table }) => (
          <Box sx={{ display: 'flex', gap: '5px' }}>
            <Box sx={{ display: 'flex', alignItems: 'center' }}>
              <OnOffSwitch />
            </Box>
            <Button sx={{
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              color: '#F56D3B',
              backgroundColor: '#FEEBE3',
              gap: '4px',
              height: '30px',
              width: '70px',
              borderRadius: '15px',
              padding: '5px',
              '&:hover': {
                backgroundColor: 'rgba(245, 235, 227, 0.8)',
              }
            }}
              variant='text'
              onClick={() => { table.setEditingRow(row); }}
            >
              <img src={editIcon}
                alt=""
              />
              <small>Edit</small>
            </Button>

            {/* <Tooltip title="Delete">
              <IconButton color="error" onClick={() => openDeleteConfirmModal(row)}>
                <DeleteIcon />
              </IconButton>
            </Tooltip> */}
          </Box>
        ),
      }
    ],
    [validationErrors],
  );

  //call CREATE hook
  const { mutateAsync: createUser, isPending: isCreatingUser } = useCreateUser();
  //call READ hook
  const {
    data: fetchedUsers = [],
    isError: isLoadingUsersError,
    isFetching: isFetchingUsers,
    isLoading: isLoadingUsers,
  } = useGetUsers();
  //call UPDATE hook
  const { mutateAsync: updateUser, isPending: isUpdatingUser } =
    useUpdateUser();
  //call DELETE hook
  // const { mutateAsync: deleteUser, isPending: isDeletingUser } =
  //   useDeleteUser();

  //CREATE action
  const handleCreateUser = async ({ values, table }) => {
    console.log('in handleCreateUser -- ', values);
    const newValidationErrors = validateUser(values);
    if (Object.values(newValidationErrors).some((error) => error)) {
      setValidationErrors(newValidationErrors);
      return;
    }
    setValidationErrors({});
    await createUser(values);
    table.setCreatingRow(null); //exit creating mode
  };

  //UPDATE action
  const handleSaveUser = async ({ values, table }) => {
    const newValidationErrors = validateUser(values);
    if (Object.values(newValidationErrors).some((error) => error)) {
      setValidationErrors(newValidationErrors);
      return;
    }
    setValidationErrors({});
    await updateUser(values);
    table.setEditingRow(null); //exit editing mode
  };

  //DELETE action
  // const openDeleteConfirmModal = (row) => {
  //   if (window.confirm('Are you sure you want to delete this user?')) {
  //     deleteUser(row.original.id);
  //   }
  // };

  const table = useMaterialReactTable({
    columns,
    data: fetchedUsers, //use the fetched data from the api
    createDisplayMode: 'modal', //default ('row', and 'custom' are also available)
    editDisplayMode: 'modal', //default ('row', 'cell', 'table', and 'custom' are also available)
    enableRowNumbers: true,
    rowNumberDisplayMode: 'original',
    enableDensityToggle: false,
    enableHiding: false,
    enableFullScreenToggle: false,
    getRowId: (row) => row.id, //unique id for each row
    muiToolbarAlertBannerProps: isLoadingUsersError
      ? {
        color: 'error',
        children: 'Error loading data',
      }
      : undefined,
    muiTableContainerProps: {
      sx: {
        maxHeight: '60vh',
        width: '65vw',
        margin: 'auto',
        scrollbarWidth: 'none',
        textAlign: 'center'
      },
    },
    muiPaginationProps: {
      showRowsPerPage: false,
      variant: 'contained',
      color: 'primary',
      sx: {
        width: '65vw',
        display: 'flex',
        justifyContent: 'center',
        '& .MuiPaginationItem-root.Mui-selected': {
          backgroundColor: '#F56D3B',
          color: 'white',
        },
      },

    },

    muiBottomToolbarProps: {
      sx: {
        display: 'flex',
        justifyContent: 'center'
      },
    },
    paginationDisplayMode: 'pages',
    initialState: {
      pagination: {
        pageSize: 7,
      },
      density: 'compact',
    },
    onCreatingRowCancel: () => setValidationErrors({}),
    onCreatingRowSave: handleCreateUser,
    onEditingRowCancel: () => setValidationErrors({}),
    onEditingRowSave: handleSaveUser,
    //optionally customize modal content
    renderCreateRowDialogContent: ({ table, row, internalEditComponents }) => (
      <>
        <DialogTitle variant="h5">Create New User</DialogTitle>
        <DialogContent
          sx={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}
        >
          {internalEditComponents.filter((component) => component.key !== 'mrt-row-create_actions')} {/* or render custom edit components here */}
        </DialogContent>
        <DialogActions>
          <MRT_EditActionButtons variant="text" table={table} row={row} />
        </DialogActions>
      </>
    ),
    //optionally customize modal content
    renderEditRowDialogContent: ({ table, row, internalEditComponents }) => (
      <>
        <DialogTitle variant="h5">Edit User</DialogTitle>
        <DialogContent
          sx={{ display: 'flex', flexDirection: 'column', gap: '1.5rem' }}
        >
          {internalEditComponents.filter((component) => component.key !== '0_actions')} {/* or render custom edit components here */}
        </DialogContent>
        <DialogActions>
          <MRT_EditActionButtons variant="text" table={table} row={row} />
        </DialogActions>
      </>
    ),
    state: {
      isLoading: isLoadingUsers,
      isSaving: isCreatingUser || isUpdatingUser, //isDeletingUser,
      showAlertBanner: isLoadingUsersError,
      showProgressBars: isFetchingUsers,
    },
  });

  return (
    <Box sx={{ display: 'flex', flexDirection: 'column', alignItems: 'center' }}>
      <Box sx={{ width: '65vw', display: 'flex', flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', marginBottom: '20px' }}>
        <Box sx={{ fontSize: '30px' }}>Hello, Saras</Box>
        <Button
          sx={{
            color: 'white',
            backgroundColor: '#F56D3B',
            width: '150px',
            height: '40px',
            borderRadius: '20px',
            '&:hover': {
              backgroundColor: 'rgba(245, 109, 59, 0.8)',
            },
          }}
          startIcon={<ControlPointOutlinedIcon />}
          onClick={() => {
            table.setCreatingRow(true);
          }}
        >
          Create TA
        </Button>
      </Box>
      <Box sx={{ display: 'flex' }}>
        <MaterialReactTable table={table} />
      </Box>
    </Box>
  );

};

//CREATE hook (post new user to api)
function useCreateUser() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (managetas) => {
      // Send API update request here
      await new Promise((resolve) => setTimeout(resolve, 1000)); // Fake API call
      return Promise.resolve();
    },
    // Client-side optimistic update
    onMutate: (managetas) => {
      queryClient.setQueryData(
        ['users'],
        (prevUsers) => [
          ...prevUsers,
          {
            ...managetas,
            id: (Math.random() + 1).toString(36).substring(7),
          },
        ]
      );
    },
    // onSettled: () => queryClient.invalidateQueries({ queryKey: ['users'] }), // Refetch users after mutation, disabled for demo
  });
}

//READ hook (get users from api)
function useGetUsers() {
  return useQuery({
    queryKey: ['users'],
    queryFn: async () => {
      //send api request here
      await new Promise((resolve) => setTimeout(resolve, 1000)); //fake api call
      return Promise.resolve(managetas['userdata']);
    },
    refetchOnWindowFocus: false,
  });
}

//UPDATE hook (put user in api)
function useUpdateUser() {
  const queryClient = useQueryClient();
  console.log('in useCreateUser --', queryClient.getQueryData['users']);
  return useMutation({
    mutationFn: async (user) => {
      //send api update request here
      await new Promise((resolve) => setTimeout(resolve, 1000)); //fake api call
      return Promise.resolve();
    },
    //client side optimistic update
    onMutate: (newUserInfo) => {
      console.log(" update INFO : ", newUserInfo);
      queryClient.setQueryData(['users'], (prevUsers) =>
        prevUsers?.map((prevUser) =>
          prevUser.username === newUserInfo.username ? newUserInfo : prevUser,
        ),
      );
    },
    // onSettled: () => queryClient.invalidateQueries({ queryKey: ['users'] }), //refetch users after mutation, disabled for demo
  });
}

//DELETE hook (delete user in api)
// function useDeleteUser() {
//   const queryClient = useQueryClient();
//   return useMutation({
//     mutationFn: async (userId) => {
//       //send api update request here
//       await new Promise((resolve) => setTimeout(resolve, 1000)); //fake api call
//       return Promise.resolve();
//     },
//     //client side optimistic update
//     onMutate: (userId) => {
//       queryClient.setQueryData(['users'], (prevUsers) =>
//         prevUsers?.filter((user) => user.id !== userId),
//       );
//     },
//     // onSettled: () => queryClient.invalidateQueries({ queryKey: ['users'] }), //refetch users after mutation, disabled for demo
//   });
// }

const queryClient = new QueryClient();

const ManagesTAs = () => (
  //Put this with your other react-query providers near root of your app
  <>
    <Header></Header>
    <Sidebar></Sidebar>
    <QueryClientProvider client={queryClient}>
      <TAtable />
    </QueryClientProvider>
  </>

);

export default ManagesTAs;

const validateRequired = (value) => !!value.length;
// const validateEmail = (email) =>
//   !!email.length &&
//   email
//     .toLowerCase()
//     .match(
//       /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
//     );

function validateUser(user) {
  return {
    taName: !validateRequired(user.taName)
      ? 'Name is Required'
      : '',
    username: !validateRequired(user.username) ? 'Username is Required' : '',
    location: !validateRequired(user.location) ? 'Location is Required' : '',
  };
}
