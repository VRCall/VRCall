import axios from "axios";
import { z } from "zod";

export interface RegisterData {
    pseudo: string,
    email: string,
    password: string,
    confirmPassword: string,
    profilePicture: File | null
};

const RegisterSchema = z.object({
    pseudo: z.string().regex(/^[A-Za-z0-9_.]+$/),
    email: z.string().email(),
    password: z.string().min(6),
    confirmPassword: z.string().min(6)
}).refine((data) => data.password === data.confirmPassword, {
    "message": "The passwords are not identical"
})

export const registerUser = async (data: RegisterData) => {
    const validatedFields = RegisterSchema.safeParse({
        pseudo: data.pseudo,
        email: data.email,
        password: data.password,
        confirmPassword: data.confirmPassword,
    });

    if(!validatedFields.success) {
        return "Error"
    }

    if(data.profilePicture !== null && !data.profilePicture?.type.startsWith("image/")) {
        return "Error"
    }

    const { pseudo, email, password } = validatedFields.data;

    let newFileName;

    if(data.profilePicture !== null) {
        let fileExtension = data.profilePicture.name.split(".").pop();
        newFileName = "/" + crypto.randomUUID() + "." + fileExtension;
    }
    else {
        newFileName = "/default.png";
    }

    const jsonData = JSON.stringify({
        "pseudo": pseudo,
        "email": email,
        "password": password,
        "profilePicture": newFileName
    });
    
    await axios.post(`${import.meta.env.VITE_API_URL}/users/signup`, jsonData, {
        headers: {
            "Content-Type": "application/json"
        }
    })
    
}