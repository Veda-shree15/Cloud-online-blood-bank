
<?php include 'admin_navbar.php'; ?>

<h2 style="text-align:center;margin-top:20px;">Manage Blood Requests</h2>

<table class="admin-table">

<thead>
<tr>
<th>Patient</th>
<th>Blood Group</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody id="requestBody"></tbody>

</table>

<script>

firebase.database().ref("requests").on("value",function(snapshot){

let html="";

snapshot.forEach(function(userSnap){

let uid=userSnap.key;

userSnap.forEach(function(req){

let data=req.val();
let id=req.key;

html+=`

<tr>

<td>${data.patientName}</td>
<td>${data.bloodGroup}</td>
<td>${data.date}</td>
<td>${data.status}</td>

<td>
<button class="green-btn" onclick="collected('${uid}','${id}')">Collected</button>
<button class="red-btn" onclick="notCollected('${uid}','${id}')">Not Collected</button>
</td>

</tr>

`;

});

});

document.getElementById("requestBody").innerHTML=html;

});

function collected(uid,id){

firebase.database().ref("requests/"+uid+"/"+id).update({
status:"Collected"
});

}

function notCollected(uid,id){

firebase.database().ref("requests/"+uid+"/"+id).update({
status:"Not Collected"
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

