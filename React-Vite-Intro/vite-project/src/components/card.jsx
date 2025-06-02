import React from 'react';
import "./card.css"; // Zorg ervoor dat je de juiste CSS-bestandspad gebruikt

export default function Card({ title, description, imageUrl }) {
    return (
        <div className="card">
            <img src={imageUrl} alt={title} className="card-image" />
            <div className="card-content">
                <h2 className="card-title">{title}</h2>
                <p className="card-description">{description}</p>
                <button className="card-button">Meer informatie</button>
            </div>
        </div>
    );
} 