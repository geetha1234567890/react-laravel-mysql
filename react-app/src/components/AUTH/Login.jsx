import { useRef, useState, useEffect } from 'react';

import './Login.css'
// import axios from '../API/axios';
import useAuth from '../Hooks/useAuth';
const LOGIN_URL = '/auth';
import { Link, useNavigate, useLocation } from 'react-router-dom';


const Login = () => {
    const { setAuth } = useAuth()

    const navigate = useNavigate();
    const location = useLocation();
    const from = location.state?.from?.pathname || '/';

    const userRef = useRef();
    const errRef = useRef();

    const [user, setUser] = useState('');
    const [pwd, setPwd] = useState('');
    const [errMsg, setErrMsg] = useState('');

    useEffect(() => {
        userRef.current.focus();
    }, [])

    useEffect(() => {
        setErrMsg('');
    }, [user, pwd])

    const handleSubmit = async (e) => {
        e.preventDefault();
        // console.log(user, pwd)
        // setUser('')
        // setPwd('')
        // setSuccess(true)
        try {
            // const response = await axios.post(LOGIN_URL,
            //     JSON.stringify({ user, pwd }),
            //     {
            //         headers: { 'Content-Type': 'application/json' },
            //         withCredentials: true
            //     }
            // );

            const response = {
                data: {
                    roles: [5150, 2001, 1984],
                    accessToken: 'Heeloo_there_123'
                }
            }
            console.log(JSON.stringify(response?.data));
            //console.log(JSON.stringify(response));
            const accessToken = response?.data?.accessToken;
            const roles = response?.data?.roles;
            console.log("USER", user)
            console.log("pwd : ", pwd)
            console.log("ROLES", roles)
            console.log("accessTOken : ", accessToken)
            setAuth({ user, pwd, roles, accessToken });
            setUser('');
            setPwd('');
            // setSuccess(true);
            navigate(from, { replace: true });
        } catch (err) {
            if (!err?.response) {
                setErrMsg('No Server Response');
            } else if (err.response?.status === 400) {
                setErrMsg('Missing Username or Password');
            } else if (err.response?.status === 401) {
                setErrMsg('Unauthorized');
            } else {
                setErrMsg('Login Failed');
            }
            errRef.current.focus();
        }
    }

    return (
        <div id="loginPage" className="login_Container">
            <section>
                <p ref={errRef} className={errMsg ? "errmsg" : "offscreen"} aria-live="assertive">{errMsg}</p>
                <h1 style={{ color: "#FFF" }}>Sign In</h1>
                <form onSubmit={handleSubmit}>
                    <label style={{ color: '#fff' }} htmlFor="username">Username:</label>
                    <input
                        type="text"
                        id="username"
                        ref={userRef}
                        autoComplete="off"
                        onChange={(e) => setUser(e.target.value)}
                        value={user}
                        required
                        style={{
                            fontFamily: 'Nunito, sans-serif',
                            fontSize: '22px',
                            padding: '0.25rem',
                            borderRadius: '0.5rem'
                        }}
                    />

                    <label style={{ color: "#fff" }} htmlFor="password">Password:</label>
                    <input
                        type="password"
                        id="password"
                        onChange={(e) => setPwd(e.target.value)}
                        value={pwd}
                        required
                        style={{
                            fontFamily: 'Nunito, sans-serif',
                            fontSize: '22px',
                            padding: '0.25rem',
                            borderRadius: '0.5rem'
                        }}
                    />
                    <button style={{
                        fontFamily: 'Nunito, sans-serif',
                        fontSize: '22px',
                        padding: '0.25rem',
                        borderRadius: '0.5rem'
                    }}>Sign In</button>
                </form>

                <p style={{ color: "#fff" }}>
                    Forget Password ?<br />
                    <span className="line">
                        {/*put router link here*/}
                        <a id='clickbutton' href="#">Click Here</a>
                    </span>
                </p>
            </section>
        </div>


    )
}

export default Login