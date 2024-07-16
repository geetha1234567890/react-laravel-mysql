import { useLocation, Navigate, Outlet } from 'react-router-dom';
import useAuth from './useAuth'; // Adjust the path to where your useAuth hook is located

const RequireAuth = ({ allowedRoles }) => {
    const { auth } = useAuth();
    const location = useLocation();

    // Ensure roles and allowedRoles are both arrays of numbers
    const userRoles = auth?.roles || [];
    const isAuthorized = userRoles.find(role => allowedRoles.includes(role));

    console.log("Auth Roles: ", userRoles);
    console.log("Allowed Roles: ", allowedRoles);
    console.log("Is Authorized: ", isAuthorized);

    return (
        isAuthorized ? (
            <Outlet />
        ) : auth?.user ? (
            <Navigate to='/unauthorized' state={{ from: location }} replace />
        ) : (
            <Navigate to='/login' state={{ from: location }} replace />
        )
    );
}

export default RequireAuth;
