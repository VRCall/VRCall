import React, { useState, useEffect } from "react";
import axios from "axios";
import ProfileInfo from "../components/Profile/ProfileInfo";
import './profile.scss'
import FriendForm from "../components/Profile/FriendForm";
import FriendList from "../components/Profile/FriendList";
import FriendRequests from "../components/Profile/FriendRequests";

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
            <FriendForm />
            <FriendList />
            <FriendRequests />
        </div>
    )

}