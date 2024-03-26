import React, { useState } from "react";
import { RegisterData, registerUser } from "../../services/register";

export default function Index() {

    const [formData, setFormData] = useState<RegisterData>({ pseudo: "", email: "", password: "", confirmPassword: "", profilePicture: null });

    const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = event.target;
        let file;
        if(name === "profilePicture") {
            file = event.target.files ? event.target.files[0] : null;
            setFormData({...formData, [name]: file});
        }
        else {
            setFormData({...formData, [name]: value});
        }
    }

    const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        registerUser(formData)
    }

    return (

        <form className="register-form" onSubmit={ handleSubmit }>
            Register
            <div>
                <label htmlFor="pseudo">Pseudo</label>
                <input required type="text" id="pseudo" name="pseudo" value={ formData.pseudo } onChange={ handleInputChange } />
            </div>
            <div>
                <label htmlFor="email">Email address</label>
                <input required type="email" id="email" name="email" value={ formData.email } onChange={ handleInputChange } />
            </div>
            <div>
                <label htmlFor="password">Password</label>
                <input required type="password" id="password" name="password" value={ formData.password } onChange={ handleInputChange } />
            </div>
            <div>
                <label htmlFor="confirmPassword">Confirm Password</label>
                <input required type="password" id="confirmPassword" name="confirmPassword" value={ formData.confirmPassword } onChange={ handleInputChange } />
            </div>
            <div>
                <label htmlFor="profilePicture">Profile picture (optional)</label>
                <input type="file" id="profilePicture" name="profilePicture" onChange={ handleInputChange } accept="image/*" />
            </div>
            <button>Submit</button>
        </form>

    )

}