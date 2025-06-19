import React, { useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import "./bookingForm.css"; 

export default function BookingForm({ cards }) {
    const { id } = useParams();
    const navigate = useNavigate();
    const card = cards.find((c) => c.id === id);

    const [formData, setFormData] = useState({
        name: "",
        email: "",
        date: "",
    });

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        console.log("Boeking verstuurd:", formData);
        alert(`Bedankt voor je boeking, ${formData.name}!`);
        navigate("/");
    };

    if (!card) return <div>Kaart niet gevonden</div>;

    return (
        <div className="booking-form">
            <h2>Boek: {card.title}</h2>
            <form onSubmit={handleSubmit}>
                <label>
                    Naam:
                    <input type="text" name="name" value={formData.name} onChange={handleChange} required />
                </label>
                <label>
                    E-mail:
                    <input type="email" name="email" value={formData.email} onChange={handleChange} required />
                </label>
                <label>
                    Datum:
                    <input type="date" name="date" value={formData.date} onChange={handleChange} required />
                </label>
                <button type="submit">Verstuur Boeking</button>
            </form>
            <button onClick={() => navigate(-1)}>Annuleer</button>
        </div>
    );
}
