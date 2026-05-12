// Firebase config
var firebaseConfig = {
  apiKey: "AIzaSyAx_Za3_PxObRp71eo3p66pk7g_UuxaaLE",
  authDomain: "onlinebloodbank15.firebaseapp.com",
  databaseURL: "https://onlinebloodbank15-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "onlinebloodbank15",
  storageBucket: "onlinebloodbank15.appspot.com",
  messagingSenderId: "30078511100",
  appId: "1:30078511100:web:5024646a8e4782e0657479"
};

// Initialize Firebase ONLY HERE
firebase.initializeApp(firebaseConfig);

// Global services
var auth = firebase.auth();
var database = firebase.database();