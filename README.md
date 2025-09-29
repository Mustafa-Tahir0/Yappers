# 🗨️ Real-Time Chatroom Web App

This is a full-featured real-time chatroom application built using:
- **Frontend**: HTML, CSS, jQuery, Socket.IO
- **Backend**: PHP + MySQL (REST API) and Node.js (WebSocket server)
- **Features**: User authentication, room creation (with optional passwords), admin powers (kick/ban), private messaging, and live user lists.

---

## 🚀 Features

- 🔐 **User Authentication**: Register, login, and session-based persistence
- 🧩 **Room System**: Create and join rooms, optionally password-protected
- 🧑‍⚖️ **Admin Tools**: Admins can kick/ban users from their rooms
- 🗣️ **Real-Time Messaging**: Powered by Socket.IO for instant chat
- 📬 **Private Messaging**: Send DMs to other users in the same room
- 📜 **Message History**: Room message logs persist in MySQL

---

## 📦 Technologies Used

- **Frontend**: HTML, CSS, jQuery, Socket.IO
- **Backend (REST API)**: PHP with MySQL
- **Backend (WebSockets)**: Node.js + Socket.IO
- **Database**: MySQL
- **Session**: PHP sessions + CSRF-safe interaction

---

## 🛠️ Setup & Deployment

### 🧱 Local Development

1. **Backend (PHP + MySQL)**:
   - Ensure you have a working PHP + MySQL environment (e.g., XAMPP, MAMP).
   - Import the `module6` schema into your MySQL server (create tables for users, rooms, messages, bans).
   - Update DB credentials in `database.php`.

2. **WebSocket Server**:
   - Ensure Node.js is installed.
   - Run `npm install socket.io` in your project directory.
   - Start the server with:
     ```bash
     node server.js
     ```

3. **Frontend**:
   - Open `client.html` in your browser via `localhost` or serve it via the Node/PHP server.

---

### 🌍 Deployment (Recommended Setup)

#### 📦 Backend on Render

1. Upload PHP files (`chat.php`, `commonFunctions.php`, etc.) to a new **Render Web Service**.
2. Use a MySQL-compatible Render database (or external one like PlanetScale).
3. Ensure CORS and sessions work via `https`.

#### 🌐 Frontend on Vercel

1. Push `client.html` and associated static assets to a GitHub repo.
2. Connect that repo to Vercel and deploy.

---

## 📁 File Structure
├── client.html # Main frontend interface
├── client.css # Stylesheet (hosted externally)
├── server.js # Node.js + Socket.IO WebSocket server
├── database.php # MySQL connection logic
├── commonFunctions.php # Handles all REST API actions
├── README.md # You're here!

---

## 🔒 Security Notes

- Passwords are hashed using `password_hash()` and verified securely.
- Banned users cannot join rooms again.
- Session tokens are used for authentication; consider adding CSRF protection for production.