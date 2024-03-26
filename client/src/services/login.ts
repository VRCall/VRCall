import axios, { AxiosResponse } from "axios";

export interface LoginData {
    email: string,
    password: string,
};

export const loginUser = async (data: LoginData) => {   

    const jsonData = JSON.stringify({
        email: data.email,
        password: data.password,
    })

    await axios.post(`${import.meta.env.VITE_API_URL}/users/login`, jsonData, {
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then((response: AxiosResponse) => {
        console.log(response);
        localStorage.setItem("token", response.data.token);
    });
    
}