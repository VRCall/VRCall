import axios from "axios";
import { ReactNode, useEffect } from "react";
import { useLocation, useNavigate } from "react-router-dom"

interface AuthGuardProps {
    children: ReactNode
};

export default function AuthGuard({ children }: AuthGuardProps) {

    const navigate = useNavigate();
    const location = useLocation();

    const checkAuth = () => {
        // Check if current location is login or signup
        const isLoginPage = location.pathname === "/login";
        const isRegisterPage = location.pathname === "/register";

        const hasToken = !!localStorage.getItem("token");

        if(!hasToken && !isLoginPage && !isRegisterPage) {
            navigate("/login");
        }

        const authToken = localStorage.getItem("token") || "";

        axios.post(`${import.meta.env.VITE_API_URL}/users/auth`, {}, {
            headers: {
                "Authorization": `Bearer ${authToken}`
            },
        })
        .then((response) => {
            if(response.data && (isLoginPage || isRegisterPage)) {
                navigate("/");
            }
            else if(!response && !isLoginPage && !isRegisterPage) {
                navigate("/login");
            }
        });
    }

    useEffect(() => {
        checkAuth();
    }, [navigate])

    return ( <>{ children }</> )

}