import React from 'react';
import { useNavigate } from 'react-router-dom';
import "./card.css";

export default function Card({ id, title, description, imageUrl }) {
    const navigate = useNavigate();

    const handleClick = () => {
        navigate(`/detail/${id}`);
    };

    return (
        <div className="card">
            <img src={imageUrl} alt={title} className="card-image" />
            <div className="card-content">
                <h2 className="card-title">{title}</h2>
                <p className="card-description">{description}</p>
                <button className="card-button" onClick={handleClick}>
                    Meer informatie
                </button>
            </div>
        </div>
    );
}
