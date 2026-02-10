import Card from "./components/card";

export default function Home() {
  return (
    <main>
      <p className="text-gray-50">sigma</p>
      <strong><h1 className="flexbox">Mooie kaarten</h1></strong>
      <div className="flexbox">
        <Card src="https://www.rug.nl/research/kenniscentrum-landschap/1-het-kenniscentrum-landschap.jpg" alt="Landscape" />
        <Card src="https://www.rug.nl/research/kenniscentrum-landschap/1-het-kenniscentrum-landschap.jpg" alt="Landscape" />
        <Card src="https://www.rug.nl/research/kenniscentrum-landschap/1-het-kenniscentrum-landschap.jpg" alt="Landscape" />
      </div>
    </main>
  );
}
