
// import Echo from 'laravel-echo'

// window.Echo = new Echo({
//   broadcaster: 'pusher',
//   key: 'd917e76cffb0a5d90d4e',
//   cluster: 'ap2',
//   forceTLS: true
// });

// var channel = Echo.channel(`App.Model.User.${userId}`);
// channel.listen('.my-event', function(data) {
//   alert(JSON.stringify(data));
// });

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('d917e76cffb0a5d90d4e', {
  cluster: 'ap2'
});

var channel = pusher.subscribe(`App.Model.User.${userId}`);
channel.bind('my-event', function(data) {
  alert(JSON.stringify(data));
});