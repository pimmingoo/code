import "./globals.css";
import Link from "next/link";
import { Inter } from "next/font/google";

const inter = Inter({ subsets: ["latin"] });

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en">
      <body className={inter.className + " flex flex-col min-h-screen"}>
        
        {/* Navbar */}
        <header className="bg-blue-600 text-white p-4">
          <nav className="flex gap-4">
            <Link href="/">Home</Link>
            <Link href="/about">About</Link>
            <Link href="/contact">Contact</Link>
          </nav>
        </header>

        {/* Content */}
        <main className="flex-1 p-6 bg-gray-100">
          {children}
        </main>

        {/* Footer */}
        <footer className="bg-gray-800 text-white text-center p-4">
          © 2026 Pim Prins
        </footer>

      </body>
    </html>
  );
}