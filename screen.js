/*
    Screen Viewer V1.0 - By Mr.Jack
    
    Remember to: npm install socket.io
*/
try {
    var io = require('socket.io', { wsEngine: 'ws' }).listen(9875);
    var buffer = "";
    require('net').createServer(function (socket) {
        socket.on('data', function (data) {
            var dt = data.toString();
            if( dt.slice(-10) == "IMAGE_SENT" ){
                io.sockets.emit('guardar_buffer', dt.slice(0,-10));
                socket.write(JSON.stringify({response:"NOTIFICATION_SENT"}) + "\0");
                io.sockets.emit('pintar_imagen');
            }else{
                io.sockets.emit('guardar_buffer', dt);
            }
        });
    }).listen(9876);
} catch(err) {
    console.log(err.message);
}