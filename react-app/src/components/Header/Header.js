import React from 'react';
import Grid from '@mui/material/Grid';
import '../Header/Header.css'
import Profile from './Profile';
import Logo from './Logo/Logo';
import Nav from './Nav/Nav';


const Header = () => {
    return (
        <header id='header' className='header fixed-top d-flex align-items-center'>  
        {/* LOGO */}
        <Logo />
        {/* NAV */}
        <Nav />
        </header>
    );
    }

export default Header;