var io = require('socket.io')(http);

var Redis = require('ioredis');

var redis = new Redis();

redis.subscribe('test-channel', function (err, count) {
    
    //
});

redis.on('message', function(channel, message) {
    console.log("Message Received!");
    
    message = JSON.parse(message);
    
    io.emit(channel + ":" + message.event, message.payload);
    
    
});

http.listen(3000, function() {
    console.log("Listening on *:3000");
});
