
<?php include 'admin_navbar.php'; ?>

<h2 style="text-align:center;margin-top:20px;">Manage Donations</h2>

<table class="admin-table">
<thead>
<tr>
<th>User ID</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody id="donationBody"></tbody>
</table>

<script>

firebase.database().ref("donations").on("value",function(snapshot){

let html="";

snapshot.forEach(function(userSnap){

let uid=userSnap.key;

userSnap.forEach(function(donation){

let data=donation.val();
let id=donation.key;

html+=`
<tr>
<td>${uid}</td>
<td>${data.date}</td>
<td>${data.time}</td>
<td>${data.status}</td>

<td>
<button class="green-btn" onclick="markDonated('${uid}','${id}')">Donated</button>
<button class="red-btn" onclick="markNotDonated('${uid}','${id}')">Not Donated</button>
</td>

</tr>
`;

});

});

document.getElementById("donationBody").innerHTML=html;

});

function markDonated(uid,id){

firebase.database().ref("donations/"+uid+"/"+id).update({
status:"Donated"
});

}

function markNotDonated(uid,id){

firebase.database().ref("donations/"+uid+"/"+id).update({
status:"Not Donated"
});

}

</script>

<style>

.admin-table{
width:90%;
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

.green-btn{
background:#27ae60;
color:white;
border:none;
padding:6px 12px;
border-radius:5px;
cursor:pointer;
}

.red-btn{
background:#e74c3c;
color:white;
border:none;
padding:6px 12px;
border-radius:5px;
cursor:pointer;
}

</style>

<?php include 'admin_footer.php'; ?>

