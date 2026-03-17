import Image from "next/image";

type CardProps = { src: string; alt?: string };

export default function Card({ src, alt = "" }: CardProps) {
  return (
    <div className="w-full max-w-sm p-5 rounded-xl bg-white flex flex-col gap-3 shadow-md">
      
      <Image
        src={src}
        alt={alt}
        width={400}
        height={200}
        className="w-full h-48 object-cover rounded-lg"
      />

      <h4 className="text-lg font-semibold text-gray-800">
        Kaart
      </h4>

      <p className="text-sm text-gray-600">
        Mooie natuur kaart met beschrijving.
      </p>

      <button className="mt-auto px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition">
        Klik
      </button>

    </div>
  );
}