import React from 'react'
import './Logo.css'
import sarasai_logo from '../../../assets/sarasai_logo.png';
function Logo() {
    const handleToggleSideBar = () => {
        document.body.classList.toggle('toggle-sidebar')
    }
    return (
        <div className='d-flex align-items-center justify-content-between'>
            <a href='/' className='logo d-flex align-items-center'>
                {/* img */}
                <img src={sarasai_logo} alt='' />
            </a>
            <i className='bi bi-list toggle-sidebar-btn' onClick={handleToggleSideBar}></i>
        </div>

    )
}

export default Logo