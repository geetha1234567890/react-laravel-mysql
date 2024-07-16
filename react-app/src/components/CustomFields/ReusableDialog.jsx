import React from 'react';
import { Dialog, DialogTitle, DialogContent, DialogActions, IconButton, Button, Typography, Box } from '@mui/material';
import CloseIcon from '@mui/icons-material/Close';

const ReusableDialog = ({ open, handleClose, title, content, actions }) => (
  <Dialog
    open={open}
    onClose={handleClose}
    maxWidth="md"
    fullWidth
    sx={{
      padding: '50px 0px 50px 0px',
      borderRadius: '10px',
      border: '2px solid #F56D38',
      color: '#FFFFFF'
    }}
  >
    <IconButton
      onClick={handleClose}
      sx={{
        color: '#F56D3B',
        position: 'absolute',
        top: 10,
        right: 10
      }}
    >
      <CloseIcon />
    </IconButton>

    <DialogTitle
      id="alert-dialog-title"
      sx={{
        m: 0,
        // p: 2,
        paddingTop:"16px",
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center'
      }}
    >
      <Typography
        variant="h6"
        sx={{
          fontWeight: '600',
          fontSize: '25px',
          color: '#1A1E3D'
        }}
      >
        {title}
      </Typography>
    </DialogTitle>

    <DialogContent sx={{ m: 2 }}>
      {content}
    </DialogContent>

    <DialogActions sx={{ p: 2, justifyContent: 'center' }}>
      <Box display="flex" justifyContent="center" width="100%" gap={2}>
        {actions}
      </Box>
    </DialogActions>
  </Dialog>
);

export default ReusableDialog;
