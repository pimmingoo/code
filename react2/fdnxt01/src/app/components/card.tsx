type CardProps = { src: string; alt?: string };

export default function Card({ src, alt = "" }: CardProps) {
  return (
    <div className="w-full max-w-sm p-5 rounded-xl bg-gray-200 flex flex-col gap-3 shadow-md">
      <img
        src={src}
        alt={alt}
        className="w-full h-48 object-cover rounded-lg"
      />

      <h4 className="text-lg font-semibold text-gray-800">
        Kaart
      </h4>

      <p className="text-sm text-gray-600 leading-relaxed">
        dlablabalbla <br />ss
        fagdgdasgdsagsd <br />
        gadsgadsgasd
      </p>

      <button className="mt-auto self-start px-4 py-2 rounded-md bg-black text-white text-sm font-medium hover:bg-gray-800 transition">
        Klik
      </button>
    </div>
  );
}
