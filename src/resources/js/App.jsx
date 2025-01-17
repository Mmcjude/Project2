import React, { useState, useEffect } from 'react';
import 'animate.css'; // Animation library for smooth transitions

// Header component with animations
const Header = () => {
    return (
        <header className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-8 text-center shadow-xl animate__animated animate__fadeIn">
            <h1 className="text-4xl font-bold">Welcome to Riley's Bookstore</h1>
            <p className="mt-2 text-xl font-light">Discover books that you'll love</p>
        </header>
    );
};

// Footer component with new styling
const Footer = () => {
    return (
        <footer className="bg-neutral-800 text-white py-6 text-center mt-12 shadow-lg">
            <p>© 2025 Riley's Bookstore. All rights reserved.</p>
        </footer>
    );
};

// Button for going back to homepage
const GoBackBtn = ({ handleGoingBack }) => {
    return (
        <button
            className="inline-block rounded-full py-2 px-6 bg-red-500 hover:bg-red-400 text-white cursor-pointer transition-all duration-300 transform hover:scale-105"
            onClick={handleGoingBack}
        >
            Back
        </button>
    );
};

// Button to see more details about a book
const SeeMoreBtn = ({ bookID, handleBookSelection }) => {
    return (
        <button
            className="inline-block rounded-full py-2 px-6 bg-gradient-to-r from-blue-500 to-indigo-600 hover:bg-indigo-500 text-white cursor-pointer transition-all duration-300 transform hover:scale-105"
            onClick={() => handleBookSelection(bookID)}
        >
            See More
        </button>
    );
};

// Display each book with title, description, and image
const TopBookView = ({ book, index, handleBookSelection }) => {
    return (
        <div
            className={`bg-white rounded-lg mb-8 py-8 flex flex-wrap shadow-lg hover:shadow-xl transform transition-all duration-300 ${index % 2 === 1 ? 'md:flex-row-reverse' : ''} animate__animated animate__fadeIn`}
        >
            <div className={`px-12 md:basis-1/2 ${index % 2 === 1 ? 'md:text-right' : ''}`}>
                <p className="text-3xl leading-8 font-light text-neutral-900">{book.name}</p>
                <p className="text-xl leading-7 font-light text-neutral-700 mb-4">
                    {book.description.split(' ').slice(0, 16).join(' ')}...
                </p>
                <SeeMoreBtn bookID={book.id} handleBookSelection={handleBookSelection} />
            </div>
            <div className="md:basis-1/2">
                <img
                    src={book.image}
                    alt={book.name}
                    className="p-1 rounded-md border border-neutral-200 w-full md:w-2/4 mx-auto hover:transform hover:scale-105 transition-all duration-300"
                />
            </div>
        </div>
    );
};

// Display details of selected book
const SelectedBookView = ({ selectedBook, handleGoingBack }) => {
    return (
        <div className="rounded-lg flex flex-wrap">
            <div className="md:basis-1/2 px-12 md:pt-12">
                <h1 className="text-3xl font-semibold text-neutral-900">{selectedBook.name}</h1>
                <p className="text-xl text-neutral-700">{selectedBook.author}</p>
                <p className="text-xl text-neutral-700 mt-4">{selectedBook.description}</p>
                <dl className="mt-6">
                    <dt className="font-bold">Published</dt>
                    <dd>{selectedBook.year}</dd>
                    <dt className="font-bold">Price</dt>
                    <dd>€ {selectedBook.price}</dd>
                    <dt className="font-bold">Genre</dt>
                    <dd>{selectedBook.genre}</dd>
                </dl>
                <GoBackBtn handleGoingBack={handleGoingBack} />
            </div>
            <div className="md:basis-1/2 pt-12 md:px-12">
                <img
                    src={selectedBook.image}
                    alt={selectedBook.name}
                    className="p-1 rounded-md border border-neutral-200 mx-auto"
                />
            </div>
        </div>
    );
};

// Display related books
const RelatedBookView = ({ book, handleBookSelection }) => {
    return (
        <div className="rounded-lg mb-4 md:basis-1/3 transform transition-all duration-300 hover:scale-105">
            <img
                src={book.image}
                alt={book.name}
                className="max-w-full md:h-80 object-cover rounded-md"
            />
            <div className="p-4">
                <h3 className="text-xl font-semibold text-neutral-900">{book.name}</h3>
                <SeeMoreBtn bookID={book.id} handleBookSelection={handleBookSelection} />
            </div>
        </div>
    );
};

// Display related books section
const RelatedBookSection = ({ selectedBookID, handleBookSelection }) => {
    const [relatedBooks, setRelatedBooks] = useState([]);

    useEffect(() => {
        fetch(`http://localhost/data/get-related-books/${selectedBookID}`)
            .then((response) => response.json())
            .then((data) => setRelatedBooks(data));
    }, [selectedBookID]);

    return (
        <div className="mt-8">
            <h2 className="text-3xl leading-8 font-light text-neutral-900 mb-4">Similar books</h2>
            <div className="flex flex-wrap md:space-x-4 md:flex-row md:flex-nowrap">
                {relatedBooks.map((book) => (
                    <RelatedBookView key={book.id} book={book} handleBookSelection={handleBookSelection} />
                ))}
            </div>
        </div>
    );
};

// Main App component
export default function App() {
    const [topBooks, setTopBooks] = useState([]);
    const [selectedBookID, setSelectedBookID] = useState(null);

    useEffect(() => {
        fetch('http://localhost/data/get-top-books')
            .then((response) => response.json())
            .then((data) => setTopBooks(data));
    }, []);

    const handleBookSelection = (bookID) => {
        setSelectedBookID(bookID);
    };

    const handleGoingBack = () => {
        setSelectedBookID(null);
    };

    return (
        <>
            <Header />
            <main className="mb-8 px-4 md:container md:mx-auto">
                {selectedBookID ? (
                    <BookPage selectedBookID={selectedBookID} handleGoingBack={handleGoingBack} />
                ) : (
                    <div>
                        <h2 className="text-3xl leading-8 font-light text-neutral-900 mb-4">Top Books</h2>
                        {topBooks.map((book, index) => (
                            <TopBookView
                                key={book.id}
                                book={book}
                                index={index}
                                handleBookSelection={handleBookSelection}
                            />
                        ))}
                    </div>
                )}
            </main>
            <Footer />
        </>
    );
}

// BookPage component - Handles selected book display
const BookPage = ({ selectedBookID, handleGoingBack }) => {
    const [selectedBook, setSelectedBook] = useState(null);

    useEffect(() => {
        fetch(`http://localhost/data/get-book/${selectedBookID}`)
            .then((response) => response.json())
            .then((data) => setSelectedBook(data));
    }, [selectedBookID]);

    if (!selectedBook) return <div>Loading...</div>;

    return (
        <div>
            <SelectedBookView selectedBook={selectedBook} handleGoingBack={handleGoingBack} />
            <RelatedBookSection selectedBookID={selectedBook.id} handleBookSelection={handleGoingBack} />
        </div>
    );
};
