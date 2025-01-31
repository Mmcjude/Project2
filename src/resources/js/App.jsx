import React, { useState, useEffect } from "react";
import { motion, AnimatePresence } from "framer-motion";
import "../css/app.css";
import "../css/loader.css";

function Loader() {
    return (
        <div className="flex justify-center items-center min-h-screen">
            <div className="loader"></div>
        </div>
    );
}

function ErrorMessage({ msg }) {
    return (
        <div className="md:container md:mx-auto bg-red-300 my-8 p-2 text-center rounded-lg shadow-lg">
            <p className="text-black font-semibold">{msg}</p>
        </div>
    );
}

function SeeMoreBtn({ bookID, handleBookSelection }) {
    return (
        <motion.button
            whileHover={{ scale: 1.1 }}
            whileTap={{ scale: 0.95 }}
            className="inline-block rounded-full py-2 px-6 bg-gradient-to-r from-blue-500 to-indigo-600 hover:bg-indigo-500 text-white cursor-pointer transition-all duration-300"
            onClick={() => handleBookSelection(bookID)}
        >
            See More
        </motion.button>
    );
}

function BookCard({ book, handleBookSelection }) {
    return (
        <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5 }}
            className="rounded-lg mb-4 p-4 shadow-lg bg-white hover:scale-105 transition-all"
        >
            <img src={book.image} alt={book.name} className="w-full h-64 object-cover rounded-md" />
            <h3 className="text-xl font-semibold mt-4">{book.name}</h3>
            <p className="text-md text-gray-600 mb-2">{book.author}</p>
            <SeeMoreBtn bookID={book.id} handleBookSelection={handleBookSelection} />
        </motion.div>
    );
}

function RelatedBookSection({ selectedBookID, handleBookSelection }) {
    const [relatedBooks, setRelatedBooks] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        setIsLoading(true);
        fetch(`http://localhost/data/get-related-books/${selectedBookID}`)
            .then((response) => {
                if (!response.ok) throw new Error("Failed to fetch related books");
                return response.json();
            })
            .then((data) => {
                setRelatedBooks(data);
                setIsLoading(false);
            })
            .catch((err) => {
                setError(err.message);
                setIsLoading(false);
            });
    }, [selectedBookID]);

    if (isLoading) return <Loader />;
    if (error) return <ErrorMessage msg={error} />;

    return (
        <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} transition={{ duration: 0.5 }}>
            <h2 className="text-3xl font-light mb-4">Similar Books</h2>
            <div className="grid md:grid-cols-3 gap-4">
                {relatedBooks.map((book) => (
                    <BookCard key={book.id} book={book} handleBookSelection={handleBookSelection} />
                ))}
            </div>
        </motion.div>
    );
}

function BookPage({ selectedBook, handleBookSelection, handleGoingBack }) {
    return (
        <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} transition={{ duration: 0.5 }}>
            <div className="flex flex-wrap">
                <div className="md:w-1/2 p-4">
                    <h1 className="text-4xl font-semibold">{selectedBook.name}</h1>
                    <p className="text-lg text-gray-700">{selectedBook.author}</p>
                    <p className="mt-2 text-gray-600">{selectedBook.description}</p>
                    <button
                        className="mt-4 px-6 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-all"
                        onClick={handleGoingBack}
                    >
                        Back
                    </button>
                </div>
                <div className="md:w-1/2 p-4">
                    <motion.img
                        src={selectedBook.image}
                        alt={selectedBook.name}
                        className="w-full rounded-md shadow-md"
                        whileHover={{ scale: 1.05 }}
                    />
                </div>
            </div>
            <RelatedBookSection selectedBookID={selectedBook.id} handleBookSelection={handleBookSelection} />
        </motion.div>
    );
}

export default function App() {
    const [topBooks, setTopBooks] = useState([]);
    const [selectedBookID, setSelectedBookID] = useState(null);
    const [selectedBook, setSelectedBook] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        setIsLoading(true);
        fetch("http://localhost/data/get-top-books")
            .then((response) => {
                if (!response.ok) throw new Error("Failed to fetch top books");
                return response.json();
            })
            .then((data) => {
                setTopBooks(data);
                setIsLoading(false);
            })
            .catch((err) => {
                setError(err.message);
                setIsLoading(false);
            });
    }, []);

    useEffect(() => {
        if (selectedBookID) {
            setIsLoading(true);
            fetch(`http://localhost/data/get-book/${selectedBookID}`)
                .then((response) => {
                    if (!response.ok) throw new Error("Failed to fetch book details");
                    return response.json();
                })
                .then((data) => {
                    setSelectedBook(data);
                    setIsLoading(false);
                })
                .catch((err) => {
                    setError(err.message);
                    setIsLoading(false);
                });
        }
    }, [selectedBookID]);

    const handleGoingBack = () => {
        setSelectedBookID(null);
        setSelectedBook(null);
    };

    if (isLoading) return <Loader />;
    if (error) return <ErrorMessage msg={error} />;

    return (
        <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} transition={{ duration: 1 }}>
            <header className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-8 text-center shadow-xl">
                <h1 className="text-4xl font-bold"> Frida's Library</h1>
            </header>
            <main className="container mx-auto p-4">
                <AnimatePresence>
                    {selectedBook ? (
                        <BookPage
                            selectedBook={selectedBook}
                            handleBookSelection={setSelectedBookID}
                            handleGoingBack={handleGoingBack}
                        />
                    ) : (
                        <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} transition={{ duration: 0.5 }}>
                            <h2 className="text-3xl font-light mb-4">Top Books</h2>
                            <div className="grid md:grid-cols-3 gap-4">
                                {topBooks.map((book) => (
                                    <BookCard key={book.id} book={book} handleBookSelection={setSelectedBookID} />
                                ))}
                            </div>
                        </motion.div>
                    )}
                </AnimatePresence>
            </main>
            <footer className="bg-gray-800 text-white py-6 text-center">
                <p>© 2025 Frida's Library. All rights reserved.</p>
            </footer>
        </motion.div>
    );
}
