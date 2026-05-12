<?php include 'admin_navbar.php'; ?>

<section class="admin-dashboard">

<h2 style="text-align:center;margin-top:30px;">Admin Dashboard</h2>

<div class="dashboard-cards">

<div class="card">
<h3>Total Donations</h3>
<p id="totalDonations">0</p>
</div>

<div class="card">
<h3>Total Requests</h3>
<p id="totalRequests">0</p>
</div>

<div class="card">
<h3>Total Users</h3>
<p id="totalUsers">0</p>
</div>

</div>

</section>

<style>

.admin-dashboard{
text-align:center;
padding-top:30px;
}

.dashboard-cards{
display:flex;
justify-content:center;
gap:30px;
margin-top:30px;
flex-wrap:wrap;
}

.card{
background:#c0392b;
color:white;
padding:30px;
width:200px;
border-radius:10px;
box-shadow:0 10px 20px rgba(0,0,0,0.2);
}

.card h3{
margin-bottom:10px;
}

.card p{
font-size:28px;
font-weight:bold;
}

</style>

<script>

firebase.database().ref("donations").once("value",snap=>{
let count=0;

snap.forEach(user=>{
user.forEach(donation=>{
count++;
});
});

document.getElementById("totalDonations").innerText=count;

});

firebase.database().ref("requests").once("value",snap=>{
let count=0;

snap.forEach(user=>{
user.forEach(req=>{
count++;
});
});

document.getElementById("totalRequests").innerText=count;

});

firebase.database().ref("users").once("value",snap=>{
document.getElementById("totalUsers").innerText=snap.numChildren();
});

</script>

<?php include 'admin_footer.php'; ?>