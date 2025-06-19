import React from "react";
import { useParams, useNavigate } from "react-router-dom";
import "./card.css";
import BookingForm from "./bookingForm.jsx";    

export default function CardDetail({ cards }) {
    const { id } = useParams();
    const navigate = useNavigate();

    const card = cards.find((card) => card.id === id);

    if (!card) return <div>Kaart niet gevonden</div>;

    return (
        <div className="card large-card">
            <img src={card.imageUrl} alt={card.title} className="card-image" />
            <div className="card-content">
                <h2 className="card-title">{card.title}</h2>
                <p className="card-description">{card.description}</p>
                <p><strong>Locatie:</strong> {card.location}</p>
                <p><strong>Prijs:</strong> {card.price}</p>
                <p className="card-details">{card.details}</p>
                <div className="card-buttons">
                    <button className="card-button" onClick={() => navigate(`/book/${id}`)}>Booken</button>
                    <button className="card-button" onClick={() => navigate(-1)}>Terug</button>
                </div>
            </div>
        </div>
    );
}