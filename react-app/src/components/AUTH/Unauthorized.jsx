import React from 'react'
import { useNavigate } from 'react-router-dom'
import './Unauthorized.css'; // Import the CSS file

const Unauthorized = () => {
  const navigate = useNavigate();
  const goBack = () => navigate(-1);
  return (
    <div className="unauthorized-container">
      <section className="unauthorized-content">
        <h1>Unauthorized</h1>
        <p>You do not have access to the requested page.</p>
        <button onClick={goBack}>Go Back</button>
      </section>
    </div>
  )
}

export default Unauthorized
