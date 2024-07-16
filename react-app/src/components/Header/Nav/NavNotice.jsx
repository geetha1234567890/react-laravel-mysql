import React from 'react'

function NavNotice() {
  return (
    <li className='nav-item dropdown'>
        <a className='nav-link nav-icon' href='#' data-bs-toggle="dropdown">
            <i className='bi bi-bell'></i>
            <span className='badge bg-primary badge-number'>4</span>
        </a>

        <ul className='dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications'>
            <li className='dropdown-header'>
                you have 4 new Notifications
                <a href='#'>
                    <span className='badge round-pill bg-primary p-2 ms-2'>
                        View All
                    </span>
                </a>
            </li>
            <li>
                <hr className='dropdown-divider'></hr>
            </li>

            <li className='notification-item'>
                <i className='bi bi-exclamation-circle text-warning'></i>
                <div>
                    <h4>Lorem Ipsum</h4>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                    <p>30 min. ago</p>
                </div>
            </li>

            <li>
                <hr className='dropdown-divider'></hr>
            </li>

            <li className='notification-item'>
                <i className='bi bi-exclamation-circle text-warning'></i>
                <div>
                    <h4>Lorem Ipsum</h4>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                    <p>30 min. ago</p>
                </div>
            </li>
            
            <li>
                <hr className='dropdown-divider'></hr>
            </li>

            <li className='dropdown-footer'>
                <a href='#'>Show All Notifications</a>
            </li>
        </ul>

    </li>
  )
}

export default NavNotice