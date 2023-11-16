import React, { useState, useEffect } from "react";
import axios from "axios";
import ProfileInfo from "../components/Profile/ProfileInfo";
import './profile.scss'

export default function Profile() {

    const [user, setUser] = useState({});

    const getCurrentUser = async () => {
        await axios.get("/api/user")
            .then((response) => console.log(response.data))
            .catch((error) => console.error(error))
    }

    useEffect(() => {
        getCurrentUser()
    }, []);

    return(
        <div className="main-profile">
            <ProfileInfo />
        </div>
    )

}