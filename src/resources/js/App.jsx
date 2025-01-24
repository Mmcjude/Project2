import React, { useState, useEffect } from 'react';
import '../css/app.css';
import '../css/loader.css';


// Loader component (simple loading indicator)
function Loader() {
    return (
        <div className="flex justify-center items-center">
            <div className="spinner"></div>
        </div>
    );
}

// See More Button
function SeeMoreBtn({ bookID, handleBookSelection }) {
    return (
        <button
            className="inline-block rounded-full py-2 px-6 bg-gradient-to-r from-blue-500 to-indigo-600 hover:bg-indigo-500 text-white cursor-pointer transition-all duration-300 transform hover:scale-105"
            onClick={() => handleBookSelection(bookID)}
        >
            See More
        </button>
    );
}

// Top Book View - Displays each book in the top books list
function TopBookView({ book, handleBookSelection }) {
    return (
        <div className="rounded-lg mb-4 md:basis-1/3">
            <img
                src={book.image}
                alt={book.name}
                className="md:h-[400px] md:mx-auto max-md:w-2/4 max-md:mx-auto"
            />
            <div className="p-4">
                <h3 className="text-xl leading-7 font-light text-neutral-900 mb-4">
                    {book.name}
                </h3>
                <p className="text-lg font-light text-neutral-600 mb-2">{book.author}</p>
                <SeeMoreBtn bookID={book.id} handleBookSelection={handleBookSelection} />
            </div>
        </div>
    );
}

// Related Book View - Displays each related book
function RelatedBookView({ book, handleBookSelection }) {
    return (
        <div className="rounded-lg mb-4 md:basis-1/3">
            <img
                src={book.image}
                alt={book.name}
                className="md:h-[400px] md:mx-auto max-md:w-2/4 max-md:mx-auto"
            />
            <div className="p-4">
                <h3 className="text-xl leading-7 font-light text-neutral-900 mb-4">
                    {book.name}
                </h3>
                <SeeMoreBtn bookID={book.id} handleBookSelection={handleBookSelection} />
            </div>
        </div>
    );
}

// Related Book Section - Displays the "Similar Books" section
function RelatedBookSection({ selectedBookID, handleBookSelection }) {
    const [relatedBooks, setRelatedBooks] = useState([]);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        fetch(`http://localhost/data/get-related-books/${selectedBookID}`)
            .then((response) => response.json())
            .then((data) => {
                setRelatedBooks(data);
                setIsLoading(false);
            });
    }, [selectedBookID]);

    if (isLoading) {
        return <Loader />;
    }

    return (
        <>
            <div className="flex flex-wrap">
                <h2 className="text-3xl leading-8 font-light text-neutral-900 mb-4">Similar books</h2>
            </div>
            <div className="flex flex-wrap md:flex-row md:space-x-4 md:flex-nowrap">
                {relatedBooks.map((book) => (
                    <RelatedBookView
                        book={book}
                        key={book.id}
                        handleBookSelection={handleBookSelection}
                    />
                ))}
            </div>
        </>
    );
}

// Selected Book View - Displays the selected book details
function SelectedBookView({ selectedBook, handleGoingBack }) {
    return (
        <>
            <div className="rounded-lg flex flex-wrap md:flex-row">
                <div className="order-2 md:order-1 md:pt-12 md:basis-1/2">
                    <h1 className="text-3xl leading-8 font-light text-neutral-900 mb-2">
                        {selectedBook.name}
                    </h1>
                    <p className="text-xl leading-7 font-light text-neutral-900 mb-2">
                        {selectedBook.author}
                    </p>
                    <p className="text-xl leading-7 font-light text-neutral-900 mb-4">
                        {selectedBook.description}
                    </p>
                    <dl className="mb-4 md:flex md:flex-wrap md:flex-row">
                        <dt className="font-bold md:basis-1/4">Published</dt>
                        <dd className="mb-2 md:basis-3/4">{selectedBook.year}</dd>
                        <dt className="font-bold md:basis-1/4">Price</dt>
                        <dd className="mb-2 md:basis-3/4">€ {selectedBook.price}</dd>
                        <dt className="font-bold md:basis-1/4">Genre</dt>
                        <dd className="mb-2 md:basis-3/4">{selectedBook.genre}</dd>
                    </dl>
                </div>
                <div className="order-1 md:order-2 md:pt-12 md:px-12 md:basis-1/2">
                    <img
                        src={selectedBook.image}
                        alt={selectedBook.name}
                        className="p-1 rounded-md border border-neutral-200 mx-auto"
                    />
                </div>
            </div>
            <div className="mb-12 flex flex-wrap">
                <GoBackBtn handleGoingBack={handleGoingBack} />
            </div>
        </>
    );
}

// Go Back Button
function GoBackBtn({ handleGoingBack }) {
    return (
        <button
            className="inline-block rounded-full py-2 px-4 bg-neutral-500 hover:bg-neutral-400 text-neutral-50 cursor-pointer"
            onClick={handleGoingBack}
        >
            Back
        </button>
    );
}

// BookPage - Displays the selected book page and the related books section
function BookPage({ selectedBook, handleBookSelection, handleGoingBack }) {
    return (
        <>
            <SelectedBookView
                selectedBook={selectedBook}
                handleGoingBack={handleGoingBack}
            />
            <RelatedBookSection
                selectedBookID={selectedBook.id}
                handleBookSelection={handleBookSelection}
            />
        </>
    );
}

// Header component with animations and cat logo
const Header = () => {
    return (
        <header className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-8 text-center shadow-xl animate__animated animate__fadeIn">
            <img
                src="/images/cat.png"
                alt="Cat Logo"
                className="w-20 h-20 mx-auto mb-4 rounded-full shadow-lg"
            />
            <h1 className="text-4xl font-bold">Welcome to Lexy's Bookstore</h1>
            <p className="mt-2 text-xl font-light">Discover books that you'll love - Communication & Comprehension</p>
        </header>
    );
};

// Footer component with new styling
const Footer = () => {
    return (
        <footer className="bg-neutral-800 text-white py-6 text-center mt-12 shadow-lg">
            <p>© 2025 Lexy's Bookstore. All rights reserved.</p>
        </footer>
    );
};

// App - The main component
export default function App() {
    const [topBooks, setTopBooks] = useState([]);
    const [selectedBookID, setSelectedBookID] = useState(null);
    const [selectedBook, setSelectedBook] = useState(null);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        fetch('http://localhost/data/get-top-books')
            .then((response) => response.json())
            .then((data) => {
                setTopBooks(data);
                setIsLoading(false);
            });
    }, []);

    useEffect(() => {
        if (selectedBookID) {
            fetch(`http://localhost/data/get-book/${selectedBookID}`)
                .then((response) => response.json())
                .then((data) => {
                    setSelectedBook(data);
                });
        }
    }, [selectedBookID]);

    const handleBookSelection = (bookID) => {
        setSelectedBookID(bookID);
    };

    const handleGoingBack = () => {
        setSelectedBookID(null);
        setSelectedBook(null);
    };

    if (isLoading) {
        return <Loader />;
    }

    return (
        <>
            <Header />
            <main className="mb-8 px-4 md:container md:mx-auto">
                {selectedBook ? (
                    <BookPage
                        selectedBook={selectedBook}
                        handleBookSelection={handleBookSelection}
                        handleGoingBack={handleGoingBack}
                    />
                ) : (
                    <div>
                        <h2 className="text-3xl leading-8 font-light text-neutral-900 mb-4">Top Books</h2>
                        {topBooks.map((book) => (
                            <TopBookView
                                key={book.id}
                                book={book}
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
