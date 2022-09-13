// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyAnarX9u8kFVklreePU_UUeHE2BmCVVRs4",
    authDomain: "merchant-bay-service.firebaseapp.com",
    projectId: "merchant-bay-service",
    storageBucket: "merchant-bay-service.appspot.com",
    messagingSenderId: "789211877611",
    appId: "1:789211877611:web:006bb3073632a306daeeae",
    measurementId: "G-M5LLMK2G5S"
});


// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);

    const title = payload.notification.title;
    const options = {
        body: payload.notification.body,
        icon: payload.notification.icon,
        data:{
            time:  new Date(Date.now()).toString(),
            click_action: payload.notification.click_action
        }
    };

    return self.registration.showNotification(
        title,
        options,
    );
    
});
// self.addEventListener('notificationonclick',function(event){
//     var action_click=event.notification.data.click_action;
//     event.notification.close();
//     event.waitUntil(
//         clients.openWindow(action_click)
//     );

// });
//Code for adding event on click of notification
self.addEventListener('notificationclick', function(event) {
    let url = event.notification.data.click_action;
    event.notification.close(); 
    event.waitUntil(
        clients.matchAll({type: 'window'}).then( windowClients => {
            // Check if there is already a window/tab open with the target URL
            for (var i = 0; i < windowClients.length; i++) {
                var client = windowClients[i];
                // If so, just focus it.
                if (client.url === url && 'focus' in client) {
                    return client.focus();
                }
            }
            // If not, then open the target URL in a new window/tab.
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});