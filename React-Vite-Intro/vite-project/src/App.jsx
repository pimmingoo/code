import React, { useState } from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Card from "./components/card";
import CardDetail from "./components/cardDetail.jsx";
import BookingForm from "./components/bookingForm.jsx"; // ✅ Nieuw toegevoegd
import "./App.css";

export default function App() {
  const cards = [
  {
    id: "1",
    title: "Vakantie aan Zee",
    description: "Geniet van zon, zee en strand in deze prachtige kustbestemming.",
    imageUrl: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRVfEpFB0-EHmG0nNB0ZaC1Fxrfo_w82twyg&s",
    location: "Scheveningen",
    price: "€499 per week",
    details: "Inclusief hotel, ontbijt en strandactiviteiten."
  },
  {
    id: "2",
    title: "Stedentrip Parijs",
    description: "Ontdek de lichtstad en bezoek iconische bezienswaardigheden.",
    imageUrl: "https://www.vakantiediscounter.nl/blog/wp-content/uploads/2016/08/bezienswaardigheden-parij.jpg",
    location: "Parijs",
    price: "€299 per persoon",
    details: "3-daagse trip met hotel en trein."
  },
  {
    id: "3",
    title: "Avontuur in de Bergen",
    description: "Ga hiken in de bergen en geniet van adembenemende uitzichten.",
    imageUrl: "https://encrypted-tbn1.gstatic.com/licensed-image?q=tbn:ANd9GcRs8pfAyDu8MYc6bjzezl5wiHgSmVdRELYD_7TBgQ6qo_J8f5n2gRCVI3qnbalA4cmLkwqz5HlCwOL5eAEHkMNRUs-j7FM056NZcoUzmg",
    location: "Zwitserland",
    price: "€699 per persoon",
    details: "Inclusief gids, overnachting en maaltijden."
  },
  {
    id: "4",
    title: "Cultuurreis Rome",
    description: "Bezoek eeuwenoude ruïnes en proef de Italiaanse sfeer.",
    imageUrl: "https://res.cloudinary.com/hello-tickets/image/upload/c_limit,f_auto,q_auto,w_1920/v1612861925/iiywrei0vyu1zk4cthai.jpg",
    location: "Rome",
    price: "€399 per persoon",
    details: "4 dagen met hotel, ontbijt en museumtickets."
  },
  {
    id: "5",
    title: "Wellnessweekend Veluwe",
    description: "Kom volledig tot rust midden in de natuur.",
    imageUrl: "https://www.dehoevevannunspeet.nl/upload/heading/wat-moet-je-gezien-hebben-op-de-veluwe-1500x750.jpg",
    location: "Veluwe",
    price: "€259 per persoon",
    details: "2 nachten in een wellnesshotel inclusief spa-arrangement."
  },
  {
    id: "6",
    title: "Safari in Zuid-Afrika",
    description: "Spot wilde dieren en beleef het avontuur van je leven.",
    imageUrl: "https://voja.travel/wp-content/uploads/2024/11/iStock-luchtfoto-Kaapstad-Zuid-Afrika-1024x683.jpg",
    location: "Krugerpark",
    price: "€1299 per persoon",
    details: "7-daagse safari met gids, lodges en alle maaltijden."
  },
  {
    id: "7",
    title: "Fietsvakantie Friesland",
    description: "Verken de Friese meren en pittoreske dorpjes per fiets.",
    imageUrl: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQbDJgs8rwj4rgYsqC92tQVrR6C1TRPDUc7aw&s",
    location: "Friesland",
    price: "€349 per persoon",
    details: "5 dagen inclusief fietsverhuur en overnachtingen."
  },
  {
    id: "8",
    title: "Winter Wonderland Lapland",
    description: "Beleef de magie van Lapland met huskysafari en noorderlicht.",
    imageUrl: "https://finlandnaturally.com/wp-content/uploads/2018/12/20171211-Winter_1-2-710x375.jpg",
    location: "Lapland",
    price: "€999 per persoon",
    details: "6 dagen inclusief vlucht, hotel en activiteiten."
  }
];


  const [searchTerm, setSearchTerm] = useState("");

  const handleSearchChange = (e) => {
    setSearchTerm(e.target.value);
  };

  const filteredCards = cards.filter((card) =>
    card.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
    card.location.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <Router>
      <div className="app-container">
        <h1>Mijn Reis App</h1>
        <input
          type="text"
          placeholder="Zoek op titel of locatie..."
          value={searchTerm}
          onChange={handleSearchChange}
          className="search-input"
        />

        <Routes>
          <Route
            path="/"
            element={
              <div className="card-list">
                {filteredCards.map((card) => (
                  <Card key={card.id} {...card} />
                ))}
              </div>
            }
          />
          <Route path="/detail/:id" element={<CardDetail cards={cards} />} />
          <Route path="/book/:id" element={<BookingForm cards={cards} />} /> {/* ✅ Toegevoegde boeking route */}
        </Routes>
      </div>
    </Router>
  );
}
