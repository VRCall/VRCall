import axios from "axios";

export interface RegisterData {
    pseudo: string,
    email: string,
    password: string,
    confirmPassword: string,
    profilePicture: File | null
};

export const registerUser = async (data: RegisterData) => {   

    const formData = new FormData();

    formData.append("pseudo", data.pseudo);
    formData.append("email", data.email);
    formData.append("password", data.password);
    formData.append("confirmPassword", data.confirmPassword);
    //formData.append("profilePicture", data.profilePicture!, data.profilePicture?.name);

    const jsonData = JSON.stringify({
        pseudo: data.pseudo,
        email: data.email,
        password: data.password,
        confirmPassword: data.confirmPassword,
    })

    await axios.post(`${import.meta.env.VITE_API_URL}/users/signup`, jsonData, {
        headers: {
            "Content-Type": "application/json"
        }
    });
    
}