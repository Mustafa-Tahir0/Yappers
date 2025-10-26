# Real-Time Multi-Room Chat Application 💬

A full-stack real-time chat application featuring WebSocket communication, user authentication, room management, private messaging, and admin controls. Built with Node.js, Socket.io, PHP, and MySQL.

![Node.js](https://img.shields.io/badge/Node.js-Server-green) ![Socket.io](https://img.shields.io/badge/Socket.io-4.8.1-black) ![PHP](https://img.shields.io/badge/PHP-Backend-blue) ![MySQL](https://img.shields.io/badge/MySQL-Database-orange)

## 🎯 Project Overview

This project demonstrates a production-ready chat application with real-time communication capabilities. It showcases expertise in full-stack development, WebSocket protocols, database design, and user authentication systems.

### Key Accomplishments

- **Real-Time Communication**: WebSocket-based instant messaging
- **Multi-Room Architecture**: Support for multiple chat rooms with password protection
- **User Authentication**: Secure login system with bcrypt password hashing
- **Admin Controls**: Room ownership with kick/ban capabilities
- **Private Messaging**: Direct messages between users
- **Persistent Storage**: MySQL database for messages and user data
- **Session Management**: PHP sessions for authentication state
- **CORS Configuration**: Secure cross-origin resource sharing

## 🌟 Features

### 1. User Authentication System
- **Account Creation**: Secure registration with password hashing (bcrypt)
- **Login/Logout**: Session-based authentication
- **Password Security**: Salted password hashing with PHP `password_hash()`
- **Session Persistence**: Users remain logged in across page refreshes
- **Auto-Login**: Automatic reconnection to last visited room

### 2. Real-Time Chat Functionality
- **Instant Messaging**: Socket.io WebSocket communication
- **Message Persistence**: All messages stored in MySQL database
- **Message History**: Retrieve past messages when joining a room
- **Timestamp Display**: Formatted timestamps for each message (MM-DD-YYYY HH:MM)
- **User List**: Live display of users in current room
- **Typing Indicators**: Real-time user presence

### 3. Multi-Room Support
- **Room Creation**: Users can create custom chat rooms
- **Password Protection**: Optional password-protected rooms
- **Room Discovery**: Browse available rooms
- **Join/Leave**: Seamless room switching
- **Default Room**: Main lobby for new users
- **Room Persistence**: Rooms saved in database

### 4. Private Messaging
- **Direct Messages**: Send private messages to specific users
- **Message Buttons**: Quick access to DM any user in the room
- **Visual Distinction**: Private messages clearly marked
- **Real-Time Delivery**: Instant private message notifications

### 5. Admin Controls
- **Room Ownership**: Creator becomes room administrator
- **Kick Users**: Remove disruptive users from rooms
- **Ban Users**: Prevent banned users from rejoining specific rooms
- **Admin UI**: Special controls visible only to room owners
- **Ban Persistence**: Bans stored in database

### 6. User Experience Features
- **Responsive Design**: Works on desktop and mobile
- **User List Display**: See all active participants
- **Last Room Memory**: Automatically rejoin last visited room
- **Password Validation**: Secure room entry with password verification
- **Clean UI**: Organized interface with hidden forms until needed

## 🏗️ Architecture

### System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        Client (Browser)                          │
│  ┌──────────────┐  ┌──────────────┐  ┌───────────────────┐    │
│  │   HTML/CSS   │  │   jQuery     │  │ Socket.io Client  │    │
│  │   Frontend   │  │   AJAX       │  │   WebSocket       │    │
│  └──────────────┘  └──────────────┘  └───────────────────┘    │
└────────┬──────────────────┬──────────────────┬──────────────────┘
         │                  │                  │
         │ HTTP/AJAX        │ HTTP/AJAX        │ WebSocket
         │                  │                  │
┌────────▼──────────────────▼──────────────────▼──────────────────┐
│                      Server Layer                                │
│  ┌──────────────────────────┐  ┌────────────────────────────┐  │
│  │   Node.js HTTP Server    │  │   PHP Backend API          │  │
│  │   • Serves client.html   │  │   • Authentication         │  │
│  │   • Port 3456            │  │   • Database operations    │  │
│  └──────────────────────────┘  │   • Session management     │  │
│                                 │   • CORS handling          │  │
│  ┌──────────────────────────┐  └────────────────────────────┘  │
│  │   Socket.io Server       │              │                    │
│  │   • Real-time messaging  │              │                    │
│  │   • Room management      │              │                    │
│  │   • User tracking        │              │                    │
│  │   • Event broadcasting   │              │                    │
│  └──────────────────────────┘              │                    │
└─────────────────────────────────────────────┼────────────────────┘
                                              │
                                              ▼
                          ┌──────────────────────────────────┐
                          │      MySQL Database              │
                          │  ┌─────────────────────────┐    │
                          │  │ users                   │    │
                          │  │ • username (PK)         │    │
                          │  │ • password_hash         │    │
                          │  └─────────────────────────┘    │
                          │  ┌─────────────────────────┐    │
                          │  │ rooms                   │    │
                          │  │ • name (PK)             │    │
                          │  │ • username (creator)    │    │
                          │  │ • password (optional)   │    │
                          │  └─────────────────────────┘    │
                          │  ┌─────────────────────────┐    │
                          │  │ messages                │    │
                          │  │ • username              │    │
                          │  │ • message               │    │
                          │  │ • room                  │    │
                          │  └─────────────────────────┘    │
                          │  ┌─────────────────────────┐    │
                          │  │ bans                    │    │
                          │  │ • username              │    │
                          │  │ • name (room)           │    │
                          │  └─────────────────────────┘    │
                          └──────────────────────────────────┘
```

### Technology Stack

**Frontend:**
- HTML5/CSS3
- jQuery 3.7.1
- Socket.io Client

**Backend:**
- Node.js (HTTP Server)
- Socket.io 4.8.1 (WebSocket Server)
- PHP 7+ (API Backend)
- MySQL (Database)

**Key Libraries:**
- `socket.io`: Real-time bidirectional communication
- `http`: Node.js HTTP server
- `fs`: File system operations
- `mysqli`: MySQL database driver for PHP

## 📁 Project Structure

```
chat-application/
│
├── chat-server.js              # Node.js WebSocket server
├── client.html                 # Frontend HTML/JavaScript
├── commonFunctions.php         # PHP API endpoints
├── module6.php                 # Database connection
├── client.css                  # Styling (referenced)
├── package.json                # Node.js dependencies
└── README.md                   # This file
```

## 🛠️ Technologies & Concepts

### Socket.io Event System

The application uses a comprehensive event system for real-time communication:

| Event | Direction | Purpose |
|-------|-----------|---------|
| `connection` | Server | Client connects to WebSocket |
| `set_username` | Client → Server | Register username and join default room |
| `join_room` | Client → Server | Switch to different chat room |
| `leave_room` | Client → Server | Exit current room |
| `message_to_server` | Client → Server | Send public message |
| `message_to_client` | Server → Client | Receive public message |
| `private_message` | Bidirectional | Send/receive private messages |
| `update_user_list` | Server → Client | Refresh list of users in room |
| `kick_user` | Client → Server | Admin kicks user from room |
| `kicked` | Server → Client | Notify user they were kicked |
| `disconnect` | Server | Client disconnects |

### Database Schema

**users Table:**
```sql
CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY,
    password_hash VARCHAR(255) NOT NULL
);
```

**rooms Table:**
```sql
CREATE TABLE rooms (
    name VARCHAR(50) PRIMARY KEY,
    username VARCHAR(50),  -- Room creator
    password VARCHAR(255) NULL,  -- Optional password
    FOREIGN KEY (username) REFERENCES users(username)
);
```

**messages Table:**
```sql
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    message TEXT,
    room VARCHAR(50),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (room) REFERENCES rooms(name)
);
```

**bans Table:**
```sql
CREATE TABLE bans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    name VARCHAR(50),  -- Room name
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (name) REFERENCES rooms(name)
);
```

## 📦 Installation & Setup

### Prerequisites

```bash
# Node.js 14.x or higher
node --version

# PHP 7.4 or higher
php --version

# MySQL 5.7 or higher
mysql --version

# npm (comes with Node.js)
npm --version
```

### Step 1: Clone the Repository

```bash
git clone https://github.com/yourusername/chat-application.git
cd chat-application
```

### Step 2: Install Node.js Dependencies

```bash
npm install
```

This will install:
- `socket.io` (^4.8.1)

### Step 3: Set Up MySQL Database

```sql
-- Create database
CREATE DATABASE module6;
USE module6;

-- Create users table
CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY,
    password_hash VARCHAR(255) NOT NULL
);

-- Create rooms table
CREATE TABLE rooms (
    name VARCHAR(50) PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255) NULL,
    FOREIGN KEY (username) REFERENCES users(username)
);

-- Create main room (default lobby)
INSERT INTO rooms (name, username) VALUES ('main', 'system');

-- Create messages table
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    message TEXT,
    room VARCHAR(50),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (room) REFERENCES rooms(name)
);

-- Create bans table
CREATE TABLE bans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    name VARCHAR(50),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (name) REFERENCES rooms(name)
);
```

### Step 4: Configure Database Connection

Edit `module6.php` with your database credentials:

```php
<?php
$mysql = new mysqli(
    'localhost',        // Host
    'your_username',    // Username
    'your_password',    // Password
    'module6'          // Database name
);

if ($mysql->connect_errno) {
    printf("Connection Failed: %s\n", $mysql->connect_error);
    exit;
}
?>
```

### Step 5: Configure CORS Origins

Update `commonFunctions.php` with your allowed origins:

```php
$allowed_origins = [
    "http://localhost:3456",
    "http://your-domain.com:3456",
    "http://127.0.0.1:3456"
];
```

### Step 6: Start the Server

```bash
node chat-server.js
```

Server will start on `http://localhost:3456`

### Step 7: Access the Application

Open your browser and navigate to:
```
http://localhost:3456
```

## 🎮 Usage Guide

### Creating an Account

1. On the landing page, fill in the "Create Account" form
2. Enter desired username and password
3. Click "Create Account"
4. You'll be automatically logged in

### Logging In

1. Enter your username and password in the "Login" form
2. Click "Login"
3. You'll be directed to the main chat lobby

### Creating a Chat Room

1. Click "make room" button
2. Enter a room name
3. Optionally enter a password for privacy
4. Click "Create"
5. The room will appear in the room list

### Joining a Room

1. Click on any room name in the room list
2. If password-protected, enter the password
3. You'll be able to see room history and active users

### Sending Messages

1. Type your message in the input field
2. Click "send" or press Enter
3. Message appears instantly for all users in the room

### Private Messaging

1. Click "Message" button next to any username
2. Enter your private message in the prompt
3. Message is sent privately to that user only

### Admin Controls (Room Owners Only)

1. **Kick User**: Click "Kick" to remove user temporarily
2. **Ban User**: Click "Ban" to permanently ban from room
3. Admin controls only visible to room creator

### Leaving a Room

1. Click "Leave Room" button
2. You'll return to the main lobby
3. Previous room history is preserved

## 🔒 Security Features

### Authentication Security

1. **Password Hashing**: Bcrypt with salt (PHP `password_hash()`)
2. **Session Management**: PHP sessions with secure cookies
3. **SQL Injection Prevention**: Prepared statements with parameterized queries
4. **XSS Protection**: Input sanitization with `htmlentities()`

### Network Security

1. **CORS Configuration**: Whitelist of allowed origins
2. **Credentials Support**: Secure cookie transmission
3. **HTTPS Ready**: Can be deployed with SSL/TLS

### Application Security

1. **Admin Verification**: Database checks for room ownership
2. **Password Verification**: Bcrypt password comparison
3. **Ban System**: Persistent ban storage
4. **Input Validation**: Client and server-side validation

## 🚀 Deployment

### Deploy to AWS EC2 (Current Setup)

The application is configured for AWS EC2 deployment:

```bash
# SSH into your EC2 instance
ssh -i your-key.pem ec2-user@your-ec2-ip

# Install Node.js
curl -sL https://rpm.nodesource.com/setup_16.x | sudo bash -
sudo yum install nodejs -y

# Install MySQL
sudo yum install mysql-server -y
sudo systemctl start mysqld

# Clone and setup
git clone your-repo
cd chat-application
npm install

# Run with PM2 (process manager)
npm install -g pm2
pm2 start chat-server.js
pm2 save
pm2 startup
```

### Configure PHP (Apache/Nginx)

**Apache Configuration:**
```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /var/www/html
    
    <Directory /var/www/html>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Nginx Configuration:**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/html;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php-fpm/php-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }
}
```

### Production Considerations

1. **Use HTTPS**: Install SSL certificate (Let's Encrypt)
2. **Environment Variables**: Store credentials securely
3. **Database Backups**: Regular MySQL backups
4. **Error Logging**: Implement comprehensive logging
5. **Rate Limiting**: Prevent spam and abuse
6. **Load Balancing**: For high traffic scenarios

## 📊 Features Breakdown

### Real-Time Communication Flow

```javascript
// Client sends message
socketio.emit("message_to_server", { message: "Hello!" });

// Server broadcasts to room
io.to(roomName).emit("message_to_client", { message: "Hello!" });

// All clients in room receive
socketio.on("message_to_client", function(data) {
    // Display message
});
```

### Room Management Flow

```javascript
// User joins room
1. Client emits "join_room"
2. Server processes: socket.leave(oldRoom) → socket.join(newRoom)
3. Server updates user lists in both rooms
4. Client fetches room message history
5. Client displays messages and users
```

### Admin Action Flow

```javascript
// Admin kicks user
1. Admin clicks "Kick" button
2. Client emits "kick_user" with username and room
3. Server finds target socket by username
4. Server emits "kicked" event to target user
5. Target user is returned to main lobby
6. Server updates user list in room
```

## 🎯 Technical Highlights

### 1. WebSocket Implementation
- **Bi-directional Communication**: Full-duplex communication channel
- **Event-Driven Architecture**: Clean event handling system
- **Room Management**: Socket.io rooms for isolated communication
- **User Tracking**: In-memory mapping of sockets to usernames

### 2. Database Design
- **Normalized Schema**: Proper foreign key relationships
- **Prepared Statements**: SQL injection prevention
- **Password Security**: Industry-standard bcrypt hashing
- **Message Persistence**: Full chat history storage

### 3. Session Management
- **Secure Cookies**: HTTP-only, path-restricted cookies
- **Auto-Reconnection**: Persistent login across refreshes
- **Last Room Memory**: LocalStorage for UX improvement

### 4. Error Handling
- **Graceful Degradation**: Proper error responses
- **Database Error Handling**: Connection failure management
- **Input Validation**: Both client and server-side

### 5. Scalability Considerations
- **Room-Based Broadcasting**: Efficient message distribution
- **Connection Pooling**: MySQL connection management
- **Stateless PHP**: Horizontal scaling capability

## 🔧 API Endpoints

### PHP Backend API

| Endpoint | Method | Parameters | Purpose |
|----------|--------|------------|---------|
| `checkLogin` | POST | - | Verify active session |
| `create` | POST | username, password | Create new account |
| `login` | POST | username, password | Authenticate user |
| `logout` | POST | - | End session |
| `push` | POST | username, room, message | Save message to DB |
| `get` | POST | room | Retrieve room messages |
| `makeRoom` | POST | username, room, password | Create new room |
| `rooms` | POST | username | Get available rooms |
| `hasPassword` | POST | room | Check if room has password |
| `checkPassword` | POST | room, password | Validate room password |
| `admin` | POST | username, room | Check admin status |
| `ban` | POST | username, room | Ban user from room |

## 🧪 Testing

### Manual Testing Checklist

**Authentication:**
- [ ] Create new account
- [ ] Login with correct credentials
- [ ] Login fails with wrong credentials
- [ ] Session persists on refresh
- [ ] Logout works correctly

**Chat Functionality:**
- [ ] Send message in main room
- [ ] Message appears for all users
- [ ] Message history loads correctly
- [ ] Timestamps are accurate

**Room Management:**
- [ ] Create room without password
- [ ] Create room with password
- [ ] Join room successfully
- [ ] Password validation works
- [ ] Leave room returns to main

**Private Messaging:**
- [ ] Send private message
- [ ] Recipient receives message
- [ ] Private messages are private
- [ ] Message format is correct

**Admin Controls:**
- [ ] Admin buttons visible to owner
- [ ] Kick user works
- [ ] Ban user works
- [ ] Banned user can't rejoin

### Load Testing

```bash
# Using Artillery for load testing
npm install -g artillery
artillery quick --count 100 --num 10 http://localhost:3456
```

## 🎓 Learning Outcomes

This project demonstrates proficiency in:

✅ **Full-Stack Development**: Frontend, backend, and database integration  
✅ **Real-Time Communication**: WebSocket protocols and Socket.io  
✅ **Database Design**: Normalized schema with foreign keys  
✅ **Authentication Systems**: Secure login with session management  
✅ **API Development**: RESTful PHP endpoints  
✅ **Security Best Practices**: Password hashing, prepared statements, CORS  
✅ **Event-Driven Programming**: Socket.io event system  
✅ **User Experience**: Intuitive interface with real-time updates  

## 🛣️ Future Enhancements

### Planned Features
- [ ] **File Sharing**: Upload and share images/files in chat
- [ ] **Emoji Support**: Rich emoji picker
- [ ] **Typing Indicators**: Show when users are typing
- [ ] **Read Receipts**: Message read status
- [ ] **User Profiles**: Avatar images and bio
- [ ] **Voice/Video Chat**: WebRTC integration
- [ ] **Message Reactions**: Like/react to messages
- [ ] **Thread Support**: Reply to specific messages
- [ ] **Search Functionality**: Search messages and rooms
- [ ] **Notifications**: Desktop/push notifications

### Technical Improvements
- [ ] **TypeScript**: Migrate to TypeScript for type safety
- [ ] **Redis**: Cache layer for performance
- [ ] **MongoDB**: NoSQL alternative for scalability
- [ ] **GraphQL**: API query optimization
- [ ] **React/Vue**: Modern frontend framework
- [ ] **Docker**: Containerization for deployment
- [ ] **Kubernetes**: Orchestration for scaling
- [ ] **CI/CD**: Automated testing and deployment
- [ ] **Rate Limiting**: Prevent spam and abuse
- [ ] **Message Encryption**: End-to-end encryption

## 🐛 Troubleshooting

### Common Issues

**"Cannot connect to server"**
```bash
# Check if Node.js server is running
node chat-server.js

# Check port availability
lsof -i :3456
```

**"Database connection failed"**
```bash
# Check MySQL is running
sudo systemctl status mysqld

# Verify credentials in module6.php
mysql -u apache -p
```

**"CORS error in browser"**
- Add your domain to `$allowed_origins` in commonFunctions.php
- Ensure server allows credentials

**"Session not persisting"**
- Check PHP session configuration
- Verify cookie settings
- Clear browser cache

## 📚 Resources & References

- **Socket.io Documentation**: [socket.io/docs](https://socket.io/docs/)
- **PHP MySQLi**: [php.net/manual/en/book.mysqli.php](https://www.php.net/manual/en/book.mysqli.php)
- **jQuery Documentation**: [api.jquery.com](https://api.jquery.com/)
- **Node.js HTTP Module**: [nodejs.org/api/http.html](https://nodejs.org/api/http.html)
- **WebSocket Protocol**: [RFC 6455](https://tools.ietf.org/html/rfc6455)

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 👨‍💻 Author

**Mustafa Tahir**
- GitHub: [@Mustafa-Tahir0](https://github.com/Mustafa-Tahir0)
- LinkedIn: [Mustafa Tahir](https://www.linkedin.com/in/mustafatahir09)
- Email: mustafa.tahir0427@gmail.com
- Portfolio: [Live Site](https://mustafatahir.vercel.app)

## 🙏 Acknowledgments

- **Socket.io Team**: For the excellent real-time engine
- **Node.js Community**: For robust server-side JavaScript
- **PHP Community**: For reliable backend scripting
- **MySQL**: For powerful database management
- **AWS**: For hosting infrastructure

---

⭐ **Star this repository if you found it helpful!**

*Built with 🔌 WebSockets, 💾 MySQL, and ☕ Node.js*

**Perfect for:**
- 🎓 Full-stack portfolio projects
- 💼 Real-time application development
- 🏆 Demonstrating WebSocket expertise
- 📚 Learning client-server architecture
- 🚀 Chat application foundations
