
<?php include 'partials/header.php'; ?>

<!-- HERO SECTION -->

<div class="about-hero">

<h1>About HopeDrop</h1>

<p id="typing-text"></p>

</div>


<!-- ABOUT CONTENT -->

<div class="about-container">

<h2>Who We Are</h2>

<p>
HopeDrop is a cloud-based blood donation platform designed to connect
blood donors with patients in need. Our goal is to make blood donation
simple, fast, and accessible for everyone.
</p>

<p>
Thousands of patients struggle to find blood during emergencies.
HopeDrop helps bridge the gap by creating a reliable network of
voluntary blood donors who are ready to help save lives.
</p>

</div>


<!-- MISSION & VISION -->

<div class="mission-section">

<div class="mission-card">

<h3>Our Mission</h3>

<p>
To build a trusted digital platform where donors and recipients
can easily connect and ensure that no life is lost due to
unavailability of blood.
</p>

</div>


<div class="mission-card">

<h3>Our Vision</h3>

<p>
To create a strong community of blood donors across the country
and make blood availability faster, transparent, and reliable
during medical emergencies.
</p>

</div>

</div>


<style>

/* HERO SECTION */

.about-hero{
background:#b30000;
color:white;
text-align:center;
padding:80px 20px;
}

.about-hero h1{
font-size:42px;
margin-bottom:15px;
}

#typing-text{
font-size:20px;
font-weight:500;
height:30px;
}


/* ABOUT CONTENT */

.about-container{
width:80%;
margin:auto;
text-align:center;
padding:50px 20px;
}

.about-container h2{
font-size:32px;
margin-bottom:20px;
color:#c0392b;
}

.about-container p{
font-size:17px;
line-height:1.7;
color:#444;
margin-bottom:15px;
}


/* MISSION SECTION */

.mission-section{
display:flex;
justify-content:center;
gap:30px;
flex-wrap:wrap;
padding:40px 20px;
}

.mission-card{
background:white;
width:320px;
padding:25px;
border-radius:10px;
box-shadow:0 4px 12px rgba(0,0,0,0.1);
text-align:center;
}

.mission-card h3{
color:#c0392b;
margin-bottom:10px;
}

.mission-card p{
color:#555;
line-height:1.6;
}

</style>


<script>

/* TAGLINE TYPING EFFECT */

const taglines = [
"Connecting Blood Donors with People in Need.",
"Every Donation Can Save a Life.",
"Building a Community of Life Savers.",
"Fast and Reliable Blood Donation Network."
];

let taglineIndex = 0;
let charIndex = 0;
let typingSpeed = 50;
let erasingSpeed = 30;
let delayBetween = 1500;

function typeTagline() {

if (charIndex < taglines[taglineIndex].length) {

document.getElementById("typing-text").textContent += taglines[taglineIndex].charAt(charIndex);

charIndex++;

setTimeout(typeTagline, typingSpeed);

}

else {

setTimeout(eraseTagline, delayBetween);

}

}

function eraseTagline() {

if (charIndex > 0) {

document.getElementById("typing-text").textContent = taglines[taglineIndex].substring(0, charIndex - 1);

charIndex--;

setTimeout(eraseTagline, erasingSpeed);

}

else {

taglineIndex = (taglineIndex + 1) % taglines.length;

setTimeout(typeTagline, typingSpeed);

}

}

window.onload = typeTagline;

</script>


<?php include 'partials/footer.php'; ?>

