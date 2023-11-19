import React, {useEffect, useState} from "react";
import axios from "axios";
import Swal from 'sweetalert2';
import './friendList.scss'

export default function FriendList() {

    const [friends, setFriends] = useState<object[]>([])

    const getFriends = async () => {
        await axios.get("https://randomuser.me/api/?results=7")
        .then((response) => {
            setFriends(response.data.results)
        })
        .catch((error) => {
            Swal.fire({
                icon: "error",
                title: "Erreur",
                text: error,
                showConfirmButton: false,
                toast: true,
                position: "top-end"
            })
        })
    }

    useEffect(() => {
        getFriends();
    }, [])

    return(
        <div className="friend-list">
            <h3>Amis</h3>
            {
                friends &&
                friends.map((friend) => {
                    return(
                        <div className="friend" key={friend.email}>
                            <img src={friend.picture.medium} alt="Friend profile picture" className="friend-picture" />
                            <span className="friend-name">{friend.name.first} {friend.name.last}</span>
                        </div>
                    )
                })
            }
        </div>
    )

}