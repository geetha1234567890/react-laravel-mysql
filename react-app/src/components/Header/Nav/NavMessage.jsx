import React from 'react'

function NavMessage() {
  return (
    <div className='nav-item dropdown'>
      <a className='nav-link nav-icon' href='#' data-bs-toggle="dropdown">
        <i className='bi bi-chat-left-text'></i>
        <span className='badge bg-success badge-number'>3</span>
      </a>

      <ul className='dropdown-menu dropdown-menu-end dropdown-menu-arrow messages'>
        <li className='dropdown-header'>ypu have 3 new messages
          <a href='#'>
            <span className='badge round-pill bg-primary p-2 ms-2'>
              View All
            </span>
          </a>
        </li>

        <li>
          <hr className='dropdown-divider'></hr>
        </li>

        <li className='message-item'>
          <a href='#'>
            <img src='' alt='' className='rounded-circle'></img>
          </a>
          <div>
            <h4>Lorem Ipsum</h4>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
            <p>30 min. ago</p>
          </div>
        </li>

        <li>
          <hr className='dropdown-divider'></hr>
        </li>

        <li className='message-item'>
          <a href='#'>
            <img src='' alt='' className='rounded-circle'></img>
          </a>
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
          <a href='#'>Show All Messages</a>
        </li>

      </ul>
    </div>
  )
}

export default NavMessage