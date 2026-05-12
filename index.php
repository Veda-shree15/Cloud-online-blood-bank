
<?php include 'partials/header.php'; ?>

<div class="hero">
  <h1>Donate Blood, Save Lives ❤️</h1>
  <p>A cloud-based platform to connect blood donors with people in need.</p>

  <div class="buttons">
    <button onclick="window.location.href='donation.php'">Register as Donor</button>
    <button onclick="window.location.href='request.php'">Find Blood</button>
  </div>
</div>

<div class="features">
  <div class="card">
    <h3>Donor Registration</h3>
    <p>Register yourself and help save lives.</p>
  </div>
</div>

<!-- LOGIN MODAL -->
<div id="loginModal" class="modal">
  <div class="modal-box">

    <span class="close" onclick="closeLogin()">&times;</span>
    <h2>WELCOME</h2>

    <form id="loginForm">

      <p class="modal-text">Login using your registered email</p>

      <label>Email</label>
      <div class="input-box">
        <span>📧</span>
        <input type="email" id="loginEmail" required>
      </div>

      <label>Password</label>
      <div class="input-box">
        <span>🔒</span>
        <input type="password" id="loginPassword" required>
        <span class="eye" onclick="togglePassword('loginPassword')">👁</span>
      </div>

      <button type="submit" class="primary-btn">Login</button>

    </form>

    <p>Don't have an account?
      <a href="javascript:void(0);" onclick="openSignup()">Create Account</a>
    </p>

  </div>
</div>


<!-- SIGNUP MODAL -->
<div id="signupModal" class="modal">
  <div class="modal-box">

    <span class="close" onclick="closeSignup()">&times;</span>
    <h2>CREATE ACCOUNT</h2>

    <form id="signupForm">

      <label>Email</label>
      <div class="input-box">
        <span>📧</span>
        <input type="email" id="signupEmail" required>
      </div>

      <label>Password</label>
      <div class="input-box">
        <span>🔒</span>
        <input type="password" id="signupPassword" required>
        <span class="eye" onclick="togglePassword('signupPassword')">👁</span>
      </div>

      <label>Confirm Password</label>
      <div class="input-box">
        <span>🔒</span>
        <input type="password" id="confirmPassword" required>
        <span class="eye" onclick="togglePassword('confirmPassword')">👁</span>
      </div>

      <button type="submit" class="primary-btn">Sign Up</button>

    </form>

    <p>Already have account?
      <a href="javascript:void(0);" onclick="backToLogin()">Login</a>
    </p>

  </div>
</div>


<style>

/* MODAL */

.modal{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.5);
justify-content:center;
align-items:center;
}

.modal-box{
background:white;
padding:30px;
border-radius:10px;
width:350px;
animation:fadeIn 0.3s ease;
}

@keyframes fadeIn{
from{transform:scale(0.9);opacity:0;}
to{transform:scale(1);opacity:1;}
}

.close{
float:right;
cursor:pointer;
font-size:22px;
}

.modal-text{
text-align:center;
color:gray;
margin-bottom:20px;
}

/* INPUT BOX */

.input-box{
position:relative;
display:flex;
align-items:center;
margin-bottom:15px;
}

.input-box span{
margin-right:8px;
}

.input-box input{
flex:1;
padding:10px;
border:1px solid #ccc;
border-radius:5px;
}

.eye{
position:absolute;
right:10px;
cursor:pointer;
}

/* BUTTON */

.primary-btn{
width:100%;
padding:10px;
background:#c0392b;
color:white;
border:none;
border-radius:5px;
cursor:pointer;
margin-top:10px;
transition:0.3s;
}

.primary-btn:hover{
background:#a93226;
}

</style>


<script>

/* MODAL FUNCTIONS */

function openLogin(){
document.getElementById("loginModal").style.display="flex";
}

function closeLogin(){
document.getElementById("loginModal").style.display="none";
}

function openSignup(){
closeLogin();
document.getElementById("signupModal").style.display="flex";
}

function closeSignup(){
document.getElementById("signupModal").style.display="none";
}

function backToLogin(){
closeSignup();
openLogin();
}


/* PASSWORD TOGGLE */

function togglePassword(id){

let field=document.getElementById(id);

if(field.type==="password"){
field.type="text";
}
else{
field.type="password";
}

}


/* AUTH SYSTEM */

document.addEventListener("DOMContentLoaded",function(){

/* SIGNUP */

document.getElementById("signupForm").addEventListener("submit",function(e){

e.preventDefault();

var email=document.getElementById("signupEmail").value;
var password=document.getElementById("signupPassword").value;
var confirm=document.getElementById("confirmPassword").value;

if(password!==confirm){
alert("Passwords do not match");
return;
}

auth.createUserWithEmailAndPassword(email,password)

.then(function(userCredential){

var uid=userCredential.user.uid;

database.ref("users/"+uid).set({
email:email,
role:"user"
});

alert("Account created successfully!");

document.getElementById("signupForm").reset();

closeSignup();
openLogin();

})

.catch(function(error){
alert(error.message);
});

});


/* LOGIN */

document.getElementById("loginForm").addEventListener("submit",function(e){

e.preventDefault();

var email=document.getElementById("loginEmail").value;
var password=document.getElementById("loginPassword").value;

auth.signInWithEmailAndPassword(email,password)

.then(function(userCredential){

var uid=userCredential.user.uid;

database.ref("users/"+uid).once("value")

.then(function(snapshot){

if(!snapshot.exists()){
alert("User record not found");
return;
}

var role=snapshot.val().role;

localStorage.setItem("userEmail",email);
localStorage.setItem("userRole",role);

alert("Login Successful");

if(role==="admin"){
window.location.href="admin_dashboard.php";
}else{
window.location.href="index.php";
}

});

})

.catch(function(error){
alert(error.message);
});

});

});

</script>

<?php include 'partials/footer.php'; ?>

