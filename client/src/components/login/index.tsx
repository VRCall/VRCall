import React, { useState } from "react";
import { LoginData, loginUser } from "../../services/login";

export default function Index() {

    const [formData, setFormData] = useState<LoginData>({ email: "", password: "" });

    const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = event.target;
        setFormData({...formData, [name]: value});
    }

    const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        loginUser(formData)
    }

    return (

        <form className="register-form" onSubmit={ handleSubmit }>
            Login
            <div>
                <label htmlFor="email">Email address</label>
                <input required type="email" id="email" name="email" value={ formData.email } onChange={ handleInputChange } />
            </div>
            <div>
                <label htmlFor="password">Password</label>
                <input required type="password" id="password" name="password" value={ formData.password } onChange={ handleInputChange } />
            </div>
            <button>Submit</button>
        </form>

    )

}