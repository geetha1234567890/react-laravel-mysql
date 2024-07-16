import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import reportWebVitals from './reportWebVitals';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { AuthProvider } from './Context/AuthProvider';
import { Provider } from 'react-redux';
import  store  from './redux/store';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <Provider store={store}>
    <BrowserRouter>
      <AuthProvider>
        <Routes>
          {/* <App /> */}
          <Route path='/*' element={<App />}></Route>
        </Routes>
      </AuthProvider>
    </BrowserRouter>
    </Provider>

  </React.StrictMode >
);
reportWebVitals();
