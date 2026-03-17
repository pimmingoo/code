import Card from "./components/card";
import Image from "next/image";

export default function Home() {
  return (
    <div className="space-y-6">
      
      <h1 className="text-3xl font-bold text-gray-800">
        Mooie kaarten
      </h1>

      <div className="flex flex-wrap gap-6">
        <Card src="https://www.rug.nl/research/kenniscentrum-landschap/1-het-kenniscentrum-landschap.jpg" />
        <Card src="https://www.rug.nl/research/kenniscentrum-landschap/1-het-kenniscentrum-landschap.jpg" />
        <Card src="https://www.rug.nl/research/kenniscentrum-landschap/1-het-kenniscentrum-landschap.jpg" />
      </div>

    </div>
  );
}