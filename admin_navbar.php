<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RedHope Admin Panel</title>

<!-- Firebase SDK -->

<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-database.js"></script>

<script>

const firebaseConfig = {
apiKey: "AIzaSyAx_Za3_PxObRp71eo3p66pk7g_UuxaaLE",
authDomain: "onlinebloodbank15.firebaseapp.com",
databaseURL: "https://onlinebloodbank15-default-rtdb.asia-southeast1.firebasedatabase.app",
projectId: "onlinebloodbank15",
storageBucket: "onlinebloodbank15.appspot.com",
messagingSenderId: "30078511100",
appId: "1:30078511100:web:5024646a8e4782e0657479"
};

if (!firebase.apps.length){
firebase.initializeApp(firebaseConfig);
}

</script>

<style>

/* PAGE STRUCTURE */

html,body{
height:100%;
margin:0;
font-family:Arial;
background:#f4f4f4;
display:flex;
flex-direction:column;
}

/* MAIN CONTENT */

.main-content{
flex:1;
padding:20px;
}

/* ADMIN NAVBAR */

.admin-navbar{
display:flex;
justify-content:space-between;
align-items:center;
background:#c0392b;
color:white;
padding:8px 25px;
}

/* TITLE */

.admin-navbar h2{
margin:0;
font-size:20px;
}

/* RIGHT SIDE */

.admin-right{
display:flex;
align-items:center;
}

/* HELLO ADMIN */

.admin-right span{
margin-right:15px;
font-size:14px;
}

/* NAV LINKS */

.admin-navbar a{
color:white;
margin-left:15px;
text-decoration:none;
font-weight:bold;
font-size:14px;
}

.admin-navbar a:hover{
text-decoration:underline;
}

</style>

</head>

<body>

<nav class="admin-navbar">

<h2>🩸 RedHope Admin</h2>

<div class="admin-right">
<span>Hello Admin 👋</span>
<a href="admin_dashboard.php">Dashboard</a>
<a href="manage_donations.php">Manage Donations</a>
<a href="manage_requests.php">Manage Requests</a>
<a href="manage_users.php">Manage Users</a>
<a href="index.php">Logout</a>
</div>

</nav>

<div class="main-content">