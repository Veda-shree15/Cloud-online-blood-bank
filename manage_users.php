
<?php include 'admin_navbar.php'; ?>

<h2 style="text-align:center;margin-top:20px;">Manage Users</h2>

<div class="user-form">

<input type="email" id="newEmail" placeholder="Email">

<div class="password-box">
<input type="password" id="password" placeholder="Password">
<span onclick="togglePassword('password')">👁</span>
</div>

<div class="password-box">
<input type="password" id="confirmPassword" placeholder="Confirm Password">
<span onclick="togglePassword('confirmPassword')">👁</span>
</div>

<button onclick="addUser()">Add User</button>

</div>

<table class="admin-table">

<thead>
<tr>
<th>Email</th>
<th>Action</th>
</tr>
</thead>

<tbody id="usersBody"></tbody>

</table>

<script>

// Load users table
firebase.database().ref("users").on("value",function(snapshot){

let html="";

snapshot.forEach(function(user){

let uid=user.key;
let data=user.val();

html+=`

<tr>
<td>${data.email}</td>

<td>
<button class="delete-btn" onclick="deleteUser('${uid}')">Delete</button>
</td>

</tr>

`;

});

document.getElementById("usersBody").innerHTML=html;

});


// ADD USER
function addUser(){

let email=document.getElementById("newEmail").value;
let password=document.getElementById("password").value;
let confirm=document.getElementById("confirmPassword").value;

if(email=="" || password=="" || confirm==""){
alert("Please fill all fields");
return;
}

if(password!==confirm){
alert("Passwords do not match");
return;
}


// Create user in Firebase Authentication
firebase.auth().createUserWithEmailAndPassword(email,password)

.then(function(userCredential){

let uid=userCredential.user.uid;

// Save user in database
firebase.database().ref("users/"+uid).set({
email:email,
role:"user"
});

alert("User Added Successfully");

// Clear fields
document.getElementById("newEmail").value="";
document.getElementById("password").value="";
document.getElementById("confirmPassword").value="";

})

.catch(function(error){
alert(error.message);
});

}


// DELETE USER
function deleteUser(uid){

firebase.database().ref("users/"+uid).remove();

alert("User Deleted");

}


// SHOW/HIDE PASSWORD
function togglePassword(id){

let field=document.getElementById(id);

if(field.type==="password"){
field.type="text";
}else{
field.type="password";
}

}

</script>

<style>

.user-form{
text-align:center;
margin:30px;
}

.user-form input{
padding:8px;
margin:8px;
width:200px;
}

.password-box{
position:relative;
display:inline-block;
}

.password-box span{
position:absolute;
right:10px;
top:8px;
cursor:pointer;
}

.user-form button{
background:#27ae60;
color:white;
border:none;
padding:8px 16px;
border-radius:5px;
cursor:pointer;
}

.admin-table{
width:80%;
margin:auto;
border-collapse:collapse;
margin-top:30px;
}

.admin-table th{
background:#c0392b;
color:white;
padding:12px;
}

.admin-table td{
padding:10px;
border:1px solid #ddd;
text-align:center;
}

.delete-btn{
background:#e74c3c;
color:white;
border:none;
padding:6px 12px;
border-radius:5px;
cursor:pointer;
}

</style>

<?php include 'admin_footer.php'; ?>

