const http = require("http"),
    fs = require("fs");

const port = 3456;
const file = "client.html";

const server = http.createServer(function (req, res) {
    fs.readFile(file, function (err, data) {
        if (err) return res.writeHead(500);
        res.writeHead(200);
        res.end(data);
    });
});
server.listen(port);

const socketio = require("socket.io")(http, {
    wsEngine: 'ws'
});

const io = socketio.listen(server);

const userSockets = {}; // Maps socket IDs to usernames

// Function to update the user list in a specific room
function updateRoomUsers(room) {
    const roomSockets = io.sockets.adapter.rooms.get(room); // Use .get(room) to access the sockets in the room
    if (!roomSockets) {
        return; // If the room does not exist or is empty, do nothing
    }
    const users = Array.from(roomSockets).map(socketId => userSockets[socketId]).filter(Boolean); // Get users based on their socket IDs
    io.to(room).emit("update_user_list", users); // Send updated user list to all clients in the room
}

// Function to get the list of users in a room
function getUsersInRoom(room) {
    const roomSockets = io.sockets.adapter.rooms.get(room);
    if (!roomSockets) return [];
    return Array.from(roomSockets).map(socketId => userSockets[socketId]);
}

io.sockets.on("connection", function (socket) {
    const defaultRoom = "main";

    // Set username for the user
    socket.on("set_username", (username) => {
        userSockets[socket.id] = username; // Store the username for this socket
        socket.join(defaultRoom); // Join the user to the default room
        socket.currentRoom = defaultRoom; // Set the user's current room
        updateRoomUsers(socket.currentRoom); // Update the room's user list
    });

    // Handle the user joining a room
    socket.on("join_room", (room) => {
        socket.leave(socket.currentRoom); // Leave the current room
        updateRoomUsers(socket.currentRoom); // Update the previous room's user list
        socket.join(room); // Join the new room
        socket.currentRoom = room; // Update the user's current room
        updateRoomUsers(socket.currentRoom); // Update the new room's user list
    });

    // Handle the user leaving the room
    socket.on("leave_room", (room) => {
        socket.leave(room); // Leave the specified room
        updateRoomUsers(socket.currentRoom); // Update the previous room's user list
        socket.join(defaultRoom); // Join the default room
        socket.currentRoom = defaultRoom; // Set the current room to default
        updateRoomUsers(socket.currentRoom); // Update the default room's user list
    });

    // Handle the admin kicking a user
    socket.on("kick_user", ({ user, room }) => {
        // Find the socket ID associated with the given username
        const socketToKick = Object.keys(userSockets).find(id => userSockets[id] === user);
    
        // Check if the user exists in userSockets and is in the correct room
        if (socketToKick) {
            // Emit the "kicked" event to the user being kicked, sending them back to the default room
            io.to(socketToKick).emit("kicked", { newRoom: defaultRoom });
            // Update the user list in the room after the user is kicked
            io.to(room).emit("update_user_list", getUsersInRoom(room));
        } else {
            // Log an error message if user not found or room mismatch
            console.log('User not found or room mismatch');
        }
    });

    socket.on("private_message", ({ recipient, message }) => {
        // Find the socket ID of the recipient
        const recipientSocketId = Object.keys(userSockets).find(
            id => userSockets[id] === recipient
        );
    
        if (recipientSocketId) {
            io.to(recipientSocketId).emit("private_message", {
                sender: userSockets[socket.id],
                message
            });
        }
    });

    // Handle user disconnection
    socket.on("disconnect", () => {
        if (userSockets[socket.id]) {
            // Remove the user from the tracking object
            delete userSockets[socket.id];
            // Broadcast updated user list (optional if you need it)
            io.emit("update_user_list", Object.values(userSockets));
        }
    });

    // Handle messages
    socket.on('message_to_server', function (data) {
        io.to(socket.currentRoom).emit("message_to_client", { message: data["message"] }); // Broadcast the message to other users in the same room
    });
});