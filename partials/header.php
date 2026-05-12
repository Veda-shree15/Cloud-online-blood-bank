<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Online Blood Bank - HopeDrop</title>
<link rel="stylesheet" href="style.css">

<style>

/* NAVBAR */
.navbar{
  background-color:#c0392b;
  color:white;
  padding:15px 30px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.logo{
  font-size:22px;
  font-weight:bold;
}

.menu a{
  color:white;
  text-decoration:none;
  margin-left:20px;
  font-weight:bold;
}

.menu a:hover{
  text-decoration:underline;
}

/* USER MENU */
.user-menu{
  position:relative;
  display:inline-block;
}

.user-btn{
  background:none;
  border:none;
  color:white;
  font-weight:bold;
  cursor:pointer;
  font-size:16px;
}

/* DROPDOWN */
.dropdown{
  display:none;
  position:absolute;
  right:0;
  top:35px;
  background:white;
  min-width:160px;
  box-shadow:0px 5px 15px rgba(0,0,0,0.2);
  border-radius:6px;
  overflow:hidden;
}

.dropdown a{
  display:block;
  padding:12px;
  text-decoration:none;
  color:black;
}

.dropdown a:hover{
  background:#f1f1f1;
}

/* BUTTON STYLE */
button{
  background-color:#c0392b;
  color:white;
  padding:10px 15px;
  border:none;
  border-radius:5px;
  cursor:pointer;
  font-weight:bold;
}

button:hover{
  background-color:#a93226;
}

/* MODAL */
.modal{
  display:none;
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background:rgba(0,0,0,0.6);
  justify-content:center;
  align-items:center;
}

.modal-box{
  background:white;
  padding:25px;
  width:350px;
  border-radius:8px;
}

.close{
  float:right;
  cursor:pointer;
  font-size:20px;
}

.modal-box input, .modal-box select{
  width:100%;
  padding:8px;
  margin:8px 0;
}

</style>
<!-- Firebase v8 SDK -->
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>

<!-- Your Firebase Config -->
<script src="firebase/firebaseConfig.js"></script>
</head>
<body>

<div class="navbar">
  <div class="logo">🩸 HopeDrop</div>

  <div class="menu">
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="donation.php">Donate</a>
    <a href="request.php">Request</a>

    <a href="javascript:void(0);" onclick="openLogin()" id="loginBtn">Login</a>

    <div class="user-menu" id="userMenu" style="display:none;">
      <button class="user-btn" onclick="toggleDropdown()">
        <span id="userEmail"></span> ▼
      </button>

      <div class="dropdown" id="dropdownMenu">
        <a href="profile.php">Edit Profile</a>
        <a href="#" onclick="logout()">Logout</a>
      </div>
    </div>
  </div>
</div>

<script>
function toggleDropdown(){
 var menu=document.getElementById("dropdownMenu");
 menu.style.display=(menu.style.display==="block")?"none":"block";
}

function logout(){
 localStorage.removeItem("userEmail");
 localStorage.removeItem("userRole");
 if(typeof auth!=="undefined"){auth.signOut();}
 alert("Logged out successfully");
 window.location.href="index.php";
}

window.addEventListener("load",function(){
 var email=localStorage.getItem("userEmail");
 if(email){
  document.getElementById("loginBtn").style.display="none";
  document.getElementById("userMenu").style.display="inline-block";
  document.getElementById("userEmail").innerText=email;
 }
});
</script>