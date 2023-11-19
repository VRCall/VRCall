import React, {useEffect, useState} from "react";
import './friendRequests.scss'
import axios from "axios";
import Swal from "sweetalert2";

export default function FriendRequests() {

    const [sentRequests, setSentRequests] = useState<object[]>([]);
    const [receivedRequests, setReceivedRequests] = useState<object[]>([]);

    const getSentRequests = async () => {
        await axios.get("https://randomuser.me/api/?results=3")
            .then((response) => {
                setSentRequests(response.data.results)
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

    const getReceivedRequests = async () => {
        await axios.get("https://randomuser.me/api/?results=3")
            .then((response) => {
                setReceivedRequests(response.data.results)
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
        getSentRequests();
        getReceivedRequests();
    }, [])

    return(
        <div className="friend-requests">
            <h3>Demandes d'ami</h3>
            <h4>Demandes reçues</h4>
            {
                receivedRequests &&
                receivedRequests.map((req) => {
                    return(
                        <div className="request" key={req.email}>
                            <img src={req.picture.medium} alt="Received request picture" className="request-picture" />
                            <span className="request-name">{req.name.first} {req.name.last}</span>
                        </div>
                    )
                })
            }
            <h4>Demandes envoyées</h4>
            {
                sentRequests &&
                sentRequests.map((req) => {
                    return(
                        <div className="request" key={req.email}>
                            <img src={req.picture.medium} alt="Sent request picture" className="request-picture" />
                            <span className="request-name">{req.name.first} {req.name.last}</span>
                        </div>
                    )
                })
            }
        </div>
    )

}