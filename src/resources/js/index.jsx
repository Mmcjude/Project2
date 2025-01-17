import React from 'react';               // Import React library
import ReactDOM from 'react-dom/client';  // Import ReactDOM for rendering the app
import '../css/app.css';                  // Import your CSS file for styling
import App from './App';                  // Import the main App component

// Get the root element from your HTML (with id="root")
const root = ReactDOM.createRoot(document.getElementById('root'));

// Render the App component inside the root element
root.render(
    <React.StrictMode>
        <App />  {/* Your App component */}
    </React.StrictMode>
);
