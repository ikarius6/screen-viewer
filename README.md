# Screen-Viewer 1.0 - By Mr.Jack
An experiment with PHP and socketio to share your screen in a pretty low rate (because PHP)

## Requeriments
NodeJS
PHP running
php_sockets extension enabled on php.ini

## Installation
```
$ git clone https://github.com/ikarius6/Screen-Viewer
$ cd Screen-Viewer
$ npm install socket.io
```

## Run
On a term run the socketio server
```
$ node screen.js
```

Open screen.html on any browser (double clic it's ok)

On another term run the broadcaster
```
$ php screen.php
```

It could run on local network just by changing the IPs correctly

## Author
[Mr.Jack](https://keybase.io/mrjack)

### Enjoy!