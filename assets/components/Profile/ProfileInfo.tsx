import React from "react";
import './profileInfo.scss'

export default function ProfileInfo() {

    return(

        <div className="profile-info">
            <h3>PROFIL</h3>
            <img className="profile-picture" src="https://picsum.photos/500/300" alt="Profile picture" />
            <h3>Pseudo</h3>
            <h3>Email</h3>
        </div>

    )

}