
<?php include 'partials/header.php'; ?>

<section class="profile-hero">
  <div class="profile-container">

    <h2>👤 My Profile</h2>

    <!-- USER INFO -->
    <div class="profile-card">
      <h3>Account Information</h3>
      <p><strong>Email:</strong> <span id="userEmailDisplay"></span></p>
    </div>

    <!-- CHANGE PASSWORD -->
    <div class="profile-card">
      <h3>🔒 Change Password</h3>

      <div class="password-box">
        <input type="password" id="newPassword" placeholder="New Password">
        <span class="eye" onclick="togglePassword('newPassword')">👁</span>
      </div>

      <div class="password-box">
        <input type="password" id="confirmPassword" placeholder="Confirm Password">
        <span class="eye" onclick="togglePassword('confirmPassword')">👁</span>
      </div>

      <button onclick="changePassword()">Update Password</button>
    </div>

    <!-- DONATION APPOINTMENTS -->
    <div class="profile-card">
      <h3>🩸 My Donation Appointments</h3>

      <p>Total Booked: <span id="totalBooked">0</span></p>
      <p>Total Cancelled: <span id="totalCancelled">0</span></p>

      <div id="appointmentsList"></div>
    </div>

    <!-- BLOOD REQUESTS -->
    <div class="profile-card">
      <h3>🚑 My Blood Requests</h3>

      <p>Total Requests: <span id="totalRequests">0</span></p>
      <p>Total Cancelled: <span id="totalRequestCancelled">0</span></p>

      <div id="requestsList"></div>
    </div>

  </div>
</section>


<style>

.profile-hero{
  padding:40px 20px;
  background:#f4f6f9;
  min-height:80vh;
}

.profile-container{
  max-width:800px;
  margin:auto;
}

.profile-card{
  background:white;
  padding:25px;
  margin-bottom:20px;
  border-radius:10px;
  box-shadow:0 10px 25px rgba(0,0,0,0.1);
  animation:fadeIn 0.5s ease-in-out;
}

.profile-card h3{
  margin-bottom:15px;
  color:#c0392b;
}

.profile-card input{
  width:100%;
  padding:10px;
  margin:8px 0;
  border-radius:5px;
  border:1px solid #ddd;
}

.profile-card button{
  margin-top:10px;
}

/* PASSWORD BOX */

.password-box{
  position:relative;
  display:flex;
  align-items:center;
}

.password-box input{
  width:100%;
}

.eye{
  position:absolute;
  right:10px;
  cursor:pointer;
  font-size:18px;
}

/* APPOINTMENT CARDS */

.appointment-card{
  border:1px solid #eee;
  padding:15px;
  border-radius:8px;
  margin-top:10px;
  transition:0.3s;
}

.appointment-card:hover{
  transform:scale(1.02);
  box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.status-booked{
  color:green;
  font-weight:bold;
}

.status-cancelled{
  color:red;
  font-weight:bold;
}

.status-pending{
  color:orange;
  font-weight:bold;
}

@keyframes fadeIn{
  from{opacity:0; transform:translateY(10px);}
  to{opacity:1; transform:translateY(0);}
}

</style>


<script>

/* SHOW / HIDE PASSWORD */

function togglePassword(id){

  let field = document.getElementById(id);

  if(field.type === "password"){
    field.type = "text";
  }else{
    field.type = "password";
  }

}


firebase.auth().onAuthStateChanged(function(user){

  if(!user){
    alert("Please login first");
    window.location.href="index.php";
    return;
  }

  document.getElementById("userEmailDisplay").innerText = user.email;

  const uid = user.uid;

  /* =========================
      DONATION APPOINTMENTS
  ==========================*/

  firebase.database().ref("donations/" + uid).on("value", function(snapshot){

    let totalBooked = 0;
    let totalCancelled = 0;
    let html = "";

    snapshot.forEach(function(child){

      const data = child.val();
      const donationId = child.key;

      if(data.status === "Booked") totalBooked++;
      if(data.status === "Cancelled") totalCancelled++;

      html += `
        <div class="appointment-card">
          <p><strong>Date:</strong> ${data.date}</p>
          <p><strong>Time:</strong> ${data.time}</p>

          <p>
            <strong>Status:</strong> 
            <span class="${data.status === 'Booked' ? 'status-booked' : 'status-cancelled'}">
              ${data.status}
            </span>
          </p>

          ${data.status === "Booked" ? 
            `<button onclick="cancelAppointment('${donationId}')">
              Cancel Appointment
            </button>` 
            : ""
          }
        </div>
      `;
    });

    document.getElementById("appointmentsList").innerHTML = html;
    document.getElementById("totalBooked").innerText = totalBooked;
    document.getElementById("totalCancelled").innerText = totalCancelled;

  });


  /* =========================
      BLOOD REQUESTS
  ==========================*/

  firebase.database().ref("requests/" + uid).on("value", function(snapshot){

    let totalRequests = 0;
    let totalCancelled = 0;
    let html = "";

    snapshot.forEach(function(child){

      const data = child.val();
      const requestId = child.key;

      totalRequests++;

      if(data.status === "Cancelled") totalCancelled++;

      html += `
        <div class="appointment-card">

          <p><strong>Patient:</strong> ${data.patientName}</p>
          <p><strong>Blood Group:</strong> ${data.bloodGroup}</p>
          <p><strong>Date Needed:</strong> ${data.date}</p>
          <p><strong>Urgency:</strong> ${data.urgency}</p>

          <p>
            <strong>Status:</strong>
            <span class="${data.status === 'Pending' ? 'status-pending' : 'status-cancelled'}">
              ${data.status}
            </span>
          </p>

          ${data.status === "Pending" ? 
            `<button onclick="cancelRequest('${requestId}')">
              Cancel Request
            </button>` 
            : ""
          }

        </div>
      `;
    });

    document.getElementById("requestsList").innerHTML = html;
    document.getElementById("totalRequests").innerText = totalRequests;
    document.getElementById("totalRequestCancelled").innerText = totalCancelled;

  });

});


/* CHANGE PASSWORD */

function changePassword(){

  const newPass = document.getElementById("newPassword").value;
  const confirmPass = document.getElementById("confirmPassword").value;

  if(newPass.length < 6){
    alert("Password must be at least 6 characters");
    return;
  }

  if(newPass !== confirmPass){
    alert("Passwords do not match");
    return;
  }

  const user = firebase.auth().currentUser;

  user.updatePassword(newPass)
    .then(()=>{
      alert("Password Updated Successfully");

      document.getElementById("newPassword").value="";
      document.getElementById("confirmPassword").value="";
    })
    .catch(error=>{
      alert(error.message);
    });
}


/* CANCEL APPOINTMENT */

function cancelAppointment(donationId){

  const user = firebase.auth().currentUser;

  if(confirm("Cancel this appointment?")){

    firebase.database()
      .ref("donations/" + user.uid + "/" + donationId)
      .update({
        status: "Cancelled"
      })
      .then(()=>{
        alert("Appointment Cancelled");
      });

  }

}


/* CANCEL REQUEST */

function cancelRequest(requestId){

  const user = firebase.auth().currentUser;

  if(confirm("Cancel this blood request?")){

    firebase.database()
      .ref("requests/" + user.uid + "/" + requestId)
      .update({
        status: "Cancelled"
      })
      .then(()=>{
        alert("Request Cancelled");
      });

  }

}

</script>

<?php include 'partials/footer.php'; ?>

