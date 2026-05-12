<?php include 'partials/header.php'; ?>

<style>
/* Reduce space between sections */
.donation-hero{
    padding:40px 20px;
}

/* White background cards */
.white-bg{
    background:#ffffff;
}

/* Horizontal radio buttons */
.radio-group{
    display:flex;
    flex-wrap:wrap;
    gap:15px;
    margin:10px 0 20px 0;
}

.radio-group label{
    display:flex;
    align-items:center;
    gap:5px;
    font-weight:500;
}

/* Phone input error style */
.input-error{
    border:2px solid red;
}
</style>

<!-- HERO 1 -->
<section class="donation-hero red-bg">
    <div class="hero-container">
        <h1>Donate Blood, Save Lives 🩸</h1>
        <p>A single pint can save three lives.</p>
    </div>
</section>


<section class="donation-hero white-bg full-requirements">

    <h2 class="requirements-title">Donation Requirements</h2>

    <div class="requirements-row">

        <div class="requirement-circle">
            <span>18 – 65<br>Years</span>
        </div>

        <div class="requirement-circle">
            <span>Weight<br>≥ 50 kg</span>
        </div>

        <div class="requirement-circle">
            <span>3 Months<br>Gap</span>
        </div>

        <div class="requirement-circle">
            <span>No Fever<br>Or Illness</span>
        </div>

    </div>

</section>

<!-- HERO 3 -->
<section class="donation-hero white-bg">
    <div class="hero-card form-card">
        <h2>🩸 Donation Form</h2>

        <form id="donationForm">

            <h3>Personal Details</h3>

            <input type="text" id="fullName" placeholder="Full Name">
            <input type="number" id="age" placeholder="Age (18-65)">

            <select id="gender">
                <option value="">Select Gender</option>
                <option>Male</option>
                <option>Female</option>
                <option>Other</option>
            </select>

            <h4>Blood Group</h4>
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

            <input type="text" id="mobile" placeholder="Mobile Number (10 digits)">
            <input type="email" id="email" placeholder="Email">
            <input type="text" id="city" placeholder="City">

            <h3>Health Questions</h3>

            <h4>Weight above 50 kg?</h4>
            <div class="radio-group">
                <label><input type="radio" name="weightCheck" value="yes">Yes</label>
                <label><input type="radio" name="weightCheck" value="no">No</label>
            </div>

            <h4>Donated in last 3 months?</h4>
            <div class="radio-group">
                <label><input type="radio" name="recentDonation" value="yes">Yes</label>
                <label><input type="radio" name="recentDonation" value="no">No</label>
            </div>

            <h4>Any illness or fever?</h4>
            <div class="radio-group">
                <label><input type="radio" name="illness" value="yes">Yes</label>
                <label><input type="radio" name="illness" value="no">No</label>
            </div>

            <h3>Schedule</h3>

            <input type="date" id="donationDate">

            <select id="timeSlot">
                <option value="">Select Time</option>
                <option>9:00 AM – 10:00 AM</option>
                <option>10:00 AM – 11:00 AM</option>
                <option>2:00 PM – 3:00 PM</option>
            </select>

            <div class="consent-box">
                <input type="checkbox" id="consent">
                I agree to donate voluntarily.
            </div>

            <button type="submit" class="main-btn">Book Appointment</button>
        </form>
    </div>
</section>

<!-- HERO 4 -->
<section class="donation-hero white-bg full-care">

    <h2 class="care-title">After Donation Care</h2>

    <div class="care-row">

        <div class="care-circle">
            <span>Drink Plenty<br>Of Fluids</span>
        </div>

        <div class="care-circle">
            <span>Avoid Heavy<br>Lifting</span>
        </div>

        <div class="care-circle">
            <span>Eat Iron-Rich<br>Foods</span>
        </div>

        <div class="care-circle">
            <span>Rest For<br>24 Hours</span>
        </div>

    </div>

</section>

<script>
const today = new Date().toISOString().split("T")[0];
document.getElementById("donationDate").setAttribute("min", today);

document.getElementById("donationForm").addEventListener("submit", function(e){
    e.preventDefault();

    const user = firebase.auth().currentUser;
    if(!user) return alert("Login first");

    const fullName = document.getElementById("fullName").value.trim();
    const age = parseInt(document.getElementById("age").value);
    const mobile = document.getElementById("mobile");
    const mobileVal = mobile.value.trim();

    const weightCheck = document.querySelector('input[name="weightCheck"]:checked');
    const recentDonation = document.querySelector('input[name="recentDonation"]:checked');
    const illness = document.querySelector('input[name="illness"]:checked');

    const dateVal = document.getElementById("donationDate").value;
    const timeVal = document.getElementById("timeSlot").value;
    const consent = document.getElementById("consent").checked;

    if(fullName === "") return alert("Enter full name");
    if(!age || age < 18 || age > 65) return alert("Age must be 18-65");

    if(!/^[0-9]{10}$/.test(mobileVal)){
        mobile.classList.add("input-error");
        return alert("Enter valid 10 digit mobile number");
    } else {
        mobile.classList.remove("input-error");
    }

    if(!weightCheck || weightCheck.value !== "yes")
        return alert("Weight must be above 50kg");

    if(!recentDonation || recentDonation.value === "yes")
        return alert("3 months gap required");

    if(!illness || illness.value === "yes")
        return alert("Cannot donate while sick");

    if(dateVal === "") return alert("Select donation date");
    if(timeVal === "") return alert("Select time slot");
    if(!consent) return alert("You must agree to consent");

    const uid = user.uid;
    const donationId = Date.now();

    firebase.database().ref("donations/"+uid+"/"+donationId).set({
        name: fullName,
        age: age,
        mobile: mobileVal,
        date: dateVal,
        time: timeVal,
        status: "Booked"
    }).then(()=>{
        alert("Appointment Booked!");
        document.getElementById("donationForm").reset();
    });
});
</script>

<?php include 'partials/footer.php'; ?>