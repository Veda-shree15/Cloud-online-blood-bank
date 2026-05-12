
<?php include 'partials/header.php'; ?>

<style>

/* Section spacing */
.request-hero{
    padding:40px 20px;
}

/* Heading */
.request-title{
    color:#c0392b;
    text-align:center;
    margin-bottom:60px;
}

/* Row layout */
.request-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* Circles */
.request-circle{
    width:180px;
    height:180px;
    background:#c0392b;
    color:white;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    padding:20px;
    font-weight:bold;
    animation:floatUpDown 3s ease-in-out infinite;
    transition:0.4s;
}

.request-circle:hover{
    transform:scale(1.08);
}

/* floating animation */
@keyframes floatUpDown{
0%{transform:translateY(0);}
50%{transform:translateY(-10px);}
100%{transform:translateY(0);}
}

/* Form */
.request-form{
    max-width:600px;
    margin:auto;
}

.request-form input,
.request-form select{
    width:100%;
    padding:10px;
    margin:10px 0;
}

/* radio buttons */
.radio-group{
    display:flex;
    flex-wrap:wrap;
    gap:15px;
}

.input-error{
    border:2px solid red;
}

</style>


<!-- HERO -->
<section class="request-hero red-bg">
<div class="hero-container">
<h1>Emergency Blood Request 🚑</h1>
<p>Request blood quickly during critical situations</p>
</div>
</section>


<!-- REQUEST GUIDELINES -->
<section class="request-hero white-bg">

<h2 class="request-title">Emergency Request Guidelines</h2>

<div class="request-row">

<div class="request-circle">
<span>Valid<br>Emergency</span>
</div>

<div class="request-circle">
<span>Correct<br>Blood Group</span>
</div>

<div class="request-circle">
<span>Emergency<br>Contact</span>
</div>

<div class="request-circle">
<span>Verified<br>Patient Info</span>
</div>

</div>

</section>


<!-- REQUEST FORM -->
<section class="request-hero white-bg">

<div class="hero-card request-form">

<h2>Blood Request Form</h2>

<p style="text-align:center;color:#555;margin-bottom:20px;">
All blood requests are handled by <b>RedHope Blood Bank</b>.
</p>

<form id="requestForm">

<h3>Patient Details</h3>

<input type="text" id="patientName" placeholder="Patient Name">

<input type="number" id="patientAge" placeholder="Patient Age">

<h4>Required Blood Group</h4>

<div class="radio-group">

<label><input type="radio" name="bloodGroup" value="A+">A+</label>
<label><input type="radio" name="bloodGroup" value="B+">B+</label>
<label><input type="radio" name="bloodGroup" value="O+">O+</label>
<label><input type="radio" name="bloodGroup" value="AB+">AB+</label>
<label><input type="radio" name="bloodGroup" value="A-">A-</label>
<label><input type="radio" name="bloodGroup" value="B-">B-</label>
<label><input type="radio" name="bloodGroup" value="O-">O-</label>
<label><input type="radio" name="bloodGroup" value="AB-">AB-</label>

</div>

<input type="text" id="city" placeholder="City">

<input type="text" id="contactNumber" placeholder="Contact Number (10 digits)">

<input type="date" id="requiredDate">

<select id="urgency">
<option value="">Urgency Level</option>
<option>Immediate</option>
<option>Within 24 Hours</option>
<option>Within 2 Days</option>
</select>

<button type="submit" class="main-btn">Submit Request</button>

</form>

</div>

</section>


<script>

/* ==============================
DATE LIMIT (TODAY + NEXT 2 DAYS)
============================== */

const today = new Date();

const minDate = today.toISOString().split("T")[0];

const maxDateObj = new Date();
maxDateObj.setDate(today.getDate() + 2);

const maxDate = maxDateObj.toISOString().split("T")[0];

const dateInput = document.getElementById("requiredDate");

dateInput.setAttribute("min", minDate);
dateInput.setAttribute("max", maxDate);



/* ==============================
FORM SUBMIT
============================== */

document.getElementById("requestForm").addEventListener("submit",function(e){

e.preventDefault();

const user = firebase.auth().currentUser;

if(!user){
alert("Login first");
return;
}

const patientName = document.getElementById("patientName").value.trim();
const patientAge = document.getElementById("patientAge").value;
const bloodGroup = document.querySelector('input[name="bloodGroup"]:checked');
const city = document.getElementById("city").value.trim();

const contactInput = document.getElementById("contactNumber");
const contact = contactInput.value.trim();

const date = document.getElementById("requiredDate").value;
const urgency = document.getElementById("urgency").value;


/* VALIDATIONS */

if(patientName==="") return alert("Enter patient name");

if(patientAge==="" || patientAge<=0) return alert("Enter valid age");

if(!bloodGroup) return alert("Select blood group");

if(city==="") return alert("Enter city");

if(!/^[0-9]{10}$/.test(contact)){
contactInput.classList.add("input-error");
return alert("Enter valid 10 digit contact number");
}else{
contactInput.classList.remove("input-error");
}

if(date==="") return alert("Select required date");

if(urgency==="") return alert("Select urgency level");


/* SAVE TO FIREBASE */

const uid = user.uid;
const requestId = Date.now();

firebase.database().ref("requests/"+uid+"/"+requestId).set({

patientName:patientName,
age:patientAge,
bloodGroup:bloodGroup.value,
city:city,
contact:contact,
date:date,
urgency:urgency,
status:"Pending"

}).then(()=>{

alert("Blood request submitted successfully!");

document.getElementById("requestForm").reset();

});

});

</script>

<?php include 'partials/footer.php'; ?>

