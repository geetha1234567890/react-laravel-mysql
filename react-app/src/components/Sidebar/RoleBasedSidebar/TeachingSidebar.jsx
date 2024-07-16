
import './Sidebar.css'

import React, { useState } from 'react';
import { Link, useLocation } from 'react-router-dom';
import Divider from '@mui/material/Divider';

const TeachingSidebar = () => {
  const location = useLocation();
  const [activeLink, setActiveLink] = useState(location.pathname);

  const handleLinkClick = (path) => {
    setActiveLink(path);
  };

  return (
    <aside id='sidebar' className='sidebar'>
      <ul className="sidebar-nav" id='sidebar-nav'>
        <li className='nav-item'>
          <Link className={`nav-link ${activeLink === '/' ? 'active' : ''}`} to={'/'} onClick={() => handleLinkClick('/dashboard')}>
            <i className='bi bi-grid'></i>
            <span>Dashboard</span>
          </Link>
        </li>
        <Divider variant="middle" component="li" sx={{ backgroundColor: 'white', opacity: '0.3' }} />
        <li className='nav-item'>
          <a className={`nav-link ${activeLink.startsWith('/manage-') ? 'active' : 'collapsed'}`} data-bs-target='#manage-tas-nav' data-bs-toggle="collapse" href='#' onClick={() => handleLinkClick('/manage')}>
            <i className='bi bi-menu-button-wide'></i>
            <span>Teaching Assistant</span>
            <i className='bi bi-chevron-down ms-auto'></i>
          </a>
          <ul id='manage-tas-nav' className={`nav-content collapse ${activeLink.startsWith('/manage-') ? 'show' : ''}`} data-bs-parent="#sidebar-nav">
            <li>
              <Link to={"/ta-manage"} className={activeLink === '/ta-manage' ? 'active' : ''} onClick={() => handleLinkClick('/ta-manage')}>
                <i className='bi bi-circle'></i>
                <span>Manage TA</span>
              </Link>
            </li>
            <li>
              <Link to={"/ta-mapping"} className={activeLink === '/ta-mapping' ? 'active' : ''} onClick={() => handleLinkClick('/ta-mapping')}>
                <i className='bi bi-circle'></i>
                <span>TA Mapping</span>
              </Link>
            </li>
            <li>
              <Link to={"/ta-availability"} className={activeLink === '/ta-availability' ? 'active' : ''} onClick={() => handleLinkClick('/ta-availability')}>
                <i className='bi bi-circle'></i>
                <span>TA Availability</span>
              </Link>
            </li>
            <li>
              <Link to={"/ta-scheduling"} className={activeLink === '/ta-scheduling' ? 'active' : ''} onClick={() => handleLinkClick('/ta-scheduling')}>
                <i className='bi bi-circle'></i>
                <span>TA Scheduling</span>
              </Link>
            </li>
          </ul>
        </li>
        <Divider variant="middle" component="li" sx={{ backgroundColor: 'white', opacity: '0.3' }} />
        <li className='nav-item'>
          <a className={`nav-link ${activeLink.startsWith('/coach-') ? 'active' : 'collapsed'}`} data-bs-target='#manage-coaches-nav' data-bs-toggle="collapse" href='#' onClick={() => handleLinkClick('/coach')}>
            <i className='bi bi-menu-button-wide'></i>
            <span>Coaches</span>
            <i className='bi bi-chevron-down ms-auto'></i>
          </a>
          <ul id='manage-coaches-nav' className={`nav-content collapse ${activeLink.startsWith('/coach-') ? 'show' : ''}`} data-bs-parent="#sidebar-nav">
            <li>
              <Link to={"/manage-coaches"} className={activeLink === '/manage-coaches' ? 'active' : ''} onClick={() => handleLinkClick('/manage-coaches')}>
                <i className='bi bi-circle'></i>
                <span>Manage Coaches</span>
              </Link>
            </li>
            <li>
              <Link to={"/coach-mapping"} className={activeLink === '/coach-mapping' ? 'active' : ''} onClick={() => handleLinkClick('/coach-mapping')}>
                <i className='bi bi-circle'></i>
                <span>Coach Mapping</span>
              </Link>
            </li>
            <li>
              <Link to={"/coach-template"} className={activeLink === '/coach-template' ? 'active' : ''} onClick={() => handleLinkClick('/coach-template')}>
                <i className='bi bi-circle'></i>
                <span>Coach Template</span>
              </Link>
            </li>
            <li>
              <Link to={"/coach-availability"} className={activeLink === '/coach-availability' ? 'active' : ''} onClick={() => handleLinkClick('/coach-availability')}>
                <i className='bi bi-circle'></i>
                <span>Coach Availability</span>
              </Link>
            </li>
            <li>
              <Link to={"/coach-scheduling"} className={activeLink === '/coach-scheduling' ? 'active' : ''} onClick={() => handleLinkClick('/coach-scheduling')}>
                <i className='bi bi-circle'></i>
                <span>Coach Scheduling</span>
              </Link>
            </li>
          </ul>
        </li>
        <Divider variant="middle" component="li" sx={{ backgroundColor: 'white', opacity: '0.3' }} />
        <li className='nav-item'>
          <Link className={`nav-link ${activeLink === '/courses' ? 'active' : 'collapsed'}`} to={'/courses'} onClick={() => handleLinkClick('/courses')}>
            <i className='bi bi-book'></i>
            <span>Courses</span>
          </Link>
        </li>
        <Divider variant="middle" component="li" sx={{ backgroundColor: 'white', opacity: '0.3' }} />
        <li className='nav-item'>
          <a className={`nav-link ${activeLink === '/tools' ? 'active' : 'collapsed'}`} href='#' onClick={() => handleLinkClick('/tools')}>
            <i className='bi bi-tools'></i>
            <span>Coaching Tools</span>
          </a>
        </li>
      </ul>
    </aside>
  );
};

export default TeachingSidebar;